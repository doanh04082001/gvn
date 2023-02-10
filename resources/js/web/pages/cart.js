import { common } from '../common';
import { query } from '../query';
import { commonCart } from '../common-cart';
import { addressForm } from '../components/address-form';
import { voucherList } from '../components/voucher-list';
import { updateCartItem } from '../components/update-cart-item';

document.addEventListener('DOMContentLoaded', () => {
    const windowReload = () => window.location.reload();
    common.initModal('delivery-address-modal');
    common.initModal('add-address-modal');
    common.initModal('add-voucher-modal');
    common.initModal('add-payment-modal');

    const deliveryTime = query('.delivery-time');
    deliveryTime.innerText = commonCart.setDeliveryTime(deliveryTime.getAttribute('data-received-at'));
    addressForm.createShippingAddress(routes.createShippingAddress, routes.searchAddress);

    const radios = document.querySelectorAll('input[type=radio][name="group-shipping-method"]');
    radios.forEach(radio => radio.addEventListener('change', () => {
        voucherList.displayVoucher();
        axios.put(updateRoutes.deliveryType, { delivery_type: radio.value })
            .then(updateCartItem.reload)
            .catch(e => commonCart.handleCartError(e, windowReload));
    }));

    voucherList.displayVoucher();

    query('.show-delivery-address-modal')?.addEventListener('click', () => {
        commonCart.checkedDefaultRadio('input[name=radio-group-address]', '.delivery-address .address');
        common.getModal('delivery-address-modal').show()
    });

    query('#delivery-address-modal .search-btn').addEventListener('click', () => {
        addressForm.getAddressList(routes.searchAddress, query('#delivery-address-modal .search-input').value)
    });

    query('.btn-add-address').addEventListener('click', () => {
        common.getModal('add-address-modal').show();
        common.getModal('delivery-address-modal').hide();
    });

    query('#address-list-form').addEventListener('submit', (e) => {
        const shippingAddress = query('input[name=radio-group-address]:checked')?.getAttribute('data-address') || '';
        query('.delivery-address .address').innerHTML = shippingAddress;
        query('.delivery-address .address').setAttribute('data-checked', shippingAddress);
        common.getModal('delivery-address-modal').hide();
        voucherList.displayVoucher();
        axios
            .put(updateRoutes.shippingAddress, { shipping_address: shippingAddress })
            .then(updateCartItem.reload)
            .catch(err => commonCart.handleCartError(err, windowReload))
        e.preventDefault();
        return false;
    });

    query('.province-select').addEventListener('change', () => {
        addressForm.clearDataSelect(['.district-select', '.ward-select'])
        addressForm.getDataOptions(routes.getDistrict, '.province-select', '.district-select');
    });

    query('.district-select')
        .addEventListener('change', () =>
            addressForm.getDataOptions(routes.getWard, '.district-select', '.ward-select'));

    query('#add-address-modal')
        .addEventListener('hidden.bs.modal', () => {
            addressForm.resetForm('#shipping-address-form')
        });

    query('.voucher-btn').addEventListener('click', () => {
        commonCart.checkedDefaultRadio('input[name=radio-group-voucher]', '.voucher-name');
        common.getModal('add-voucher-modal').show()
    });

    voucherList.checkboxOnlyOne('#add-voucher-modal .custom-radio');

    query('#add-voucher-modal .btn-accept')
        .addEventListener('click', () => {
            common.getModal('add-voucher-modal').hide();
            axios
                .put(updateRoutes.voucher, {
                    voucher: query('input[name=radio-group-voucher]:checked')?.value,
                    store_id: query('#current-store-id')?.value
                })
                .then(updateCartItem.reload)
                .catch(e => commonCart.handleCartError(e, windowReload))
        });

    query('.note-shipping-input').addEventListener('blur', () => {
        axios
            .put(updateRoutes.note, { note: query('.note-shipping-input').value })
            .then(updateCartItem.reload)
            .catch(e => commonCart.handleCartError(e, windowReload));
    });

    query('#add-voucher-modal .search-btn')
        .addEventListener('click', () =>
            voucherList.getVoucherList(routes.searchVoucher, query('#add-voucher-modal .search-input').value));

    query('.payment-btn').addEventListener('click', () => {
        commonCart.checkedDefaultRadio('input[name=radio-group-payment]', '.payment-name');
        common.getModal('add-payment-modal').show()
    });

    query('#add-payment-modal .btn-accept')
        .addEventListener('click', () => {
            query('.payment .payment-name').innerHTML = query('input[name=radio-group-payment]:checked + label > .payment-label')?.innerHTML || defaultPaymentText;
            query('.payment .payment-name').setAttribute('data-checked', query('input[name=radio-group-payment]:checked')?.value);
            common.getModal('add-payment-modal').hide()
            axios
                .put(updateRoutes.paymentMethod, {
                    payment_method: query('input[name=radio-group-payment]:checked')?.value || ''
                })
                .then(updateCartItem.reload)
                .catch(e => commonCart.handleCartError(e, windowReload))
        });

    query('.able-order-btn')?.addEventListener('click', () => {
        query('.able-order-btn').disabled = true;
        axios
            .post(updateRoutes.order).then(
                res => window.location.href = res?.data?.data?.payment_redirect || routes.myOrder
            )
            .catch(error => commonCart.handleCartError(
                error,
                () => query('.able-order-btn').disabled = false)
            );
    });

    window.productQuantityMinus = (target, frmId) => {
        updateCartItem.updateProductQuantity(frmId, target, 'minus');
    }

    window.productQuantityPlus = (target, frmId) => {
        updateCartItem.updateProductQuantity(frmId, target, 'plus');
    };

    window.removeCartItem = frmId => {
        updateCartItem.removeItem(frmId);
    }

    query('.delete-voucher-btn')?.addEventListener('click', () => {
        axios.put(updateRoutes.voucher, {
            voucher: null,
            store_id: query('#current-store-id')?.value
        })
            .then(updateCartItem.reload)
            .catch(commonCart.handleCartError)
    });
});
