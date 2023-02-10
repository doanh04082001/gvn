import { common } from '../common';
import { handleCartError } from '../utils/handle-cart-error';
import { query } from '../query';

common.initModal('product-detail-modal');
const modalElement = document.getElementById('product-detail-modal');
const actionButton = modalElement.querySelectorAll('.modal-footer > .btn');

let productQuantity = 1;
let productApplyPrice = 0;
let productOriginPrice = 0;
let totalToppingPrice = 0;

window.productQuantityMinus = (target) => {
    if (productQuantity > 1)
        productQuantity--;
    target.nextElementSibling.innerText = productQuantity;
}

window.productQuantityPlus = (target) => {
    productQuantity++;
    target.previousElementSibling.innerText = productQuantity;
}

window.changeVariant = (applyPrice, originPrice) => {
    productApplyPrice = parseInt(applyPrice);
    productOriginPrice = parseInt(originPrice);

    updatePrice();
}

window.changeTopping = (input, toppingSalePrice) => {
    if (input.checked) {
        totalToppingPrice += parseInt(toppingSalePrice);
    } else {
        totalToppingPrice -= parseInt(toppingSalePrice);
    }

    updatePrice();
}

const updatePrice = () => {
    modalElement.querySelector('.product-apply-price').innerText = formatNumberWithCurrency(productApplyPrice + totalToppingPrice);
    modalElement.querySelector('.product-origin-price').innerText = formatNumberWithCurrency(productOriginPrice + totalToppingPrice);
}

const formatNumberWithCurrency = (number, currency = null) => {
    if (!currency) {
        return number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }).replace('₫', 'đ')
    }
}

window.addToCart = async (isNeededToRedirect = false) => {

    let formData = formToppingFilter(new FormData(document.querySelector('.product-detail-form')));
    formData.append('product[quantity]', productQuantity);

    if (!formData.get('store_id')) {
        common.getModal('product-detail-modal').hide();
        common.getModal('store-modal').show();
        return;
    }

    const existsOtherCart = await existsOtherCartRequest(formData.get('store_id'));

    if (existsOtherCart && !(await confirmToCreateNewCartOk())) {
        return;
    }

    const success = await addProductItemToCart(formData);
    common.getModal('product-detail-modal').hide();
    if (success && isNeededToRedirect) {
        return window.location.href = CART_PAGE_URL;
    }

    document.querySelector('#cart-dropdown-warp').innerHTML = await refreshDropdownComponent();
};

const confirmToCreateNewCartOk = () => new Promise((resolve, reject) => {
    common.confirm(
        Language.other_cart_exists_message,
        () => resolve(true),
        () => resolve(false),
    );
})

const existsOtherCartRequest = (storeId) => {
    return axios
        .post(CHECK_OTHER_CART_EXISTED_URL, { store_id: storeId })
        .then(({ data }) => data.existed)
        .catch(e => handleCartError(e));
};

const addProductItemToCart = (data) => {
    return axios
        .post(ADD_TO_CART_URL, data)
        .then(response => document.dispatchEvent(
            new CustomEvent('update_cart_item', { detail: response.data })
        ))
        .catch(e => handleCartError(e));
}

const refreshDropdownComponent = () => {
    return axios
        .get(REFRESH_DROPDOWN_COMPONENT_URL)
        .then(({ data }) => data)
        .catch(e => console.error(e));
}

export const productDetailModal = {
    showModal: (data) => {
        modalElement.querySelector('.modal-body').innerHTML = data;
        productDetailModal.reFresh();

        if (modalElement.querySelectorAll('.wrap-info .variants-detail, .wrap-info .toppings-detail').length < 1) {
            query('.wrap-info').classList.add('border-top-0');
        }

        common.getModal('product-detail-modal').show();
    },

    reFresh: () => {
        productQuantity = 1;
        productApplyPrice = parseInt(modalElement.querySelector('.product-apply-price').getAttribute('data'));
        productOriginPrice = parseInt(modalElement.querySelector('.product-origin-price').getAttribute('data'));
        totalToppingPrice = 0;
    },
}

const formToppingFilter = (formData) => {
    let toppingTypeQuantity = modalElement.querySelectorAll('.toppings-detail > .topping-group').length;

    for (var i = 0; i < toppingTypeQuantity; i++) {
        if (!formData.get(`product[toppings][${i}][id]`)) {
            formData.delete(`product[toppings][${i}][quantity]`);
        }
    }

    return formData;
}
