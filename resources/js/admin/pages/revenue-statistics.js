import { showResponseErrorMessage } from '../utils/alerts.js';
import { daterangeMixin } from '../utils/daterange-mixin.js';
import { showConfirm } from '../utils/alerts.js';
import { encodeNumber } from '../utils/format-number.js';

const SYNCHRONIZE_SUCCESS_CODE = 0;

const app = new Vue({
    mixins: [daterangeMixin],
    el: '#app-revenue-statistics',
    data: {
        filters: {
            storeId: INIT_STORE_ID,
        },
        datatable: {
            baseDataTableConfig: {
                language: {
                    "url": DATATABLE_LANGUAGE
                },
                info: false
            },
            $productDataTable: null,
            $storeDataTable: null
        },
        state: {
            current_period: {
                order_statistics: {
                    quantity_success: 0,
                    quantity_incomplete: 0
                },
                product_statistics: {
                    total: 0,
                    products: [],
                    stores: []
                }
            },
            previous_period: {
                order_statistics: {
                    quantity_success: 0,
                    quantity_incomplete: 0
                },
                product_statistics: {
                    total: 0,
                    products: [],
                    stores: []
                }
            }
        }
    },

    mounted() {
        this.fetch();
        this.initDataTable();
    },

    computed: {
        totalRatio() {
            return this.calculateRatio(
                this.state.current_period.product_statistics.total,
                this.state.previous_period.product_statistics.total
            );
        },

        quantitySuccessRatio() {
            return this.calculateRatio(
                this.state.current_period.order_statistics.quantity_success,
                this.state.previous_period.order_statistics.quantity_success
            );
        },

        quantityIncompleteRatio() {
            return this.calculateRatio(
                this.state.current_period.order_statistics.quantity_incomplete,
                this.state.previous_period.order_statistics.quantity_incomplete
            );
        }
    },

    methods: {
        fetch() {
            const that = this;

            return axios
                .get(STATISTIC_REVENUE_FETCH_URL, {
                    params: {
                        store_id: this.filters.storeId,
                        from_date: this.daterange.startDate,
                        to_date: this.daterange.endDate
                    },
                })
                .then(this.fetchSuccessHandle)
                .catch(showResponseErrorMessage);
        },

        fetchSuccessHandle({ data }) {
            this.state = data;

            this.initDataTable();
        },

        calculateRatio(currentPeriodValue, previousPeriodValue) {
            return(((currentPeriodValue - previousPeriodValue)/(previousPeriodValue || 1)) * 100).toFixed(0);
        },

        initDataTable() {
            this.destroyDataTable();

            this.initProductDataTable();
            this.initStoreDataTable();
        },

        initProductDataTable() {
            this.datatable.$productDataTable = $('#product-datatable')
                .DataTable({
                    ...this.datatable.baseDataTableConfig,
                    ...this.configProductDataTable()
                });
        },

        initStoreDataTable() {
            this.datatable.$storeDataTable = $('#store-datatable')
                .DataTable({
                    ...this.datatable.baseDataTableConfig,
                    ...this.configStoreDataTable()
                });
        },

        destroyDataTable() {
            if ($.fn.dataTable.isDataTable(this.datatable.$productDataTable)) {
                this
                    .datatable
                    .$productDataTable
                    .destroy();
            }

            if ($.fn.dataTable.isDataTable(this.datatable.$storeDataTable)) {
                this
                    .datatable
                    .$storeDataTable
                    .destroy();
            }
        },

        configProductDataTable() {
            return {
                order: [[ 2, "desc" ]],
                lengthMenu: [[5, 10, 50, -1], [5, 10, 50, "All"]],
                data: this.state.current_period.product_statistics.products,
                columns: [
                    {
                        data: 'productable_name'
                    },
                    {
                        data: 'quantity',
                        className: 'text-right',
                        render: data => encodeNumber(data)
                    },
                    {
                        data: 'revenue',
                        className: 'text-right',
                        render: data => encodeNumber(data)
                    },
                ]
            }
        },

        configStoreDataTable() {
            return {
                order: [[ 1, "desc" ]],
                pageLength: 10,
                lengthMenu: [[5, 10, 50, -1], [5, 10, 50, "All"]],
                data: this.state.current_period.product_statistics.stores,
                columns: [
                    {
                        data: 'store_name',
                        className: 'text-left'
                    },
                    {
                        data: 'revenue',
                        className: 'text-right',
                        render: data => encodeNumber(data)
                    },
                ]
            }
        },

        synchronize() {
            const that = this;

            showConfirm(
                this.submitSynchronize,
                (() => ''),
                {
                    title: CONFIRM_IMPORTANT_ACTION_TEXT,
                    text: CONFIRM_SYNCHRONIZE_TEXT,
                }
            );
        },

        submitSynchronize() {
            const that = this;

            return axios
                .get(STATISTIC_REVENUE_SYNCHRONIZE_URL)
                .then(({ data }) => {
                    if (data?.exitCode != SYNCHRONIZE_SUCCESS_CODE) {
                        return showResponseErrorMessage();
                    }

                    that.fetch();
                })
                .catch(showResponseErrorMessage);
        },

        formatNumber(number) {
            return encodeNumber(number)
        },

        renderRatioIcon(ratio) {
            ratio = ratio || 0;

            if (ratio > 0) {
                return `<i class="fa fa-arrow-up" aria-hidden="true"></i>`;
            }

            if (ratio < 0) {
                return `<i class="fa fa-arrow-down" aria-hidden="true"></i>`;
            }

            return '';
        }
    }
});
