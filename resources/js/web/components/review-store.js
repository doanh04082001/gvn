import { ImageUploadPreview } from './image-upload-preview';
import {HTTP_OK} from "../constants";

export const ReviewStore = {
    addTag: () => {
        let selector = document.querySelector('.review-content');
        selector.value += (selector.value ? ', ' : '') + event.target.textContent ;
    },

    changeFavoriteStore: (storeId) => {
        axios.post(ROUTES.favoriteStore.replace(':storeId', storeId))
            .then((response) => {
                const heartStore = document.getElementById('heart_store');
                if (response.status === HTTP_OK) {
                    heartStore.classList.remove('heart-store');
                    if (response.data.is_favorite) {
                        heartStore.classList.add('heart-store');
                    }
                }
            })
            .catch(e => console.error(e));
    },

    ...ImageUploadPreview
}
