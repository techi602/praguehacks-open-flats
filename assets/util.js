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
