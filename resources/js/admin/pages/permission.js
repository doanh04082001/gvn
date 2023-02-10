import { dataTableMixin } from '../utils/datatable-mixin.js'
import { showResponseErrorMessage, showSuccess } from '../utils/alerts.js'

new Vue({
    el: '#permission-page',
    mixins: [dataTableMixin],
    data: {
        role: ROLE,
        oldMapping: _.cloneDeep(MAPPING),
        mapping: _.cloneDeep(MAPPING),
        languages: LANGUAGES,
        datatableElement: '#permission-table',
        showPermissionButton: false
    },

    watch: {
        mapping: {
            deep: true,
            handler(val) {
                this.handleMapChanged(this.oldMapping, val)
            }
        },
        oldMapping: {
            deep: true,
            handler(val) {
                this.handleMapChanged(val, this.mapping)
            }
        }
    },

    methods: {
        configDataTable() {
            return {
                dom: `<"datatable-header--custom row"
                        <"col-md-6"f>
                        <"col-md-6 form-group row select-role">
                    >`,
                paging: false,
                bInfo: false,
                ordering: false,
            }
        },

        handleDataTableEvent() {
            const that = this

            $(this.$el).on('change', '.select-role > select', function () {
                that.redirectRoleManagementPage($(this).val())
            })

            $(function () {
                $('.select-role').append(
                    `<label class="col-md-3 col-4 col-form-label font-weight-normal">
                        ${ROLES_DROPDOWN_TEXT}:
                    </label>
                    <select class="form-control col-8">${that.renderRoleOptions()}<select/>`
                )
            })
        },

        renderRoleOptions() {
            return ROLES.map(role => `<option value="${role.id}" ${this.role.id == role.id ? 'selected' : ''}>
                ${role.name}
            </option>`)
        },

        handleMapChanged(oldMapping, newMapping) {
            this.showPermissionButton = !_.isEqual(oldMapping, newMapping)
        },

        handleChangeGroup(group) {
            Object.keys(this.mapping[group].permissions)
                .forEach(
                    permission => this.mapping[group].permissions[permission] = this.mapping[group].hasGroupPermission
                )
        },

        handleChangePermission(group) {
            let isCheckAllPermissionsOfGroup = true
            Object.keys(this.mapping[group].permissions)
                .forEach(
                    permission => isCheckAllPermissionsOfGroup &&= this.mapping[group].permissions[permission]
                )

            this.mapping[group].hasGroupPermission = isCheckAllPermissionsOfGroup
        },

        toSaveConfig() {
            axios
                .post(SAVE_PERMISSION_URL, this.mapping)
                .then(({ data }) => {
                    this.oldMapping = _.cloneDeep(data)
                    showSuccess(SAVE_SUCCESS)
                })
                .catch(showResponseErrorMessage)
        },

        toRevertConfig() {
            this.mapping = _.cloneDeep(this.oldMapping)
        },

        redirectRoleManagementPage(roleSeletedId) {
            location.href = `${BASE_ADMIN_URL}/roles/${roleSeletedId}/permissions`
        }
    }
})
