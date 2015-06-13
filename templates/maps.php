<style>

    html, body, #map {
        height: 100%;
    }

</style>
<div id="map"></div>
<script>

    var map = L.map('map');

    L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
        '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="http://mapbox.com">Mapbox</a>',
        id: 'examples.map-i875mjb7'
    }).addTo(map);

    function onLocationFound(e) {
        var radius = e.accuracy / 2;

        L.marker(e.latlng).addTo(map)
            .bindPopup("You are within " + radius + " meters from this point").openPopup();

        L.circle(e.latlng, radius).addTo(map);
    }

    function onLocationError(e) {
        L.panTo(new L.LatLng(50.06, 14.463));
        alert(e.message);
    }

    map.on('locationfound', onLocationFound);
    map.on('locationerror', onLocationError);
    map.locate({setView: true, maxZoom: 14});

    flats = [
        {
            "street": "K novým domkům",
            "num_desc": "131",
            "num_orient": null,
            "num_flat": "1",
            "area": "79.7",
            "status": "volný",
            "rent_area": null,
            "rent": "3000",
            "hire_from": null,
            "hire_to": null,
            "admin": "ACTON s.r.o.",
            "city_district": "Praha - Lahovice",
            "note": null,
            "source": "ACTON-PPS - byty",
            "source_id": "78",
            "rate": null,
            "rent_base": null,
            "equipment": null,
            "lat": 50.063882,
            "lng": 14.444922
        },
        {
            "street": "K novým domkům 2",
            "num_desc": "131",
            "num_orient": null,
            "num_flat": "1",
            "area": "79.7",
            "status": "volný",
            "rent_area": null,
            "rent": "3000",
            "hire_from": null,
            "hire_to": null,
            "admin": "ACTON s.r.o.",
            "city_district": "Praha - Lahovice",
            "note": null,
            "source": "ACTON-PPS - byty",
            "source_id": "78",
            "rate": null,
            "rent_base": null,
            "equipment": null,
            "lat": 50.053882,
            "lng": 14.434922
        }
    ];

    flats.forEach(function (flat, key) {

        marker = L.marker([flat.lat, flat.lng]);
        marker.bindPopup(
            '<strong>' + flat.street + '</strong><br>' +
            'Cena: ' + flat.rent +' Kč<br>' +
            'Rozměry: 20m2<br>' +
            '<a href="/praguehacks/detail?id=1" title="Ahoj">Klikni na mě</a>');
        marker.addTo(map);
    });


</script>
