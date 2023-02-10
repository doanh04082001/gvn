import { query } from '../query';

export const notificationSetting = {
    listenNotificationSettingEvent: () => {
        const statusCb = query('.notification-setting .change-state');
        statusCb.addEventListener('click', (e) => {
            const checked = e.target.checked;
            axios.put('/my/setting/notification', {
                'notification_state': +checked
            })
                .catch(() => {
                    statusCb.checked = !checked;
                })
        });
    },
};
