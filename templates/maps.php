<style>

    html, body, #map {
        height: 100%;
    }

    .slider-horizontal {
        width: 70% !important;
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
                <span id="price-range" class="text-nowrap"></span>
            </div>
            <div class="col-md-2">
                Plocha (m2):
            </div>
            <div class="col-md-4">
                <input id="area" type="text" class="span2" value="" data-slider-min="10" data-slider-max="300" data-slider-step="5" data-slider-value="[20,100]">
                <span id="area-range" class="text-nowrap"></span>
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
    window.DATA_URL = "<?= $dataUrl ?>";

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
        map.locate({
            watch: false,
            locate: true,
            setView: true,
            enableHighAccuracy: false
        });

        loadGeoData();
    });

</script>

<?= include 'modal.php' ?>
