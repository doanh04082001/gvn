import {axios} from "./axios-loader";

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.FirebaseCredentials = require('../firebase/firebase-client-credentials.json');
try {
    firebase.initializeApp(FirebaseCredentials);
    window.FirebaseMessaging = firebase.messaging();
    window.FirebaseMessaging.onMessage((payload) => {
        window.dispatchEvent(new CustomEvent('onfcm', {
            detail: {payload}
        }));
    });
} catch (e) {
    console.log(e)
}
window.FirebasePublicKey = process.env.MIX_FIREBASE_PUBLIC_KEY;
window.BASE_URL = process.env.MIX_APP_URL;
