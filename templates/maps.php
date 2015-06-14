<style>

    html, body, #map {
        height: 100%;
    }

</style>

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
