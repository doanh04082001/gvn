import { productDetailModal } from '../components/product-detail';

const axios = require('axios');

export const productItem = {
    init: () => {
        productItem.listenClickEvent();
        productItem.checkFlexImage();

        window.addEventListener('resize', () => {
            productItem.checkFlexImage();
        });
    },

    checkFlexImage: () => {
        document.querySelectorAll('.image-product-wrap').forEach((ele) => {
            const styles = window.getComputedStyle(ele);
            ele.style.height = (ele.clientWidth - parseFloat(styles.paddingLeft) - parseFloat(styles.paddingRight)) + 'px';
        });
    },

    listenClickEvent: () => {
        document.querySelectorAll('.product-item-wrap').forEach(item => {
            item.addEventListener('click', (event) => {
                const url = event.target.closest('.product-item-wrap').getAttribute('data-url')

                axios
                    .get(url)
                    .then((response) => {
                        if (response.status === 200) {
                            productDetailModal.showModal(response.data);
                        }
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            });
        });
    },
}
