var map_container;
var single_map_container;
var default_center = {
    lat: -8.219078,
    lng: 114.4373073
};
var geo_json;
var pref_url = '/balai-jatim/gis_quarry';


function initMap(element) {
    if (map_container === undefined) {
        map_container = L.map(element).setView([default_center['lat'], default_center['lng']], 9);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 16,
            attribution: '© OpenStreetMap'
        }).addTo(map_container);
    }
}

function initSingleMap(element, coordinates = []) {
    if (single_map_container === undefined) {
        single_map_container = L.map(element).setView([default_center['lat'], default_center['lng']], 13);
        // L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //     maxZoom: 16,
        //     attribution: '© OpenStreetMap'
        // }).addTo(single_map_container);
        // let layerGroup = L.layerGroup();
        // let marker = L.marker(coordinates);
        // layerGroup.addLayer(marker);
        // single_map_container.addLayer(layerGroup);
        // single_map_container.panTo(new L.LatLng(coordinates[0], coordinates[1]));
    }
}

function getGeoJSONQuarry(cities = [], categories = [], init = true, isAdmin = false) {
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
            createMarker(payload, isAdmin);
            if (!init) {
                let arrayBound = [];
                let featuresData = response['payload']['features'];
                $.each(featuresData, function (k, v) {
                    arrayBound.push([
                        v['properties']['latitude'],
                        v['properties']['longitude'],
                    ])
                });
                map_container.fitBounds(arrayBound);
            }
        },
        error: function () {
        }
    });
}

function createMarker(data, isAdmin = false) {
    geo_json = L.geoJSON(data, {}).bindPopup(function (layer) {
        console.log(layer.feature.properties.name);
        return popUpDetail(layer.feature.properties, isAdmin);
    }).addTo(map_container);
}

function removeAllMarkers() {
    if (geo_json !== undefined) {
        map_container.removeLayer(geo_json);
    }
}

function createSingleMarker(coordinates = []) {
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 16,
        attribution: '© OpenStreetMap'
    }).addTo(single_map_container);
    let layerGroup = L.layerGroup();
    let marker = L.marker(coordinates);
    layerGroup.addLayer(marker);
    single_map_container.addLayer(layerGroup);
    single_map_container.panTo(new L.LatLng(coordinates[0], coordinates[1]));
}

function removeSingleMapLayer() {
    if (single_map_container !== undefined) {
        single_map_container.eachLayer(function (layer) {
            single_map_container.removeLayer(layer);
        });
    }
}

function popUpDetail(d, isAdmin = false) {
    let redirect = isAdmin ? pref_url+'/admin/quarry/' + d.id + '/detail' : pref_url+'/member/quarry/' + d.id + '/detail';
    return ('<div>' +
        '<p class="mb-1 font-weight-bold">' + d.name + '</p>' +
        '<p  class="mt-0 mb-0 font-weight-bold"><span style="color: #777777; font-weight: normal"> (' + d.category.name + ')</span></p>' +
        '<a href="' + redirect + '" style="font-size: 12px;">Detail</a>' +
        '</div>');
}

var panMarker;
function mapOnClick(callback) {
    map_container.on('click', function (e) {
        // console.log(e.latlng);
        let coordinate = e.latlng;
        if (panMarker !== undefined) {
            map_container.removeLayer(panMarker);
        }
        panMarker = L.marker([coordinate.lat,coordinate.lng],{
        }).addTo(map_container);
        callback(coordinate.lat, coordinate.lng)
        // var popup = L.popup().setLatLng(coordinate).setContent('<div></div>').openOn(map_container)
    })
}

function changeOnClick(lat = 0, lng = 0, callback) {
    let coordinate = {lat: lat, lng: lng};
    panMarker = L.marker([coordinate.lat,coordinate.lng],{
    }).addTo(map_container);
    map_container.panTo(new L.LatLng(coordinate.lat, coordinate.lng));
    map_container.on('click', function (e) {
        // console.log(e.latlng);
        coordinate = e.latlng;
        // if(lat !== 0 || lng !== 0) {
        //     coordinate = {
        //         lat: lat,
        //         lng: lng
        //     }
        // }
        console.log(coordinate);
        if (panMarker !== undefined) {
            map_container.removeLayer(panMarker);
        }
        panMarker = L.marker([coordinate.lat,coordinate.lng],{
        }).addTo(map_container);
        callback(coordinate.lat, coordinate.lng)
    })
}
