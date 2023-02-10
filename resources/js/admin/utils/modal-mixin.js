const modalMixin = {
    data: {
        modalElement: null
    },
    methods: {
        openModal() {
            $(this.modalElement).modal('show')
        },

        closeModal() {
            $(this.modalElement).modal('hide')
        }
    }
}

export { modalMixin }
