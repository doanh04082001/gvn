import {
    ERROR_CODE,
    USER_BLOCK_CODE,
    HTTP_INTERNAL_SERVER_ERROR,
    HTTP_UNAUTHORIZED,
    HTTP_UNPROCESSABLE,
    HTTP_FORBIDDEN, OUT_OF_WORKING_TIME,
} from "./constants";
import {common} from "./common";

const axios = require('axios')

axios.interceptors.request.use(function (config) {
    // Do something before request is sent
    if (['post', 'put', 'patch'].includes(config.method)) {
        axios.defaults.headers.common = {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };
    }
    document.getElementById('loader-wrapper').style.visibility = "visible";
    return config;
}, function (error) {
    // Do something with request error
    document.getElementById('loader-wrapper').style.visibility = "hidden";
    return Promise.reject(error);
});

// Add a response interceptor
axios.interceptors.response.use(function (response) {
    // Any status code that lie within the range of 2xx cause this function to trigger
    // Do something with response data
    document.getElementById('loader-wrapper').style.visibility = "hidden";
    return response;
}, function (error, status) {

    //handle error internal server
    if (error?.response?.data?.code === OUT_OF_WORKING_TIME) {
        common.alert(Language.out_of_working_time);
        document.getElementById('loader-wrapper').style.visibility = "hidden";
        return Promise.reject(error);
    }

    if (error?.response?.status === HTTP_INTERNAL_SERVER_ERROR) {
        common.alert(Language.error_retry);
    }

    //handle error authentication
    if (!error?.config?.url.includes('/auth/login') && error?.response?.status === HTTP_UNAUTHORIZED) {
        common.alert(Language.error_unauthorized, () => common.getModal('login-form-modal').show());
    }
    //handle user block exception
    if (
        error?.response?.status === HTTP_FORBIDDEN &&
        error?.response?.data?.code === USER_BLOCK_CODE
    ) {
        common.alert(Language.account_blocked, () => {
            if (!error?.config?.url.includes("/auth/login")) {
                window.location.replace(`${BASE_URL}/auth/logout`);
            }
        });
    }

    // Any status codes that falls outside the range of 2xx cause this function to trigger
    // Do something with response error
    document.getElementById('loader-wrapper').style.visibility = "hidden";
    return Promise.reject(error);
});

export {axios}
