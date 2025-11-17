const frm = document.querySelector("#formulario");
const email = document.querySelector("#email");
const clave = document.querySelector("#clave");
const formRecuperar = document.querySelector("#formRecuperar");
const correoRecuperar = document.querySelector("#correoRecuperar");
const btnRecuperar = document.querySelector("#btnEnviarRecuperacion");
const modalRecuperacion = document.querySelector('#modalRecuperacion');
const modalInstance = modalRecuperacion ? bootstrap.Modal.getOrCreateInstance(modalRecuperacion) : null;
document.addEventListener("DOMContentLoaded", function() {
    const triggerRecuperacion = document.querySelector('[data-bs-target="#modalRecuperacion"]');

    if (triggerRecuperacion && modalRecuperacion) {
        triggerRecuperacion.addEventListener('click', function(e) {
            e.preventDefault();
            modalInstance.show();
        });
    }

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
                    console.log(this.responseText);
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

    if (btnRecuperar && formRecuperar) {
        btnRecuperar.addEventListener("click", function() {
            const correo = correoRecuperar.value.trim();
            if (correo === "") {
                alertas("el correo es obligatorio", "warning");
                return;
            }
            const data = new FormData(formRecuperar);
            const url = base_url + "admin/recuperar";
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(data);
            http.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono === 'success') {
                        formRecuperar.reset();
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }
                    alertas(res.msg, res.icono);
                }
            }
        });
    }
});

function alertas(msg, icono) {
    Swal.fire("Aviso?", msg.toUpperCase(), icono);
}