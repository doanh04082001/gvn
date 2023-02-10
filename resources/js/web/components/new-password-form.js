import {common} from '../common'
import {HTTP_UNPROCESSABLE, HTTP_OK, OTP_FAIL} from '../constants';

export const newPasswordForm = {
    listenNewPasswordFormSubmitEvent: () => {
        document.querySelector("#new-password-form").addEventListener("submit", (e) => {
            axios.post(`${BASE_URL}/auth/new-password`, new FormData(document.querySelector("#new-password-form")))
                .catch(newPasswordForm.handleError)
                .then(newPasswordForm.handleSuccess);
            e.preventDefault();
            return false
        });
    },

    handleSuccess: (response) => {
        if (response.status === HTTP_OK) {
            window.location.reload();
        }
    },

    handleError(errorResponse) {
        document.querySelector('#new-password-form .error').classList.add('d-none');
        const response = errorResponse?.response;
        if (response.status === HTTP_UNPROCESSABLE) {
            if (response.data.code == OTP_FAIL) {
                document.querySelector('#new-password-form .error-otp').classList.remove('d-none');
                document.querySelector('#new-password-form .error-otp').innerHTML = response.data.message;
            } else {
                const errors = response?.data?.errors
                document.querySelectorAll('#new-password-form .error').forEach((e) => {
                    e.classList.add('d-none');
                });
                Object.keys(errors).forEach((v, i) => {
                    document.querySelector('#new-password-form .error-' + v).classList.remove('d-none');
                    document.querySelector('#new-password-form .error-' + v).textContent = errors[v].join(',');
                })
            }
        }
    },

    initModalNewPassword: () => {
        common.initModal('new-password-form-modal')
    }
}
