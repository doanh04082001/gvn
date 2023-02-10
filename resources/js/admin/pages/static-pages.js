import { showSuccess } from '../utils/alerts.js';
import { dataTableMixin } from '../utils/datatable-mixin.js';

new Vue({
    mixins: [dataTableMixin],
    el: '#static-pages-element',
    data: {
        routes: ROUTES,
        permissions: PERMISSIONS,
        datatableElement: '#static-pages-table',
    },
    mounted() {
        if (message != '') {
            showSuccess(message);
        }
    },
    methods: {
        configDataTable() {
            return {
                dom: `<"datatable-header--custom">
                    <t>
                    <"row"<"col-12 float-right"p>>`,
                bInfo: true,
                buttons: [],
                paging: true,
                aaSorting: [],
                serverSide: true,
                ajax: {
                    url: this.routes.getDatatable,
                },
                columns: [
                    {
                        data: 'name',
                        className: 'align-middle'
                    },
                    {
                        searchable: false,
                        data: 'order',
                        className: 'align-middle text-center'
                    },
                    {
                        data: 'status',
                        className: 'align-middle text-center',
                        render: this.renderStatusColumn
                    },
                    {
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
});
