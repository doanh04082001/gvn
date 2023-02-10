import { common } from './common';
import { query, queryAll } from './query';
import { handleCartError } from './utils/handle-cart-error';

export const commonCart = {
    getTwoDigit: input => `0${input}`.slice(-2),

    getTwoDigitMonth: month => ('0' + (month + 1)).slice(-2),

    handleCartError,

    checkedDefaultRadio: (elm, fromElm) => {
        queryAll(elm).forEach(input =>
            input.value == query(fromElm).getAttribute('data-checked') ? input.checked = true : input.checked = false
        );
    },

    updateCartDisplay: res => {
        const data = res?.data?.order;
        query('.total-quantity-count').innerText = res?.data?.totalItems || 0;
        if (data) {
            query('.cart-delivery-address').innerText = data?.shipping_address || '';
            query('.delivery-time').innerText = commonCart.setDeliveryTime(data?.received_at);
            query('.cart-price-amount').innerText = commonCart.formatMoney(data?.amount);
            query('.cart-shipping-fee-amount').innerText = commonCart.formatMoney(data?.shipping_fee);
            query('.cart-discount-amount').innerText = (data?.discount == 0 ? '' : '- ') + commonCart.formatMoney(data?.discount);
            query('.cart-total-amount').innerText = commonCart.formatMoney(data?.amount + data?.shipping_fee - data?.discount);
            query('.voucher .voucher-name').innerText = data?.voucher?.name || defaultVoucherText;
            query('.voucher .voucher-name').setAttribute('data-checked', data?.voucher?.code || null);
            query('.shopping-cart .store-order-info').innerHTML = commonCart.buildStoreHtml(data?.store);
            commonCart.toggleCartDeliveryAddress(data?.delivery_type);
            commonCart.toggleDeleteVoucherButton(data?.voucher);
            commonCart.toggleDisplayDeliveryTime(data?.delivery_type);
        }
    },

    buildStoreHtml(store) {
        return `<span class="store-name">${store?.name}</span>
                <span> - ${store?.phone} - ${store?.address}</span>`;
    },

    toggleDeleteVoucherButton(voucher) {
        if (voucher != null) {
            query('.delete-voucher-btn').classList.remove('d-none');
            query('.voucher .shilin-top').classList.add('d-none');
        } else {
            query('.delete-voucher-btn').classList.add('d-none');
            query('.voucher .shilin-top').classList.remove('d-none');
        }
    },

    toggleDisplayDeliveryTime(deliveryType) {
        if (deliveryType == DELIVERY_TYPE_AT_STORE) {
            query('.delivery-time-block').classList.add('d-none');
        } else {
            query('.delivery-time-block').classList.remove('d-none');
        }
    },

    setDeliveryTime: (receivedAt) => {
        return receivedAt
            ? common.convertToClientTz(receivedAt)
            : commonCart.getDefaultShippingTime(30);
    },

    formatMoney: (num, suffix = 'đ') => (num?.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") + suffix) || '0đ',

    getDefaultShippingTime: addMinutes => {
        const date = new Date();
        date.setMinutes(date.getMinutes() + addMinutes);
        return commonCart.getTwoDigit(date.getHours()) + ':' + commonCart.getTwoDigit(date.getMinutes()) + ' - ' +
            commonCart.getTwoDigit(date.getDate()) + '/' + commonCart.getTwoDigitMonth(date.getMonth()) + '/' +
            date.getFullYear();
    },

    toggleCartDeliveryAddress(deliveryType) {
        if (deliveryType == DELIVERY_TYPE_SHIPPING) {
            query('.cart-change-delivery-address').classList.remove('d-none')
            query('.cart-delivery-address').classList.remove('d-none')
        } else {
            query('.cart-change-delivery-address').classList.add('d-none')
            query('.cart-delivery-address').classList.add('d-none')
        }
    }
}
