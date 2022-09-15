var map_container;
var default_center = {
    lat: -8.219078,
    lng: 114.4373073
};
var geo_json;

function initMap(element) {
    if (map_container === undefined) {
        map_container = L.map(element).setView([default_center['lat'], default_center['lng']], 9);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map_container);
    }
}

function getGeoJSONQuarry(cities = [], categories = []) {
    $.ajax({
        url: '/quarry/map',
        type: 'GET',
        data: {
            cities: cities,
            categories: categories
        },
        success: function (response) {
            let payload = response['payload'];
            removeAllMarkers();
            createMarker(payload);
        },
        error: function () {
        }
    });
}

function createMarker(data) {
    geo_json = L.geoJSON(data, {
    }).bindPopup(function (layer) {
        console.log(layer.feature.properties.name);
        return popUpDetail(layer.feature.properties);
    }).addTo(map_container);
}

function removeAllMarkers() {
    if(geo_json !== undefined) {
        map_container.removeLayer(geo_json);
    }
}

function popUpDetail(d) {
    return ('<div>' +
        '<p class="mb-1 font-weight-bold">'+d.name+'</p>' +
        '<p  class="mt-0 mb-0 font-weight-bold">'+d.company.name+'<span style="color: #777777; font-weight: normal"> ('+d.category.name+')</span></p>' +
        '<a href="#" style="font-size: 12px;">Detail</a>' +
        '</div>');
}
