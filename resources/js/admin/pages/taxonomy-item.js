import { showSuccess, showResponseErrorMessage, showDeleteConfirm } from '../utils/alerts.js';
import { createFormData } from '../utils/create-form-data.js';
import { dataTableMixin } from '../utils/datatable-mixin.js';
import {PreviewImage} from '../utils/preview-image.js';

const errorsFormDefault = {
    name: [],
    image: [],
    taxonomy_id: []
}

new Vue({
    mixins: [dataTableMixin],
    el: '#app-taxonomy',
    components: {
        PreviewImage
    },
    data: {
        message: '',
        taxonomyItemForm: {
            name: '',
            image: '',
            taxonomy_id: '',
            image_url: '',
            order: '',
        },
        errorsForm: errorsFormDefault,
        modal: MODAL_CREATE_TAXONOMY_ITEM_CONFIG,
        datatableElement: '#taxonomy-table',
    },

    mounted() {
        $('#taxonomy-modal').on('hidden.bs.modal', () => {
            this.errorsForm = ''
            this.previewImage = ''
            this.modal = MODAL_CREATE_TAXONOMY_ITEM_CONFIG
        })
    },

    methods: {
        configDataTable() {
            return {
                dom: `<"datatable-header--custom row"<"col-md-12 text-left">>
                <t>
                <"row"<"col-12 float-right"p>>`,
                bInfo: true,
                paging: true,
                aaSorting: [],
                serverSide: true,
                ajax: {
                    url: `${BASE_ADMIN_URL}/taxonomy-items/datatable`,
                },
                columns: [
                    {
                        data: 'name',
                        className: 'align-middle'
                    },
                    {
                        data: 'taxonomy_id',
                        className: 'align-middle',
                        render: (data, type, row) => (row.taxonomy.name)
                    },
                    {
                        searchable: false,
                        orderable: false,
                        data: 'image_url',
                        className: 'align-middle text-center',
                        render: (imageUrl) => {
                            return `<img src="${imageUrl || DEFAULT_SQUARE_IMAGE}" onerror="onImageError(this)" class="image_view">`
                        }
                    },
                    {
                        data: 'order',
                        className: 'align-middle text-center',
                    },
                    {
                        data: 'status',
                        className: 'align-middle text-center',
                        render: this.renderStatusCheckbox
                    },
                    {
                        searchable: false,
                        orderable: false,
                        className: 'align-middle',
                        render: this.renderActionsButton
                    }
                ],
                orderCellsTop: true,
                fixedHeader: true,
            }
        },

        renderStatusCheckbox(data, type, row) {
            const disabled = CAN_EDIT_TAXONOMY_ITEM ? '' : 'disabled';
            const checked = row.status == 1 ? 'checked' : '';

            return `<div class="custom-control custom-switch custom-switch-on-success">
                <input type="checkbox" id="${row.id}" class="custom-control-input update-status" data-id='${row.id}' name="status" ${disabled} ${checked} />
                <label class="custom-control-label" for="${row.id}"></label>
            </div>`
        },

        renderActionsButton(data, type, row) {
            let actionsHtml = '';
            if (CAN_EDIT_TAXONOMY_ITEM) {
                actionsHtml = `<button class="btn btn-sm btn-outline-primary btn-edit">
                        <i class="fas fa-user-edit"></i>
                    </button> `
            }

            if (CAN_DELETE_TAXONOMY_ITEM) {
                actionsHtml += `<button class="btn btn-sm btn-outline-danger btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>`
            }

            return actionsHtml;
        },

        handleDataTableEvent() {
            const that = this

            this.$datatable
                .on('click', '.btn-edit', function () {
                    let { id, name, image, image_url, taxonomy_id, status, order } = that.$datatable.row($(this).parents('tr')).data();
                    image = image == null ? '' : image
                    that.toEdit(
                        { id, name, image, image_url, taxonomy_id, status, order },
                        `${BASE_ADMIN_URL}/taxonomy-items/${id}`
                    )
                })
                .on('click', '.btn-delete', function () {
                    const taxonomyItem = that.$datatable.row($(this).parents('tr')).data();
                    that.toRemove(`${BASE_ADMIN_URL}/taxonomy-items/${taxonomyItem.id}`)
                })
                .on('change', '.update-status', function () {
                    const taxonomyItemId = $(this).data('id')
                    const cb = $(this)
                    that.toChangeStatus(
                        {
                            id: cb.attr('id'),
                            status: +cb.is(':checked'),
                        },
                        `${BASE_ADMIN_URL}/taxonomy-items/${taxonomyItemId}/status`
                    )
                })
                .on('keyup change clear', 'thead tr:eq(1) th input, thead tr:eq(1) th select',  _.debounce(function () {
                    const column = that.$datatable.columns($(this).parent().index())
                    if (column.search() !== this.value) {
                        column.search(this.value)
                            .draw();
                    }
                }, 200))

            $('.taxonomy-default').val("1").trigger("change");
        },

        openTaxonomyItemModal() {
            $('#taxonomy-modal').modal('show')
        },

        closeRoleModal() {
            $('#taxonomy-modal').modal('hide')
        },

        onFileChange(image) {
            this.taxonomyItemForm.image = image;
        },

        toCreate() {
            this.$refs.imagePreview.previewImage = ''
            this.taxonomyItemForm = { name: '', image: '', taxonomy_id: '', status: '', order: ''}
            this.modal = MODAL_CREATE_TAXONOMY_ITEM_CONFIG
            this.openTaxonomyItemModal()
        },

        toEdit(taxonomyItem, url) {
            this.$refs.imagePreview.previewImage = taxonomyItem.image_url
            this.taxonomyItemForm = taxonomyItem
            this.modal = {
                title: EDIT_TAXONOMY_ITEM_TEXT,
                buttonText: EDIT_TAXONOMY_ITEM_BUTTON_TEXT,
                buttonClass: 'btn-sm btn-outline-primary',
                action: {
                    method: 'PUT',
                    url,
                }
            }
            this.openTaxonomyItemModal()
        },

        toChangeStatus(data, url) {
            axios
                .put(url, data)
                .then(() => {
                    this.$datatable.ajax.reload(null, false);
                    showSuccess(MODIFIED_SUCCESS)
                })
                .catch(showResponseErrorMessage)
        },

        toRemove(url) {
            showDeleteConfirm(() => this.delete(url))
        },

        submitTaxonomyItemForm() {
            if (this.modal.action.method === 'POST') {
                this.store()
            }

            if (this.modal.action.method === 'PUT') {
                this.update()
            }
        },

        store() {
            this.errorsForm = errorsFormDefault
            axios
                .post(this.modal.action.url, createFormData({
                    ...this.taxonomyItemForm,
                    status: +this.taxonomyItemForm.status
                }))
                .then(() => {
                    this.closeRoleModal()
                    this.$datatable.ajax.reload(null, false);
                    showSuccess(ADDED_SUCCESS)
                })
                .catch(error => {
                    if (error?.response?.status === 422) {
                        this.errorsForm = error?.response?.data?.errors ?? errorsFormDefault
                    };
                    showResponseErrorMessage(error)
                })
        },

        update() {
            this.errorsForm = errorsFormDefault
            axios
                .post(this.modal.action.url, createFormData({
                    _method: 'PUT',
                    ...this.taxonomyItemForm,
                    status: +this.taxonomyItemForm.status
                }))
                .then(() => {
                    this.closeRoleModal()
                    this.$datatable.ajax.reload(null, false);
                    showSuccess(MODIFIED_SUCCESS)
                })
                .catch(error => {
                    if (error?.response?.status === 422) {
                        this.errorsForm = error?.response?.data?.errors ?? errorsFormDefault
                    };
                    showResponseErrorMessage(error);
                })
        },

        delete(url) {
            axios
                .delete(url)
                .then((response) => {
                    this.$datatable.ajax.reload(null, false);
                    showSuccess(DELETED_SUCCESS)
                })
                .catch(showResponseErrorMessage)
        }
    }
})
