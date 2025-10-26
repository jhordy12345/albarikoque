<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->

    <title>ALBARIKOQUE</title>
    <link rel="icon" href="assets/images/logo_abarikoque.png">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="imgenes/"> <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/principal/css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/principal/css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/principal/css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/principal/images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/principal/css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--  -->
    <!-- owl stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext"
        rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/principal/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/principal/css/owl.theme.default.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/principal/slick/slick.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/principal/slick/slick-theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo MONEDA; ?>">
    </script>
    <style>
    .table>tbody>tr>td {
        vertical-align: middle;
    }
    </style>
</head>

<body>
    <!-- banner bg main start -->
    <div class="banner_bg_main">
        <!-- header top section start -->
        <div class="container">
            <div class="header_section_top">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="custom_menu">
                            <ul>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>">
                                        <img src="<?php echo BASE_URL; ?>assets/images/baner_albarikoque.png"
                                            alt="ALBARIKOQUE" style="height: 50px;">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- header top section start -->
        <!-- logo section start -->
        <div class="logo_section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="logo"><a href="<?php echo BASE_URL; ?>"></a></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- logo section end -->
        <!-- header section start -->
        <div class="header_section">
            <div class="container">
                <div class="containt_main">


                    <!-- Menú lateral izquierdo (sidenav) -->
                    <div id="mySidenav" class="sidenav">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <?php foreach ($data['categorias'] as $categoria) { ?>
                        <a href="#categoria_<?php echo $categoria['id']; ?>">
                            <i class="fa-solid fa-tag"></i> <?php echo $categoria['categoria']; ?>
                        </a>
                        <?php } ?>
                    </div>
<!-- Menú desplegable principal -->
<div class="dropdown" id="menuPrincipal">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa-solid fa-bars icono-menu"></i> <span class="texto-menu">Menú</span>
    </button>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

        <!-- Opción Inicio -->
        <a class="dropdown-item" href="<?php echo BASE_URL; ?>">
            <i class="fa-solid fa-house"></i> Inicio
        </a>

        <?php
        // Detectar si estamos en la página principal
        $url_actual = $_SERVER['REQUEST_URI'];
        // Normalizar quitando barras finales
        $url_actual = rtrim($url_actual, '/');

        // Obtener la ruta base del proyecto (por ejemplo: /tecnoSmart)
        $base_path = parse_url(BASE_URL, PHP_URL_PATH);
        $base_path = rtrim($base_path, '/');

        // Comprobar si estamos en la raíz del sitio (inicio)
        if ($url_actual == $base_path || $url_actual == $base_path . '/index' || $url_actual == $base_path . '/index.php') {
        ?>
            <!-- Estas opciones solo aparecen en la página principal -->
            <a class="dropdown-item" href="javascript:void(0)" onclick="openNav()">
                <i class="fa-solid fa-list"></i> Categorías
            </a>

            <a class="dropdown-item" href="#productos">
                <i class="fa-solid fa-laptop"></i> Productos
            </a>
        <?php
        }
        ?>

        <!-- Estas opciones se muestran siempre -->
        <a class="dropdown-item" href="#contactos">
            <i class="fa-solid fa-envelope"></i> Contactos
        </a>
        <a class="dropdown-item" href="#acerca_de">
            <i class="fa-solid fa-circle-info"></i> Acerca de
        </a>
    </div>
</div>



                    




                    <div class="main">
                        <!-- Another variation with a button -->
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="¿Que estas buscando?" id="search">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button"
                                    style="background-color: #126BF3; border-color:#126BF3 ">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="position-absolute row" id="resultBusqueda" style="z-index: 99999;"></div>
                    </div>
                    <div class="header_box">
                        <div class="login_menu">
                            <ul>
                                <li><a href="#" id="verCarrito">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        <span class="padding_10" id="btnCantidadCarrito">Cart</span></a>
                                </li>
                                <?php if (empty($_SESSION['nombreCliente'])) {
                           echo '<li><a href="#" data-toggle="modal" data-target="#modalLogin">
                                 <i class="fa fa-user" aria-hidden="true"></i>
                                 <span class="padding_10">Acceder</span></a>
                           </li>';
                        } else {
                           echo '<li><a href="' . BASE_URL . 'clientes">
                                 <i class="fa fa-user" aria-hidden="true"></i>
                                 <span class="padding_10 text-capitalize">' . $_SESSION['nombreCliente'] . '</span></a>
                           </li>';
                        }
                        ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header section end -->