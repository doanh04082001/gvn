import {common} from '../common'
import {
    SUCCESS_CODE,
    HTTP_UNPROCESSABLE,
    UNVERIFIED_CODE,
    HTTP_FORBIDDEN,
    HTTP_UNAUTHORIZED
} from '../constants';
import {query, queryAll} from "../query";

export const loginForm = {
    showLoginForm: () => {
        document.addEventListener('update_device_token', (e) => {
            query('#login-form #device_token').value = '';
            if (e.detail.token) {
                query('#login-form #device_token').value = e.detail.token ?? '';
            }
        })
        queryAll(".show-login-modal").forEach((e) => {
            e.addEventListener("click", () => {
                common.getModal('login-form-modal').show()
                common.getModal('register-form-modal').hide()
                common.getDeviceToken()
            })
        })
    },

    listenLoginFormSubmitEvent: () => {
        query("#login-form").addEventListener("submit", (e) => {
            query('#login-fail').classList.add('d-none');
            axios.post(`${BASE_URL}/auth/login`, new FormData(query("#login-form")))
                .catch(loginForm.handleError)
                .then((response) => {
                    if (response.data.code === SUCCESS_CODE) {
                        window.location.reload();
                    }
                });
            e.preventDefault();
            return false
        });
    },

    handleReverifyOtp: () => {
        axios.post(`${BASE_URL}/auth/reverify-otp`, new FormData(query("#login-form")))
            .catch(loginForm.handleError)
            .then(loginForm.showRevalidateOtp);
    },

    showRevalidateOtp: (response) => {
        if (response.data.code === SUCCESS_CODE) {
            query('#otp-register-form input[name="customer_id"]')
                .value = response.data.data.customer_id
            query('#otp-register-form input[name="request_id"]')
                .value = response.data.data.request_id
            common.getModal('login-form-modal').hide();
            common.getDeviceToken()
            common.getModal('otp-register-form-modal').show();
        }
    },

    handleError(errorResponse) {
        const response = errorResponse?.response;

        if (response.status === HTTP_FORBIDDEN && response.data.code === UNVERIFIED_CODE) {
            common.confirm(Language.account_unverified, loginForm.handleReverifyOtp)
        }

        if (response.status === HTTP_UNAUTHORIZED) {
            query('#login-fail').classList.remove('d-none');
        }

        if (response.status === HTTP_UNPROCESSABLE) {
            const errors = response?.data?.errors
            queryAll('#login-form .error').forEach((e) => {
                e.classList.add('d-none');
            });
            Object.keys(errors).forEach((v, i) => {
                query('#login-form .error-' + v).classList.remove('d-none');
                query('#login-form .error-' + v).textContent = errors[v].join(',');
            })
        }
    },

    initModalLogin: () => {
        common.initModal('login-form-modal')
    }
}
