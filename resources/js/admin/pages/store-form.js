import { showResponseErrorMessage } from "../utils/alerts.js";

import goongMapMixin from "../utils/goong-map-mixin.js";
new Vue({
  el: "#app-store",

  mixins: [goongMapMixin],

  data: {
    store: {
      id: currentStore?.id,
      name: currentStore?.name,
      phone: currentStore?.phone,
      address: "123",
      latitude: currentStore?.latitude,
      longitude: currentStore?.longitude,
    },
    errors: {
      name: null,
      phone: null,
      address: null,
      latitude: null,
      longitude: null,
    },
    isLoadingMap: false,
  },

  mounted() {
    this.initGoong({
      geocoderId: "geocoder",
      mapId: "map",
      coordinateId: "coordinates",
      geocoderInitValue: this.store.address,
      mapOption: this.store.latitude
        ? { center: [this.store.longitude, this.store.latitude] }
        : {},
    });
  },

  methods: {
    loadingMapHandle() {
      this.isLoadingMap = true;
    },

    geocoderOnResultHandle() {
      this.setStoreCoordinates();
      this.isLoadingMap = false;
    },

    geocoderOnChangeHandle() {
      this.setStoreAddress();
    },

    setStoreCoordinates() {
      const { latitude, longitude } = this.getMarkerCoordinates();

      Object.assign(this.store, {
        latitude: String(latitude),
        longitude: String(longitude),
      });
    },

    setStoreAddress() {
      this.store.address = this.getGeocoderValue();
    },

    markerOnDragEndHandle() {
      this.setStoreCoordinates();
    },

    submitForm() {
      return this.store.id ? this.update() : this.create();
    },

    update() {
      const that = this;

      axios
        .put(updateStoreUrl, this.store)
        .then((response) => this.redirectToIndex())
        .catch((error) => that.handleErrors(error));
    },

    create() {
      const that = this;

      axios
        .post(createStoreUrl, this.store)
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
