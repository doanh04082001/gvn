import { PreviewImage } from '../utils/preview-image.js';
import { mapNumberEncodeDisplay } from '../utils/map-number-encode-display.js'
import { convertToClientTz, convertToUtcTz } from '../utils/timezone.js';

const app = new Vue({
    el: '#app-promotion-form',

    components: {
        PreviewImage,
        'v-select': VueSelect.VueSelect
    },

    data: {
        errors: [],
        showRectangle: false,
        type,
        discountValue,
        maxDiscountAmount,
        promotionPositions,
        status,
        promotionStores,
        promotionProducts,
        startAt,
        expireAt,
    },

    computed: {
        ...mapNumberEncodeDisplay([
            'discountValue',
            'maxDiscountAmount',
        ]),
        startAtDisplay: {
            get() {
                return convertToClientTz(this.startAt, 'YYYY-MM-DDTHH:mm');
            },
            set(val) {
                this.startAt = convertToUtcTz(val)
            }
        },
        expireAtDisplay: {
            get() {
                return convertToClientTz(this.expireAt, 'YYYY-MM-DDTHH:mm');
            },
            set(val) {
                this.expireAt = convertToUtcTz(val);
            }
        },
        positionOptions: () => Object.keys(POSITION_OPTIONS)
            .map(k => ({ id: k, text: POSITION_OPTIONS[k] }))
    },

    methods: {
        handleTypeChange() {
            if (this.type == TYPE_SAME_PRICE) {
                this.maxDiscountAmount = '';
            }
        },
    }
});
