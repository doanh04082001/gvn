import { HTTP_OK } from '../constants';
import { common } from '../common';
import { query } from '../query';
import { Reorder } from '../utils/reorder';
import { ReviewStore } from '../components/review-store';
import { loadOrderStatus } from '../components/load-order-status';
import { Chatbox } from '../components/chat-box';

window.ReviewStore = ReviewStore;
window.Chatbox = new Chatbox();

document.addEventListener("DOMContentLoaded", (event) => {
    common.initModal('review-store');
    common.initModal('order-detail');
    window.addEventListener('onfcm', (e) => {
        const data = JSON.parse(e.detail.payload?.data?.payload)?.data;
        const type = data?.type;
        const order = data?.order;

        if (NOTIFICATION_TYPES.includes(type)) {
            loadOrderStatus.loadOrderlist(order);
            loadOrderStatus.loadOrderDetail(order);
        }
    });
});

export const myOrder = {
    showModal: (selector, modal) => {
        axios.get(selector.dataset.url)
            .then(response => {
                if (response.status === HTTP_OK) {
                    common.replaceModalBody(modal, response.data);
                    common.getModal(modal).show();
                    const btnCancel = '.modal-action .btn.btn-cancel';
                    query(btnCancel).addEventListener('click', () => {
                        common.confirm(Language.cancel_order, () =>
                            axios.put(query(btnCancel).dataset.url)
                                .then(res => window.location.href = res?.data)
                        );
                    });
                }
            })
            .catch(e => console.error(e));
    },

    reorder: element => new Reorder(element)
}

window.myOrder = myOrder
