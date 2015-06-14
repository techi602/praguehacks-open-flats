<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title><?= isset($title) ? htmlspecialchars($title) . ' - ' : '' ?>Byty Otevřeně</title>
    <!--meta name="viewport" content="width=device-width, initial-scale=1"-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.css" media="screen">
    <link rel="stylesheet" href="https://bootswatch.com/assets/css/bootswatch.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/styles.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/leaflet.markercluster.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/leaflet.usermarker.css">
    <link rel="stylesheet" href="http://seiyria.github.io/bootstrap-slider/stylesheets/bootstrap-slider.css">
    <link type="text/plain" rel="author" href="<?= $baseUrl ?>/humans.txt">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://bootswatch.com/bower_components/html5shiv/dist/html5shiv.js"></script>
    <script src="https://bootswatch.com/bower_components/respond/dest/respond.min.js"></script>
    <![endif]-->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://bootswatch.com/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="https://bootswatch.com/assets/js/bootswatch.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js"></script>

    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css" />
    <script src="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
    <script src="<?= $baseUrl ?>/assets/store.min.js"></script>
    <script src="<?= $baseUrl ?>/assets/leaflet.markercluster.js"></script>
    <script src="<?= $baseUrl ?>/assets/leaflet.usermarker.js"></script>
    <script src="<?= $baseUrl ?>/assets/util.js"></script>
    <script src="http://seiyria.github.io/bootstrap-slider/javascripts/bootstrap-slider.js"></script>
    <script>
        function toggleFullScreen() {
            if (!document.fullscreenElement &&    // alternative standard method
                !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                }
            }
        }


    </script>
    <?php if (!empty($js)): ?>
        <?php foreach ($js as $script): ?>
            <script src="<?= $script ?>"></script>
        <?php endforeach ?>
    <?php endif ?>

</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="<?= $baseUrl ?>/" class="navbar-brand">Byty Otevřeně</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <?php if (false): ?>
                <li<?php echo $page == 'home' ? ' class="active"' : '' ?>>
                    <a href="<?= $baseUrl ?>/"><span class="glyphicon glyphicon-home"></span> Home</a>
                </li>
                <li<?php echo $page == 'google' ? ' class="active"' : '' ?>>
                    <a href="<?= $baseUrl ?>/google"><span class="glyphicon glyphicon-wrench"></span> Google maps</a>
                </li>
                <?php endif ?>

                <li<?php echo $page == 'maps' ? ' class="active"' : '' ?>>
                    <a href="<?= $baseUrl ?>/maps"><span class="glyphicon glyphicon-map-marker"></span> Mapy</a>
                </li>

                <li<?php echo $page == 'buildings' ? ' class="active"' : '' ?>>
                    <a href="<?= $baseUrl ?>/buildings"><span class="glyphicon glyphicon glyphicon-piggy-bank"></span> Budovy</a>
                </li>

                <li>
                    <a href="#" onclick="$('#filter-form').toggle()">
                        <span class="glyphicon glyphicon-cog"></span>
                        Filtr
                    </a>
                </li>

                <li>
                    <a href="#" data-toggle="modal" data-target="#modal-fav">
                        <span class="glyphicon glyphicon-thumbs-up"></span>
                        Oblíbené
                    </a>
                </li>

                <li>
                    <a href="javascript:alert('Tak Sdílej!!!')">
                        <span class="glyphicon glyphicon-share"></span>
                        Sdílet
                    </a>
                </li>

                <li>
                    <a href="javascript:toggleFullScreen()">
                        <span class="glyphicon glyphicon-zoom-in"></span>
                        (+)
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>

<div id="filter-form" style="display: none">
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

</div>


<?= $yield ?>

<!-- Modal -->
<div class="modal fade" id="modal-fav" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="font-size: 2em">Oblíbené</h4>
            </div>
            <div class="modal-body">

                <ul id="fav-list">

                </ul>

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


<script>

    $(function() {
        $('#modal-fav').on('show.bs.modal', function (e) {
            xdata = $(this).data();
            options = xdata['bs.modal'].options;

            var list = [];

            // Loop over all stored values
            store.forEach(function(key, val) {
                if (val == 1 && key.substr(0, 5) == 'like-') {
                    var address = key.substr(5);
                    list.push('<li>' + address + '</li>');
                }
            });

            $('#fav-list').html(list.join("\n"));
        });

        $("#modal-flat").on('hidden.bs.modal', function () {
            $(this).data('bs.modal', null);
        });
    });
</script>



</body>
</html>
