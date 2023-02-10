import { query } from './query';

export const common = {
    initModal: (id) => {
        new bootstrap.Modal(document.getElementById(id));
    },

    getModal: (id) => {
        return bootstrap.Modal.getInstance(document.getElementById(id))
    },

    replaceModalBody: (id, html) => {
        document.getElementById(id).querySelector('.modal-body').innerHTML = html;
    },

    getDeviceToken: () => {
        try {
            return FirebaseMessaging.getToken({ vapidKey: FirebasePublicKey }).then((currentToken) => {
                if (currentToken) {
                    document.dispatchEvent(new CustomEvent('update_device_token', {
                        detail: { token: currentToken }
                    }))
                } else {
                    console.log('No registration token available. Request permission to generate one.');
                }
            }).catch((err) => {
                console.log('An error occurred while retrieving token. ', err);
            });
        } catch (e) {
            console.log(e.message)
        }
    },

    htmlDialog: (id, cancelId, okId, message, title, isConfirm) => {
        let buttonsHTML = `<button type="button" class="btn btn-primary btn-shilin-primary" id="${okId}">${Language.button.ok}</button>`
        if (isConfirm) {
            buttonsHTML =
                `<button type="button" class="btn btn-secondary cancel btn-shilin-secondary" id="${cancelId}" data-bs-dismiss="modal">${Language.button.close}</button>
                 <button type="button" class="btn btn-primary btn-shilin-primary" id="${okId}">${Language.button.ok}</button>`
        }
        return `<div class="modal modal-secondary alert-modal" id="${id}"
                data-bs-backdrop="static"
                data-bs-keyboard="false"
                tabindex="-1"
                aria-labelledby="staticBackdropLabel"
                aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                              <div class="modal-header">
                                    <h5 class="modal-title text-center">${title}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body text-center">${message}</div>
                              <div class="modal-footer modal-footer-padding-base">${buttonsHTML}</div>
                        </div>
                    </div>
                </div>`;
    },

    alert: (message, okCallback = null, titleText = null) => {
        common.notification(message, okCallback, null, titleText, false)
    },

    confirm: (message, confirmCallback, cancelCallback = null, titleText = null) => {
        common.notification(message, confirmCallback, cancelCallback, titleText, true)
    },

    notification: (message, confirmCallback, cancelCallback = null, titleText = null, isConfirm = true) => {
        const currentTime = new Date().getTime()
        const title = titleText ?? 'Shillin'
        const id = `confirm_${currentTime}`
        const cancelId = `cancelId_${currentTime}`
        const okId = `okId_${currentTime}`
        const htmlDialog = common.htmlDialog(id, cancelId, okId, message, title, isConfirm)
        const dialogElement = document.createElement("div");
        dialogElement.innerHTML = htmlDialog;
        query('body').appendChild(dialogElement)
        common.initModal(id);
        if (isConfirm === true) {
            query('#' + cancelId).addEventListener('click', () => {
                if (cancelCallback !== null) {
                    cancelCallback();
                }
                common.getModal(id).hide();
                query('body').removeChild(dialogElement)
            })
        }
        query('#' + okId).addEventListener('click', () => {
            if (confirmCallback !== null) {
                confirmCallback()
            }
            common.getModal(id).hide();
            query('body').removeChild(dialogElement)
        })
        common.getModal(id).show();
    },

    convertToClientTz: (time, format = 'HH:mm - DD/MM/YYYY') => moment.utc(time).tz(moment.tz.guess()).format(format)
}
