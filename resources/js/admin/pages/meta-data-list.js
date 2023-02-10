import { dataTableMixin } from '../utils/datatable-mixin.js';
import { showDeleteConfirm, showResponseErrorMessage, showSuccess } from '../utils/alerts.js';

new Vue({
    mixins: [dataTableMixin],
    el: '#app-meta-data-list',
    data: {
        routes: ROUTES,
        permissions: PERMISSIONS,
        datatableElement: '#meta-data-table',
    },
    mounted() {
        if (message != '') {
            showSuccess(message);
        }
    },
    methods: {
        configDataTable() {
            return {
                dom: `<"datatable-header--custom row"<"col-md-6 text-left"s><"col-md-6 text-right">>
                <t>
                <"row"<"col-12 float-right"p>>`,
                bInfo: true,
                paging: true,
                pageLength: 10,
                aaSorting: [],
                serverSide: true,
                ajax: {
                    url: this.routes.getMetaDataDatatable,
                },
                columns: [
                    {
                        data: 'title',
                    },
                    {
                        data: 'description',
                    },
                    {
                        data: 'keyword',
                    },
                    {
                        searchable: false,
                        orderable: false,
                        data: 'image_url',
                        className: 'text-center',
                        render: image_url => `<img src="${image_url || DEFAULT_SQUARE_IMAGE}"
                                    onerror="onImageError(this)"
                                    class="image_view">`
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

        handleDataTableEvent() {
            const that = this;

            this.$datatable
                .on('keyup change clear', 'thead tr:eq(1) th input, thead tr:eq(1) th select', _.debounce(function () {
                    const i = $(this).parents('th').index();
                    const column = that.$datatable.column(i);
                    if (column.search() !== this.value) {
                        column
                            .search(this.value)
                            .draw();
                    }
                }, 200));
        },

        handleEditButtonEvent(button) {
            redirectToUrl(`${this.routes.editMetaDataUrl.replace(':id', $(button).data('id'))}`);
        },

        handleDeleteButtonEvent(button) {
            this.destroy(`${this.routes.deleteMataDataUrl.replace(':id', $(button).data('id'))}`);
        },

        destroy(url) {
            const that = this;

            showDeleteConfirm(function () {
                axios.delete(url)
                    .then(() => {
                        that.reloadTable();
                        showSuccess(DELETED_SUCCESS);
                    })
                    .catch(showResponseErrorMessage)
            });
        },
    }
});
