import { categories } from '../components/categories';
import { promotionsSlider } from '../components/slider-show-hero';
import { productItem } from '../components/product-item';

document.addEventListener("DOMContentLoaded", (event) => {
    categories.buildCategoriesSlider();
    promotionsSlider.buildPromotionsSlider();
    productItem.init();
});
