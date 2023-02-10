import { showSuccess, showResponseErrorMessage, showDeleteConfirm } from '../utils/alerts.js';
import { dataTableMixin } from '../utils/datatable-mixin.js';

new Vue({
    mixins: [dataTableMixin],
    el: '#app',
    components: {
        ckeditor: CKEditor.component
    },
    data: {
        routes: ROUTES,
        permissions: PERMISSIONS,
        // groups: GROUPS,
        datatableElement: '#faq-table',
        editorConfig: EditorConfig,
        editor: ClassicEditor,
    },

    methods: {
        configDataTable() {
            return {
                dom: `<"datatable-header--custom row"<"col-md-6 text-left"s><"col-md-6 text-right"B>>
                <t>
                <"row"<"col-12 float-right"p>>`,
                bInfo: true,
                paging: true,
                aaSorting: [],
                buttons: this.permissions.create
                    ? [{
                        text: `<i class="fas fa-plus"></i>&nbsp${CREATE_FAQ_TEXT}`,
                        className: 'btn btn-sm btn-outline-success',
                        action: () => redirectToUrl(this.routes.create)
                    }]
                    : [],
                serverSide: true,
                ajax: {
                    url: this.routes.getDatatable,
                },
                columns: [
                    {
                        data: 'question',
                    },
                    // {
                    //     data: 'group',
                    //     render: (data) => {
                    //         return this.groups[data];
                    //     }
                    // },
                    {
                        searchable: false,
                        orderable: false,
                        className: 'text-center',
                        render: this.renderActionsButton
                    }
                ],
                orderCellsTop: true,
                fixedHeader: true,
            }
        },

        handleEditButtonEvent(element) {
            redirectToUrl(this.routes.edit.replace(
                ':id',
                this.getRowData(element).id
            ));
        },

        handleDeleteButtonEvent(element) {
            this.submitDelete(this.routes.delete.replace(
                ':id',
                this.getRowData(element).id
            ));
        },
    }
});
