import { showSuccess } from '../utils/alerts.js';
import { dataTableMixin } from '../utils/datatable-mixin.js';
import { encodeNumber, decodeNumber } from '../utils/format-number.js';

const app = new Vue({
    el: '#app-customer-list',
    mixins: [dataTableMixin],
    data: {
        routes: CUSTOMER_ROUTES,
        permissions: CUSTOMER_PERMISSIONS,
        search: {
            minPoint: "",
            maxPoint: "",
            minOrder: "",
            maxOrder: ""
        },
        datatableElement: '#customer-table',
    },
    computed: {
        minPointDisplay: {
            get() {
                return encodeNumber(this.search.minPoint)
            },
            set(val) {
                this.search.minPoint = decodeNumber(val)
            }
        },
        maxPointDisplay: {
            get() {
                return encodeNumber(this.search.maxPoint)
            },
            set(val) {
                this.search.maxPoint = decodeNumber(val)
            }
        },
        minOrderDisplay: {
            get() {
                return encodeNumber(this.search.minOrder)
            },
            set(val) {
                this.search.minOrder = decodeNumber(val)
            }
        },
        maxOrderDisplay: {
            get() {
                return encodeNumber(this.search.maxOrder)
            },
            set(val) {
                this.search.maxOrder = decodeNumber(val)
            }
        },
    },
    mounted() {
        if (message != '') {
            showSuccess(message);
        }
    },
    methods: {
        configDataTable() {
            const that = this;
            return {
                dom: `<"datatable-header--custom">
                    <t>
                    <"row"<"col-12 float-right"p>>`,
                bInfo: false,
                buttons: [],
                paging: true,
                aaSorting: [],
                serverSide: true,
                ajax: {
                    url: this.routes.getDatatable,
                    data: (data) => {
                        data.min_point = that.search.minPoint,
                        data.max_point = that.search.maxPoint,
                        data.min_order = that.search.minOrder,
                        data.max_order = that.search.maxOrder
                    }
                },
                columns: [
                    {
                        data: 'name',
                        className: 'align-middle'
                    },
                    {
                        data: 'code',
                        className: 'align-middle'
                    },
                    {
                        data: 'phone',
                        className: 'align-middle'
                    },
                    {
                        data: 'points',
                        className: 'align-middle text-right',
                        render: data => encodeNumber(data),
                    },
                    {
                        data: 'orders_count',
                        className: 'align-middle text-right',
                        render: data => encodeNumber(data),
                    },
                    {
                        data: 'status',
                        className: 'align-middle text-center',
                        render: this.renderStatusColumn
                    },
                    {
                        searchable: false,
                        orderable: false,
                        className: 'align-middle text-center',
                        render: this.renderActionsButton
                    }
                ],
                columnDefs: [
                    { width: '15%', targets: 3 },
                    { width: '15%', targets: 4 },
                ],
                orderCellsTop: true,
                fixedHeader: true,
                select: true
            }
        },

        handleDataTableEvent() {
            const that = this;

            this.$datatable
                .on('keyup change clear', 'thead tr:eq(1) th input, thead tr:eq(1) th select', _.debounce(function () {
                    const column = that.$datatable.column($(this).closest('th').index());
                    if (column.search() !== this.value) {
                        column.search(this.value)
                            .draw();
                    }
                }, 200))
        },

        getChangeStatusUrl(checkbox) {
            return this.routes.update.replace(
                ':id',
                this.$datatable.row($(checkbox).parents('tr')).data().id
            );
        },

        handleEditButtonEvent(button) {
            const url = this.routes.edit.replace(
                ':id',
                this.$datatable.row($(button).parents('tr')).data().id
            );
            this.redirectToUrl(url);
        },

        handleDeleteButtonEvent(button) {
            this.submitDelete(
                this.routes.delete.replace(
                    ':id',
                    this.$datatable.row($(button).parents('tr')).data().id
                )
            )
        },
    }
})
