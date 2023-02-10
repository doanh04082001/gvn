import { getBody, getIcon, getTitle } from '../../firebase/utils/helper'
import { common } from '../common'
import { query, queryAll } from '../query'

export const commonNotification = {
    initNotification() {
        queryAll('.notification-item').forEach(item => {
            commonNotification.renderNotification(item)
        })

        window.addEventListener('onfcm', (e) => {
            const payload = JSON.parse(e.detail.payload?.data?.payload)
            commonNotification.changeTotalUnreadElement(payload?.total_unread)
            commonNotification.changeReadAllText(payload?.total_unread)
            commonNotification.reloadNotificationDropdown()
            commonNotification.reloadMyNotificationsPage()
        })
    },

    renderNotification(item) {
        const notification = JSON.parse(
            item.getAttribute('data-notification')
        )
        item.querySelector('.shilin-notification-icon')
            .classList
            .add(getIcon(notification.data))

        item.querySelector('.notification-title').innerHTML = getTitle(notification.data).replaceAll("\n", '<br />')
        item.querySelector('.notification-body').innerHTML = getBody(notification.data).replaceAll("\n", '<br />')

        commonNotification.renderReadAt(item, notification)
        commonNotification.handleClickNotification(item)
    },

    renderReadAt(item, notification) {
        const readedAtElement = item.querySelector('.notification-created-at')
        if (readedAtElement) {
            readedAtElement.innerHTML = common.convertToClientTz(
                notification.created_at,
                'HH:mm DD-MM-YYYY'
            )
        }
    },

    handleClickNotification(item) {
        item.addEventListener('click', () => {
            const target = item.querySelector('a')
            const url = target.getAttribute('data-notification-url')
            if (target.classList.contains('unread')) {
                commonNotification.readNotification(
                    target.getAttribute('data-notification-id'),
                    url
                )
            } else {
                window.location.href = url
            }
        })
    },

    readNotification(id, url) {
        axios.put(READ_ONE_NOTIFICATION_URL.replace(':id', id))
            .then(() => window.location.href = url)
            .catch(err => console.error(err))
    },

    changeTotalUnreadElement(totalUnread) {
        queryAll('.notification-total-unread').forEach(element => {
            if (totalUnread) {
                element.classList.remove('d-none')
                element.innerHTML = totalUnread
            } else {
                element.classList.add('d-none')
                element.innerHTML = 0
            }
        })
    },

    changeReadAllText(totalUnread) {
        const readAllElement = query('#read-all-form a')
        if (!readAllElement) {
            return
        }

        readAllElement.innerHTML = READ_ALL_TEXT.replace(':total_unread', totalUnread)
    },

    reloadNotificationDropdown() {
        axios.get(GET_NOTIFICATION_VIEW_ITEMS)
            .then(({ data }) => {
                query('.dropdown-menu').innerHTML = data
                queryAll('.dropdown-menu .notification-item').forEach(item => {
                    commonNotification.renderNotification(item)
                })
            })
            .catch(err => console.error(err))
    },

    reloadMyNotificationsPage() {
        const notificationContainer = query('.notification-container')
        if (!notificationContainer) {
            return
        }
        const page = notificationContainer.querySelector('.page-item.active>span')?.innerHTML ?? 1;
        axios.get(GET_NOTIFICATION_VIEW_ITEMS + `?page=${page}`)
            .then(({ data }) => {
                notificationContainer.querySelectorAll('.notification-item')
                    .forEach(item => item.remove())
                notificationContainer.insertAdjacentHTML('beforeend', data)

                notificationContainer.querySelectorAll('.notification-item')
                    .forEach(item => {
                        commonNotification.renderNotification(item)
                    })
            })
            .catch(err => console.error(err))
    }
}
