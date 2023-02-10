const GEOCODER_STATUS = {
    success: 'OK'
};

const DEFAULT_COORDINATES = {
    latitude: 21.03677130693113,
    longitude: 105.8344898123422
};

const DEFAULT_MAP_STYLE = 'https://tiles.goong.io/assets/goong_map_web.json';

const DEFAULT_ZOOM = 16;

const DEFAULT_MAP_OPTION = {
    style: DEFAULT_MAP_STYLE,
    center: [DEFAULT_COORDINATES.longitude, DEFAULT_COORDINATES.latitude],
    zoom: DEFAULT_ZOOM
};

const COORDINATE_RANGE = {
    min_latitude: -90,
    max_latitude: 90,
    min_longitude: -180,
    max_longitude: 180
};

export default {
    methods: {
        initGoong({
            geocoderId,
            mapId,
            coordinateId,
            geocoderInitValue = '',
            mapOption = {}
        }) {
            this.initGeocoder({
                geocoderId,
                geocoderInitValue
            });

            this.initMap({
                mapId,
                mapOption,
                coordinateId
            });
        },

        initGeocoder({ geocoderId, geocoderInitValue }) {
            const geocoder = new GoongGeocoder({
                accessToken: GOONG_MAP_API_KEY
            });

            geocoder.addTo(`#${geocoderId}`);

            const inputElement = document.querySelector(`#${geocoderId} input`);
            inputElement.value = geocoderInitValue;

            this.initGeocoderEvents({
                geocoder,
                inputElement
            });

            this.geocoder = geocoder;
        },

        initGeocoderEvents({
            geocoder,
            inputElement
        }) {
            const that = this;

            geocoder.on('result', e => {
                if (that.isGeocoderSuccess(e?.result)) {
                    that.loadingMapHandle();

                    const result = e.result;

                    that.jumpTo(result);

                    that.showCoordinates();

                    that.geocoderOnResultHandle(result);
                }
            });

            inputElement
                .addEventListener('change', () => that.geocoderOnChangeHandle());
        },

        loadingMapHandle() { },

        geocoderOnResultHandle() { },

        geocoderOnChangeHandle() { },

        initMap({ mapId, mapOption, coordinateId }) {
            goongjs.accessToken = GOONG_MAP_MAPTILES_KEY;

            const map = new goongjs.Map(this.setMapOption({ mapId, mapOption }));

            this.initCoordinateContainer(coordinateId);

            this.initMarker(map);

            this.map = map;
        },

        setMapOption({ mapId, mapOption }) {
            this.validateMapOptionCenter(mapOption);

            return Object.assign(
                DEFAULT_MAP_OPTION,
                {
                    ...mapOption,
                    container: mapId
                }
            );
        },

        validateMapOptionCenter(mapOption) {
            const center = mapOption?.center;

            if (!center) {
                return;
            }

            const [longitude, latitude] = center;

            return this.isValidCoordinates({ latitude, longitude }) || delete mapOption.center;
        },

        initCoordinateContainer(coordinateId) {
            const coordinateContainer = document.getElementById(coordinateId);

            coordinateContainer.style.display = 'block';

            this.coordinateContainer = coordinateContainer;
        },

        initMarker(map) {
            const { latitude, longitude } = this.getMapCenterCoordinates(map);

            const marker = new goongjs.Marker({
                draggable: true
            })
                .setLngLat([longitude, latitude])
                .addTo(map);

            this.initMarkerEvents(marker);

            this.marker = marker;
        },

        initMarkerEvents(marker) {
            const that = this;

            marker.on('dragend', () => {
                that.showCoordinates();

                that.markerOnDragEndHandle();
            });
        },

        markerOnDragEndHandle() { },

        jumpTo(result) {
            const { latitude, longitude } = this.getGeocoderCoordinates(result);

            this.map.jumpTo({
                center: [longitude, latitude],
                zoom: DEFAULT_ZOOM
            });

            this.marker.setLngLat({
                lng: longitude,
                lat: latitude
            });
        },

        isGeocoderSuccess(result) {
            return result?.status === GEOCODER_STATUS.success;
        },

        showCoordinates() {
            const { latitude, longitude } = this.getMarkerCoordinates();

            this.coordinateContainer.innerHTML = `Longitude: ${longitude}\nLatitude: ${latitude}`;
        },

        getGeocoderCoordinates(result) {
            const { lat: latitude, lng: longitude } = result.result.geometry.location;

            return {
                latitude,
                longitude
            };
        },

        getMarkerCoordinates() {
            const { lat: latitude, lng: longitude } = this.marker.getLngLat();

            return {
                latitude,
                longitude
            }
        },

        getMapCenterCoordinates(map) {
            const { lat: latitude, lng: longitude } = map.getCenter();

            return {
                latitude,
                longitude
            };
        },

        getGeocoderValue() {
            return this.geocoder.getInput();
        },

        isValidCoordinates({ latitude, longitude }) {
            return (COORDINATE_RANGE.min_latitude <= latitude && latitude <= COORDINATE_RANGE.max_latitude) &&
                (COORDINATE_RANGE.min_longitude <= longitude && longitude <= COORDINATE_RANGE.max_longitude);
        }
    }
}
