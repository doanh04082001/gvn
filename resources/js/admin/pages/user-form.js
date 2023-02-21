const app = new Vue({
    el: '#app-user-form',
    components: {
        'v-select': VueSelect.VueSelect
    },
    data: {
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
