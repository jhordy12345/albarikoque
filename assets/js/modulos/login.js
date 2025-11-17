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
            panelRecuperar.classList.toggle('d-none');
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
            http.send(data);
            http.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                }
            }
        });
    }
});

function alertas(msg, icono) {
    Swal.fire("Aviso?", msg.toUpperCase(), icono);
}