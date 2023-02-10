import {dataTableMixin} from '../utils/datatable-mixin.js';
import {encodeNumber, decodeNumber} from '../utils/format-number.js';
import {showResponseErrorMessage, showSuccess} from "../utils/alerts.js";

window.appStoreTopping = new Vue({
    el: '#app-store-topping',
    mixins: [dataTableMixin],
    data: {
        datatableElement: '#store-topping-table',
        errors: {},
        topping_id: '',
        topping_name: '',
        status: '',
        store_topping: [],
        permissions: {
            edit: canEdit,
            delete: canDelete
        }
    },

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
                    url: ROUTES.get_store_topping,
                    data: data => {
                        data.topping_id = this.topping_id
                        data.status = this.status
                    },
                    dataSrc: this.tranformData
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
                        data: 'status',
                        className: 'align-middle text-center',
                        render: this.renderStatusColumn
                    }

                ],
                orderCellsTop: true,
                fixedHeader: true,
            }
        },

        tranformData(response) {
            try {
                this.store_topping = response.data.map((v, i) => {
                    return {
                        store_id: v.id,
                        topping_id: this.topping_id,
                        price: v.topping_with_inactive.length ? v.topping_with_inactive[0]?.pivot?.price : 0,
                        sale_price: v.topping_with_inactive.length ? v.topping_with_inactive[0]?.pivot?.sale_price : 0,
                        status: v.topping_with_inactive.length ? v.topping_with_inactive[0]?.pivot?.status : 1,
                    }
                });
            } catch (e) {
                console.log(e)
            }
            return response.data;
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
            const price = decodeNumber(jQuery(element).val())
            jQuery(element).val(encodeNumber(price))
            const id = jQuery(element).attr('data-id')
            const dataType = jQuery(element).attr('data-type')
            this.store_topping.forEach(v => {
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
            const saveStoreToppingUrl = ROUTES.save_store_topping;
            axios
                .patch(saveStoreToppingUrl, this.store_topping.find(v => v.store_id === rowData.id))
                .then(() => {
                    that.reloadTable()
                    showSuccess(MODIFIED_SUCCESS)
                })
                .catch(showResponseErrorMessage)
        },

        renderEditPriceColumn(status, type, row) {
            return `<input type="text" ${canEdit ? '' : 'disabled'} class="form-control price-input"
                        data-type="price"
                        data-id="${row.id}" id="price_${row.id}"
                        value="${encodeNumber(row.topping_with_inactive[0]?.pivot?.price)}"
                        placeholder="${LANGUAGE.PRICE}">`
        },

        renderEditSalePriceColumn(status, type, row) {
            return `<input type="text" ${canEdit ? '' : 'disabled'} class="form-control price-input"
                        data-type="sale_price"
                        data-id="${row.id}" id="sale_price_${row.id}"
                        value="${encodeNumber(row.topping_with_inactive[0]?.pivot?.sale_price)}"
                        placeholder="${LANGUAGE.SALE_PRICE}">`
        },

        renderActionsButton(status, type, row) {
            return `<button data-id="${row.id}" class="btn btn-sm btn-outline-primary btn-save-price">
                        <i class="fas fa-save"></i>
                    </button>`
        },

        renderStatusColumn(status, type, row) {
            return `<div class="custom-control custom-switch custom-switch-on-success">
                <input ${canEdit ? '' : 'disabled'}  type="checkbox" class="custom-control-input cb-input"
                    ${this.permissions.edit && row.topping_with_inactive?.length ? '' : 'disabled'}
                    id="${row.id}" toppingId="${row.topping_with_inactive[0]?.id}"
                    ${row.topping_with_inactive?.length && row.topping_with_inactive[0]?.pivot?.status ? 'checked' : ''}>
                <label class="custom-control-label" for="${row.id}"></label>
            </div>`
        },

        getChangeStatusUrl(checkbox) {
            return ROUTES.update_store_topping_status
                .replace(':store', $(checkbox).attr('id'))
                .replace(':topping', $(checkbox).attr('toppingId'))
        },

        saveAll() {
            const that = this;
            axios
                .put(ROUTES.update_multi_store_topping, {store_topping: this.store_topping})
                .then(() => {
                    that.reloadTable();
                    showSuccess(MODIFIED_SUCCESS)
                })
                .catch(showResponseErrorMessage);
        }
    }
})
