import {dataTableMixin} from '../utils/datatable-mixin.js';
import {modalMixin} from '../utils/modal-mixin.js';
import {encodeNumber, decodeNumber} from '../utils/format-number.js';
import {showResponseErrorMessage, showSuccess} from '../utils/alerts.js';
import {encodeMixin} from "../utils/encode-mixin.js";

const defaultToppingForm = {
    name: null,
    price: null,
    sale_price: null,
    id: null
}

const createModalConfig = {
    title: LANGUAGE.CREATE_TOPPING_TITLE,
    action: {
        method: 'POST',
        url: ROUTES.store,
    }
}

const app = new Vue({
    el: '#app-topping-list',
    mixins: [dataTableMixin, modalMixin, encodeMixin],
    data: {
        datatableElement: '#topping-table',
        min_price: null,
        max_price: null,
        min_sale_price: null,
        max_sale_price: null,
        toppingForm: _.cloneDeep(defaultToppingForm),
        errors: {},
        modal: _.cloneDeep(createModalConfig),
        modalElement: '#topping-modal',
        permissions: {
            edit: canEdit,
            delete: canDelete
        }
    },

    computed: {
        minPriceDisplay: {
            get() {
                return encodeNumber(this.min_price);
            },
            set(val) {
                this.min_price = decodeNumber(val);
            }
        },
        maxPriceDisplay: {
            get() {
                return encodeNumber(this.max_price);
            },
            set(val) {
                this.max_price = decodeNumber(val);
            }
        },
        minSalePriceDisplay: {
            get() {
                return encodeNumber(this.min_sale_price);
            },
            set(val) {
                this.min_sale_price = decodeNumber(val);
            }
        },
        maxSalePriceDisplay: {
            get() {
                return encodeNumber(this.max_sale_price);
            },
            set(val) {
                this.max_sale_price = decodeNumber(val);
            }
        },
        priceDisplay: {
            get() {
                return encodeNumber(this.toppingForm.price);
            },
            set(val) {
                this.toppingForm.price = decodeNumber(val);
            }
        },
        salePriceDisplay: {
            get() {
                return encodeNumber(this.toppingForm.sale_price);
            },
            set(val) {
                this.toppingForm.sale_price = decodeNumber(val);
            }
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
                    url: ROUTES.getDatatable,
                    data: data => {
                        data.min_price = this.min_price
                        data.max_price = this.max_price
                        data.min_sale_price = this.min_sale_price
                        data.max_sale_price = this.max_sale_price
                    }
                },
                columns: [
                    {
                        data: 'name',
                        className: 'align-middle'
                    },
                    {
                        searchable: false,
                        orderable: false,
                        data: 'price',
                        className: 'align-middle text-center',
                        render: this.renderPriceColumn
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
            that.$datatable
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
                }, 200));
        },

        handleButtonEditPriceEvent(button) {
            const {id, name} = this.$datatable.row($(button).parents('tr')).data()
            this.toEditPrice(id, name);
        },

        renderPriceColumn(status, type, row) {
            return `<button class="btn btn-sm btn-outline-primary btn-edit-price"><i class="fas fa-edit"></i> ${LANGUAGE.EDIT_PRICE} </button>`
        },

        toEditPrice(id, mame) {
            window.appStoreTopping.topping_id = id
            window.appStoreTopping.topping_name = this.htmlEncode(mame);
            window.appStoreTopping.$datatable.ajax.reload()
            $('#store-topping-modal').modal('show')
        },

        handleEditButtonEvent(button) {
            const {id, name, price, sale_price} = this.$datatable.row($(button).parents('tr')).data();
            const url = ROUTES.update.replace(':id', id);
            this.toEdit({id, name, price, sale_price}, url);
        },

        handleDeleteButtonEvent(button) {
            this.submitDelete(ROUTES.delete.replace(':id', $(button).data('id')));
        },

        getChangeStatusUrl(checkbox) {
            return ROUTES.update_status.replace(':id', $(checkbox).attr('id'))
        },

        submitForm() {
            if (this.modal.action.method === 'POST') {
                this.store()
            }

            if (this.modal.action.method === 'PUT') {
                this.update()
            }
        },

        toCreate() {
            this.errors = {};
            this.toppingForm = _.cloneDeep(defaultToppingForm);
            this.modal = _.cloneDeep(createModalConfig);
            this.openModal()
        },

        toEdit(item, url) {
            this.errors = {};
            item.name = this.htmlEncode(item.name)
            this.toppingForm = item;
            this.modal = {
                title: LANGUAGE.EDIT_TOPPING_TITLE,
                action: {
                    method: 'PUT',
                    url
                }
            };
            this.openModal()
        },

        store() {
            axios
                .post(this.modal.action.url, this.toppingForm)
                .then(() => {
                    this.reloadTable();
                    this.closeModal();
                    showSuccess(ADDED_SUCCESS)
                })
                .catch(this.handleErrors)
        },

        update() {
            axios
                .put(this.modal.action.url, this.toppingForm)
                .then(() => {
                    this.reloadTable();
                    this.closeModal();
                    showSuccess(MODIFIED_SUCCESS)
                })
                .catch(this.handleErrors)
        },

        handleErrors(error) {
            const res = error?.response;
            const errorsArr = [];
            if (res?.status === 422) {
                const errors = res?.data?.errors;
                Object.entries(errors).forEach(item => {
                    const nameSplit = item[0].split('.');
                    errorsArr[nameSplit] = item[1][0];
                });
                this.errors = errorsArr;
            }

            showResponseErrorMessage(error)
        }
    }
})
