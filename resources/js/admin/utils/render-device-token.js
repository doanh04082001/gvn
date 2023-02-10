export const renderDeviceToken = ($form) => {
    firebase.initializeApp(FirebaseCredentials);

    firebase.messaging().getToken({ vapidKey: FirebasePublicKey }).then((currentToken) => {
        if (currentToken) {
            $form.prepend(`<input type='hidden' name='device_token' value=${currentToken}>`)
        } else {
            console.log('No registration token available. Request permission to generate one.');
        }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
    });
}
