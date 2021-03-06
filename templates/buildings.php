<style>

    html, body, #map {
        height: 100%;
    }

</style>

<div id="map"></div>

<script>
    window.DATA_URL = "<?= $dataUrl ?>";
    //"/praguehacks/data/flats-geo-simple.json"



    var cluster = L.markerClusterGroup();

    var map;

    var markers = [];

    var APP = {
        // Definition of the Křovák projection
        // EPSG:102067 instead of EPSG:5514 needs to be used with IPR's WMS.
        crs: new L.Proj.CRS("EPSG:102067",
            "+proj=krovak +lat_0=49.5 +lon_0=24.83333333333333 "
            + "+alpha=30.28813972222222 +k=0.9999 +x_0=0 +y_0=0 "
            + "+ellps=bessel +towgs84=589,76,480,0,0,0,0 +units=m "
            + "+no_defs",
            {origin: [-951499.37, -930499.37],
                // The difficult part
                resolutions: [131088, 65544, 32772, 16386, 8193, 4096.5, 2048.25, 1024.125, 512.0625,
                    256.03125, 128.015625, 64.0078125, 32.00390625, 16.001953125, 8.0009765625,
                    4.00048828125, 2.000244140625, 1.0001220703125, 0.50006103515625,
                    0.250030517578125, 0.1250152587890625, 0.06250762939453125]}),
        main: function () {
            // Definition of the WGS 84 / Pseudo-Mercator
            proj4.defs("EPSG:3857","+proj=merc +a=6378137 +b=6378137 "
            + "+lat_ts=0.0 +lon_0=0.0 +x_0=0.0 +y_0=0 +k=1.0 "
            + "+units=m +nadgrids=@null +wktext  +no_defs");
            var layerOptions = {
                format: "image/png",
                transparent: true,
                opacity: 1,
                layers: ["0"],
                crs: APP.crs,
                attribution: 'Map data &copy; <a href="http://www.geoportalpraha.cz/">Institut plánování a rozvoje hlavního města Prahy</a>'
            };
            // Map tiles of Prague
            var pragueMap = L.tileLayer.wms(
                "http://mpp.praha.eu/ArcGIS/Services/DMP/MTVU/MapServer/WMSServer",
                layerOptions
            );
            // Layer with Prague-owned properties
            var pragueProperties = L.tileLayer.wms(
                "http://wgp.urm.cz/ArcGIS/services/SED/Majetek_HMP_budovy/MapServer/WMSServer",
                layerOptions
            );
            // Layer with Prague-owned flats for rent
            /*
             GeoJSON feature collection needs to specify its coordinate system, like this:
             "crs": {
             "type": "name",
             "properties": {
             "name": "urn:ogc:def:crs:EPSG::3857"
             }
             }
             */
            var pragueFlats = L.geoJson();

            var center = [50.093743, 14.446707]; // In Prague
            map = L.map("map",
                {layers: [pragueMap, pragueProperties, pragueFlats],
                    crs: APP.crs}
            ).setView(center, 13);


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
            /*
            $.getJSON(window.DATA_URL, function (data) {
                pragueFlats.addData(data);
            });
            */
        }
    };

        document.addEventListener("DOMContentLoaded", APP.main);



    $(function() {
        initForm();
    });

</script>


<?= include 'modal.php' ?>
