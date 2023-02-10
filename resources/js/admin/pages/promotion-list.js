import { showSuccess } from '../utils/alerts.js'
import { dataTableMixin } from '../utils/datatable-mixin.js'
import { mapNumberEncodeDisplay } from '../utils/map-number-encode-display.js'
import { encodeNumber } from '../utils/format-number.js'
import { convertToClientTz, convertToUtcTz } from '../utils/timezone.js'

new Vue({
    el: '#app-promotion-list',
    mixins: [dataTableMixin],
    data: {
        datatableElement: '#promotion-table',
        permissions: {
            edit: canEdit,
            delete: canDelete,
        },
        discountValueFrom: '',
        discountValueTo: '',
    },
    computed: {
        ...mapNumberEncodeDisplay([
            'discountValueFrom',
            'discountValueTo',
        ])
    },

    mounted() {
        if (message != '') {
            showSuccess(message)
        }
    },

    methods: {
        configDataTable() {
            const that = this
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
                        d.discount_value_from = that.discountValueFrom
                        d.discount_value_to = that.discountValueTo
                    }
                },
                columns: [
                    {
                        data: 'name',
                        className: 'align-middle text-center'
                    },
                    {
                        searchable: false,
                        orderable: false,
                        data: 'images.square_url',
                        className: 'align-middle text-center',
                        render: imageSquareUrl => `<img src="${imageSquareUrl || DEFAULT_SQUARE_IMAGE}"
                            onerror="onImageError(this)" class="image-on-datatable" />`
                    },
                    {
                        data: 'type',
                        className: 'align-middle text-center',
                        render: type => TYPE_TEXTS[type] ?? ''
                    },
                    {
                        data: 'discount_value',
                        className: 'align-middle text-right',
                        render: (data, type, row) => row?.type == TYPE_PERCENT
                            ? encodeNumber(data) + ' %'
                            : encodeNumber(data)
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
                        data: 'positions',
                        orderable: false,
                        className: 'align-middle',
                        render: (data, type, row) => row.positions
                            .map(position => POSITION_TEXTS[position] ?? '')
                            .join('<br />')
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
                        render: this.renderActionsButton
                    }

                ],
                orderCellsTop: true,
                fixedHeader: true,
            }
        },

        handleDataTableEvent() {
            const that = this
            this.$datatable
                .on('keyup change clear', 'thead tr:eq(1) td input, thead tr:eq(1) td select', _.debounce(function () {
                    const i = $(this).parents('td').index()
                    const column = that.$datatable.column(i)
                    if (column.search() !== this.value) {
                        column.search([5, 6].includes(i) ? convertToUtcTz(this.value) : this.value)
                            .draw()
                    }
                }, 200))
        },

        handleEditButtonEvent(button) {
            this.redirectToUrl(ROUTES.update.replace(':id', $(button).data('id')))
        },

        handleDeleteButtonEvent(button) {
            this.submitDelete(ROUTES.delete.replace(':id', $(button).data('id')))
        },

        getChangeStatusUrl(checkbox) {
            return ROUTES.updateStatus.replace(':id', $(checkbox).attr('id'))
        },
    }
})
