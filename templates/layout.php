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

                <li>
                    <a href="#">
                        <span class="glyphicon glyphicon-bookmark"></span>
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

<?= $yield ?>

</body>
</html>
