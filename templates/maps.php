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

    $.getJSON( "/praguehacks/data/flats.json", function( flats ) {
        flats.forEach(function (flat, key) {
            marker = L.marker([flat.lat, flat.lng]);
            marker.bindPopup(
                '<p style="font-size: 1.5em">' +
                '<strong>' + flat.street + '</strong><br>' +
                'Nájemné: ' + flat.rent +' Kč<br>' +
                'Plocha: 20m2<br>' +
                '<a href="#"' +
                'data-toggle="modal"' +
                'data-target="#modal-flat" ' +
                'data-title="' + flat.street + '" ' +
                'data-rent="' + flat.rent + '" ' +
                'data-area="' + 20 + '" ' +
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
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>
                    Nájemné: <span id="flat-rent"></span> Kč <br>Plocha: <span id="flat-area"></span> m2 <br>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
