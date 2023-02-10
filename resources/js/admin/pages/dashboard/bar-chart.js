export const barChart = {
    extends: VueChartJs.Bar,
    props: ['storeId'],
    data: function () {
        return {
            dataChart: [],
            dataLabel: [],
            dataColor: [],
        }
    },

    created() {
        this.getChartData(this.storeId)
    },

    methods: {
        getChartData(storeId) {
            const app = this
            const timezone = moment.tz.guess();
            axios.get(ROUTES.getBarChartData, {
                params: {
                    store_id: storeId,
                    timezone: timezone,
                }
            }).then((res) => {
                app.dataLabel = res.data.product_name
                app.dataChart = res.data.quantity
                app.dataColor = res.data.color
                this.doRenderChart()
            });
        },

        doRenderChart() {
            this.renderChart(
                {
                    labels: this.dataLabel,
                    datasets: [
                        {
                            backgroundColor: '#00CC00',
                            pointBackgroundColor: 'white',
                            borderWidth: 1,
                            pointBorderColor: '#249EBF',
                            data: this.dataChart
                        }
                    ]
                },
                {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                autoSkip: false
                            },
                            gridLines: {
                                display: true
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                autoSkip: false,
                            },
                            gridLines: {
                                display: false
                            },
                            maxBarThickness: 30
                        }]
                    },
                    legend: {
                        display: false
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            );
        },
    }
}

