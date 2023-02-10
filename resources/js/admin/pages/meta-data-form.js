import { PreviewImage } from '../utils/preview-image.js';

new Vue({
    el: '#app-meta-data',
    components: {
        'v-select': VueSelect.VueSelect,
        PreviewImage
    },
    data: {
        selected: CURRENT_PAGE
    },
    methods: {
        onPageChange(value) {
            this.$refs.url.value = value?.url || '';
            this.selected = value;
        }
    }
});
