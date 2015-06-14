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
            rent += ' Kč';
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
            '<a href="#"' +
            'data-toggle="modal"' +
            'data-target="#modal-flat" ' +
            'data-title="' + street + '" ' +
            'data-rent="' + rent + '" ' +
            'data-area="' + flat.properties.area + '" ' +
            'data-status="' + status + '" ' +
            'data-district="' + flat.properties.city_district + '" ' +
            '">Zobrazit detail nabídky</a>' +
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

    url += '?area=' + $('#area').val();
    url += '&price=' + $('#price').val();
    url += '&status=' + $('#status').is(":checked");
    url += '&lat=' + latLng.lat;
    url += '&lng=' + latLng.lng;

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


$(function() {
    $('#modal-flat').on('show.bs.modal', function (e) {
        xdata = $(this).data();
        options = xdata['bs.modal'].options;

        $('#myModalLabel').html(options.title);
        $('#flat-rent').html(options.rent);
        $('#flat-area').html(options.area);
        $('#flat-status').html(options.status);

        var mail = 'Libuse.Bartunkova@praha.eu';
        var mailto = 'mailto:' + mail + '?Subject=Prosba o více informací k bytu na adrese ' + options.title + '&body=Dobrý den,\n prosím o více informací o dostupnosti bytu na adrese ' + options.title + '.\n\nPředem Děkuji\nS pozdravem';
        $('#mail-link').attr('href', mailto);
    });

    $("#modal-flat").on('hidden.bs.modal', function () {
        $(this).data('bs.modal', null);
    });

    $("#price").slider({});
    $("#area").slider({});

    $("#price").on("slide", function(slideEvt) {
        var val = slideEvt.value;
        $('#price-range').html(val[0] + ' - ' + val[1]);
        setTimeout(loadGeoData, 800);
    });

    $("#area").on("slide", function(slideEvt) {
        var val = slideEvt.value;
        $('#area-range').html(val[0] + ' - ' + val[1]);
        setTimeout(loadGeoData, 800);
    });

    map = L.map('map', {
        center: [50.063882, 14.444922],
        zoom: 12
    });

    L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
        '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="http://mapbox.com">Mapbox</a>',
        id: 'examples.map-i875mjb7'
    }).addTo(map);

    map.on('locationfound', onLocationFound);
    map.on('locationerror', onLocationError);
    map.on('dragend', onDragEnd);
    map.locate({setView: true, maxZoom: 14});

    loadGeoData();
});
