const app = new Vue({
    el: '#app-user-form',
    components: {
        'v-select': VueSelect.VueSelect
    },
    data: {
        stores: STORES,
        userStores: STORES.filter(store => USER_STORES.includes(store.id)) ?? [],
        allStatus: ALL_STATUS,
        userStatus: USER_STATUS,
    },
    methods: {
        submitForm() {
            this.$refs.userFrm.submit();
        },

        toggleStatus(event) {
            event.target.checked
                ? this.userStatus = this.allStatus.active
                : this.userStatus = this.allStatus.inactive;
        }
    }
})
