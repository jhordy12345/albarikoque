<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo BASE_URL; ?>assets/admin/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/admin/img/favicon.png">
    <title><?php echo $data['title']; ?></title>
    <link rel="icon" href="assets/images/logo_abarikoque.png">
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="<?php echo BASE_URL; ?>assets/admin/css/nucleo-icons.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>assets/admin/css/nucleo-svg.css" rel="stylesheet" />
    <link id="pagestyle" href="<?php echo BASE_URL; ?>assets/admin/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
    <style>
    .login-hero {
        background-image: linear-gradient(120deg, rgba(13, 71, 161, 0.65), rgba(0, 184, 212, 0.55)), url('<?php echo BASE_URL; ?>assets/images/fondo_admin.jpg');
        background-size: cover;
        background-position: center;
        position: relative;
        overflow: hidden;
    }

    .login-card {
        backdrop-filter: blur(12px);
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.6);
    }

    .login-header {
        background: linear-gradient(120deg, #0d47a1, #00acc1);
    }

    .brand-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
    }

    .brand-chip img {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.85);
    }

    .input-group.input-group-outline.is-focused .form-label,
    .input-group.input-group-outline.is-filled .form-label {
        color: #0d47a1;
    }

    .btn-primary-cta {
        background: linear-gradient(120deg, #0d47a1, #00acc1);
        box-shadow: 0 10px 20px rgba(13, 71, 161, 0.25);
    }

    .btn-primary-cta:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }
    </style>
</head>

<body class="bg-gray-200">
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100 login-hero">
            <span class="mask bg-gradient-dark opacity-4"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom login-card">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 login-header">
                                <div class="shadow-primary border-radius-lg py-3 pe-1">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="brand-chip">
                                            <img src="<?php echo BASE_URL; ?>assets/images/logo_abarikoque.png" alt="Logo Albarikoque">
                                            <div class="text-start">
                                                <span class="text-white text-sm">Panel de Administración</span>
                                                <h4 class="text-white font-weight-bolder mb-0">Restablecer contraseña</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form role="form" class="text-start" id="formReset" autocomplete="off">
                                    <input type="hidden" name="tokenReset" id="tokenReset" value="<?php echo $data['token']; ?>">
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Nueva contraseña</label>
                                        <input type="password" id="nueva_clave" name="nueva_clave" class="form-control">
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Confirmar contraseña</label>
                                        <input type="password" id="confirmar_clave" name="confirmar_clave" class="form-control">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-2 mb-3">
                                        <span class="text-sm text-secondary">Tu contraseña debe tener al menos 8 caracteres</span>
                                        <a class="text-primary text-sm" href="<?php echo BASE_URL; ?>admin">Volver al inicio</a>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn text-white btn-primary-cta w-100 my-3">Guardar nueva contraseña</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer position-absolute bottom-2 py-2 w-100">
                <div class="container">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-12 col-md-6 my-auto">
                            <div class="copyright text-center text-sm text-white text-lg-start">
                                ©OPYRIGHT ALBARIKOQUE <script>
                                document.write(new Date().getFullYear())
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>
    <script src="<?php echo BASE_URL; ?>assets/admin/js/core/popper.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/js/core/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/admin/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
    const base_url = '<?php echo BASE_URL; ?>';
    </script>
    <script src="<?php echo BASE_URL; ?>assets/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/modulos/restablecer.js"></script>
</body>

</html>
