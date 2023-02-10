import { showSuccess } from "../utils/alerts.js";

import goongMapMixin from '../utils/goong-map-mixin.js';
new Vue({
    el: '#setting-contact',

    mixins: [goongMapMixin],

    data: {
        contact,
        isLoadingMap: false
    },

    mounted() {
        this.initGoong({
            geocoderId: 'geocoder',
            mapId: 'map',
            coordinateId: 'coordinates',
            geocoderInitValue: this.contact.address,
            mapOption: this.contact.latitude
                ? { center: [parseFloat(this.contact.longitude), parseFloat(this.contact.latitude)] }
                : {}
        });

        this.showFlashMessage(message);
    },

    methods: {
        loadingMapHandle() {
            this.isLoadingMap = true;
        },

        geocoderOnResultHandle() {
            this.setContactCoordinates();
            this.isLoadingMap = false;
        },

        geocoderOnChangeHandle() {
            this.setContactAddress();
        },

        setContactCoordinates() {
            const { latitude, longitude } = this.getMarkerCoordinates();

            Object.assign(
                this.contact,
                {
                    latitude: String(latitude),
                    longitude: String(longitude)
                }
            );
        },

        setContactAddress() {
            this.contact.address = this.getGeocoderValue();
        },

        markerOnDragEndHandle() {
            this.setContactCoordinates();
        },
        
        showFlashMessage(message) {
            if (message != '') {
                showSuccess(message);
            }
        }
    }
});
