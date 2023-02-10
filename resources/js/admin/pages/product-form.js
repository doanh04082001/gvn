import {createFormData} from '../utils/create-form-data.js';
import {showError, showResponseErrorMessage} from '../utils/alerts.js';
import {PreviewImage} from '../utils/preview-image.js';
import {decodeNumber, encodeNumber} from '../utils/format-number.js';

const defaultOrder = 1;
const defaultIsCombo = 0;
const defaultIsOnline = 0;

const initVariant = {
    name: '',
    price: '',
    sale_price: ''
};

const initTopping = {
    id: '',
    name: ''
};

const initProductCombo = {
    id: '',
    full_name: '',
    quantity: ''
}

const defaultProduct = {
    id: '',
    name: '',
    sku: '',
    category_id: '',
    unit_id: '',
    price: '',
    sale_price: '',
    cost: '',
    description: '',
    order: defaultOrder,
    image: '',
    is_combo: defaultIsCombo,
    is_online: defaultIsOnline,
}

const app = new Vue({
    el: '#app-product-form',
    components: {
        'v-select': VueSelect.VueSelect,
        PreviewImage
    },
    data: {
        product: _.cloneDeep(PRODUCT ?? defaultProduct),
        variants: _.cloneDeep(VARIANTS ?? []),
        toppings: _.cloneDeep(TOPPINGS ?? []),
        combos: _.cloneDeep(COMBOS ?? []),
        toppingOptions,
        errors: null
    },
    computed: {
        priceDisplay: {
            get() {
                return encodeNumber(this.product.price)
            },
            set(val) {
                this.product.price = decodeNumber(val)
            }
        },

        variantsPriceDisplay: {
            get() {
                return this.variants.map(e => encodeNumber(e.price))
            },
            set({index, value}) {
                this.variants[index].price = decodeNumber(value)
            }
        },

        variantsSalePriceDisplay: {
            get() {
                return this.variants.map(e => encodeNumber(e.sale_price))
            },
            set({index, value}) {
                this.variants[index].sale_price = decodeNumber(value)
            }
        },

        salePriceDisplay: {
            get() {
                return encodeNumber(this.product.sale_price)
            },
            set(val) {
                this.product.sale_price = decodeNumber(val)
            }
        },

        costDisplay: {
            get() {
                return encodeNumber(this.product.cost)
            },
            set(val) {
                this.product.cost = decodeNumber(val)
            }
        },

        comboQuantityDisplay: {
            get() {
                return this.combos.map(e => encodeNumber(e.quantity))
            },
            set({index, value}) {
                this.combos[index].quantity = decodeNumber(value)
            }
        },
    },
    methods: {
        addVariant() {
            this.variants.push({...initVariant});
        },

        removeVariant(index) {
            Vue.delete(this.variants, index);
        },

        addTopping() {
            this.toppings.push(initTopping);
        },

        removeTopping(index) {
            Vue.delete(this.toppings, index);
        },

        addProductCombo() {
            this.combos.push(_.cloneDeep(initProductCombo));
        },

        removeProductCombo(index) {
            Vue.delete(this.combos, index);
        },

        onSubmit(url) {
            this.errors = null;
            Object.keys(this.product).forEach(key => {
                this.product[key] = this.product[key] === null ? '' : this.product[key];
            });
            this.product.is_combo = +this.product.is_combo;
            this.product.is_online = +this.product.is_online;
            const data = {
                product: this.product,
                variants: this.variants,
                toppings: this.toppings,
                combos: this.combos
            };
            if (isEdit) {
                axios
                    .post(url, createFormData({
                        _method: 'PUT',
                        ...data
                    }))
                    .then(res => redirectToUrl(res?.data))
                    .catch(this.handleErrors);
            } else {
                axios
                    .post(url, createFormData(data))
                    .then(res => redirectToUrl(res?.data))
                    .catch(this.handleErrors);
            }
        },

        handleButtonEditPriceEvent(e) {
            const {id, name} = {
                id: $(e.target).data('id'),
                name: $(e.target).data('name')
            };
            this.toEditPrice(id, name);
        },

        toEditPrice(id, name) {
            window.appStoreProduct.product_id = id;
            window.appStoreProduct.product_name = $('<textarea />').html(name).text();
            window.appStoreProduct.$datatable.ajax.reload();
            $('#store-product-modal').modal('show')
        },

        handleErrors(error) {
            const res = error?.response;
            if (res?.status === 422) {
                const errors = res?.data?.errors;
                const variantErrs = [];
                const toppingErrs = [];
                const comboErrs = [];
                const productErrs = {};
                Object.entries(errors).forEach(item => {
                    const nameSplit = item[0].split(".");
                    switch (nameSplit[0]) {
                        case 'variants':
                            if (_.isUndefined(variantErrs[nameSplit[1]])) {
                                variantErrs[nameSplit[1]] = {};
                            }
                            variantErrs[nameSplit[1]][nameSplit[2]] = item[1][0];
                            break;
                        case 'toppings':
                            if (_.isUndefined(toppingErrs[nameSplit[1]])) {
                                toppingErrs[nameSplit[1]] = {};
                            }
                            toppingErrs[nameSplit[1]][nameSplit[2]] = item[1][0]
                            break;
                        case 'combos':
                            if (_.isUndefined(comboErrs[nameSplit[1]])) {
                                comboErrs[nameSplit[1]] = {};
                                showError(item[1][0]);
                            }
                            comboErrs[nameSplit[1]][nameSplit[2]] = item[1][0]
                            break;
                        case 'product':
                            productErrs[nameSplit[1]] = item[1][0];
                            break;
                        default:
                            break;
                    }
                });
                this.errors = {
                    productErrs,
                    variantErrs,
                    toppingErrs,
                    comboErrs
                };
            }

            showResponseErrorMessage(error)
        },

        onFileChange(image) {
            this.product.image = image;
        },

        setComboSelected(value, index) {
           this.combos[index].id = value.id;
           this.combos[index].full_name = value.full_name;
        },
    }
});
