import { common } from '../common'
import {
    HTTP_INTERNAL_SERVER_ERROR,
    HTTP_UNPROCESSABLE,
    HTTP_NOT_FOUND
} from '../constants'
import { castErrorMessage } from './handle-cart-error'

export class Reorder {
    constructor(element) {
        this.orderId = element.getAttribute('data-order-id')
        this.storeId = element.getAttribute('data-store-id')

        this.handle()
    }

    async handle() {
        const canReorder = await axios
            .post(ROUTES.cartExists)
            .then(response => this.confirmReorder(response?.data?.existed))
            .catch(error => this.handleReorderError(error))

        if (canReorder) {
            const response = await this.sendReorder()
            if (response) {
                window.location.href = ROUTES.cart
            }
        }
    }

    confirmReorder(otherCartExisted = false) {
        return otherCartExisted
            ? new Promise((resolve, reject) => {
                common.confirm(
                    Language.confirm_cart_existed,
                    () => resolve(true),
                    () => resolve(false),
                )
            })
            : Promise.resolve(true)
    }

    sendReorder() {
        return axios
            .post(ROUTES.reorder.replace(':orderId', this.orderId), {
                store_id: this.storeId
            })
            .then(res => res)
            .catch(error => this.handleReorderError(error))
    }

    handleReorderError(error) {
        const response = error?.response
        if (!response) {
            return console.error(error);
        }

        return this.showReorderError(response)
    }

    showReorderError(response) {
        let message = '';

        switch (response.status) {
            case HTTP_INTERNAL_SERVER_ERROR:
                message = Language.error_retry
                break
            case HTTP_UNPROCESSABLE:
                message = castErrorMessage(response)
                break
            case HTTP_NOT_FOUND:
                message = messages.order_not_existed
                break
            default:
                break;

        }

        if (message) {
            common.alert(message, () => {
                if (message == Language.product_not_exists) {
                    window.location.href = ROUTES.cart
                }
            })
        }
    }
}
