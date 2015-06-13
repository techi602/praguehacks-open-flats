<style>

    html, body, #map {
        height: 100%;
    }

</style>
<div id="map"></div>
<script>

    var map = L.map('map', {
        center: [50.063882, 14.444922],
        zoom: 12
    });

//    var map = L.map('map');

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
            .bindPopup("Nacházíte se přibližně " + radius + " metrů od této pozice").openPopup();

        L.circle(e.latlng, radius).addTo(map);
    }

    function onLocationError(e) {
        L.panTo(new L.LatLng(50.06, 14.463));
        alert(e.message);
    }

    map.on('locationfound', onLocationFound);
    map.on('locationerror', onLocationError);
    map.locate({setView: true, maxZoom: 14});

    $.getJSON( "/praguehacks/data/flats-geo.json", function( data ) {
        flats = data.features;

        flats.forEach(function (flat, key) {
            marker = L.marker([flat.geometry.coordinates[1], flat.geometry.coordinates[0]]);
            var street = flat.properties.street + ' ' + flat.properties.num_desc;
            if (flat.num_orient){
                street += '/' + flat.properties.num_orient;
            }

            marker.bindPopup(
                '<p style="font-size: 1.5em">' +
                '<strong>' + street + '</strong><br>' +
                'Nájemné: ' + flat.properties.rent +' Kč<br>' +
                'Plocha: ' + flat.properties.area + ' m2<br>' +
                'Stav: ' + flat.properties.status + '<br>' +
                '<a href="#"' +
                'data-toggle="modal"' +
                'data-target="#modal-flat" ' +
                'data-title="' + street + '" ' +
                'data-rent="' + flat.properties.rent + '" ' +
                'data-area="' + flat.properties.area + '" ' +
                'data-status="' + flat.properties.status + '" ' +
                'data-district="' + flat.properties.city_district + '" ' +
                '">Zobrazit detail nabídky</a>' +
                '</p>'
            );
            marker.addTo(map);
        });
    });

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
    });


</script>

<!-- Modal -->
<div class="modal fade" id="modal-flat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="font-size: 2em">Modal title</h4>
            </div>
            <div class="modal-body">
                <p style="font-size: 1.5em">
                    Nájemné: <span id="flat-rent"></span> Kč <br>
                    Plocha: <span id="flat-area"></span> m2 <br>
                    Stav: <span id="flat-status"></span> <br>
                </p>
            </div>
            <div class="modal-footer">
                <a href="tel:+420236002435" class="btn btn-primary" id="phone-link">
                    <span class="glyphicon glyphicon-phone-alt"></span> Telefon +420 236 00 2435
                </a>
                <a href="#" class="btn btn-success" id="mail-link">
                    <span class="glyphicon glyphicon-envelope"></span> E-mail
                </a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavřít</button>
            </div>
        </div>
    </div>
</div>
