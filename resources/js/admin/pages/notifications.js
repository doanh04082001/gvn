import { parseFcmPayload } from '../utils/parse-fcm-payload.js';
import { showResponseErrorMessage } from '../utils/alerts.js';

new Vue({
    el: '#notification-container',

    data: {
        notifications: [],
        totalUnread: TOTAL_UNREAD,
        isInit: false,
        isLoading: false,
        isLoadedLastPage: false,
        params: {
            createdAt: null,
            exceptedIds: [],
        },
        keyChange: 0,
        diffFromNowInterval: null,
    },

    mounted() {
        window.FCM.fcmHandle(this.fcmHandle);
        this.dropdownAddEventListener();
    },

    methods: {
        load() {
            this.isLoading = true;

            const that = this;

            return axios
                .get(GET_NOTIFICATION_URL, {
                    params: {
                        created_at: that.params.createdAt,
                        excepted_ids: that.params.exceptedIds,
                    },
                })
                .then(that.successLoadHandle)
                .catch(that.errorLoadHandle);
        },

        successLoadHandle({ data }) {
            const notifications = data?.notifications;

            this.appendNotificationsProperty(notifications);

            this.setTotalUnread(data?.total_unread);

            this.setParams(notifications);

            this.isInit = true;

            this.markIsLoaded();

            this.isLoadedLastPage = !notifications.length;
        },

        appendNotificationsProperty(responseNotifications) {
            this.notifications.push(
                ...this.renderNotifications(responseNotifications)
            );
        },

        setTotalUnread(totalUnread) {
            this.totalUnread = totalUnread;
        },

        setParams(responseNotifications) {
            this.setParamCreatedAt(responseNotifications);
            this.setParamExceptedIds(responseNotifications);
        },

        setParamCreatedAt(responseNotifications) {
            this.params.createdAt = responseNotifications.at(-1)?.created_at;
        },

        setParamExceptedIds(responseNotifications) {
            this.params.exceptedIds = this.getIdsAtCreatedAt(
                responseNotifications
            );
        },

        markIsLoaded() {
            this.isLoading = false;
        },

        errorLoadHandle(error) {
            this.markIsLoaded();
            return showResponseErrorMessage(error);
        },

        firstLoading() {
            if (this.isInit || this.isLoading) {
                return;
            }

            this.load();
        },

        loadMore(e) {
            if (!this.canLoadMore(e.target)) {
                return;
            }

            this.load();
        },

        canLoadMore(container) {
            return (
                Math.ceil(
                    $(container).scrollTop() + $(container).innerHeight()
                ) >= container.scrollHeight - 10 &&
                !this.isLoading &&
                !this.isLoadedLastPage
            );
        },

        getIdsAtCreatedAt(notifications) {
            const that = this;

            return notifications
                .filter(notification => notification.created_at == that.params.createdAt)
                .map(notification => notification.id);
        },

        renderNotification(responseNotification) {
            const data = responseNotification.data;

            return {
                id: responseNotification.id,
                icon: window.FCM.getAdminIcon(data),
                title: window.FCM.getTitle(data),
                body: window.FCM.getBody(data),
                web_push_url: data?.web_push_url,
                created_at: responseNotification.created_at,
                read_at: responseNotification.read_at,
            };
        },

        renderNotifications(responseNotifications) {
            const that = this;

            return responseNotifications.map(that.renderNotification);
        },

        fcmHandle({ data }) {
            const payload = parseFcmPayload(data);

            this.setTotalUnread(payload?.total_unread);

            if (!this.isInit) {
                return;
            }

            this.notifications.unshift(this.renderNotification(payload));
        },

        markAsRead(id, e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            let markNotification = this.notifications.find(notification => notification.id == id);

            if (markNotification?.read_at) {
                return;
            }

            const that = this;

            axios
                .patch(MARK_AS_READ_URL.replace(':id', id))
                .then(({ data }) => {
                    markNotification.read_at = data?.read_at;
                    that.setTotalUnread(data?.total_unread);
                })
                .catch(showResponseErrorMessage);
        },

        diffFromNow(dateString) {
            return moment.tz(dateString, 'UTC').fromNow();
        },

        dropdownAddEventListener() {
            $('#notification-container').on('shown.bs.dropdown', this.setDiffFromNowInterval);
            $('#notification-container').on('hide.bs.dropdown', this.dropdownHideHandle);
        },

        dropdownHideHandle() {
            this.keyChange = 0;
            clearInterval(this.diffFromNowInterval);
        },

        setDiffFromNowInterval() {
            this.updateKeyChange();

            const that = this;

            this.diffFromNowInterval = setInterval(() => that.updateKeyChange(), 60000);
        },

        updateKeyChange() {
            this.keyChange++;
        },

        markAllAsRead(e) {
            e.stopPropagation();

            const that = this;

            axios
                .put(MARK_AS_READ_ALL_URL)
                .then(({ data }) => {
                    that.notifications.forEach(notification => notification.read_at = data.read_at);
                    that.totalUnread = 0;                    
                })
                .catch(showResponseErrorMessage);
        }
    }
});
