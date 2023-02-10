import { showError, showSuccess } from '../utils/alerts.js';

const app = new Vue({
    el: '#app-momo-payment-form',

    mounted: () => {
        if (message != '') {
            showSuccess(message);
        }

        if (hasErrors) {
            showError(DATA_WAS_INVALID_ERROR_MESSAGE)
        }
    }
})
