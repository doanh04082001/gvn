const app = new Vue({
    el: '#static-pages-form',
    components: {
        ckeditor: CKEditor.component
    },
    data: {
        allStatus: ALL_STATUS,
        staticPageStatus: STATIC_PAGE_STATUS,
        staticPageContent: STATIC_PAGE_CONTENT,
        editorConfig: EditorConfig,
        editor: ClassicEditor
    },
    methods: {
        submitForm() {
            this.$refs.staticPageFrm.submit();
        },

        toggleStatus(event) {
            event.target.checked
                ? this.staticPageStatus = this.allStatus.active
                : this.staticPageStatus = this.allStatus.inactive;
        }
    }
});
