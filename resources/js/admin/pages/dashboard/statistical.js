const app = new Vue({
    el: '#statistical',
    data: {
        storeId: null,
        totalOrder: '',
        totalOrderCcomplete: '',
        totalRevenue: '',
        totalCustomer: '',
    },

    mounted() {
        const app = this;
        $('#select-store').change(_.debounce(function () {
            app.storeId = this.value
            app.getStatisticalData(app.storeId)
        }, 200));
    },

    created() {
        this.getStatisticalData(this.storeId)
    },

    methods: {
        getStatisticalData(storeId) {
            const timezone = moment.tz.guess();
            axios.get(ROUTES.getStatisticaltData, {
                params: {
                    store_id: storeId,
                    timezone: timezone,
                }
            }).then((res) => {
                this.totalOrder = res.data.total_order;
                this.totalOrderCcomplete = res.data.total_order_complete;
                this.totalRevenue = res.data.total_revenue;
                this.totalCustomer = res.data.total_customer;
            });
        },
    }
});

