function toggleHand(change)
{
    var states = [
        'glyphicon glyphicon-hand-right',
        'glyphicon glyphicon-thumbs-up',
        'glyphicon glyphicon-thumbs-down'
    ];

    var key = 'like-' + $('#myModalLabel').html();
    status = store.get(key);
    status = parseInt(status);

    if (typeof status == 'undefined') {
        status = 0;
    }

    if (isNaN(status)) {
        status = 0;
    }

    if (change) {
        status++;
    }

    if (status >= 3) {
        status = 0;
    }

    store.set(key, status);
    var css = states[status];
    $('#hand').attr('class', css);
}

var defaultDelay = 600;

function initForm()
{
    $("#price").slider({});
    $("#area").slider({});
    $('#status').click(function (e) {
        setTimeout(loadGeoData, defaultDelay);
    });

    $("#price").on("slide", function(slideEvt) {
        var val = slideEvt.value;
        $('#price-range').html(val[0] + ' - ' + val[1]);
        setTimeout(loadGeoData, defaultDelay);
    });

    $("#area").on("slide", function(slideEvt) {
        var val = slideEvt.value;
        $('#area-range').html(val[0] + ' - ' + val[1]);
        setTimeout(loadGeoData, defaultDelay);
    });
}

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
