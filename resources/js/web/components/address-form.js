import { HTTP_UNPROCESSABLE, SUCCESS_CODE } from '../constants';
import { common } from '../common';
import { query, queryAll } from '../query';

export const addressForm = {
    createShippingAddress: (url, addressUrl) => {
        query('#shipping-address-form').addEventListener('submit', (e) => {
            axios
                .post(url, new FormData(query('#shipping-address-form')))
                .then(res => {
                    if (res.data.code === SUCCESS_CODE) {
                        addressForm.getAddressList(addressUrl);
                        common.getModal('delivery-address-modal').show();
                        common.getModal('add-address-modal').hide();
                    }
                })
                .catch(addressForm.handleError)
            e.preventDefault();
            return false;
        });
    },

    getDataOptions: (url, elm, goalElm) => {
        axios.get(url.replace(':id', query(elm).value))
            .then(res => {
                let options = '<option value=""></option>';
                const data = res?.data;
                if (data.length > 0) {
                    data.forEach(item => {
                        options += `<option value='${item.id}'>${item.name}</option>`;
                    });
                    query(goalElm).innerHTML = options;
                }
            })
            .catch(error => console.log(error))
    },

    clearDataSelect: selectElm => {
        if (selectElm.length > 0) {
            selectElm.forEach(item => {
                query(item).innerHTML = '';
            })
        }
    },

    getAddressList: (url, keyword = '') => {
        axios.get(url + '?keyword=' + keyword)
            .then(res => {
                query('.radio-group-wrap').innerHTML = res?.data;
                common.checkedDefaultRadio('input[name=radio-group-address]', '.delivery-address .address');
            })
            .catch(error => console.log(error))
    },

    handleError: errorResponse => {
        const response = errorResponse?.response;
        if (response?.status === HTTP_UNPROCESSABLE) {
            const errors = response?.data?.errors
            queryAll('#shipping-address-form .error').forEach((e) => {
                e.classList.add('d-none');
            });
            Object.keys(errors).forEach((v, i) => {
                query('#shipping-address-form .error-' + v).classList.remove('d-none');
                query('#shipping-address-form .error-' + v).textContent = errors[v].join(',');
            })
        }
    },

    resetForm: form => {
        query(form).reset();
        queryAll(form + ' .error').forEach((e) => {
            e.classList.add('d-none');
        });
    }
}
