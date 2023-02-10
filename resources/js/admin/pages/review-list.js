import {dataTableMixin} from '../utils/datatable-mixin.js';
const app = new Vue({
    el: '#app-review-list',
    mixins: [dataTableMixin],
    data: {
        datatableElement: '#review-table',
        productReviews: [],
        storeName : '',
        reviewContent: '',
        reviewImages: [],
    },
    methods: {
        configDataTable() {
            return {
                dom: `<"datatable-header--custom row"<"col-md-12 text-left" f>><t><"row"<"col-12 float-right"p>>`,
                bInfo: true,
                paging: true,
                aaSorting: [],
                serverSide: true,
                ajax: {
                    url: `${BASE_ADMIN_URL}/reviews/datatable`,
                },
                columns: [
                    {
                        data: 'customer.name',
                        className: 'align-middle',
                        render: (data, type, row) => (row.customer.name)
                    },
                    {
                        data: 'store.name',
                        className: 'align-middle',
                        render: (data, type, row) => (row.store.name)
                    },

                    {
                        searchable: false,
                        orderable: false,
                        data: 'content',
                        className: 'align-middle',
                    },
                    {
                        searchable: false,
                        orderable: false,
                        data: ('customer_id', 'store_id'),
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
                .on('click', '.view-product-store', function () {
                    that.handleButtonEditPriceEvent(this)
                })
                .on('keyup change clear', 'thead tr:eq(1) th input, thead tr:eq(1) th select', _.debounce(function () {
                    const i = $(this).parents('th').index();
                    const column = that.$datatable.column(i);
                    if (column.search() !== this.value) {
                        column
                            .search(this.value)
                            .draw();
                    }
                }, 200));
        },

        handleButtonEditPriceEvent(button) {
            const orderId = this.$datatable.row($(button).parents('tr')).data().order_id
            this.storeName = this.$datatable.row($(button).parents('tr')).data().store.name
            this.reviewContent = this.$datatable.row($(button).parents('tr')).data().content
            this.reviewImages = this.$datatable.row($(button).parents('tr')).data().images_url
            this.showProductReviews(orderId)
        },
        
        renderActionsButton() {
            return `<button  class="btn btn-default view-product-store">
                      ${LANGUAGE.VIEW_REVIEW}
                    </button>`
        },

        showProductReviews(orderId) {
            axios.get(ROUTES.productReviews.replace(
                ':orderId', orderId
            )).then((res) => {
                this.productReviews = res.data.reviews;
                $("#review-modal").modal('show');
            });
        }
    },
})

