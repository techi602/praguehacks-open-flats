<style>

    html, body, #map {
        height: 100%;
    }

 .slider-horizontal {
        width: 80% !important;
    }

</style>


    <div class="container">
        <fieldset>
            <legend>Filtry</legend>

        <div class="row">
            <div class="col-md-2">
                Měsíční nájemné (Kč):
            </div>
            <div class="col-md-4">
                <input id="price" type="text" class="span2" value="" data-slider-min="2000" data-slider-max="20000" data-slider-step="500" data-slider-value="[1000,10000]">
                <span id="price-range"></span>
            </div>
            <div class="col-md-2">
                Plocha (m2):
            </div>
            <div class="col-md-4">
                <input id="area" type="text" class="span2" value="" data-slider-min="10" data-slider-max="300" data-slider-step="5" data-slider-value="[20,100]">
                <span id="area-range"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>
                    <input type="checkbox" value="1" name="status" id="status"> Pouze volné byty
                </label>
            </div>
        </div>
        </fieldset>

    </div>

<br>

<div id="map"></div>
<script>

    $(function() {
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

        loadGeoData();
    });

    var markers = [];

    function deletePreviousMarkers()
    {
        for (i = 0; i < markers.length; i++) {
            map.removeLayer(markers[i]);
        }
    }

    function refreshMarkers(data)
    {
        deletePreviousMarkers();
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
            markers.push(marker);
        });
    }

    function loadGeoData()
    {
        var id = window.setTimeout(function() {}, 0);

        while (id--) {
            window.clearTimeout(id); // will do nothing if no timeout with id is present
        }

        var latLng = map.getCenter();

        var url =  "<?= $dataUrl ?>";

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



/*
        $.getJSON(url, function( data ) {
            refreshMarkers(data);
        });
        */
    }

    var map = L.map('map', {
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

    map.on('locationfound', onLocationFound);
    map.on('locationerror', onLocationError);
    map.on('dragend', onDragEnd);
    map.locate({setView: true, maxZoom: 14});

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
                    <div class="row">
                        <div class="col-md-6">
                            <p style="font-size: 1.5em">
                                Nájemné: <span id="flat-rent"></span> Kč <br>
                                Plocha: <span id="flat-area"></span> m2 <br>
                                Stav: <span id="flat-status"></span> <br>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <a href="#" style="font-size: 4em">
                                <span class="glyphicon glyphicon-thumbs-up"></span><!--
                            --></a>

                            &nbsp;&nbsp;

                            <a href="#" style="font-size: 4em">
                                <span class="glyphicon glyphicon-thumbs-down"></span>
                            </a>
                        </div>
                    </div>

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
