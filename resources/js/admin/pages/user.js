import { dataTableMixin } from "../utils/datatable-mixin.js";
import { showDeleteConfirm, showSuccess, showResponseErrorMessage } from "../utils/alerts.js";

new Vue({
    mixins: [dataTableMixin],
    el: '#app-user',
    data: {
        datatableElement: '#user-table',
    },
    mounted() {
        if (message != '') {
            showSuccess(message);
        }
    },
    methods: {
        configDataTable() {
            return {
                dom: `<"datatable-header--custom row"<"col-md-12 text-left">>
                <t>
                <"row"<"col-12 float-right"p>>`,
                bInfo: true,
                buttons: [],
                paging: true,
                aaSorting: [],
                serverSide: true,
                ajax: {
                    url: `${BASE_ADMIN_URL}/users/datatable`,
                },
                columns: [
                    {
                        data: 'email',
                        className: 'align-middle'
                    },
                    {
                        data: 'email',
                        className: 'align-middle'
                    },
                    {
                        data: 'name',
                        className: 'align-middle',
                        name: 'users.name'
                    },
                    {
                        orderable: false,
                        data: 'roles.[0].name',
                        className: 'align-middle',
                        name: 'roles.name',
                        render: (data) => (data == 'super_admin' ? SUPER_ADMIN_TEXT : data)
                    },
                    {
                        searchable: false,
                        orderable: false,
                        data: 'roles.[0].name',
                        className: 'align-middle',
                        render: this.renderActionsButton
                    }
                ],
                orderCellsTop: true,
                fixedHeader: true,
            }
        },

        renderActionsButton(data, type, row) {
            let actionsHtml = '';

            if (CAN_EDIT_USER && data != 'super_admin') {
                actionsHtml += `<button class="btn btn-sm btn-outline-primary btn-edit" data-id='${row.id}'>
                        <i class="fas fa-user-edit"></i>
                    </button> `
            }

            if (CAN_DELETE_USER && data != 'super_admin') {
                actionsHtml += `<button class="btn btn-sm btn-outline-danger btn-delete" data-id='${row.id}'>
                        <i class="fas fa-trash"></i>
                    </button>`
            }

            return actionsHtml;
        },

        handleDataTableEvent() {
            const that = this

            this.$datatable
                .on('click', '.btn-edit', function () {
                    const dataUserId = $(this).data('id');
                    that.redirectToUrl(`${BASE_ADMIN_URL}/users/${dataUserId}/edit`)
                })
                .on('click', '.btn-delete', function () {
                    const dataUserId = $(this).data('id');
                    that.toRemove(`${BASE_ADMIN_URL}/users/${dataUserId}`)
                })
                .on('keyup change clear', 'thead tr:eq(1) th input, thead tr:eq(1) th select', _.debounce(function () {
                    const column = that.$datatable.columns($(this).parent().index())
                    if (column.search() !== this.value) {
                        column.search(this.value)
                            .draw();
                    }
                }, 200));
        },

        toRemove(url) {
            showDeleteConfirm(() => this.delete(url))
        },

        delete(url) {
            axios.delete(url)
                .then((res) => {
                    this.$datatable.ajax.reload(null, false)
                    showSuccess(DELETED_SUCCESS)
                })
                .catch(showResponseErrorMessage)
        }
    }
})
