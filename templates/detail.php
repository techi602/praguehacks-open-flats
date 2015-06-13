<style>

    html, body, #map {
        height: 250px;
    }

</style>
<div id="map"></div>
<script type="text/javascript">

    var map = L.map('map', {
        center: [50.063882, 14.444922],
        zoom: 15
    });

    L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
        '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="http://mapbox.com">Mapbox</a>',
        id: 'examples.map-i875mjb7'
    }).addTo(map);

//    map.locate({setView: true, maxZoom: 16});

//    map.panTo(new L.LatLng(50.063882, 14.444922));
    marker = L.marker([50.063882, 14.444922]);
    marker.addTo(map);

</script>



<div class="container">
    <div class="row">
        <div class="col-lg-12">

            <div class="pull-right">
                <a href="#" style="font-size: 1.5em">
                    <span class="glyphicon glyphicon-star"></span>
                    Přidat do oblíbených
                </a>
            </div>
            <div style="clear: both"></div>


        <h1>
            Detail bytu XY - Ulice 123
        </h1>


            <p>
                Ulice: 123<br>
                Cena: 5000 Kč<br>
                Nějaká jiná data<br>

            </p>
        </div>
    </div>
</div>
