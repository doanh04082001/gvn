window.FCM.fcmHandle(({ data }) => {
    pendingOrderVue.reloadPendingOrderTable(data);
    processingOrderVue.reloadProcessingOrderTable(data);
});
