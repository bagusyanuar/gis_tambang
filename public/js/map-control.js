var map_container;
var default_center = {
    lat: -8.219078,
    lng: 114.4373073
};

function initMap(element) {
    if (map_container === undefined) {
        map_container = L.map(element).setView([default_center['lat'], default_center['lng']], 9);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map_container);
    }
    getGeoJSONQuarry();
}

function getGeoJSONQuarry() {
    // try {
        // let response = await $.get('/quarry/map');
        $.ajax({
            url: '/quarry/map',
            type: 'GET',
            data: {
                categories: ['a', 'b', 'c']
            },
            success: function (response) {
                console.log(response);
            },
            error: function () {

            }
        });
        // let payload = response['payload'];
        // createMarker(payload);

    // }catch (e) {
    //     console.log(e);
    // }
}

function createMarker(data) {
    L.geoJSON(data, {

    }).bindPopup(function (layer) {
        return ('<div><strong>Detail</strong></div>')
    }).addTo(map_container);
}
