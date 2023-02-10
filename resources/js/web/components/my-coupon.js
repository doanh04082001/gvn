import { SUCCESS_CODE } from '../constants';
import { common } from '../common'
import { HTTP_INTERNAL_SERVER_ERROR, HTTP_NOT_FOUND } from '../constants'

export const myCoupon = {

    listenMyCouponOnKeyUpEvent: () => {
        document.querySelector("#coupon_search").addEventListener("keyup", (e) => {
            axios.post(`${BASE_URL}/my/coupons`, {
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                code: e.target.value
            })
                .then((response) => {
                    document.querySelector(".my-coupon-wrap").innerHTML = response.data;
                })
                .catch(error => this.handleError(error))
        });
    },

    listenChoiceMyCoupon: () => {
        document.body.addEventListener('click', function (event) {
            if (event.target.classList.contains('coupon-accept')) {
                const couponId = event.target.getAttribute('coupon-id');
                const couponCode = event.target.getAttribute('coupon-code');
                axios.post(`${BASE_URL}/my/coupons/${couponId}`, {
                    code: couponCode
                })
                    .then((response) => {
                        if (response.data.code === SUCCESS_CODE) {
                            window.location.href = `${BASE_URL}/`
                        }
                    })
                    .catch(error => this.handleError(error))
            }
        });
    },

    handleError(error) {
        const response = error?.response
        if (!response) {
            return console.error(error);
        }

        return this.handleResponse(response)
    },

    handleResponse(response) {
        let message = '';

        switch (response.status) {
            case HTTP_INTERNAL_SERVER_ERROR:
                message = Language.error_retry
                break
            case HTTP_NOT_FOUND:
                message = messages.coupon_not_existed
                break
            default:
                break;

        }

        if (message) {
            return common.alert(message);
        }
    }
};
