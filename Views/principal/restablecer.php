<?php include_once 'Views/template/header-principal.php'; ?>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <?php if (!empty($data['cliente'])) { ?>
                        <h4 class="mb-4 text-center">Restablecer contraseña</h4>
                        <p class="text-muted text-center mb-4">Agrega tu nueva contraseña y confirma la contraseña para continuar.</p>
                        <form id="formRestablecer">
                            <input type="hidden" name="token" id="tokenRestablecer"
                                value="<?php echo $data['token']; ?>">
                            <div class="form-group mb-3">
                                <label for="nuevaClave"><i class="fas fa-key"></i> Nueva contraseña</label>
                                <input type="password" class="form-control" id="nuevaClave" name="clave"
                                    placeholder="Ingresa tu nueva contraseña">
                            </div>
                            <div class="form-group mb-4">
                                <label for="confirmarClave"><i class="fas fa-key"></i> Confirmar contraseña</label>
                                <input type="password" class="form-control" id="confirmarClave" name="confirmar"
                                    placeholder="Confirma tu nueva contraseña">
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?php echo BASE_URL; ?>" class="btn btn-link">Volver al inicio</a>
                                <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                            </div>
                        </form>
                        <?php } else { ?>
                        <div class="alert alert-danger text-center mb-0" role="alert">
                            <h4 class="alert-heading">Token no válido</h4>
                            <p class="mb-2">El enlace para restablecer la contraseña no es válido o ha caducado.</p>
                            <a href="<?php echo BASE_URL; ?>" class="btn btn-outline-primary">Ir al inicio</a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'Views/template/footer-principal.php'; ?>

    <?php if (!empty($data['cliente'])) { ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const formReset = document.querySelector('#formRestablecer');
        const nuevaClave = document.querySelector('#nuevaClave');
        const confirmarClave = document.querySelector('#confirmarClave');
        const token = document.querySelector('#tokenRestablecer');

        if (formReset) {
            formReset.addEventListener('submit', function(e) {
                e.preventDefault();
                if (nuevaClave.value === '' || confirmarClave.value === '') {
                    Swal.fire('Aviso?', 'TODO LOS CAMPOS SON REQUERIDOS', 'warning');
                } else if (nuevaClave.value !== confirmarClave.value) {
                    Swal.fire('Aviso?', 'LAS CONTRASEÑAS NO COINCIDEN', 'warning');
                } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(nuevaClave.value)) {
                    Swal.fire('Aviso?', 'LA CONTRASEÑA DEBE TENER AL MENOS 8 CARACTERES, UNA MAYÚSCULA, UNA MINÚSCULA Y UN NÚMERO', 'warning');
                } else {
                    let formData = new FormData();
                    formData.append('token', token.value);
                    formData.append('clave', nuevaClave.value);
                    formData.append('confirmar', confirmarClave.value);
                    const url = base_url + 'clientes/actualizarClave';
                    const http = new XMLHttpRequest();
                    http.open('POST', url, true);
                    http.send(formData);
                    http.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            const res = JSON.parse(this.responseText);
                            Swal.fire('Aviso?', res.msg, res.icono);
                            if (res.icono == 'success') {
                                setTimeout(() => {
                                    window.location.href = base_url;
                                }, 2000);
                            }
                        }
                    };
                }
            });
        }
    });
    </script>
    <?php } ?>
