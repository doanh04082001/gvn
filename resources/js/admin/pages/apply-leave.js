import { showResponseErrorMessage } from "../utils/alerts.js";
import { dataTableMixin } from "../utils/datatable-mixin.js";

new Vue({
  el: "#app-apply-leave",
  mixins: [dataTableMixin],
  data: {
    store: {
      id: currentStore?.id,
      user_id: currentStore?.user_id,
      name: currentStore?.name,
      email: currentStore?.email,
      phone: currentStore?.phone,
      address: currentStore?.address,
      reason: currentStore?.reason,
      start_date: currentStore?.start_date,
      end_date: currentStore?.end_date,
      status: currentStore?.status,
      position: currentStore?.position,
    },
    errors: {
      name: null,
      email: null,
      phone: null,
      address: null,
      reason: null,
      start_date: null,
      end_date: null,
      status: null,
      position: null,
    },
  },

  mounted() {
  },

  methods: {
    submitForm() {
      return this.store.id ? this.update() : this.create();
    },

    create() {
      const that = this;
      axios
        .post(createApplyLeaveUrl, {
          phone: that.store.phone,
          reason: that.store.reason,
          start_date: that.store.start_date,
          end_date: that.store.end_date
        })
        .then((response) => this.redirectToIndex())
        .catch((error) => that.handleErrors(error));
    },

    update() {
      const that = this;
      axios
        .put(updateApplyLeaveUrl, {
          phone: that.store.phone,
          reason: that.store.reason,
          start_date: that.store.start_date,
          end_date: that.store.end_date
        })
        .then((response) => this.redirectToIndex())
        .catch((error) => that.handleErrors(error));
    },

    redirectToIndex() {
      window.location.href = indexUrl;
    },

    handleErrors(error) {
      showResponseErrorMessage(error);
      const response = error?.response;
      if (response?.status == 422) {
        const errorColumns = response.data.errors;
        for (let column in errorColumns) {
          errorColumns[column] = errorColumns[column].join(" ");
        }
        this.refreshErrors(errorColumns);
      }
    },

    refreshErrors(errors = {}) {
      this.errors = {
        name: null,
        phone: null,
        address: null,
        latitude: null,
        longitude: null,
      };
      Object.assign(this.errors, errors);
    },
  },
});
