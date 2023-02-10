import {HTTP_OK} from "../constants";

export const favoriteStore = {
    removeFavoriteStore: (storeId) => {
        axios.delete(ROUTES.removeFavoriteStore.replace(':storeId', storeId))
            .then(response => {
                if (response.status === HTTP_OK && response.data.is_favorite) {
                    document.getElementById(storeId).remove();
                }
            })
            .catch(e => console.error(e));
    },
};

window.favoriteStore = favoriteStore

