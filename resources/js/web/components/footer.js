import {HTTP_UNPROCESSABLE} from '../constants';
import {common} from "../common";
import {query} from "../query";

export const footer = {

    listenSubcribleFormSubmitEvent: () => {
        document.querySelector("#email-subcrible").addEventListener("submit", (e) => {
            document.querySelector('.error-subcrible-email').classList.add('d-none');
            axios.post(`${BASE_URL}/subscribe/mailchimp`, {
                email: document.querySelector('#email-subcrible input[name="email"]').value
            })
                .catch(footer.handleError)
                .then((response) => {
                    common.alert(response.data.data.messages)
                });
            e.preventDefault();
            document.querySelector('#email-subcrible input[name="email"]').value = '';
        });
    },

    handleError(errorResponse) {
        const response = errorResponse?.response;
        if (response.status === HTTP_UNPROCESSABLE) {
            common.alert(query('.error-subcrible-email').textContent)
        }
    },
}
