import { dataTableMixin } from '../utils/datatable-mixin.js'
import { showDeleteConfirm, showSuccess, showResponseErrorMessage } from '../utils/alerts.js'

const defaultErrorsForm = {
    name: []
}

new Vue({
    el: '#role-page',
    mixins: [dataTableMixin],
    data: {
        roles: ROLES,
        roleForm: {
            name: ''
        },
        errorsForm: defaultErrorsForm,
        modal: MODAL_CREATE_CONFIG,
        datatableElement: '#role-table'
    },

    mounted() {
        $('#role-modal')
            .on('hidden.bs.modal', () => {
                this.errorsForm = defaultErrorsForm
                this.modal = MODAL_CREATE_CONFIG
            })
    },

    methods: {
        configDataTable() {
            return {
                dom: '<"datatable-header--custom row"<"col-md-6 text-left"f><"col-md-6 text-right">>',
                paging: false,
                bInfo: false
            }
        },

        openRoleModal() {
            $('#role-modal').modal('show')
        },

        closeRoleModal() {
            $('#role-modal').modal('hide')
        },

        toCreate() {
            this.roleForm = { name: '' }
            this.modal = MODAL_CREATE_CONFIG
            this.openRoleModal()
        },

        toEdit({ name }, url) {
            this.roleForm = { name }
            this.modal = {
                title: EDIT_ROLE_TEXT,
                okButtonText: EDIT_ROLE_BUTTON_TEXT,
                okButtonClass: 'btn-outline-primary',
                action: {
                    method: 'PUT',
                    url,
                }
            }

            this.openRoleModal()
        },

        toRemove(roleId, url) {
            showDeleteConfirm(() => this.delete(roleId, url))
        },

        toAssignPermission(url) {
            window.location.href = url;
        },

        submitRole() {
            if (this.modal.action.method === 'POST') {
                this.store()
            }

            if (this.modal.action.method === 'PUT') {
                this.update()
            }
        },

        store() {
            this.errorsForm = defaultErrorsForm

            axios
                .post(this.modal.action.url, {
                    ...this.roleForm
                })
                .then(({ data }) => {
                    if (data) {
                        this.roles.unshift(data)
                    }

                    this.closeRoleModal()
                    showSuccess(ADDED_SUCCESS)
                })
                .catch(error => {
                    if (error?.response?.status === 422) {
                        this.errorsForm = error?.response?.data?.errors ?? defaultErrorsForm
                    }

                    showResponseErrorMessage(error)
                })
        },

        update() {
            axios
                .put(this.modal.action.url, {
                    ...this.roleForm
                })
                .then(({ data }) => {
                    const index = this.roles.findIndex(r => r.id == data?.id)
                    if (data && index >= 0) {
                        this.roles[index] = data
                    }

                    this.closeRoleModal()
                    showSuccess(MODIFIED_SUCCESS)
                })
                .catch(error => {
                    if (error?.response?.status === 422) {
                        this.errorsForm = error?.response?.data?.errors ?? defaultErrorsForm
                    }

                    showResponseErrorMessage(error)
                })
        },

        delete(roleId, url) {
            axios
                .delete(url)
                .then((response) => {
                    if ((response.status ?? null) == 200) {
                        this.roles = this.roles.filter(role => role.id !== roleId)
                        showSuccess(DELETED_SUCCESS)
                    }
                })
                .catch(showResponseErrorMessage)
        }
    }
})
