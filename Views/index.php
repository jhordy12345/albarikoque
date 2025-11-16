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


        <section class="experience_section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="experience_intro">
                            <span class="pill pill-soft">Nuevo look</span>
                            <h2>Disfruta la experiencia Albarikoque</h2>
                            <p>Organizamos todo tu pedido en un vistazo: selecciona la categoría, guarda tus favoritos y
                                recibe notificaciones claras de cada paso.</p>
                            <div class="experience_meta">
                                <span class="meta_chip"><i class="fa-solid fa-clock"></i> Entregas promedio 30-45 min</span>
                                <span class="meta_chip"><i class="fa-solid fa-bell"></i> Alertas en tiempo real</span>
                                <span class="meta_chip"><i class="fa-solid fa-leaf"></i> Ingredientes frescos garantizados</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="highlight_grid">
                            <div class="highlight_card">
                                <div class="highlight_icon">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                                <div class="highlight_body">
                                    <div class="highlight_tag">Seguimiento inteligente</div>
                                    <h4>Entrega sin fricciones</h4>
                                    <p>Confirma tu dirección, elige método de pago y rastrea el recorrido del repartidor sin salir de la página.</p>
                                </div>
                            </div>
                            <div class="highlight_card">
                                <div class="highlight_icon">
                                    <i class="fa-solid fa-pizza-slice"></i>
                                </div>
                                <div class="highlight_body">
                                    <div class="highlight_tag">Menú curado</div>
                                    <h4>Secciones listas para ti</h4>
                                    <p>Explora pizzas, pastas, pollos y bebidas con recomendaciones rápidas para completar tu combo perfecto.</p>
                                </div>
                            </div>
                            <div class="highlight_card">
                                <div class="highlight_icon">
                                    <i class="fa-solid fa-headset"></i>
                                </div>
                                <div class="highlight_body">
                                    <div class="highlight_tag">Soporte inmediato</div>
                                    <h4>Ayuda a un clic</h4>
                                    <p>Accede a tu cuenta para resolver dudas, actualizar pedidos o chatear con nuestro equipo.</p>
                                </div>
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
                    <?php foreach ($categoria['productos'] as $producto) { ?>
                    <div class="<?php echo (count($categoria['productos']) > 2) ? 'col-lg-4' : 'col-lg-12'; ?>">
                        <div class="box_main">
                            <div class="product_meta">
                                <span class="pill pill-primary"><i class="fa-solid fa-tag"></i>
                                    <?php echo $categoria['categoria']; ?></span>
                                <span class="pill pill-soft">Disponible</span>
                            </div>
                            <h4 class="shirt_text"><?php echo $producto['nombre']; ?></h4>
                            <p class="price_text">Precio <span style="color: #262626;">S/
                                    <?php echo $producto['precio']; ?></span></p>
                            <div class="product_image_wrapper">
                                <img data-lazy="<?php echo BASE_URL . $producto['imagen']; ?>" class="product_image" />
                            </div>
                            <div class="btn_main">
                                <div class="buy_bt">
                                    <a href="#" class="btnAddcarrito" prod="<?php echo $producto['id']; ?>"><i
                                            class="fa-solid fa-cart-plus"></i> Añadir</a>
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