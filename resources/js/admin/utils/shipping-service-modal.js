import { showResponseErrorMessage, showSuccess, showError } from "./alerts.js"

export const ShippingServiceModal = {
    props: {
        name: {
            type: String,
            required: false,
        },
        statusChoosen: {
            type: Number,
            required: false,
        },
        currentService: {
            type: String,
            required: false,
        },
    },

    data() {
        return {
            modalElementId: (this.name ? this.name + '-' : '') + 'shipping-service-modal',
            title: SHIPPING_SERVICE_MODAL_TITLE,
            okText: OK_TEXT,
            cancelText: CANCEL_TEXT,
            serviceChoosen: this.currentService ?? AHAMOVE_SHIPPING_SERVICE,
            shippingServices: [],
        }
    },

    template: `<div class="modal fade" :id="modalElementId" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ title }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6" v-for="(value, key) in shippingServices">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" :id="(name ? name + '-' : '') + key" type="radio" :value="key" v-model="serviceChoosen">
                                <label :for="(name ? name + '-' : '') + key" class="custom-control-label font-weight-normal">{{ key | capitalize }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-right">
                    <button type="button" class="btn btn-outline-secondary btn-sm pl-4 pr-4"
                        data-dismiss="modal">{{ cancelText }}</button>
                    <button type="button" 
                        class="btn btn-outline-success btn-sm pl-4 pr-4" @click="submit()">{{ okText }}</button>
                </div>
            </div>
        </div>
    </div>`,

    mounted() {
        this.getShippingServices();
    },

    methods: {

        getShippingServices() {
            axios
                .get(GET_SHIPPING_SERVICE_URL)
                .then((response) => {
                    this.shippingServices = response.data.shippings;
                })
                .catch((error) => {
                    showResponseErrorMessage(error);
                });
        },

        submit() {
            this.$emit('update', {
                status: this.statusChoosen,
                shipping_method: this.serviceChoosen
            });
        },

        show() {
            $('#' + this.modalElementId).modal('show');
        },

        hide() {
            $('#' + this.modalElementId).modal('hide');
        },
    },

    filters: {
        capitalize(value) {
            if (!value) {
                return '';
            }
            value = value.toString()

            return value.charAt(0).toUpperCase() + value.slice(1)
        }
    },
}
