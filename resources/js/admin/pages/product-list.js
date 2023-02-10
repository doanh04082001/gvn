import { dataTableMixin } from '../utils/datatable-mixin.js';
import { modalMixin } from '../utils/modal-mixin.js';
import { showResponseErrorMessage, showSuccess } from '../utils/alerts.js';

const app = new Vue({
    mixins: [dataTableMixin, modalMixin],
    el: '#app-product-list',
    data: {
        datatableElement: '#product-table',
        productStoresForm: {
            name: null,
            stores: null
        },
        permissions: {
            edit: canEdit,
            delete: canDelete
        },
        modalElement: '#product-stores-modal'
    },
    mounted: () => {
        if (message != '') {
            showSuccess(message);
        }
    },
    methods: {
        configDataTable() {
            return {
                dom: `<"datatable-header--custom row"<"col-md-6 text-left"><"col-md-6 text-right">>
                <t>
                <"row"<"col-12 float-right"p>>`,
                bInfo: true,
                paging: true,
                aaSorting: [],
                serverSide: true,
                ajax: {
                    url: DATATABLE_URL,
                },
                columns: [
                    {
                        searchable: false,
                        orderable: false,
                        data: 'image_url',
                        className: 'align-middle text-center',
                        render: image_url => `<img src="${image_url || DEFAULT_SQUARE_IMAGE}"
                                              onerror="onImageError(this)"
                                              class="image_view">`
                    },
                    {
                        data: 'sku',
                        className: 'align-middle'
                    },
                    {
                        data: 'name',
                        className: 'align-middle'
                    },
                    {
                        data: 'category_id',
                        className: 'align-middle',
                        render: (data, type, row) =>
                            row.category.taxonomy_id == CATEGORY_TAXONOMY_ID ? row.category.name : ''
                    },
                    {
                        data: 'is_online',
                        className: 'align-middle text-center',
                        render: data => SALE_FORM_OPTIONS[data]
                    },
                    {
                        searchable: false,
                        orderable: false,
                        className: 'align-middle text-center',
                        render: () => `<button class="btn btn-outline-primary btn-sm btn-edit-price">
                                       <i class="fa fa-edit"></i> ${CHANGE_PRICE_STORE}</button>`
                    },
                    {
                        searchable: false,
                        data: 'order',
                        className: 'align-middle text-right',
                    },
                    {
                        searchable: false,
                        orderable: false,
                        data: 'id',
                        className: 'align-middle text-center',
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
                .on('click', '.btn-edit-price', function () {
                    that.handleButtonEditPriceEvent(this)
                })
                .on('keyup change clear', 'thead tr:eq(1) th input, thead tr:eq(1) th select', _.debounce(function () {
                    const i = $(this).parents('th').index();
                    const column = that.$datatable.column(i);
                    if (column.search() !== this.value) {
                        column
                            .search(this.value)
                            .draw();
                    }
                }, 200))
                .on('draw.dt', () => that.renderVariantRows());
        },

        handleButtonEditPriceEvent(button) {
            const row = $(button).parents('tr');
            const {id, name} = this.$datatable.row(row).data() || {id: row.data('id'), name: row.data('name')};
            this.toEditPrice(id, name);
        },

        toEditPrice(id, name) {
            window.appStoreProduct.product_id = id;
            window.appStoreProduct.product_name = $('<textarea />').html(name).text();
            window.appStoreProduct.$datatable.ajax.reload();
            $('#store-product-modal').modal('show')
        },

        handleEditButtonEvent(button) {
            this.redirectToUrl(ROUTES.edit.replace(':id', $(button).data('id')));
        },

        handleDeleteButtonEvent(button) {
            this.submitDelete(ROUTES.delete.replace(':id', $(button).data('id')));
        },

        submitProductStoresForm() {
            axios
                .patch(
                    ROUTES.syncToStores
                        .replace(':id', this.productStoresForm.id),
                    {
                        store_ids: this.productStoresForm.stores
                    }
                )
                .then(() => {
                    this.closeModal();
                    this.reloadTable();
                    showSuccess(MODIFIED_SUCCESS);
                })
                .catch(showResponseErrorMessage);
        },

        renderVariantRows() {
            this.$datatable.rows().every(function () {
                const data = this.data();
                let variantHtml = ''
                data.variants.forEach(item => {
                    variantHtml += `<tr data-id="${item.id}" data-name="${item.name}">
                                        <td colspan="2"></td>
                                        <td>${data.name} (${item.name})</td>
                                        <td>${data.category.taxonomy_id == CATEGORY_TAXONOMY_ID ? data.category.name : ''}</td>
                                        <td class="text-center">${SALE_FORM_OPTIONS[data.is_online]}</td>
                                        <td class="text-center">
                                            <button class="btn btn-outline-primary btn-sm btn-edit-price">
                                            <i class="fa fa-edit"></i> ${CHANGE_PRICE_STORE}</button>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>`;
                });

                this.child($(variantHtml)).show();
            });
        },
    }
});
