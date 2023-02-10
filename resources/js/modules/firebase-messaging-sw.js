importScripts('/vendor/firebase8.6.1/firebase-app.js');
importScripts('/vendor/firebase8.6.1/firebase-messaging.js');

const config = require('../firebase/firebase-client-credentials.json');
const { getTitle, getBody } = require('../firebase/utils/helper');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp(config);

// Retrieve an instance of Firebase Messaging so that it can handle background messages.
firebase.messaging().onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
});

self.addEventListener('push', (event) => {
    const response = JSON.parse(event.data && event.data.text());

    const { image } = response?.notification;
    const payload = JSON.parse(response?.data?.payload ?? '{}');

    console.log('[firebase-messaging-sw.js] Received background message ', payload);

    const payloadData = payload.data;

    event.waitUntil(
        self.registration.showNotification(
            getTitle(payloadData),
            {
                body: getBody(payloadData),
                icon: image,
                image,
                data: {
                    web_push_url: payloadData.web_push_url ?? process.env.MIX_APP_URL
                }
            })
    )
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data.web_push_url)
    );
});
