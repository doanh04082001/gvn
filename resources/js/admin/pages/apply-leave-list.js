import {
  showDeleteConfirm,
  showModalConfirm,
  showSuccess,
  showResponseErrorMessage,
} from "../utils/alerts.js";
import { dataTableMixin } from "../utils/datatable-mixin.js";

const app = new Vue({
  el: "#apply-leave-list",
  mixins: [dataTableMixin],
  data: {
    datatableElement: "#apply-leave-table",
  },
  mounted: function() {
    if (message != "") {
      showSuccess(message);
    }
  },
  methods: {
    configDataTable() {
      return {
        columnDefs: [
          {
            orderable: false,
            targets: 3,
          },
        ],
        dom: `<"datatable-header--custom row"<"col-md-6 text-left"><"col-md-6 text-right">>
                    <t>
                    <"row"<"col-12 float-right"p>>`,
        bInfo: false,
        orderCellsTop: true,
        fixedHeader: true,
      };
    },

    handleDataTableEvent() {
      const that = this;
      that.$datatable.on(
        "keyup change clear",
        "thead tr:eq(1) th input",
        _.debounce(function() {
          const column = that.$datatable.column(
            $(this)
              .parents("th")
              .index()
          );
          if (column.search() !== this.value) {
            column.search(this.value).draw();
          }
        }, 200)
      );
    },

    destroy(url) {
      showDeleteConfirm(function() {
        axios
          .delete(url)
          .then(() => {
            location.reload();
          })
          .catch(showResponseErrorMessage);
      });
    },

    updateStatus(url, urlDeny) {
      showModalConfirm(
        function() {
          axios
            .post(url)
            .then(() => {
              location.reload();
            })
            .catch(showResponseErrorMessage);
        },
        function() {
          axios
            .post(urlDeny)
            .then(() => {
              location.reload();
            })
            .catch(showResponseErrorMessage);
        }
      );
    },
  },
});
