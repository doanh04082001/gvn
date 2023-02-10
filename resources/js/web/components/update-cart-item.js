import { query } from '../query';
import { commonCart } from '../common-cart';
import { common } from '../common';

export const updateCartItem = {
    reload: res => {
        axios.get(updateRoutes.getCartItemsHtml).then(response =>
            query('.order-items-block').innerHTML = response?.data
        );
        axios.get(updateRoutes.getCartDropdownRefresh).then(response =>
            query('#cart-dropdown-warp').innerHTML = response?.data
        );

        commonCart.updateCartDisplay(res);
    },

    updateProductQuantity: async (formId, target = null, type = null) => {
        const existsOtherCart = await updateCartItem.checkOtherCartExisted();

        if ((existsOtherCart && await updateCartItem.confirmToCreateNewCartOk()) || !existsOtherCart) {
            updateCartItem.setNewProductQuantity(formId, target, type);
            axios.post(updateRoutes.updateItem, updateCartItem.getFormData(formId))
                .then(updateCartItem.reload)
                .catch(e => commonCart.handleCartError(e, updateCartItem.reload))
        }
    },

    removeItem: (formId, target = null, type = null) => {
        axios.post(updateRoutes.removeItem, updateCartItem.getFormData(formId))
            .then(updateCartItem.reload)
            .catch(e => commonCart.handleCartError(e, updateCartItem.reload))
    },

    checkOtherCartExisted: () => {
        return axios
            .post(
                updateRoutes.checkOtherCartExist,
                { store_id: query('#current-store-id')?.value }
            )
            .then(({ data }) => (data.existed ?? false))
            .catch(commonCart.handleCartError)
    },

    confirmToCreateNewCartOk: () => new Promise((resolve, reject) => {
        common.confirm(
            Language.other_cart_exists_message,
            () => resolve(true),
            () => resolve(false),
        );
    }),

    setNewProductQuantity: (formId, target = null, type = null) => {
        let quantity = 0;

        if (target != null) {
            if (type == 'plus') {
                target.previousElementSibling.innerText = ++target.previousElementSibling.innerText;
                quantity = target.previousElementSibling.innerText;
            } else if (type == 'minus') {
                let productQuantity = target.nextElementSibling.innerText;
                target.nextElementSibling.innerText = productQuantity > 1 ? --productQuantity : productQuantity;
                quantity = target.nextElementSibling.innerText;
            }
        }

        query(`.form-${formId} input[name="product[quantity]"]`).value = quantity;
    },

    getFormData: formId => {
        const formData = new FormData(query(`.form-${formId}`));
        formData.append('_method', 'put')
        formData.append('store_id', query('#current-store-id')?.value);

        return formData;
    }
}
