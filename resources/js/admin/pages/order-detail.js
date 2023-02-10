import { dataTableMixin } from '../utils/datatable-mixin.js'
import { orderShippingMixin } from '../utils/order-shipping-mixin.js'
import { encodeNumber } from '../utils/format-number.js'
import { parseFcmPayload } from '../utils/parse-fcm-payload.js'
import { convertToClientTz } from '../utils/timezone.js';

new Vue({
    mixins: [dataTableMixin, orderShippingMixin],
    el: '#app',
    data: {
        routes: ROUTES,
        permissions: PERMISSIONS,
        datatableElement: '#order-detail-table',
        status: STATUS,
        statusText: '',
        order: ORDER ?? {
            created_at: null,
            received_at: null
        },
        selectedOrderId: ORDER.id,
    },

    mounted() {
        window.FCM.fcmHandle(({ data }) => this.changeStatusByFcm(data));

        this.statusText = STATUS_TEXTS[this.status]
    },

    computed: {
        statusAllows() {
            if ([STATUS_CANCEL, STATUS_DONE].includes(Number(this.status))) {
                return []
            }

            return STATUSES.filter(status => (status == STATUS_CANCEL || status > this.status))
        },

        createdText: {
            get() {
                return convertToClientTz(this.order.created_at);
            }
        },

        receivedText: {
            get() {
                return convertToClientTz(this.order.received_at);
            }
        },
    },

    watch: {
        status(val) {
            this.statusText = STATUS_TEXTS[val]
        }
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
                buttons: [],
                serverSide: true,
                ajax: {
                    url: this.routes.getDatatable,
                },
                columns: [
                    {
                        data: 'product_name',
                    },
                    {
                        data: 'quantity',
                        className: 'text-right',
                    },
                    {
                        data: 'taxonomy_name',
                    },
                    {
                        data: 'amount',
                        className: 'text-right',
                        render: data => encodeNumber(data)
                    },
                    {
                        data: 'note',
                    }
                ],
                orderCellsTop: true,
                fixedHeader: true,
            }
        },

        updateStatus(status) {
            if (this.needCreateShipping(this.order, status)) {
                return this.openOrderShippingModal(
                    this.order.id,
                    status
                );
            }

            this.showChangeStatusConfirm(
                this.order.id,
                status
            );
        },

        activated(status) {
            return status == this.status ? 'btn-' : 'btn-outline-'
        },

        disabled(status) {
            return !this.permissions.edit || !this.statusAllows.includes(status)
        },

        changeStatusByFcm(notification) {
            const payload = parseFcmPayload(notification)

            if (NOTIFICATION_TYPES.includes(payload?.data?.type) && payload?.data?.order?.id == ORDER_ID) {
                this.status = payload.data.order.status
            }
        },
    },
})
