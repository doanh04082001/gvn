const images = new DataTransfer();
const maxImageUpload = process.env.MIX_MAX_QUANTITY_IMAGE_UPLOAD;

export const ImageUploadPreview = {
    onChangeImage: () => {
        Promise.resolve()
            .then(() => {
                Object.entries(event.target.files).forEach(([key, file]) => {
                    if (file.type.match('image') && images.items.length < maxImageUpload) {
                        images.items.add(file);

                        if (images.items.length == maxImageUpload) {
                            document.querySelector('.image-upload').style.display = 'none';
                        }

                        const reader = new FileReader();
                        reader.onload = (e) => {
                            ImageUploadPreview.createImagePreview(e.target.result, file);
                        }
                        reader.readAsDataURL(file);
                    }
                })
            })
            .then(ImageUploadPreview.setImageInput)
    },
    createImagePreview: (imageSrc, file) => {
        const imgPreview = document.createElement('div');
        imgPreview.classList.add('image-preview');
        const img = document.createElement('img');
        img.setAttribute('src', imageSrc);
        imgPreview.appendChild(img);

        const removeImage = document.createElement('i');
        removeImage.classList.add('badge', 'bg-danger', 'rounded-pill', 'image-remove', 'shilin-cancle');
        removeImage.addEventListener('click', () => {
            Object.entries(images.files).forEach(([k, v]) => {
                if (v === file) {
                    images.items.remove(k);
                    ImageUploadPreview.setImageInput();
                }
            })
            removeImage.parentNode.remove()
            if (images.items.length < maxImageUpload) {
                document.querySelector('.image-upload').style.display = 'block';
            }
        })
        imgPreview.appendChild(removeImage);

        const imgUpload = document.querySelector('.image-upload');
        imgUpload.parentNode.insertBefore(imgPreview, imgUpload);
    },
    setImageInput: () => {
        document.getElementById('image-upload-input').files = images.files
    }
}
