import { query, queryAll } from "../query";
import { common } from "../common";

export const voucherList = {
    getVoucherList: (url, code) => {
        axios.get(url + '?code=' + code)
            .then(res => {
                query('.vouchers-block').innerHTML = res?.data;
                common.checkedDefaultRadio('input[name=radio-group-voucher]', '.voucher-name');
                voucherList.checkboxOnlyOne('#add-voucher-modal .custom-radio');
            })
            .catch(e => console.log(e))
    },

    checkboxOnlyOne: (className) => {
        const inputs = queryAll(className), checkboxes = [];

        for (let i = 0; i < inputs.length; i++) {
            if (inputs[i].type === 'checkbox') {
                checkboxes.push(inputs[i]);
                inputs[i].addEventListener('change', function() {
                    if (this.checked) {
                        for (let j = 0; j < checkboxes.length; j++) {
                            if (checkboxes[j] !== this) {
                                checkboxes[j].checked = false;
                            }
                        }
                    }
                });
            }
        }
    },

    displayVoucher: () => {
        if (query('.cart-delivery-address').innerHTML.trim() == '' && query('input[type=radio][name="group-shipping-method"]:checked').value != DELIVERY_TYPE_AT_STORE) {
            query('.voucher').style.display = 'none';
        } else {
            query('.voucher').style.display = 'block';
        }
    }
}
