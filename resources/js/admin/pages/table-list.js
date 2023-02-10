import {
    showSuccess,
    showResponseErrorMessage,
    showDeleteConfirm,
} from "../utils/alerts.js";
import { dataTableMixin } from "../utils/datatable-mixin.js";

const errorsFormDefault = {
    name: [],
    note: [],
};

const dataResetModal = {
    name: "",
    note: "",
};

new Vue({
    mixins: [dataTableMixin],
    el: "#app",
    data: {
        permissions: PERMISSIONS,
        datatableElement: "#seat-table",
        selectStoreId: SELECT_STORE_ID,
        modal: MODAL_CREATE_CONFIG,
        tableForm: { ...dataResetModal },
        errorsForm: { ...errorsFormDefault },
    },

    mounted() {
        $("#table-modal").on("hidden.bs.modal", () => {
            this.errorsForm = { ...errorsFormDefault };
            this.modal = MODAL_CREATE_CONFIG;
        });
    },

    watch: {
        selectStoreId() {
            this.$datatable.ajax.reload();
        },
    },

    methods: {
        configDataTable() {
            const that = this;

            return {
                dom: `<"datatable-header--custom">
                    <t>
                    <"row"<"col-12 float-right"p>>`,
                bInfo: true,
                paging: true,
                aaSorting: [],
                serverSide: true,
                ajax: {
                    url: ROUTE_GET_DATATABLE,
                    data(filter) {
                        filter.store_id = that.selectStoreId;
                    },
                },
                columns: [
                    {
                        data: "name",
                    },
                    {
                        data: "note",
                    },
                    {
                        searchable: false,
                        orderable: false,
                        className: "text-center",
                        render: this.renderActionsButton,
                    },
                ],
                orderCellsTop: true,
                fixedHeader: true,
            };
        },

        handleEditButtonEvent(button) {
            const { id, name, note } = this.$datatable
                .row($(button).parents("tr"))
                .data();
            this.showEditModal(
                { id, name, note },
                `${BASE_ADMIN_URL}/tables/${id}`
            );
        },

        handleDeleteButtonEvent(button) {
            const { id } = this.$datatable.row($(button).parents("tr")).data();
            showDeleteConfirm(() =>
                this.delete(`${BASE_ADMIN_URL}/tables/${id}`)
            );
        },

        showCreateModal() {
            this.modal = MODAL_CREATE_CONFIG;
            this.tableForm = { ...dataResetModal };
            this.showModal();
        },

        showEditModal(table, url) {
            this.tableForm = table;
            this.modal = {
                title: EDIT_TABLE_TEXT,
                action: {
                    method: "PUT",
                    url: url,
                },
            };
            this.showModal();
        },

        showModal() {
            $("#table-modal").modal("show");
        },

        hideModal() {
            $("#table-modal").modal("hide");
        },

        submit() {
            if (this.modal.action.method === "POST") {
                this.store();
            }

            if (this.modal.action.method === "PUT") {
                this.update();
            }
        },

        store() {
            axios
                .post(
                    this.modal.action.url,
                    {
                        ...this.tableForm,
                        store_id: this.selectStoreId,
                    }
                )
                .then(() => {
                    this.hideModal();
                    this.reloadTable();
                    showSuccess(ADDED_SUCCESS);
                })
                .catch((error) => {
                    if (error?.response?.status === 422) {
                        this.errorsForm =
                            error?.response?.data?.errors ?? errorsFormDefault;
                    }
                    showResponseErrorMessage(error);
                });
        },

        update() {
            axios
                .post(
                    this.modal.action.url,
                    {
                        _method: "PUT",
                        ...this.tableForm,
                        store_id: this.selectStoreId,
                    }
                )
                .then(() => {
                    this.hideModal();
                    this.reloadTable();
                    showSuccess(MODIFIED_SUCCESS);
                })
                .catch((error) => {
                    if (error?.response?.status === 422) {
                        this.errorsForm =
                            error?.response?.data?.errors ?? errorsFormDefault;
                    }
                    showResponseErrorMessage(error);
                });
        },

        delete(url) {
            axios
                .delete(url)
                .then((response) => {
                    this.reloadTable();
                    showSuccess(DELETED_SUCCESS);
                })
                .catch(showResponseErrorMessage);
        },
    },
});
