/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const Vue = require('vue').default;

Vue.use({
    install(Vue, options) {
        Vue.prototype.redirectToUrl = require('./utils/redirect-to-url')
        Vue.redirectToUrl = require('./utils/redirect-to-url')
    },
})

window.Vue = Vue;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });

window.onImageError = require('./utils/on-image-error');

window.FirebaseCredentials = require('../firebase/firebase-client-credentials.json');
window.FirebasePublicKey = process.env.MIX_FIREBASE_PUBLIC_KEY;
/**
 * CONFIG ENVIRONTMENT FOR JS
 */
window.MAP_API_KEY = process.env.MIX_GOOGLE_MAPS_API_KEY;
window.DATATABLE_LANGUAGE = process.env.MIX_DATATABLE_LANGUAGE;

window.GOONG_MAP_API_KEY = process.env.MIX_GOONG_MAP_API_KEY;
window.GOONG_MAP_MAPTILES_KEY = process.env.MIX_GOONG_MAP_MAPTILES_KEY;
