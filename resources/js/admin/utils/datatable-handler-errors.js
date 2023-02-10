import { showResponseErrorMessage } from './alerts.js';

$.fn.dataTable.ext.errMode = function (settings) {
    showResponseErrorMessage({ response: settings.jqXHR });
};
