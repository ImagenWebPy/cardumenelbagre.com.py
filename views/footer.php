
<script src="<?= ASSETS; ?>js/vendor/jquery-ui-1.10.4.custom.min.js"></script>
<script src="<?= ASSETS; ?>js/vendor/jquery.touchSwipe.min.js"></script>

<script src="<?= PUBLIC_FILES; ?>plugins/bootstrap/js/bootstrap.min.js"></script>


        <!--[if IE]><script type="text/javascript" src="<?= ASSETS; ?>js/vendor/excanvas.js"></script><![endif]-->
<script src="<?= ASSETS; ?>js/vendor/jquery.knob.min.js"></script>
<script src="<?= ASSETS; ?>js/vendor/fastclick.min.js"></script>
<script src="<?= ASSETS; ?>js/vendor/jquery.stellar.min.js"></script>

<script src="<?= ASSETS; ?>js/vendor/jquery.mousewheel.js"></script>
<script src="<?= ASSETS; ?>js/vendor/perfect-scrollbar.min.js"></script>
<script src="<?= ASSETS; ?>js/vendor/jquery.mtmenu.js"></script>

<script src="<?= ASSETS; ?>js/vendor/isotope.pkgd.min.js"></script>

<script src="<?= ASSETS; ?>js/vendor/jquery.validationEngine.js"></script>
<script src="<?= ASSETS; ?>js/vendor/jquery.validationEngine-en.js"></script>

<!-- LayerSlider script files -->
<script src="<?= ASSETS; ?>plugins/layerslider/js/greensock.js" type="text/javascript"></script>
<script src="<?= ASSETS; ?>plugins/layerslider/js/layerslider.transitions.js" type="text/javascript"></script>
<script src="<?= ASSETS; ?>plugins/layerslider/js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script>

<script src="<?= ASSETS; ?>js/plugins.js"></script>
<script src="<?= ASSETS; ?>js/main.js"></script>
<script src="<?= ASSETS; ?>js/jquery.youtubebackground.js"></script>

<!--SLICK-->
<script src="<?= PUBLIC_FILES; ?>plugins/slick/slick/slick.js"></script>

<!--GOOGLE MAPS-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwncHAgzJNmPsM9B3vjYk7y0tjoKR7tkg&callback=initMap"
async defer></script>
<script type="text/javascript">
    var maps = [];
    var markers = [];
    function initMap() {
        var $maps = $('#gmap');
        $.each($maps, function (i, value) {
            var uluru = {lat: parseFloat($(value).attr('data-latitud')), lng: parseFloat($(value).attr('data-longitud'))};
            var mapDivId = $(value).attr('id');
            maps[mapDivId] = new google.maps.Map(document.getElementById(mapDivId), {
                zoom: 17,
                center: uluru
            });
            markers[mapDivId] = new google.maps.Marker({
                position: uluru,
                icon: '<?= ASSETS; ?>img/pez-marker.png',
                map: maps[mapDivId]
            });
        })
    }
    $(function ($) {
        $(".center").slick({
            dots: true,
            infinite: true,
            centerMode: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $('#background-video').YTPlayer({
            fitToBackground: true,
            videoId: '9lvptGdodCA',
            remember_last_time: true,
            showAnnotations: false,
            height: "100%",
            width: "100%",
            mute: false,
            callback: function () {
                videoCallbackEvents();
            }
        });

        var videoCallbackEvents = function () {
            var player = $('#background-video').data('ytPlayer').player;
            player.addEventListener('onStateChange', function (event) {
                // OnStateChange Data
                if (event.data === 1) {
                    $('.ls-mental-scrollunder').css('display', 'block');
                }
            });
        }
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(document).on("click", ".btnTrabaja", function (e) {
            if (e.handled !== true) {
                $.ajax({
                    url: "<?= URL; ?>contenido/mostrarModalTrabaja",
                    type: "post",
                    dataType: "json",
                    success: function (data) {
                        $(".genericModal .modal-header").addClass("modal-header bg-black");
                        $(".genericModal .modal-title").html(data['titulo']);
                        $(".genericModal .modal-body").html(data['contenido']);
                        $(".genericModal").modal("toggle");
                    }
                }); //END AJAX
            }
            e.handled = true;
        });
        $('.gl-item').hover(function () {
            $(this).find('.divTitulosPost:first').hide()
        }, function () {
            $(this).find('.divTitulosPost:first').show();
        });
    });
</script>
<?php
#cargamos los js de las vistas
if (isset($this->external_js)) {
    foreach ($this->external_js as $external) {
        echo '<script async defer src="' . $external . '"></script>';
    }
}
if (isset($this->public_js)) {
    foreach ($this->public_js as $public_js) {
        echo '<script type="text/javascript" src="' . URL . 'public/' . $public_js . '"></script>';
    }
}
if (isset($this->js)) {
    foreach ($this->js as $js) {
        echo '<script type="text/javascript" src="' . URL . 'views/' . $js . '"></script>';
    }
}
?>
<!-- Bootstrap Modal -->
<div class="modal fade genericModal" tabindex="-1" role="dialog" aria-labelledby="Generic Modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>