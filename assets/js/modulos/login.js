const frm = document.querySelector("#formulario");
const email = document.querySelector("#email");
const clave = document.querySelector("#clave");
const toggleRecuperar = document.querySelector('#toggle-recuperar');
const panelRecuperar = document.querySelector('#recuperar-panel');
const formularioRecuperar = document.querySelector('#formRecuperar');
const correoRecuperar = document.querySelector('#correoRecuperar');

document.addEventListener("DOMContentLoaded", function() {
    if (frm) {
        frm.addEventListener("submit", function(e) {
            e.preventDefault();
            if (email.value == "" || clave.value == "") {
                alertas("todo los campos son requeridos", "warning");
            } else {
                let data = new FormData(this);
                const url = base_url + "admin/validar";
                const http = new XMLHttpRequest();
                http.open("POST", url, true);
                http.send(data);
                http.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        const res = JSON.parse(this.responseText);
                        if (res.icono == 'success') {
                            setTimeout(() => {
                                window.location = base_url + 'admin/home';
                            }, 2000);
                        }
                        alertas(res.msg, res.icono);
                    }
                }
            }
        });
    }

    if (toggleRecuperar && panelRecuperar) {
        toggleRecuperar.addEventListener('click', function(e) {
            e.preventDefault();

            const isHidden = panelRecuperar.classList.toggle('d-none');
            const showingRecuperar = !isHidden;

            if (frm) {
                frm.classList.toggle('d-none');
            }

            toggleRecuperar.textContent = showingRecuperar
                ? 'Volver al inicio de sesión'
                : '¿Olvidaste tu contraseña?';

            if (showingRecuperar && correoRecuperar) {
                correoRecuperar.focus();
            }
        });
    }

    if (formularioRecuperar) {
        formularioRecuperar.addEventListener('submit', function(e) {
            e.preventDefault();
            if (correoRecuperar.value == "") {
                alertas("el correo es requerido", "warning");
                return;
            }
            let data = new FormData(this);
            const url = base_url + "admin/recuperar";
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Enviando verificación',
                    text: 'Por favor espera mientras procesamos tu solicitud',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
            http.send(data);
            http.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (typeof Swal !== 'undefined') {
                        Swal.close();
                    }
                    try {
                        const res = JSON.parse(this.responseText);
                        alertas(res.msg, res.icono);
                    } catch (error) {
                        alertas("no pudimos procesar la respuesta", "error");
                        console.error("Error al procesar la respuesta de recuperación", error, this.responseText);
                    }
                } else if (this.readyState == 4) {
                    if (typeof Swal !== 'undefined') {
                        Swal.close();
                    }
                    alertas("no se pudo enviar la solicitud", "error");
                }
            }
        });
    }
});

function alertas(msg, icono) {
    if (typeof Swal !== 'undefined') {
        Swal.fire("Aviso?", msg.toUpperCase(), icono);
    } else {
        alert(msg);
    }
}