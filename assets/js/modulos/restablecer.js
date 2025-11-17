const resetForm = document.querySelector('#formReset');
const nuevaClave = document.querySelector('#nueva_clave');
const confirmarClave = document.querySelector('#confirmar_clave');

if (resetForm) {
    resetForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if (nuevaClave.value === '' || confirmarClave.value === '') {
            alertas('todo los campos son requeridos', 'warning');
            return;
        }
        if (nuevaClave.value !== confirmarClave.value) {
            alertas('las contraseñas no coinciden', 'warning');
            return;
        }
        if (nuevaClave.value.length < 8) {
            alertas('la contraseña debe tener al menos 8 caracteres', 'warning');
            return;
        }

        let data = new FormData(this);
        const url = base_url + 'admin/actualizarPassword';
        const http = new XMLHttpRequest();
        http.open('POST', url, true);
        http.send(data);
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);
                if (res.icono === 'success') {
                    setTimeout(() => {
                        window.location = base_url + 'admin';
                    }, 2000);
                }
            }
        }
    });
}

function alertas(msg, icono) {
    Swal.fire('Aviso?', msg.toUpperCase(), icono);
}
