export const categories = {
    buildCategoriesSlider: function () {
        try {
            new Swiper(".categories-slider", {
                slidesPerView: 3,
                autoplay: {
                    delay: 2500,
                },
                spaceBetween: 10,
                breakpoints: {
                    640: {
                        slidesPerView: 3,
                    },
                    768: {
                        slidesPerView: 4,
                    },
                    1024: {
                        slidesPerView: 5,
                    },
                },
            });
        } catch (e) {
            console.log(e);
        }
    }
}

