require('./bootstrap');
window.Language = require('../web/lang/vi.json')
import {registerForm} from './components/register-form';
import {forgotPasswordForm} from './components/forgot-password-form';
import {newPasswordForm} from './components/new-password-form';
import {loginForm} from './components/login-form';
import {store} from './components/store';
import {otpRegisterVerification} from './components/otp-register-verification';
import {footer} from './components/footer';
import {searchArea} from './components/search-area';
import {commonNotification} from './components/common-notification.js';

document.addEventListener('DOMContentLoaded', (event) => {
    loginForm.initModalLogin()
    loginForm.showLoginForm()
    loginForm.listenLoginFormSubmitEvent()
    store.initModalStore()
    store.listenShowStore()
    store.listenChoiceStore()
    footer.listenSubcribleFormSubmitEvent()
    registerForm.initModalRegiter()
    registerForm.showRegisterForm()
    registerForm.listenRegisterFormSubmitEvent()
    // registerForm.maskDate()
    forgotPasswordForm.initModalForgotPassword()
    forgotPasswordForm.showForgotPasswordForm()
    forgotPasswordForm.listenForgotPasswordFormSubmitEvent()
    newPasswordForm.initModalNewPassword()
    newPasswordForm.listenNewPasswordFormSubmitEvent()
    otpRegisterVerification.initModalOtpRgister()
    otpRegisterVerification.listenOtpRegisterSubmit()
    otpRegisterVerification.listenOtpCodeKeyUp()
    otpRegisterVerification.listenOtpResent()
    otpRegisterVerification.listenDeviceToken()
    searchArea.listenCartItemUpdate()
    commonNotification.initNotification()
});
