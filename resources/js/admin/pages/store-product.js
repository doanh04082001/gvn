import { dataTableMixin } from '../utils/datatable-mixin.js';
import { encodeNumber, decodeNumber } from '../utils/format-number.js';
import { showResponseErrorMessage, showSuccess } from "../utils/alerts.js";

window.appStoreProduct = new Vue({
    el: '#app-store-product',
    mixins: [dataTableMixin],
    data: {
        datatableElement: '#store-product-table',
        errors: {},
        product_id: '',
        product_name: '',
        featured: '',
        status: '',
        stores: [],
        permissions: {
            edit: canEdit,
            delete: canDelete
        }
    },
    computed: {},

    methods: {
        configDataTable() {
            const that = this;
            return {
                dom: `<"datatable-header--custom row"<"col-md-6 text-left"><"col-md-6 text-right">>
                <t>
                <"row"<"col-12 float-right"p>>`,
                bInfo: true,
                paging: true,
                aaSorting: [],
                serverSide: true,
                ajax: {
                    url: ROUTES.getStoreProduct,
                    data: data => {
                        data.product_id = this.product_id
                        data.status = this.status
                        data.featured = this.featured
                    },
                    dataSrc: that.parseDataSrc
                },
                columns: [
                    {
                        data: 'name',
                        className: 'align-middle'
                    },
                    {
                        searchable: false,
                        orderable: false,
                        className: 'align-middle text-left',
                        render: this.renderEditPriceColumn
                    },
                    {
                        searchable: false,
                        orderable: false,
                        className: 'align-middle text-left',
                        render: this.renderEditSalePriceColumn
                    },
                    {
                        searchable: false,
                        orderable: false,
                        data: 'id',
                        className: 'align-middle text-left align-middle',
                        render: this.renderActionsButton
                    },
                    {
                        searchable: false,
                        orderable: false,
                        data: 'featured',
                        className: 'align-middle text-center',
                        render: this.renderFeaturedColumn
                    },
                    {
                        searchable: false,
                        orderable: false,
                        data: 'status',
                        className: 'align-middle text-center',
                        render: this.renderStatusColumn
                    }
                ],
                orderCellsTop: true,
                fixedHeader: true,
            }
        },

        handleDataTableEvent() {
            const that = this;
            that.$datatable
                .on('keyup change clear', '.price-input', function () {
                    that.handleEditPrice(this)
                })
                .on('click', '.btn-save-price', function () {
                    that.savePrice(this)
                })
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

        handleEditPrice(element) {
            const price = decodeNumber($(element).val())
            $(element).val(encodeNumber(price))
            const id = $(element).attr('data-id')
            const dataType = $(element).attr('data-type')
            this.store_product.forEach(v => {
                if (id !== v.store_id) return;

                if (dataType === 'price') {
                    v.price = price;
                    return
                }

                v.sale_price = price;
            })
        },

        savePrice(element) {
            const that = this
            const rowData = this.$datatable.row($(element).parents('tr')).data()
            const saveStoreProductUrl = ROUTES.saveStoreProduct;
            axios
                .patch(saveStoreProductUrl, this.store_product.find(v => v.store_id === rowData.id))
                .then(() => {
                    that.reloadTable()
                    showSuccess(MODIFIED_SUCCESS)
                })
                .catch(showResponseErrorMessage)
        },

        renderEditPriceColumn(price, type, row) {
            return `<input type="text" ${canEdit ? '' : 'disabled'} class="form-control price-input"
                        data-type="price"
                        data-id="${row.id}" id="price_${row.id}"
                        value="${encodeNumber(row.all_products[0]?.pivot?.price)}"
                        placeholder="${LANGUAGE.PRICE}">`
        },

        renderEditSalePriceColumn(sale_price, type, row) {
            return `<input type="text" ${canEdit ? '' : 'disabled'} class="form-control price-input"
                        data-type="sale_price"
                        data-id="${row.id}" id="sale_price_${row.id}"
                        value="${encodeNumber(row.all_products[0]?.pivot?.sale_price)}"
                        placeholder="${LANGUAGE.SALE_PRICE}">`
        },

        renderActionsButton(data, type, row) {
            return `<button data-id="${row.id}" class="btn btn-sm btn-outline-primary btn-save-price">
                        <i class="fas fa-save"></i>
                    </button>`
        },

        renderFeaturedColumn(featured, type, row) {
            return `<div class="custom-control custom-switch custom-switch-on-success">
                <input ${canEdit ? '' : 'disabled'}  type="checkbox" class="custom-control-input cb-input-featured"
                    ${this.permissions.edit && row.all_products?.length ? '' : 'disabled'}
                    id="featured-${row.id}" storeId="${row.id}" productId="${row.all_products[0]?.id}"
                    ${row.all_products?.length && row.all_products[0]?.pivot?.featured ? 'checked' : ''}>
                <label class="custom-control-label" for="featured-${row.id}"></label>
            </div>`
        },

        renderStatusColumn(status, type, row) {
            return `<div class="custom-control custom-switch custom-switch-on-success">
                <input ${canEdit ? '' : 'disabled'}  type="checkbox" class="custom-control-input cb-input"
                    ${this.permissions.edit && row.all_products?.length ? '' : 'disabled'}
                    id="status-${row.id}" storeId="${row.id}" productId="${row.all_products[0]?.id}"
                    ${row.all_products?.length && row.all_products[0]?.pivot?.status ? 'checked' : ''}>
                <label class="custom-control-label" for="status-${row.id}"></label>
            </div>`
        },

        parseDataSrc(response) {
            try {
                this.store_product = response.data.map((v, i) => {
                    return {
                        store_id: v.id,
                        product_id: this.product_id,
                        price: v.all_products.length ? v.all_products[0]?.pivot?.price : 0,
                        sale_price: v.all_products.length ? v.all_products[0]?.pivot?.sale_price : 0,
                        featured: v.all_products.length ? v.all_products[0]?.pivot?.featured : 1,
                        status: v.all_products.length ? v.all_products[0]?.pivot?.status : 1,
                    }
                });
            } catch (e) {
                console.log(e);
            }

            return response.data;
        },

        getChangeFeaturedUrl(checkbox) {
            return ROUTES.updateStoreProductFeatured
                .replace(':store', $(checkbox).attr('storeId'))
                .replace(':product', $(checkbox).attr('productId'))
        },

        getChangeStatusUrl(checkbox) {
            return ROUTES.updateStoreProductStatus
                .replace(':store', $(checkbox).attr('storeId'))
                .replace(':product', $(checkbox).attr('productId'))
        },

        saveAll() {
            const that = this;
            axios
                .put(ROUTES.updateMultiStoreProduct, {store_product: this.store_product})
                .then(() => {
                    that.reloadTable();
                    showSuccess(MODIFIED_SUCCESS)
                })
                .catch(showResponseErrorMessage);
        }
    }
})
