import { dataTableMixin } from '../../utils/datatable-mixin.js';
import { orderShippingMixin } from '../../utils/order-shipping-mixin.js'
import { encodeNumber } from '../../utils/format-number.js';
import { parseFcmPayload } from '../../utils/parse-fcm-payload.js';
import { showError, showResponseErrorMessage, showSuccess, showConfirm } from '../../utils/alerts.js';

window.processingOrderVue = new Vue({
    mixins: [dataTableMixin, orderShippingMixin],
    el: '#app-processing-order',
    data: {
        routes: ROUTES,
        permisstions: PERMISSIONS,
        datatableElement: '#order-table-processing',
        selectedOrderId: '',
    },
    methods: {
        configDataTable() {
            return {
                dom: `<"datatable-header--custom row"<"col-md-6 text-left"s><"col-md-6 text-right">>
                <t>
                <"row"<"col-12 float-right"p>>`,
                bInfo: true,
                paging: true,
                pageLength: 5,
                aaSorting: [],
                serverSide: true,
                ajax: {
                    url: this.routes.getProcessingDatatable,
                },
                columns: [
                    {
                        data: 'store_id',
                    },
                    {
                        data: 'shipping_name',
                    },
                    {
                        data: 'phone',
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
                        data: 'id',
                        searchable: false,
                        orderable: false,
                        className: 'text-center',
                        render: this.renderActionsButton
                    }
                ],
                columnDefs: [
                    {visible: false, targets: [0], searchable: true}
                ],
                orderCellsTop: true,
                fixedHeader: true,
            }
        },

        renderActionsButton(id) {
            return `${this.permisstions.edit
                    ? `<button type="button" class="btn btn-outline-info btn-sm btn-processing-order">
                        ${SHIPPING_BTN_TEXT}
                    </button>`
                    : ''}
                    ${this.permisstions.show
                    ? `<a href="${this.routes.orderDetail.replace(':id', id)}" class="btn btn-sm" target="_blank">
                        <i class="fas fa-eye"></i>
                    </a>`
                    : ''}`
        },

        handleDataTableEvent() {
            const that = this;
            const lastRowNumber = 1;
            const firstPage = 0;

            this.$datatable
                .on('click', '.btn-processing-order', function () {
                    if (that.needCreateShipping(that.getRowData(this), STATUS_SHIPPING)) {
                        return that.openOrderShippingModal(
                            that.getRowData(this).id,
                            STATUS_SHIPPING
                        );
                    }

                    that.showChangeStatusConfirm(
                        that.getRowData(this).id,
                        STATUS_SHIPPING
                    );

                    const numRows = that.$datatable.rows().count();
                    const currentPage = that.$datatable.page();
                    if (numRows === lastRowNumber && currentPage > firstPage) {
                        that.$datatable.page(currentPage - 1);
                    }
                });

            $('#select-store').change(_.debounce(function () {
                const column = that.$datatable.column(0);
                if (column.search() !== this.value) {
                    column
                        .search(this.value)
                        .draw();
                }
            }, 200));
        },

        reloadProcessingOrderTable(data) {
            if (NOTIFICATION_TYPES.includes(parseFcmPayload(data)?.data?.type)) {
                setTimeout(this.reloadTable, 500)
            }
        },
    }
});
