const Languagues = require('./languages')
const {
    TYPE_NEW_ORDER,
    TYPE_UPDATE_STATUS_ORDER,
    TYPE_CANCEL_ORDER,
    TYPE_SHIPPING_ACCEPTED,
    TYPE_SHIPPING_CANCELLED
} =  require('./types')

const replaceStrByObject = (str, object) => {
    Object.keys(object).forEach(key => {
        str = str.replaceAll(`:${key}`, object[key])
    })

    return str;
}

export const getTitle = (data, lang = 'vi') => {
    const languague = Languagues[lang];
    let title = languague.default_title
    switch (data?.type) {
        case TYPE_NEW_ORDER:
            title = languague.orders.new_order.title
            break
        case TYPE_UPDATE_STATUS_ORDER:
            title = languague.orders.update_status.title
            break
        case TYPE_CANCEL_ORDER:
            title = languague.orders.cancel_order.title
            break
        case TYPE_SHIPPING_ACCEPTED:
            title = languague.shipping.accepted.title
            break
        case TYPE_SHIPPING_CANCELLED:
            title = languague.shipping.cancel.title
            break
        default:
            break
    }

    return title
}

/**
 * Get body.
 *
 * @return string
 */
export const getBody = (data, lang = 'vi') => {
    const languague = Languagues[lang];
    let body = ''
    switch (data?.type) {
        case TYPE_NEW_ORDER:
            body = replaceStrByObject(languague.orders.new_order.body, {
                code: data?.order?.code
            })
            break
        case TYPE_UPDATE_STATUS_ORDER:
            body = replaceStrByObject(languague.orders.update_status.body, {
                code: data?.order?.code,
                status: languague.orders.status_options[data?.order?.status]
            })
            break
        case TYPE_CANCEL_ORDER:
            body = replaceStrByObject(languague.orders.cancel_order.body, {
                code: data?.order?.code,
                store_name: data?.order?.store?.name ?? ''
            })
            break
        case TYPE_SHIPPING_ACCEPTED:
            body = replaceStrByObject(languague.shipping.accepted.body, {
                code: data?.order?.code,
                store_name: data?.order?.store?.name ?? ''
            })
            break
        case TYPE_SHIPPING_CANCELLED:
            body = replaceStrByObject(languague.shipping.cancel.body, {
                code: data?.order?.code,
                store_name: data?.order?.store?.name ?? ''
            })
            break
        default:
            break
    }

    return body
}

/**
 * Get icon.
 *
 * @return string
 */
export const getIcon = data => {
    let iconClass = 'shilin-infor-bell';

    switch (data?.type) {
        case TYPE_NEW_ORDER:
        case TYPE_UPDATE_STATUS_ORDER:
        case TYPE_CANCEL_ORDER:
            iconClass = 'shilin-infor-order';
            break;
        default:
            break;
    }

    return iconClass;
}

/**
 * Get admin icon.
 *
 * @return string
 */
export const getAdminIcon = data => {
    const type = data?.type;

    return `${getAdminIconFont(type)} ${getAdminIconColor(data)}`;
}

/**
 * Get admin icon font.
 *
 * @return string
 */
const getAdminIconFont = type => {
    let iconFont = 'fas fa-volume-up';

    switch (type) {
        case TYPE_NEW_ORDER:
        case TYPE_UPDATE_STATUS_ORDER:
        case TYPE_CANCEL_ORDER:
            iconFont = 'fas fa-clipboard-list';
            break;
        case TYPE_SHIPPING_ACCEPTED:
        case TYPE_SHIPPING_CANCELLED:
            iconFont = 'fa fa-motorcycle';
            break;
        default:
            break;
    }

    return iconFont;
}

/**
 * Get admin icon color.
 *
 * @return string
 */
const getAdminIconColor = (data, languague = 'vi') => {
    let iconColor = 'text-primary';

    switch (data?.type) {
        case TYPE_NEW_ORDER:
        case TYPE_SHIPPING_ACCEPTED:
            iconColor = 'text-success';
            break;
        case TYPE_UPDATE_STATUS_ORDER:
            iconColor = 'text-warning';
            break;
        case TYPE_CANCEL_ORDER:
        case TYPE_SHIPPING_CANCELLED:
            iconColor = 'text-danger';
            break;
        default:
            break;
    }

    if (data?.order?.status == Languagues[languague].orders.status.done) {
        iconColor = 'text-primary'
    }

    return iconColor;
}

/**
 * Firebase cloud messaging handle.
 *
 * @return void
 */
export const fcmHandle = callback => {
    window.addEventListener('onfcm', (e) => {
        callback(e.detail.payload);
    });
}

if (typeof window != 'undefined') {
    window.FCM = {
        getTitle,
        getBody,
        getIcon,
        getAdminIcon,
        fcmHandle
    };
}
