export const PreviewImage = {
    props: {
        image: File | String,
        inputName: '',
        className: '',
        styles: {
            minWidth: String,
            maxWidth: String,
            maxHeight: String
        },
        defaultImage: String,
    },

    data() {
        return {
            previewImage: ''
        };
    },

    template: `<div>
        <input :name="inputName" type="file" ref="uploadFileInput"
            @change="onFileChange" accept=".png, .jpg, .jpeg, .bmp, .gif" class="d-none"/>
        <span class="btn up-img-btn">
            <img :class="'preview-img-style img-thumbnail ' + className" @click="uploadFile"
            :style="imageStyle" :src="previewImage ? previewImage : initImage" @error="handleImageError">
            <span v-if="!!previewImage" class="btn del-img-btn" @click="removePreviewImage">
                <i class="fa fa-times"></i>
            </span>
        </span>
    </div>`,

    computed: {
        imageStyle() {
            const minWidth = this?.styles?.minWidth ?? '200px';
            const maxWith = this?.styles?.maxWidth ?? '300px';
            const maxHeight = this?.styles?.maxHeight ?? '300px';

            return `min-width: ${minWidth}; max-width: ${maxWith}; max-height: ${maxHeight}`
        },

        initImage() {
            if (this.defaultImage == 'rectangle') {
                return DEFAULT_RECTANGLE_IMAGE
            }

            if (this.defaultImage == 'rectangle_2x3') {
                return DEFAULT_RECTANGLE_2x3_IMAGE
            }

            return DEFAULT_SQUARE_IMAGE;
        },
    },

    mounted() {
        this.previewImage = this.image;
    },

    methods: {
        handleImageError(e) {
            onImageError(e.target, this.defaultImage)
        },

        onFileChange(e) {
            const files = e.target.files || e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                this.previewImage = URL.createObjectURL(file);
                this.$emit('file-changed', file);
            }
        },

        removePreviewImage() {
            this.$refs.uploadFileInput.value = null;
            this.previewImage = '';
            this.$emit('file-changed', '');
        },

        uploadFile() {
            this.$refs.uploadFileInput.click();
        },
    },
}
