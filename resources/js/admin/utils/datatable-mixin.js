import { showDeleteConfirm, showResponseErrorMessage, showSuccess } from './alerts.js';

const dataTableMixin = {
    data: {
        $datatable: null,
        datatableElement: '#datatable',
        baseDatatableConfig: {
            language: {
                "url": DATATABLE_LANGUAGE
            },
        },
        permissions: {}
    },
    mounted() {
        this.initDataTable()
        console.log(this.$datatable);
        this.handleButtonDataTableEvent()
        this.handleDataTableEvent()
    },

    methods: {
        configDataTable() {
            return {};
        },

        initDataTable() {
            const config = this.configDataTable()

            this.$datatable = $(this.datatableElement)
                .DataTable(
                    config ? { ...this.baseDatatableConfig, ...config } : config
                )
        },

        handleButtonDataTableEvent() {
            const that = this;
            this.$datatable
                .on('change', '.cb-input', function () {
                    that.submitChangeStatus(
                        that.getChangeStatusUrl(this),
                        { status: +$(this).is(':checked') },
                    )
                })
                .on('change', '.cb-input-featured', function () {
                    that.submitChangeStatus(
                        that.getChangeFeaturedUrl(this),
                        { featured: +$(this).is(':checked') },
                    )
                })
                .on('click', '.btn-edit', function () {
                    that.handleEditButtonEvent(this)
                })
                .on('click', '.btn-delete', function () {
                    that.handleDeleteButtonEvent(this)
                });
        },

        handleDataTableEvent() { },
        getChangeStatusUrl() { },
        handleEditButtonEvent() { },
        handleDeleteButtonEvent() { },

        renderStatusColumn(status, type, row) {
            return `<div class="custom-control custom-switch custom-switch-on-success">
                <input type="checkbox" class="custom-control-input cb-input"
                    ${this.permissions.edit ? '' : 'disabled'}
                    id="${row.id}" ${status ? 'checked' : ''}>
                <label class="custom-control-label" for="${row.id}"></label>
            </div>`
        },

        renderActionsButton(id) {
            let actionsHtml = '';
            if (this.permissions.edit) {
                actionsHtml += `<button data-id="${id}" class="btn btn-sm btn-outline-primary btn-edit">
                    <i class="fas fa-edit"></i>
                </button> `
            }
            if (this.permissions.delete) {
                actionsHtml += `<button data-id="${id}" class="btn btn-sm btn-outline-danger btn-delete">
                    <i class="fas fa-trash"></i>
                </button>`
            }

            return actionsHtml;
        },

        submitChangeStatus(url, data) {
            const that = this;
            axios
                .patch(url, data)
                .then(() => {
                    that.reloadTable();
                    showSuccess(MODIFIED_SUCCESS)
                })
                .catch(showResponseErrorMessage);
        },

        submitDelete(url) {
            const that = this;
            showDeleteConfirm(function () {
                axios
                    .delete(url)
                    .then(() => {
                        that.reloadTable();
                        showSuccess(DELETED_SUCCESS)
                    })
                    .catch(showResponseErrorMessage)
            });
        },

        onKeyUpFilter: _.debounce(function (event) {
            this.handleFilter(event)
        }, 300),

        handleFilter(event) {
            const column = this.$datatable.column(event.target.parentNode.cellIndex);
            const value = event.target.value;
            if (column.search() !== value) {
                column.search(value).draw();
            }
        },

        getRowData(clicked, isRowClicked = false) {
            if (isRowClicked) {
                return this.$datatable.row(clicked).data()
            }

            return this.$datatable.row($(clicked).parents('tr')).data();
        },

        reloadTable() {
            this.$datatable.ajax.reload(null, false);
        }
    }
}

export { dataTableMixin };
