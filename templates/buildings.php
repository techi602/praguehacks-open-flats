<style>

    html, body, #map {
        height: 100%;
    }

</style>

<div id="map"></div>

<script>
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
            var layerOptions = {
                format: "image/png",
                transparent: true,
                opacity: 1,
                layers: ["0"],
                crs: APP.crs
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

            var center = [50.093743, 14.446707]; // In Prague
            var map = L.map("map",
                {layers: [pragueMap, pragueProperties],
                    crs: APP.crs}
            ).setView(center, 13);
        }
    };

    document.addEventListener("DOMContentLoaded", APP.main);
</script>
