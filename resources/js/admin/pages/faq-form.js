import { showSuccess, showResponseErrorMessage, showDeleteConfirm } from '../utils/alerts.js';
import { createFormData } from '../utils/create-form-data.js';

const errorsFormDefault = {
    question: [],
    answer: [],
    // group: [],
};

new Vue({
    el: '#app',
    components: {
        ckeditor: CKEditor.component
    },
    data: {
        url: URL,
        message: {},
        action: ACTION,
        faqForm: FAQ,
        errorsForm: errorsFormDefault,
        editorConfig: EditorConfig,
        editor: ClassicEditor,
    },

    methods: {
        save() {
            this.errorsForm = errorsFormDefault;
            axios
                .post(this.url, createFormData({
                    _method: this.action,
                    ...this.faqForm,
                }))
                .then(() => {
                    showSuccess(SAVE_SUCCESS)
                    window.location.href = FAQ_INDEX;
                })
                .catch(error => {
                    if (error?.response?.status === 422) {
                        this.errorsForm = error?.response?.data?.errors ?? errorsFormDefault
                    }
                    showResponseErrorMessage(error)
                })
        },
    }
});
