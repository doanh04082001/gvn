import { dataTableMixin } from '../utils/datatable-mixin.js'
import { orderShippingMixin } from '../utils/order-shipping-mixin.js'
import { encodeNumber } from '../utils/format-number.js'
import { parseFcmPayload } from '../utils/parse-fcm-payload.js'
import {convertToClientTz, convertToUtcTz} from '../utils/timezone.js';

const errorsFormDefault = {
    email: [],
    phone: [],
    shipping_name: [],
    shipping_address: [],
    discount: [],
    note: [],
    payment_method: [],
}

new Vue({
    mixins: [dataTableMixin, orderShippingMixin],
    el: '#app',
    data: {
        routes: ROUTES,
        permissions: PERMISSIONS,
        paymentStatuses: PAYMENT_STATUS_TEXT,
        message: {},
        orderForm: {
            email: '',
            status: 0,
            phone: '',
            amount: '',
            shipping_name: '',
            shipping_address: '',
            discount: '',
            note: '',
            payment_method: '',
            payment_status: '',
        },
        errorsForm: errorsFormDefault,
        datatableElement: '#order-table',
        rows: [
            { id: '', status: '' }
        ],
    },

    mounted() {
        const that = this;

        window.FCM.fcmHandle(function({ data }) {
            if (NOTIFICATION_TYPES.includes(parseFcmPayload(data)?.data?.type)) {
                setTimeout(that.reloadTable, 500);
            }
        });
    },

    methods: {
        configDataTable() {
            return {
                dom: `<"datatable-header--custom row"<"col-md-6 text-left"s><"col-md-6 text-right"B>>
                <t>
                <"row"<"col-12 float-right"p>>`,
                bInfo: true,
                paging: true,
                aaSorting: [],
                buttons: this.permissions.create
                    ? [{
                        text: `<i class="fas fa-plus"></i>&nbsp${CREATE_ORDER_TEXT}`,
                        className: 'btn btn-sm btn-outline-success',
                    }]
                    : [],
                serverSide: true,
                ajax: {
                    url: this.routes.getDatatable,
                },
                columns: [
                    {
                        data: 'created_at',
                        render: (data, type, row) => {
                            if (data) {
                                return convertToClientTz(data);
                            }
                            return '';
                        },
                    },
                    {
                        data: 'received_at',
                        render: (data, type, row) => {
                            if (row.delivery_time) {
                                return convertToClientTz(row.delivery_time);
                            }
                            if (data) {
                                return convertToClientTz(data);
                            }
                            return '';
                        },
                    },
                    {
                        data: 'shipping_address',
                    },
                    {
                        data: 'total_amount',
                        className: 'text-right',
                        render: data => encodeNumber(data)
                    },
                    {
                        data: 'store_id',
                        render: (data, type, row) => row.store.name
                    },

                    {
                        data: 'payment_status',
                        orderable: false,
                        className: 'text-center',
                        render: (data) => (this.paymentStatuses[data])
                    },
                    {
                        data: 'status',
                        orderable: false,
                        className: 'text-center',
                        render: this.renderChangeStatus
                    },
                    {
                        data: 'id',
                        searchable: false,
                        orderable: false,
                        className: 'text-center',
                        render: this.renderActionsButton
                    }
                ],
                orderCellsTop: true,
                fixedHeader: true,
            }
        },

        renderChangeStatus(data) {
            const statusAllows = this.getStatusAllows(data);
            const options = STATUSES.filter(status => status != STATUS_CANCEL)
            options.push(STATUS_CANCEL)
            const optionsHtml = options.map(status => {
                const disabled = this.needToDisableOption(statusAllows, status) ? 'disabled' : ''
                const selected = data === status ? 'selected' : ''
                return `<option value="${status}" ${selected} ${disabled}>
                    ${STATUS_TEXTS[status]}
                </option>`
            })

            const disabledSelect = !this.permissions.edit || !statusAllows.length ? 'disabled' : ''

            return `<select class='form-control status' ${disabledSelect}>
                ${optionsHtml}
            </select>`
        },

        needToDisableOption(statusAllows, nextStatus) {
            return !this.permissions.edit || !statusAllows.includes(nextStatus)
        },

        getStatusAllows(status) {
            if ([STATUS_CANCEL, STATUS_DONE].includes(Number(status))) {
                return []
            }

            return STATUSES.filter(st => (st == STATUS_CANCEL || st > Number(status)))
        },

        renderActionsButton(id) {
            return `<a href="${this.routes.detail.replace(':id', id)}" class="btn btn-sm" target="_blank">
                <i class="fas fa-eye"></i>
            </a>`
        },

        handleDataTableEvent() {
            const that = this

            this.$datatable
                .on('change', '.status', function () {
                    const status = $(this).val();

                    if (that.needCreateShipping(that.getRowData(this), status)) {
                        that.openOrderShippingModal(
                            that.getRowData(this).id,
                            status
                        );

                        return that.reloadTable();
                    }

                    that.showChangeStatusConfirm(
                        that.getRowData(this).id,
                        status
                    );
                })
        },

        cancelChangeStatus() {
            return this.reloadTable();
        },
    }
})
