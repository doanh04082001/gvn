import {query} from "../query";

export const searchArea = {
    listenCartItemUpdate: () => {
        document.addEventListener('update_cart_item', (e) => {
            if (e.detail?.totalItems) {
                query('.mb-item-count').textContent = e.detail?.totalItems ?? 0;
            }
        })
    }
}
