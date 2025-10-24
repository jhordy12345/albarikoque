<?php include_once 'Views/template/header-principal.php'; ?>

<!-- banner section start -->
<div class="banner_section layout_padding">
    <div class="container">
        <div id="my_slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="banner_taital">Vamos a pedir <br>una pizza</h1>
                            <div class="buynow_bt">
                                <a href="#categoria_1">Comprar ahora</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="banner_taital">COMIENZE <br>SUS COMPRAS FAVORITAS</h1>
                            <div class="buynow_bt">
                                <a href="#categoria_2">Comprar ahora</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="banner_taital">COMPRA <br>LO QUE TU QUIERAS</h1>
                            <div class="buynow_bt">
                                <a href="#categoria_3">Comprar ahora</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#my_slider" role="button" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#my_slider" role="button" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div>
</div>
<!-- banner section end -->

<!-- fashion section start -->
<?php foreach ($data['categorias'] as $categoria) { ?>
<div class="fashion_section">
    <div class="container" id="categoria_<?php echo $categoria['id']; ?>">
        <h1 class="fashion_taital text-uppercase"><?php echo $categoria['categoria']; ?></h1>
        <div class="row <?php echo (count($categoria['productos']) > 0) ? 'multiple-items' : ''; ?>">
            <?php foreach ($categoria['productos'] as $producto) { ?>
            <div class="<?php echo (count($categoria['productos']) > 2) ? 'col-lg-4' : 'col-lg-12'; ?>">
                <div class="box_main">
                    <h4 class="shirt_text"><?php echo $producto['nombre']; ?></h4>
                    <p class="price_text">Precio <span style="color: #262626;">S/ <?php echo $producto['precio']; ?></span></p>
                    <div class="text-center">
                        <img data-lazy="<?php echo BASE_URL . $producto['imagen']; ?>" />
                    </div>
                    <div class="btn_main">
                        <div class="buy_bt">
                            <a href="#" class="btnAddcarrito" prod="<?php echo $producto['id']; ?>">Añadir</a>
                        </div>
                        <div class="seemore_bt">
                            <a href="#" class="btnLeerMas" data-id="<?php echo $producto['id']; ?>">Leer más</a>
                        </div>
                    </div>
                    <!-- Contenedor oculto con descripción (solo para extraer texto) -->
                    <div class="descripcion_producto" style="display:none;">
                        <p><?php echo $producto['descripcion']; ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>

<!-- Tooltip global fuera del slider -->
<div id="tooltip_global" style="display:none; position:absolute; z-index:9999; background: rgba(0,0,0,0.85); color:#fff; padding:10px 15px; border-radius:8px; width:220px; text-align:center; box-shadow:0 4px 8px rgba(0,0,0,0.3); pointer-events:auto;">
    <p id="tooltip_text"></p>
</div>

<?php include_once 'Views/template/footer-principal.php'; ?>

<script>
$(document).ready(function () {
    // Slick slider
    $('.multiple-items').slick({
        lazyLoad: 'ondemand',
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [
            { breakpoint: 1024, settings: { slidesToShow: 3, slidesToScroll: 3 } },
            { breakpoint: 600, settings: { slidesToShow: 2, slidesToScroll: 2 } },
            { breakpoint: 480, settings: { slidesToShow: 1, slidesToScroll: 1 } }
        ]
    });

    $(document).on("click", ".btnLeerMas", function(e){
        e.preventDefault();
        e.stopPropagation();

        const productoBox = $(this).closest('.box_main');
        const desc = productoBox.find('.descripcion_producto');
        const tooltip = $('#tooltip_global');
        const tooltipText = $('#tooltip_text');

        // Pausar autoplay
        $('.multiple-items').slick('slickPause');

        // Coloca el texto y posición del tooltip
        tooltipText.html(desc.html());
        const offset = productoBox.offset();
        tooltip.css({
            top: offset.top + productoBox.outerHeight() + 10, // debajo del producto
            left: offset.left + productoBox.outerWidth()/2 - tooltip.outerWidth()/2
        });

        tooltip.fadeIn(300);
    });

    // Cierra al hacer clic fuera
    $(document).on("click", function(e){
        if (!$(e.target).closest("#tooltip_global, .btnLeerMas").length){
            $('#tooltip_global').fadeOut(200);
            $('.multiple-items').slick('slickPlay');
        }
    });
});
</script>
