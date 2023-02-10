import {showSuccess, showResponseErrorMessage} from '../utils/alerts.js';
import {dataTableMixin} from '../utils/datatable-mixin.js';

const app = new Vue({
    el: '#app',
    mixins: [dataTableMixin],
    data: {
        datatableElement: '#voucher-apply-table'
    },
    methods: {
        configDataTable() {
            return {
                columnDefs: [
                    {
                        orderable: false,
                        targets: -1,
                        className: 'text-center'
                    }
                ],
                dom: `<"datatable-header--custom row"<"col-md-6 text-left"><"col-md-6 text-right">>
                    <t>
                    <"row"<"col-12 float-right"p>>`,
                bInfo: false,
                orderCellsTop: true,
                fixedHeader: true,
            }
        },

        applyVoucher(event) {
            axios
                .post(event.target.dataset.url, { is_apply: +event.target.checked })
                .then(() => {
                    showSuccess(MODIFIED_SUCCESS)
                })
                .catch(showResponseErrorMessage);
        },
    }
})
