<!-- copyright section start -->
<div class="copyright_section">
  <div class="container">
    <p class="copyright_text">© COPYRIGHT ALBARIKOQUE <?php echo date('Y'); ?>. Todos los derechos reservados.</p>
  </div>
</div>
<!-- copyright section end -->

<!-- Modal Carrito -->
<div class="modal fade" id="modalCarrito" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Mi carrito</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover align-middle" id="tableListaCarrito">
            <thead>
              <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>SubTotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div class="d-flex justify-content-around mb-3">
        <h3 id="totalGeneral"></h3>
        <?php if (!empty($_SESSION['correoCliente'])) { ?>
          <a class="btn btn-outline-primary" href="<?php echo BASE_URL . 'clientes'; ?>">Procesar Pedido</a>
        <?php } else { ?>
          <a class="btn btn-outline-primary" href="#" onclick="abrirModalLogin();">Acceder</a>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<!-- Modal Login / Registro -->
<div id="modalLogin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Iniciar Sesión o Registrarse</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body m-3">
        <div class="text-center mb-3">
          <img class="img-thumbnail rounded-circle" src="<?php echo BASE_URL . 'assets/img/logo.png'; ?>" alt="Logo" width="100">
        </div>

        <div class="row">
          <!-- Login -->
          <div class="col-md-12" id="frmLogin">
            <div class="form-group mb-3">
              <label for="correoLogin"><i class="fas fa-envelope"></i> Correo</label>
              <input id="correoLogin" class="form-control" type="text" name="correoLogin" placeholder="Correo electrónico">
            </div>
            <div class="form-group mb-3">
              <label for="claveLogin"><i class="fas fa-key"></i> Contraseña</label>
              <input id="claveLogin" class="form-control" type="password" name="claveLogin" placeholder="Contraseña">
            </div>
            <a href="#" id="btnRegister">¿Todavía no tienes una cuenta?</a>
            <div class="float-right">
              <button class="btn btn-primary" type="button" id="login">Acceder</button>
            </div>
          </div>

          <!-- Registro -->
          <div class="col-md-12 d-none" id="frmRegister">
            <div class="form-group mb-3">
              <label for="nombreRegistro"><i class="fas fa-user"></i> Nombre</label>
              <input id="nombreRegistro" class="form-control" type="text" name="nombreRegistro" placeholder="Nombre completo">
            </div>
            <div class="form-group mb-3">
              <label for="correoRegistro"><i class="fas fa-envelope"></i> Correo</label>
              <input id="correoRegistro" class="form-control" type="text" name="correoRegistro" placeholder="Correo electrónico">
            </div>
            <div class="form-group mb-3">
              <label for="claveRegistro"><i class="fas fa-key"></i> Contraseña</label>
              <input id="claveRegistro" class="form-control" type="password" name="claveRegistro" placeholder="Contraseña">
            </div>
            <a href="#" id="btnLogin">¿Ya tienes una cuenta?</a>
            <div class="float-right">
              <button class="btn btn-primary" type="button" id="registrarse">Registrarse</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- ==============================
     JAVASCRIPT
============================== -->
<script src="<?php echo BASE_URL; ?>assets/principal/js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
<script src="<?php echo BASE_URL; ?>assets/principal/js/plugin.js"></script>
<script src="<?php echo BASE_URL; ?>assets/principal/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/principal/slick/slick.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/principal/js/custom.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/all.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
const base_url = '<?php echo BASE_URL; ?>';

// ==============================
// FUNCIONES DE MENÚ LATERAL
// ==============================
function openNav() {
  const sidenav = document.getElementById("mySidenav");
  if (sidenav) sidenav.style.width = "250px";
}

function closeNav() {
  const sidenav = document.getElementById("mySidenav");
  if (sidenav) sidenav.style.width = "0";
}

// ==============================
// MOSTRAR CATEGORÍAS (desde menú principal)
// ==============================
function mostrarCategorias(e) {
  e.preventDefault();

  // Si ya estamos en index
  if (window.location.pathname.endsWith('index.php') || window.location.pathname === '/' || window.location.href === base_url) {
    openNav();
    window.scrollTo({ top: 0, behavior: "smooth" });
  } else {
    // Si no estás en index, redirige y abre después
    window.location.href = base_url + "index.php#mostrarCategorias";
  }
}

// Abrir menú si vienes desde otra página
document.addEventListener("DOMContentLoaded", function () {
  const hash = window.location.hash;
  if (hash === "#mostrarCategorias") {
    setTimeout(() => {
      openNav();
      window.scrollTo({ top: 0, behavior: "smooth" });
    }, 300);
  }

  // Si hay una categoría guardada, mostrarla
  const categoriaGuardada = localStorage.getItem('categoriaSeleccionada');
  if (categoriaGuardada) {
    openNav();
    setTimeout(() => {
      const categoria = document.querySelector(`#categoria_${categoriaGuardada}`);
      if (categoria) categoria.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 500);
    localStorage.removeItem('categoriaSeleccionada');
  }
});

// ==============================
// NAVEGAR A CATEGORÍA POR ID
// ==============================
function irACategoria(idCategoria) {
  localStorage.setItem('categoriaSeleccionada', idCategoria);

  if (!window.location.pathname.endsWith('index.php') && !window.location.pathname.endsWith('/')) {
    window.location.href = base_url;
  } else {
    openNav();
    setTimeout(() => {
      const categoria = document.querySelector(`#categoria_${idCategoria}`);
      if (categoria) categoria.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 500);
  }
}
</script>

<script src="<?php echo BASE_URL; ?>assets/js/carrito.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/login.js"></script>
