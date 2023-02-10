export const promotionsSlider = {
    buildPromotionsSlider: () => {
        const sliderShowHeroCarousel = document.querySelector('#sliderShowHero');
        const carousel = new bootstrap.Carousel(sliderShowHeroCarousel, {
            interval: 6000,
            pause: false,
        });
    }
}
