<?php include_once 'Views/template/header-principal.php'; ?>

<body>
    <main class="contact-page">
        <section class="contact-hero text-white d-flex align-items-center">
            <div class="container py-5">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-7">
                        <h1 class="display-4 font-weight-bold mb-3">Ponte en contacto con nosotros</h1>
                        <p class="lead mb-4">Estamos listos para ayudarte con tus pedidos, reservas y cualquier consulta que
                            tengas sobre la experiencia Albarikoque.</p>
                        <div class="d-flex flex-wrap align-items-center">
                            <a href="tel:+51904902527" class="btn btn-light btn-lg mr-3 mb-2"><i
                                    class="fa-solid fa-phone mr-2"></i> Llámanos</a>
                            <a href="https://wa.me/51904902527" target="_blank"
                                class="btn btn-outline-light btn-lg mb-2"><i class="fa-brands fa-whatsapp mr-2"></i>
                                Escríbenos por WhatsApp</a>
                        </div>
                    </div>
                    <div class="col-lg-5 d-none d-lg-block text-right">
                        <img src="<?php echo BASE_URL; ?>assets/images/logo_abarikoque.png" alt="Ilustración de contacto"
                            class="img-fluid contact-hero__image">
                    </div>
                </div>
            </div>
        </section>

        <section class="contact-content py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body p-4">
                                <h2 class="h4 mb-3">Nuestros datos</h2>
                                <p class="text-muted">Visítanos o contáctanos a través de cualquiera de los siguientes medios.
                                </p>
                                <div class="media mb-3">
                                    <span class="media-icon mr-3"><i class="fa-solid fa-location-dot"></i></span>
                                    <div class="media-body">
                                        <h3 class="h6 mb-1">Dirección</h3>
                                        <p class="mb-0">Av. Andrés Avelino Cáceres 439<br>Huanta, Ayacucho - Perú</p>
                                    </div>
                                </div>
                                <div class="media mb-3">
                                    <span class="media-icon mr-3"><i class="fa-solid fa-clock"></i></span>
                                    <div class="media-body">
                                        <h3 class="h6 mb-1">Horario de atención</h3>
                                        <p class="mb-0">Lunes a Domingo<br>12:00 p.m. a 11:00 p.m.</p>
                                    </div>
                                </div>
                                <div class="media mb-3">
                                    <span class="media-icon mr-3"><i class="fa-solid fa-phone"></i></span>
                                    <div class="media-body">
                                        <h3 class="h6 mb-1">Teléfono</h3>
                                        <p class="mb-0"><a href="tel:+51904902527">+51 904 902 527</a></p>
                                    </div>
                                </div>
                                <div class="media">
                                    <span class="media-icon mr-3"><i class="fa-solid fa-envelope"></i></span>
                                    <div class="media-body">
                                        <h3 class="h6 mb-1">Correo electrónico</h3>
                                        <p class="mb-0"><a href="mailto:albariokque@gmail.com">albariokque@gmail.com</a></p>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <h3 class="h6 text-uppercase text-muted">Síguenos</h3>
                                <div class="d-flex align-items-center">
                                    <a href="https://www.facebook.com/albarikoqueperu" class="btn btn-outline-secondary btn-sm mr-2"
                                        target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="https://www.instagram.com/albarikoque.oficial" class="btn btn-outline-secondary btn-sm mr-2"
                                        target="_blank"><i class="fa-brands fa-instagram"></i></a>
                                    <a href="#" class="btn btn-outline-secondary btn-sm mr-2"><i class="fa-brands fa-tiktok"></i></a>
                                    <a href="#" class="btn btn-outline-secondary btn-sm"><i class="fa-brands fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h2 class="h4 mb-3">Escríbenos</h2>
                                <p class="text-muted">Completa el formulario y nuestro equipo se comunicará contigo en el menor
                                    tiempo posible.</p>
                                <form id="formContactos">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="nombre"><i class="fa-solid fa-user mr-1"></i> Nombre completo</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre"
                                                placeholder="Ingresa tu nombre" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email"><i class="fa-solid fa-envelope mr-1"></i> Correo electrónico</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="ejemplo@correo.com" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="telefono"><i class="fa-solid fa-mobile-screen-button mr-1"></i> Teléfono (opcional)</label>
                                        <input type="tel" class="form-control" id="telefono" name="telefono"
                                            placeholder="Número de contacto">
                                    </div>
                                    <div class="form-group">
                                        <label for="mensaje"><i class="fa-solid fa-comment-dots mr-1"></i> ¿Cómo podemos ayudarte?</label>
                                        <textarea class="form-control" id="mensaje" name="mensaje" rows="5"
                                            placeholder="Cuéntanos más sobre tu consulta" required></textarea>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                        <small class="text-muted">Al enviar aceptas nuestras políticas de privacidad.</small>
                                        <button type="submit" class="btn btn-primary mt-3 mt-md-0">
                                            <i class="fa-solid fa-paper-plane mr-2"></i>Enviar mensaje
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="contact-map pb-5">
            <div class="container">
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="card-body p-0">
                        <div class="embed-responsive embed-responsive-21by9">
                            <iframe class="embed-responsive-item"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3905.5354766187007!2d-74.23692132502906!3d-12.939382787367406!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x910d6f1b750e5a25%3A0x3b5d8064dc704c2c!2sAv.%20Andr%C3%A9s%20Avelino%20C%C3%A1ceres%20439%2C%20Huanta%2005101!5e0!3m2!1ses-419!2spe!4v1700000000000!5m2!1ses-419!2spe"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once 'Views/template/footer-principal.php'; ?>

    <style>
    .contact-hero {
        background: linear-gradient(135deg, rgba(18, 107, 243, 0.85), rgba(255, 94, 98, 0.85)),
            url('<?php echo BASE_URL; ?>assets/images/fondo_admin.jpg') center/cover no-repeat;
        min-height: 320px;
    }

    .contact-hero__image {
        max-height: 260px;
    }

    .contact-page .media-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: rgba(18, 107, 243, 0.1);
        color: #126BF3;
        font-size: 1.25rem;
    }

    .contact-page .btn-outline-secondary {
        border-color: #dfe3ea;
        color: #4a4f58;
    }

    .contact-page .btn-outline-secondary:hover {
        background-color: #126BF3;
        border-color: #126BF3;
        color: #fff;
    }

    @media (max-width: 991.98px) {
        .contact-hero {
            text-align: center;
        }
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const formContactos = document.getElementById('formContactos');
        if (!formContactos) {
            return;
        }

        formContactos.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(formContactos);

            fetch(`${base_url}contactos/enviar`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.icono) {
                        alertaPerzanalizada(data.msg, data.icono, 'Contáctanos');
                        if (data.icono === 'success') {
                            formContactos.reset();
                        }
                    } else {
                        alertaPerzanalizada('Hubo un problema al procesar tu solicitud.', 'error', 'Contáctanos');
                    }
                })
                .catch(() => {
                    alertaPerzanalizada('No pudimos enviar tu mensaje. Inténtalo nuevamente.', 'error', 'Contáctanos');
                });
        });
    });
    </script>
</body>

</html>
