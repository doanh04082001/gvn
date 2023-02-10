const daterangeMixin = {
    data: {
        $daterange: null,
        daterangeElement: '#daterange',
        daterange: {
            startDate: null,
            endDate: null
        }
    },

    mounted() {
        this.initDaterange();
    },

    methods: {
        initDaterange() {
            const that = this;

            this.$daterange = $(this.daterangeElement)
                .daterangepicker(
                    {
                        locale: DATERANGEPICKER_LOCALE,
                        startDate: moment(),
                        endDate: moment(),
                        alwaysShowCalendars: true,
                        ranges: {
                            [DATERANGEPICKER_CUSTOM_RANGE.today]: [moment(), moment()],
                            [DATERANGEPICKER_CUSTOM_RANGE.yesterday]: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            [DATERANGEPICKER_CUSTOM_RANGE.last_seven_days]: [moment().subtract(6, 'days'), moment()],
                            [DATERANGEPICKER_CUSTOM_RANGE.last_thirty_day]: [moment().subtract(29, 'days'), moment()],
                            [DATERANGEPICKER_CUSTOM_RANGE.this_month]: [moment().startOf('month'), moment().endOf('month')],
                            [DATERANGEPICKER_CUSTOM_RANGE.last_month]: [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                        }
                    },
                    function (startDate, endDate) {
                        that.daterange.startDate = startDate.format('YYYY-MM-DD');
                        that.daterange.endDate = endDate.format('YYYY-MM-DD');
                    }
                );

            this.onInit();
        },

        onInit() {
            this.daterange.startDate = this.$daterange.data('daterangepicker').startDate.format('YYYY-MM-DD');
            this.daterange.endDate = this.$daterange.data('daterangepicker').endDate.format('YYYY-MM-DD');
        }
    }
}

export { daterangeMixin };
