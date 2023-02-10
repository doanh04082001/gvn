import {common} from '../common'
import {ERROR_CODE, HTTP_UNPROCESSABLE, SUCCESS_CODE} from '../constants';

export const registerForm = {
    showRegisterForm: () => {
        document.querySelectorAll(".show-register-modal").forEach((e) => {
            e.addEventListener("click", () => {
                common.getModal('register-form-modal').show();
                common.getModal('login-form-modal').hide();
            })
        });
    },

    listenRegisterFormSubmitEvent: () => {
        document.querySelector("#register-form").addEventListener("submit", (e) => {
            document.querySelectorAll('.error').forEach((e) => {
                e.classList.add('d-none');
            });
            axios
                .post(`${BASE_URL}/auth/register`, new FormData(document.querySelector("#register-form")))
                .catch(registerForm.handleErrors)
                .then(registerForm.handleSuccess)
            e.preventDefault();
        });
    },

    handleSuccess: (response) => {
        if (response.data.code === SUCCESS_CODE) {
            document.querySelector('#otp-register-form input[name="customer_id"]')
                .value = response.data.data.customer_id
            document.querySelector('#otp-register-form input[name="request_id"]')
                .value = response.data.data.request_id
            common.getModal('register-form-modal').hide();
            common.getDeviceToken()
            common.getModal('otp-register-form-modal').show();
        }
    },

    handleErrors: (errorResponse) => {
        const response = errorResponse?.response;
        if (response.code === ERROR_CODE) {
            document.querySelector('#sign-up-fail').classList.remove('d-none')
        }
        if (response.status === HTTP_UNPROCESSABLE) {
            const errors = response?.data?.errors
            Object.keys(errors).forEach((v, i) => {
                document.querySelector('#register-form .error-' + v).classList.remove('d-none');
                document.querySelector('#register-form .error-' + v).textContent = errors[v].join(',');
            })
        }
    },

    maskDate: () => {
        document.querySelector('#register-form input[name="birthday"]')
            .addEventListener('keyup', (e) => {
                let v = e.target.value;
                if (v.match(/^\d{2}$/) !== null) {
                    e.target.value = v + '/';
                } else if (v.match(/^\d{2}\/\d{2}$/) !== null) {
                    e.target.value = v + '/';
                }
            })
    },

    initModalRegiter: () => {
        common.initModal('register-form-modal')
    }
}
