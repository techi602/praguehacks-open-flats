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
                            Plocha: <span id="flat-area"></span> m<sup>2</sup> <br>
                            Stav: <span id="flat-status"></span> <br>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <a href="javascript:toggleHand(true)" style="font-size: 4em">
                            <span id="hand" class="glyphicon glyphicon-hand-right"></span><!--
                            --></a>

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

<script>

    $(function() {
        $('#modal-flat').on('show.bs.modal', function (e) {
            xdata = $(this).data();
            options = xdata['bs.modal'].options;

            $('#myModalLabel').html(options.title);
            $('#flat-rent').html(options.rent);
            $('#flat-area').html(options.area);
            $('#flat-status').html(options.status);

            var mail = 'Libuse.Bartunkova@praha.eu';
            var mailto = 'mailto:' + mail + '?Subject=Prosba o více informací k bytu na adrese ' + options.title + '&body=Dobrý den,\n prosím o více informací o dostupnosti bytu na adrese ' + options.title + '.\n\nPředem Děkuji\nS pozdravem';
            $('#mail-link').attr('href', mailto);
            toggleHand();
        });

        $("#modal-flat").on('hidden.bs.modal', function () {
            $(this).data('bs.modal', null);
        });
    });
</script>
