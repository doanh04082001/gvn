import { query, queryAll } from '../query';

export const loadOrderStatus = {
    loadOrderlist: (order) => {
        const orderDom = query(`li.order[data-order-id="${order.id}"]`);
        orderDom && (loadOrderlistStatus(orderDom, order.status) || loadOrderlistPaymentStatus(orderDom, order.payment_status));
    },

    loadOrderDetail: (order) => {
        if (query('#order-id')?.value == order.id) {
            const status = order?.status || orderStatus.pending;
            const elmCssString = '#order-detail .progress-container .progressbar li';
            queryAll(elmCssString).forEach(item => {
                const elm = query(`li[data-status="${item.dataset.status}"]`);
                elm.classList.remove('active');
                elm.dataset.status <= status && elm.classList.add('active');
            });

            if (status == orderStatus.processing || status == orderStatus.shipping) {
                document.getElementById('open-chat').style.display = 'block';
            } else {
                document.getElementById('open-chat').style.display = 'none';
            }

            const statusLabelHide = status == orderStatus.cancel ? orderStatus.pending : orderStatus.cancel;
            const statusLabelShow = status == orderStatus.cancel ? orderStatus.cancel : orderStatus.pending;

            query(`${elmCssString} span.label.label-${statusLabelHide}`)?.classList.add('d-none');
            query(`${elmCssString} span.label.label-${statusLabelShow}`)?.classList.remove('d-none');

            queryAll('.modal-action .btn').forEach(item => {
                query(`.modal-action .${item.classList?.value.trim().replaceAll(' ', '.')}`)
                    ?.classList
                    .add('d-none');
            });

            status === orderStatus.pending && query('.modal-action .btn.btn-cancel')?.classList.remove('d-none');
            status === orderStatus.done && query('.modal-action .btn.btn-review')?.classList.remove('d-none');
            (status === orderStatus.done || status === orderStatus.cancel)
            && query('.modal-action .btn.btn-reorder')?.classList.remove('d-none');

            const paymentStatusDom = query('#order-detail .order-detail-info .payment-status');
            if (paymentStatusDom && paymentStatusDom.getAttribute('data-payment-status') != order.payment_status) {
                paymentStatusDom.setAttribute('data-payment-status', order.payment_status);
                paymentStatusDom.innerHTML = paymentStatusText[order.payment_status];
            }
        }
    }
}

const loadOrderlistStatus = (orderDom, receivedStatus) => {
    const statusDom = orderDom.querySelector('.status');

    if (statusDom.getAttribute('data-status') != receivedStatus) {
        statusDom.setAttribute('data-status', receivedStatus);
        statusDom.innerHTML = orderStatusHtmls[receivedStatus];

        if (receivedStatus == orderStatus.done) {
            orderDom.querySelector('.btn-review')?.classList.remove('d-none');
        }
    }
}

const loadOrderlistPaymentStatus = (orderDom, receivedPaymentStatus) => {
    const paymentStatusDom = orderDom.querySelector('.payment-status');
    if (paymentStatusDom && paymentStatusDom.getAttribute('data-payment-status') != receivedPaymentStatus) {
        paymentStatusDom.setAttribute('data-payment-status', receivedPaymentStatus);
        paymentStatusDom.innerHTML = `&bull;&nbsp;&nbsp;${paymentStatusText[receivedPaymentStatus]}`;
    }
}
