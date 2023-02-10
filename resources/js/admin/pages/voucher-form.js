import {showResponseErrorMessage} from '../utils/alerts.js';
import {convertToClientTz, convertToUtcTz} from '../utils/timezone.js';
import {encodeNumber, decodeNumber} from '../utils/format-number.js';

const app = new Vue({
    el: '#app-voucher-form',
    data: {
        voucher: VOUCHER ?? {
            code: null,
            type: null,
            name: null,
            discount_amount: null,
            max_apply: null,
            min_order_amount: null,
            start_at: null,
            expire_at: null,
            max_discount_amount: null,
            description: null,
            apply_time: null,
            status: null
        },
        errors: []
    },
    computed: {
        maxApplyDisplay: {
            get() {
                return encodeNumber(this.voucher.max_apply);
            },
            set(val) {
                this.voucher.max_apply = decodeNumber(val);
            }
        },
        discountAmountDisplay: {
            get() {
                return encodeNumber(this.voucher.discount_amount);
            },
            set(val) {
                this.voucher.discount_amount = decodeNumber(val);
            }
        },
        minOrderAmountDisplay: {
            get() {
                return encodeNumber(this.voucher.min_order_amount);
            },
            set(val) {
                this.voucher.min_order_amount = decodeNumber(val);
            }
        },
        maxDiscountAmountDisplay: {
            get() {
                return encodeNumber(this.voucher.max_discount_amount);
            },
            set(val) {
                this.voucher.max_discount_amount = decodeNumber(val);
            }
        },
        startAtDisplay: {
            get() {
                return convertToClientTz(this.voucher.start_at, 'YYYY-MM-DDTHH:mm');
            },
            set(val) {
                this.voucher.start_at = convertToUtcTz(val)
            }
        },
        expireAtDisplay: {
            get() {
                return convertToClientTz(this.voucher.expire_at, 'YYYY-MM-DDTHH:mm');
            },
            set(val) {
                this.voucher.expire_at = convertToUtcTz(val);
            }
        }
    },
    methods: {
        submitForm() {
            this.voucher.status = +this.voucher.status;
            isEdit ? this.submitEdit() : this.submitCreate()
        },

        submitCreate() {
            axios
                .post(SUBMIT_URL, this.voucher)
                .then(res => this.redirectToUrl(res.data))
                .catch(this.handleErrors)
        },

        submitEdit() {
            axios
                .put(SUBMIT_URL, this.voucher)
                .then(res => this.redirectToUrl(res.data))
                .catch(this.handleErrors)
        },

        handleErrors(error) {
            const res = error?.response;
            const errorsArr = [];
            if (res?.status === 422) {
                const errors = res?.data?.errors;
                Object.entries(errors).forEach(item => {
                    const nameSplit = item[0].split(".");
                    errorsArr[nameSplit] = item[1][0];
                });
                this.errors = errorsArr;
            }

            showResponseErrorMessage(error)
        },

        changeType() {
            this.voucher.type == voucherTypeFix && (this.maxDiscountAmountDisplay = '');
        }
    }
});
