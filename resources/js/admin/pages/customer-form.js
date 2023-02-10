import {encodeNumber} from '../utils/format-number.js';

const app = new Vue({
    el: '#app-customer-form',

    data: {
        point: encodeNumber(POINT),
        orderCount: encodeNumber(ORDER_COUNT),
    },

    methods: {
        submitForm() {
            this.$refs.customerFrm.submit();
        }
    }
})
