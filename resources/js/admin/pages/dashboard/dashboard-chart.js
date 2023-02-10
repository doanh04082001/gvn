import {barChart}  from './bar-chart.js';

const app = new Vue({
    el: '#top-order-product-chart',
    components: {
        'bar-chart': barChart,
    },
    data: {
        storeId: null
    },

    mounted() {
        const app = this;
        $('#select-store').change(_.debounce(function () {
            app.storeId = this.value
            app.reloadChart()
        }, 200));
    },

    methods: {
        reloadChart() {
            this.$refs.chart.getChartData(this.storeId)
        }
    }
})

