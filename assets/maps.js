var markers = [];

var cluster = L.markerClusterGroup();

var map;

function deletePreviousMarkers()
{
    for (i = 0; i < markers.length; i++) {
        cluster.removeLayer(markers[i]);
    }
}

function refreshMarkers(data)
{
    deletePreviousMarkers();

    map.removeLayer(cluster);

    flats = data.features;

    flats.forEach(function (flat, key) {
        marker = L.marker([flat.geometry.coordinates[1], flat.geometry.coordinates[0]]);
        var street = flat.properties.street + ' ' + flat.properties.num_desc;
        if (flat.num_orient){
            street += '/' + flat.properties.num_orient;
        }

        var rent = flat.properties.rent;
        if (rent == 0 || rent == null) {
            rent = 'neupřesněno';
        } else {
            rent = Math.round(rent) + ' Kč';
        }

        var status = flat.properties.status;
        if (status == null) {
            status = 'neznámý';
        }

        marker.bindPopup(
            '<p style="font-size: 1.5em">' +
            '<strong>' + street + '</strong><br>' +
            'Nájemné: ' + rent + '<br>' +
            'Plocha: ' + flat.properties.area + ' m2<br>' +
            'Stav: ' + status + '<br>' +
            '<a class="btn btn-primary text-center" style="font-weight: bold;color:white; width: 100%" href="#"' +
            'data-toggle="modal"' +
            'data-target="#modal-flat" ' +
            'data-title="' + street + '" ' +
            'data-rent="' + rent + '" ' +
            'data-area="' + flat.properties.area + '" ' +
            'data-status="' + status + '" ' +
            'data-district="' + flat.properties.city_district + '" ' +
            '">Detail</a>' +
            '</p>'
        );
        //marker.addTo(map);
        markers.push(marker);
        cluster.addLayer(marker);
    });

    map.addLayer(cluster);
}

function loadGeoData()
{
    var id = window.setTimeout(function() {}, 0);

    while (id--) {
        window.clearTimeout(id); // will do nothing if no timeout with id is present
    }

    var latLng = map.getCenter();

    var url = window.DATA_URL;

    params = [];
    if ($('#area').length) {
        params.push('area=' + $('#area').val());
    }
    if ($('#price').length) {
        params.push('price=' + $('#price').val());
    }
    if ($('#status').length) {
        params.push('status=' + $('#status').is(":checked"));
    }
    params.push('lat=' + latLng.lat);
    params.push('lng=' + latLng.lng);
    params.push('zoom=' + map.getZoom());

    url += '?' + params.join('&');
    console.log(url);

    $.ajax({
        type: 'GET',
        dataType: "json",
        url: url,
        crossDomain: true,
        success: function (data, textStatus, jqXHR) {
            console.log(data);
            refreshMarkers(data);
        },
        error: function (responseData, textStatus, errorThrown) {
            alert('Request failed.' + textStatus);
        }
    });
}

function onLocationFound(e) {
    var radius = e.accuracy / 2;

    L.marker(e.latlng).addTo(map)
        .bindPopup("Nacházíte se přibližně " + radius + " metrů od této pozice").openPopup();

    L.circle(e.latlng, radius).addTo(map);
}

function onLocationError(e) {
    L.panTo(new L.LatLng(50.06, 14.463));
    alert(e.message);
}

function onDragEnd(e) {
    setTimeout(loadGeoData, 300);
}
