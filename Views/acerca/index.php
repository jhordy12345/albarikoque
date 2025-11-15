<?php include_once 'Views/template/header-principal.php'; ?>

<body>
    <main id="acerca_de" class="about-page">
        <section class="about-hero text-white d-flex align-items-center">
            <div class="container py-5">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <h1 class="display-4 font-weight-bold mb-3">Sobre Albarikoque</h1>
                        <p class="lead mb-4">Somos un equipo apasionado por ofrecer experiencias gastronómicas memorables,
                            combinando sabores tradicionales con un servicio cálido y cercano.</p>
                        <div class="d-flex flex-wrap align-items-center">
                            <a href="<?php echo BASE_URL; ?>" class="btn btn-light btn-lg mr-3 mb-2">
                                <i class="fa-solid fa-house mr-2"></i>Volver al inicio
                            </a>
                            <a href="<?php echo BASE_URL; ?>contactos" class="btn btn-outline-light btn-lg mb-2">
                                <i class="fa-solid fa-envelope mr-2"></i>Contáctanos
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5 text-center">
                        <img src="<?php echo BASE_URL; ?>assets/images/logo_abarikoque.png" alt="Logo Albarikoque"
                            class="img-fluid about-hero__image">
                    </div>
                </div>
            </div>
        </section>

        <section class="about-values py-5">
            <div class="container">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-8">
                        <h2 class="h1 font-weight-bold">Nuestra esencia</h2>
                        <p class="text-muted">Cada plato cuenta una historia. Seleccionamos ingredientes frescos de la
                            región, respetamos las recetas familiares y sumamos el toque creativo que nos caracteriza.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body p-4 text-center">
                                <span class="icon-circle mb-3"><i class="fa-solid fa-fire"></i></span>
                                <h3 class="h5">Pasión por el sabor</h3>
                                <p class="text-muted mb-0">Desde nuestras pizzas artesanales hasta los pollos a la brasa,
                                    trabajamos con dedicación para lograr un sabor inigualable.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body p-4 text-center">
                                <span class="icon-circle mb-3"><i class="fa-solid fa-heart"></i></span>
                                <h3 class="h5">Experiencias memorables</h3>
                                <p class="text-muted mb-0">Creamos momentos especiales para familias y amigos con un ambiente
                                    acogedor y un servicio amable.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body p-4 text-center">
                                <span class="icon-circle mb-3"><i class="fa-solid fa-leaf"></i></span>
                                <h3 class="h5">Compromiso con la calidad</h3>
                                <p class="text-muted mb-0">Elegimos insumos frescos y procesos cuidadosos para garantizar la
                                    calidad en cada preparación.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-story py-5 bg-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h2 class="h1 font-weight-bold mb-3">Nuestra historia</h2>
                        <p class="text-muted">Nacimos en Huanta con el sueño de compartir la auténtica sazón peruana. Lo
                            que comenzó como una pizzería familiar se transformó en un espacio donde conviven pizzas,
                            pastas, pollos a la brasa y postres caseros.</p>
                        <p class="text-muted mb-4">Hoy seguimos creciendo gracias a la confianza de nuestros clientes y al
                            esfuerzo de un equipo que ama lo que hace. Innovamos constantemente para sorprenderte con
                            nuevos sabores sin dejar de lado nuestras raíces.</p>
                        <div class="row text-center text-lg-left">
                            <div class="col-6">
                                <div class="about-counter">
                                    <span class="counter-value">10+</span>
                                    <p class="text-muted mb-0">Años de experiencia</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="about-counter">
                                    <span class="counter-value">5k+</span>
                                    <p class="text-muted mb-0">Clientes satisfechos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 overflow-hidden">
                            <img src="<?php echo BASE_URL; ?>assets/images/fondo_admin.jpg" class="card-img-top"
                                alt="Equipo de Albarikoque">
                            <div class="card-body">
                                <p class="mb-0 text-muted">Nuestro equipo se capacita constantemente para llevar a tu mesa una
                                    experiencia deliciosa y segura.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-team py-5">
            <div class="container">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-8">
                        <h2 class="h1 font-weight-bold">Conoce al equipo</h2>
                        <p class="text-muted">Personas comprometidas con brindarte un servicio amable y oportuno en cada
                            pedido.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="team-card text-center h-100">
                            <div class="team-card__avatar">MR</div>
                            <div class="team-card__body">
                                <h3 class="h5 mb-1">María Rodríguez</h3>
                                <p class="text-primary mb-2">Chef Ejecutiva</p>
                                <p class="text-muted mb-0">Lidera la creación de nuevas recetas y asegura el sabor único que
                                    nos distingue.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="team-card text-center h-100">
                            <div class="team-card__avatar">JF</div>
                            <div class="team-card__body">
                                <h3 class="h5 mb-1">Jorge Fernández</h3>
                                <p class="text-primary mb-2">Coordinador de Atención</p>
                                <p class="text-muted mb-0">Cuida cada detalle del servicio para que tus pedidos lleguen puntuales
                                    y en perfectas condiciones.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="team-card text-center h-100">
                            <div class="team-card__avatar">LG</div>
                            <div class="team-card__body">
                                <h3 class="h5 mb-1">Laura Gutiérrez</h3>
                                <p class="text-primary mb-2">Gestión y Calidad</p>
                                <p class="text-muted mb-0">Asegura que nuestros procesos sean eficientes para brindarte la mejor
                                    experiencia en cada compra.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-cta py-5 bg-primary text-white">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2 class="h1 font-weight-bold mb-3">¿Listo para disfrutar de Albarikoque?</h2>
                        <p class="lead mb-0">Haz tu pedido en línea, visítanos o contáctanos para reservas especiales. Siempre
                            será un placer atenderte.</p>
                    </div>
                    <div class="col-lg-4 text-lg-right text-center">
                        <a href="<?php echo BASE_URL; ?>clientes" class="btn btn-light btn-lg mb-2">
                            <i class="fa-solid fa-pizza-slice mr-2"></i>Haz tu pedido
                        </a>
                        <br class="d-lg-none">
                        <a href="tel:+51904902527" class="btn btn-outline-light btn-lg">
                            <i class="fa-solid fa-phone mr-2"></i>Llámanos ahora
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once 'Views/template/footer-principal.php'; ?>

    <style>
    .about-hero {
        background: linear-gradient(135deg, rgba(18, 107, 243, 0.85), rgba(255, 94, 98, 0.85)),
            url('<?php echo BASE_URL; ?>assets/images/fondo_admin.jpg') center/cover no-repeat;
        min-height: 320px;
    }

    .about-hero__image {
        max-height: 260px;
    }

    .about-values .icon-circle {
        width: 64px;
        height: 64px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: rgba(18, 107, 243, 0.1);
        color: #126BF3;
        font-size: 1.5rem;
    }

    .about-counter {
        background-color: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(18, 107, 243, 0.08);
        margin-bottom: 1rem;
    }

    .about-counter .counter-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #126BF3;
        display: block;
    }

    .team-card {
        background-color: #fff;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(18, 107, 243, 0.12);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .team-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(18, 107, 243, 0.18);
    }

    .team-card__avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 160px;
        font-size: 2.5rem;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #126BF3, #ff5e62);
    }

    .team-card__body {
        padding: 24px;
    }

    @media (max-width: 991.98px) {
        .about-hero {
            text-align: center;
        }

        .about-cta .btn {
            width: 100%;
        }
    }
    </style>
</body>
