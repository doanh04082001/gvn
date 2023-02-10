import {common} from '../common'
import {
    ERROR_CODE,
    HTTP_UNPROCESSABLE,
    HTTP_OK,
    SUCCESS_CODE,
    UNAUTHENTICATED,
    BLOCK_CODE,
    HTTP_FORBIDDEN
} from '../constants';
import {query} from "../query";

export const forgotPasswordForm = {
    showForgotPasswordForm: () => {
        document.addEventListener('update_device_token', (e) => {
            query('#new-password-form input[name="device_token"]').value = '';
            if (e.detail.token) {
                query('#new-password-form input[name="device_token"]').value = e.detail.token ?? '';
            }
        });

        document.querySelectorAll(".show-forgot-password-form-modal").forEach((e) => {
            e.addEventListener("click", () => {
                common.getModal('forgot-password-form-modal').show();
                common.getModal('login-form-modal').hide();
            })
        });
    },

    listenForgotPasswordFormSubmitEvent: () => {
        document.querySelector("#forgot-password-form").addEventListener("submit", (e) => {
            axios.post(`${BASE_URL}/auth/forgot-password/otp`, new FormData(document.querySelector("#forgot-password-form")))
                .catch(forgotPasswordForm.handleError)
                .then(forgotPasswordForm.handleSuccess);
            e.preventDefault();
            return false
        });
    },

    handleSuccess: (response) => {
        if (response.status === HTTP_OK) {
            document.querySelector('#new-password-form input[name="customer_id"]')
                .value = response.data.customer_id
            document.querySelector('#new-password-form input[name="request_id"]')
                .value = response.data.request_id
            common.getDeviceToken()
            common.getModal('forgot-password-form-modal').hide();
            common.getModal('new-password-form-modal').show();
        }
    },

    handleError(errorResponse) {
        const response = errorResponse?.response;
        if (response.status === HTTP_UNPROCESSABLE) {
            const errors = response?.data?.errors
            document.querySelectorAll('#forgot-password-form .error').forEach((e) => {
                e.classList.add('d-none');
            });
            Object.keys(errors).forEach((v, i) => {
                document.querySelector('#forgot-password-form .error-' + v).classList.remove('d-none');
                document.querySelector('#forgot-password-form .error-' + v).textContent = errors[v].join(',');
            })
        }
        if (response.status === HTTP_FORBIDDEN) {
            common.alert(Language.account_blocked)
        }
    },

    initModalForgotPassword: () => {
        common.initModal('forgot-password-form-modal')
    }
}
