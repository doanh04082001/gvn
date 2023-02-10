const axios = require('axios')

axios.interceptors.request.use(function (config) {
    // Do something before request is sent
    if (['post', 'put', 'patch'].includes(config.method)) {
        axios.defaults.headers.common = {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };
    }

    if(!config.url.includes('/notifications')) {
        $("#loader-wrapper").show();
    }
    
    return config;
}, function (error) {
    // Do something with request error
    $('#loader-wrapper').hide();
    return Promise.reject(error);
});

// Add a response interceptor
axios.interceptors.response.use(function (response) {
    // Any status code that lie within the range of 2xx cause this function to trigger
    // Do something with response data
    $('#loader-wrapper').hide();
    return response;
}, function (error) {
    // Any status codes that falls outside the range of 2xx cause this function to trigger
    // Do something with response error
    $('#loader-wrapper').hide();
    return Promise.reject(error);
});

module.exports = axios;
