<?php include_once 'Views/template/header-principal.php'; ?>

<body>

    <div class="banner_bg_main">

        <!-- Sección completa de header y carrusel -->
        <!-- Sección completa banner + header -->
        <div class="banner_complete_section">

            <!-- Header superior con logo -->
            <div class="header_section_top">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="custom_menu">
                                <ul>
                                    <li>
                                        <a href="<?php echo BASE_URL; ?>">
                                            <img src="<?php echo BASE_URL; ?>assets/images/baner_albarikoque.png"
                                                alt="ALBARIKOQUE" class="logo_img">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner con carrusel -->
            <div class="banner_section layout_padding">
                <div class="container">
                    <div id="my_slider" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h1 class="banner_taital">Vamos a pedir <br>una pizza</h1>
        
                                        <p class="banner_subtitle">Descubre sabores artesanales y combínalos como quieras.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h1 class="banner_taital">COMIENZE <br>SUS COMPRAS FAVORITAS</h1>
                                        
                                        <p class="banner_subtitle">Filtra por categoría y encuentra tus antojos rápidamente.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h1 class="banner_taital">COMPRA <br>LO QUE TU QUIERAS</h1>
                                        
                                        <p class="banner_subtitle">Entrega rápida, productos frescos y soporte en línea.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Controles del carrusel -->
                        <a class="carousel-control-prev" href="#my_slider" role="button" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="carousel-control-next" href="#my_slider" role="button" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>


        <section class="benefits_strip">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="benefit_item">
                            <div class="benefit_icon"><i class="fa-solid fa-clock"></i></div>
                            <div>
                                <h3>Entrega ágil</h3>
                                <p>Revisa el menú, agrega al carrito y recibe tu pedido sin demoras.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="benefit_item">
                            <div class="benefit_icon"><i class="fa-solid fa-pizza-slice"></i></div>
                            <div>
                                <h3>Selección curada</h3>
                                <p>Productos destacados por categoría para que elijas con confianza.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="benefit_item">
                            <div class="benefit_icon"><i class="fa-solid fa-headset"></i></div>
                            <div>
                                <h3>Acompañamiento</h3>
                                <p>Soporte en línea y seguimiento de pedidos desde tu cuenta.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- fashion section start -->
        <?php foreach ($data['categorias'] as $categoria) { ?>
        <div class="fashion_section">
            <div class="container" id="categoria_<?php echo $categoria['id']; ?>">
                <div class="section_title_wrapper">
                    <h1 class="fashion_taital text-uppercase"><?php echo $categoria['categoria']; ?></h1>
                    <span class="section_divider"></span>
                </div>
                <div class="row <?php echo (count($categoria['productos']) > 0) ? 'multiple-items' : ''; ?>">
                    <?php foreach ($categoria['productos'] as $producto) {
                        $descripcionLimpia = strip_tags($producto['descripcion']);
                        $resumen = strlen($descripcionLimpia) > 140 ? substr($descripcionLimpia, 0, 140) . '…' : $descripcionLimpia;
                        $precioFormateado = number_format($producto['precio'], 2);
                    ?>
                    <div class="<?php echo (count($categoria['productos']) > 2) ? 'col-lg-4' : 'col-lg-12'; ?>">
                        <div class="box_main">
                            <div class="product_header">
                                <div class="product_meta">
                                    <span class="pill pill-primary"><i class="fa-solid fa-tag"></i>
                                        <?php echo $categoria['categoria']; ?></span>
                                    <span class="pill pill-soft">Disponible</span>
                                </div>
                                <div class="price_chip">
                                    <span class="price_currency">S/</span>
                                    <span class="price_amount"><?php echo $precioFormateado; ?></span>
                                </div>
                            </div>
                            <div class="product_image_wrapper">
                                <img data-lazy="<?php echo BASE_URL . $producto['imagen']; ?>" class="product_image" />
                            </div>
                            <div class="product_body">
                                <h4 class="shirt_text"><?php echo $producto['nombre']; ?></h4>
                                <p class="product_excerpt"><?php echo $resumen; ?></p>
                            </div>
                            <div class="btn_main">
                                <div class="buy_bt">
                                    <a href="#" class="btnAddcarrito" prod="<?php echo $producto['id']; ?>"><i
                                            class="fa-solid fa-cart-plus"></i> Añadir al carrito</a>
                                </div>
                                <div class="seemore_bt">
                                    <a href="#" class="btnLeerMas" data-id="<?php echo $producto['id']; ?>">Ficha
                                        rápida</a>
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
        <div id="tooltip_global"
            style="display:none; position:absolute; z-index:9999; background: rgba(0,0,0,0.85); color:#fff; padding:10px 15px; border-radius:8px; width:220px; text-align:center; box-shadow:0 4px 8px rgba(0,0,0,0.3); pointer-events:auto;">
            <p id="tooltip_text"></p>
        </div>
    </div>


    <?php include_once 'Views/template/footer-principal.php'; ?>

    <script>
    $(document).ready(function() {
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
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $(document).on("click", ".btnLeerMas", function(e) {
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
                left: offset.left + productoBox.outerWidth() / 2 - tooltip.outerWidth() / 2
            });

            tooltip.fadeIn(300);
        });

        // Cierra al hacer clic fuera
        $(document).on("click", function(e) {
            if (!$(e.target).closest("#tooltip_global, .btnLeerMas").length) {
                $('#tooltip_global').fadeOut(200);
                $('.multiple-items').slick('slickPlay');
            }
        });
    });
    </script>