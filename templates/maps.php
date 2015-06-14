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
                                Nájemné: <span id="flat-rent"></span> <br>
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
