import { common } from '../common';
import {
    HTTP_INTERNAL_SERVER_ERROR,
    HTTP_UNAUTHORIZED,
    HTTP_UNPROCESSABLE,
    ORDER_IS_EMPTY_CODE,
    ORDER_MISSING_PROPERTY_CODE,
    PRODUCT_NOT_EXISTS_CODE,
    STORE_NOT_EXISTS_CODE,
    VARIANT_NOT_EXISTS_CODE,
    TOPPING_NOT_EXISTS,
    VOUCHER_CAN_NOT_APPLY_STORE_CODE,
    VOUCHER_CAN_NOT_USE_CODE,
    VOUCHER_IS_OVERUSED_CODE,
    VOUCHER_NOT_REACHED_MIN_VALUE_CODE,
    SHIPPING_SERVICE_REQUEST_FAIL_CODE
} from '../constants';

export const handleCartError = (error, callback = null) => {
    const response = error?.response

    if (response) {
        const message = castErrorMessage(response)
        if (message) {
            common.alert(message, callback)
        }
    }

    throw error;
}

export const castErrorMessage = response => {
    let message = '';

    if ([HTTP_UNAUTHORIZED, HTTP_INTERNAL_SERVER_ERROR].includes(response?.status)) {
        return
    }

    message = Language.error_retry;

    if (response.status == HTTP_UNPROCESSABLE) {
        switch (response.data.code) {
            case STORE_NOT_EXISTS_CODE:
                message = Language.store_not_exists
                break

            case PRODUCT_NOT_EXISTS_CODE:
            case VARIANT_NOT_EXISTS_CODE:
            case TOPPING_NOT_EXISTS:
                message = Language.product_not_exists
                break

            case ORDER_MISSING_PROPERTY_CODE:
            case VOUCHER_CAN_NOT_USE_CODE:
            case VOUCHER_CAN_NOT_APPLY_STORE_CODE:
            case VOUCHER_NOT_REACHED_MIN_VALUE_CODE:
            case VOUCHER_IS_OVERUSED_CODE:
            case ORDER_IS_EMPTY_CODE:
            case SHIPPING_SERVICE_REQUEST_FAIL_CODE:
                message = response?.data?.message
                break;

            default:
                message = response.data.errors[Object.keys(response.data.errors)[0]];
                break
        }
    }

    return message
}
