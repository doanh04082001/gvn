// import { showError, showResponseErrorMessage, showSuccess, showConfirm } from "../utils/alerts.js"
// import { ShippingServiceModal } from '../utils/shipping-service-modal.js';

// const orderShippingMixin = {
//     data: {
//         selectedOrderId: '',
//         statusChoosen: null,
//         statusProcessing: STATUS_PROCESSING,
//         statusShipping: STATUS_SHIPPING,
//         updateOrderShippingUrl: UPDATE_ORDER_SHIPPING_URL,
//         updateOrderStatusUrl: UPDATE_ORDER_STATUS_URL,
//     },

//     components: {
//         ShippingServiceModal
//     },

//     methods: {
//         showChangeStatusConfirm(id, status) {
//             const that = this;

//             showConfirm(
//                 () => that.submitChangeStatus(
//                     that.getChangeStatusUrl(id),
//                     status
//                 ),
//                 (() => that.cancelChangeStatus()),
//                 {
//                     title: CONFIRM_IMPORTANT_ACTION_TEXT,
//                     text: CONFIRM_CHANGE_ORDER_STATUS_HINT_TEXT,
//                 }
//             );
//         },

//         submitChangeStatus(url, status) {
//             const that = this;

//             axios
//                 .patch(url, { status: status })
//                 .then((response) => {
//                     that.reloadData(response.data);
//                     showSuccess(MODIFIED_SUCCESS)
//                 })
//                 .catch(that.castChangeStatusError)
//         },

//         castChangeStatusError(error) {
//             if (error?.response?.status == 422) {
//                 return showError(error?.response?.data?.errors?.status[0]);
//             }

//             return showResponseErrorMessage(error);
//         },

//         openOrderShippingModal(id, status) {
//             this.selectedOrderId = id;
//             this.statusChoosen = parseInt(status);

//             return this.$refs.shippingServiceModal.show();
//         },

//         changeOrderShipping(data) {
//             if (data.status) {
//                 return this.updateOrderShippingWithStatus(data)
//             }
//             return this.updateOrderShippingWithoutStatus(data);
//         },

//         updateOrderShippingWithStatus(params) {
//             const that = this;

//             axios
//                 .patch(that.getChangeStatusUrl(that.selectedOrderId), params)
//                 .then((response) => {
//                     that.reloadData(response.data);
//                     that.$refs.shippingServiceModal.hide();
//                     showSuccess(MODIFIED_SUCCESS);
//                 })
//                 .catch(that.castChangeOrderShippingError)
//         },

//         updateOrderShippingWithoutStatus(params) {
//             const that = this;

//             axios
//                 .put(that.getChangeOrderShippingUrl(that.selectedOrderId), params)
//                 .then((response) => {
//                     that.reloadData(response.data);
//                     that.$refs.shippingServiceModal.hide();
//                     showSuccess(MODIFIED_SUCCESS);
//                 })
//                 .catch(that.castChangeOrderShippingError)
//         },

//         reloadData(data) {
//             if (this.order) {
//                 this.order = data.order;
//                 this.status = data.order.status;
//                 this.statusChoosen = null;
//             }
//             if (this.datatableElement) {
//                 this.reloadTable();
//             }
//         },

//         castChangeOrderShippingError(error) {
//             if (error?.response?.status == 422) {
//                 return showError(error?.response?.data?.message);
//             }
//             return showResponseErrorMessage(error);
//         },

//         getChangeStatusUrl(id) {
//             return this.updateOrderStatusUrl.replace(':id', id);
//         },

//         getChangeOrderShippingUrl(id) {
//             return this.updateOrderShippingUrl.replace(':id', id);
//         },

//         needCreateShipping(order, status) {
//             return order.delivery_type == DELIVERY_TYPE_SHIPPING
//                 && !order.shipping_method
//                 && (status == STATUS_PROCESSING || status == STATUS_SHIPPING);
//         },

//         cancelChangeStatus() {
//             return;
//         },
//     },

//     filters: {
//         capitalize(value) {
//             if (!value) {
//                 return '';
//             }
//             value = value.toString()

//             return value.charAt(0).toUpperCase() + value.slice(1)
//         }
//     }
// }

// export { orderShippingMixin };
