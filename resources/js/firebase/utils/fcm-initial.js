firebase.initializeApp(FirebaseCredentials);

firebase.messaging().onMessage((payload) => {
    window.dispatchEvent(
        new CustomEvent('onfcm', {
            detail: { payload }
        })
    );
});
