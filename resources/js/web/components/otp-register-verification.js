import {common} from '../common'
import {HTTP_UNPROCESSABLE, SUCCESS_CODE, OTP_LENGTH, ERROR_CODE} from '../constants';

export const otpRegisterVerification = {
    listenDeviceToken: () => {
        document.addEventListener('update_device_token', (e) => {
            document.querySelector('#otp-register-form [name=device_token]').value = '';
            if (e.detail.token) {
                document.querySelector('#otp-register-form [name=device_token]').value = e.detail.token ?? '';
            }
        })
    },

    listenOtpRegisterSubmit: () => {
        document.querySelector("#otp-register-form")
            .addEventListener("submit", (e) => {
                document.querySelector('#otp-register-form button[type="submit"]').disabled = true;
                document.querySelector('#otp-register-form .otp-fail').classList.add('d-none');
                document.querySelectorAll('.error').forEach((e) => {
                    e.classList.add('d-none');
                });
                axios
                    .post(`${BASE_URL}/auth/opt-register-validate`,
                        new FormData(document.querySelector("#otp-register-form"))
                    )
                    .catch(otpRegisterVerification.handleErrors)
                    .then(otpRegisterVerification.handleValidateSuccess)
                e.preventDefault();
                document.querySelector('#otp-register-form input[name="otp"]').value = '';
            });
    },

    handleValidateSuccess: (response) => {
        if (response.data.code === SUCCESS_CODE) {
            window.location.reload();
        }
    },

    handleErrors: (errorResponse) => {
        const response = errorResponse?.response;
        if (response.data.code === ERROR_CODE) {
            document.querySelector('#otp-register-form .otp-fail').classList.remove('d-none');
            document.querySelector('#otp-register-form .otp-fail').innerHTML = response.data.message;
        }
        if (response.status === HTTP_UNPROCESSABLE) {
            const errors = response?.data?.errors
            Object.keys(errors).forEach((v, i) => {
                document.querySelector('.error-' + v).classList.remove('d-none');
                document.querySelector('.error-' + v).textContent = errors[v].join(',');
            })
        }
    },

    listenOtpCodeKeyUp: () => {
        document.querySelector('#otp-register-form input[name="otp"]')
            .addEventListener('keyup', (e) => {
                document.querySelector('#otp-register-form button[type="submit"]').disabled = false;
                if (e.target.value.length === OTP_LENGTH) {
                    document.querySelector('#otp-register-form button[type="submit"]').disabled = false;
                }
            });
    },

    listenOtpResent: () => {
        document.querySelector('#otp-register-form .retry')
            .addEventListener('click', (e) => {
                axios
                    .post(`${BASE_URL}/auth/otp-resend`,
                        new FormData(document.querySelector("#otp-register-form"))
                    )
                    .catch(otpRegisterVerification.handleErrors)
                    .then(otpRegisterVerification.handleResendSuccess)
                e.preventDefault();
            })
    },

    handleResendSuccess: (response) => {
        if (response.data.code === SUCCESS_CODE) {
            common.alert(Language.otp_resent)
        }
    },

    initModalOtpRgister: () => {
        common.initModal('otp-register-form-modal')
    }
}
