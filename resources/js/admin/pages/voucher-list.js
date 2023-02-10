import {showDeleteConfirm, showSuccess, showResponseErrorMessage} from '../utils/alerts.js';
import {dataTableMixin} from '../utils/datatable-mixin.js';
import {encodeNumber, decodeNumber} from '../utils/format-number.js';
import {convertToClientTz, convertToUtcTz} from '../utils/timezone.js';

const app = new Vue({
    el: '#app-voucher-list',
    mixins: [dataTableMixin],
    data: {
        datatableElement: '#voucher-table',
        minApplyCount: '',
        maxApplyCount: '',
        minMaxApply: '',
        maxMaxApply: '',
        permissions: {
            edit: canEdit,
            delete: canDelete
        }
    },
    computed: {
        minApplyCountDisplay: {
            get() {
                return encodeNumber(this.minApplyCount)
            },
            set(val) {
                this.minApplyCount = decodeNumber(val)
            }
        },
        maxApplyCountDisplay: {
            get() {
                return encodeNumber(this.maxApplyCount)
            },
            set(val) {
                this.maxApplyCount = decodeNumber(val)
            }
        },
        minMaxApplyDisplay: {
            get() {
                return encodeNumber(this.minMaxApply)
            },
            set(val) {
                this.minMaxApply = decodeNumber(val)
            }
        },
        maxMaxApplyDisplay: {
            get() {
                return encodeNumber(this.maxMaxApply)
            },
            set(val) {
                this.maxMaxApply = decodeNumber(val)
            }
        },
    },
    mounted() {
        if (message != '') {
            showSuccess(message);
        }
    },
    methods: {
        configDataTable() {
            const that = this;
            return {
                dom: `<"datatable-header--custom row"<"col-md-6 text-left"><"col-md-6 text-right">>
                <t>
                <"row"<"col-12 float-right"p>>`,
                bInfo: true,
                paging: true,
                aaSorting: [],
                serverSide: true,
                ajax: {
                    url: ROUTES.getDatatable,
                    data: function (d) {
                        d.apply_count_min = that.minApplyCount;
                        d.apply_count_max = that.maxApplyCount;
                        d.max_apply_min = that.minMaxApply;
                        d.max_apply_max = that.maxMaxApply;
                    }
                },
                columns: [
                    {
                        data: 'code',
                        className: 'align-middle text-center'
                    },
                    {
                        data: 'name',
                        className: 'align-middle'
                    },
                    {
                        data: 'start_at',
                        className: 'align-middle',
                        render: data => convertToClientTz(data)
                    },
                    {
                        data: 'expire_at',
                        className: 'align-middle',
                        render: data => convertToClientTz(data)
                    },
                    {
                        data: 'apply_count',
                        className: 'align-middle text-right',
                        render: data => encodeNumber(data)
                    },
                    {
                        data: 'max_apply',
                        className: 'align-middle text-right',
                        render: data => encodeNumber(data)
                    },
                    {
                        data: 'status',
                        className: 'align-middle text-center',
                        render: that.renderStatusColumn
                    },
                    {
                        searchable: false,
                        orderable: false,
                        data: 'id',
                        className: 'align-middle text-center',
                        render: this.renderApplyButton
                    },
                    {
                        searchable: false,
                        orderable: false,
                        data: 'id',
                        className: 'align-middle text-center',
                        render: this.renderActionsButton
                    }

                ],
                orderCellsTop: true,
                fixedHeader: true,
            }
        },

        handleDataTableEvent() {
            const that = this;
            that.$datatable
                .on('keyup change clear', 'thead tr:eq(1) td input, thead tr:eq(1) td select', _.debounce(function () {
                    const i = $(this).parents('td').index();
                    const column = that.$datatable.column(i);
                    if (column.search() !== this.value) {
                        column
                            .search([2, 3].includes(i) ? convertToUtcTz(this.value) : this.value)
                            .draw();
                    }
                }, 200));
        },

        handleEditButtonEvent(button) {
            this.redirectToUrl(ROUTES.update.replace(':id', $(button).data('id')));
        },

        handleDeleteButtonEvent(button) {
            this.submitDelete(ROUTES.delete.replace(':id', $(button).data('id')));
        },

        getChangeStatusUrl(checkbox) {
            return ROUTES.update_status.replace(':id', $(checkbox).attr('id'))
        },

        renderApplyButton(id) {
            return `<a href="${ROUTES.apply.replace(':id', id)}" class="btn btn-sm btn-outline-success" target="_blank">
                        <i class="fas fa-link"></i>
                    </a>`
        }
    }
})
