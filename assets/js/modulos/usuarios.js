const nuevo = document.querySelector("#nuevo_registro");
const frm = document.querySelector("#frmRegistro");
const titleModal = document.querySelector("#titleModal");
const btnAccion = document.querySelector("#btnAccion");
const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));
const selectRol = document.querySelector("#rol");
const grupoClave = document.querySelector("#grupoClave");
const inputClave = document.querySelector("#clave");
let tblUsuario;
document.addEventListener("DOMContentLoaded", function() {
    tblUsuario = $("#tblUsuarios").DataTable({
        ajax: {
            url: base_url + "usuarios/listar",
            dataSrc: "",
        },
        columns: [
            { data: "id" },
            { data: "nombres" },
            { data: "apellidos" },
            { data: "correo" },
            { data: "rol" },
            { data: "estado" },
            { data: "accion" },
        ],
        language,
        dom,
        buttons,
    });
    //levantar modal
    nuevo.addEventListener("click", function() {
        document.querySelector('#id').value = '';
        titleModal.textContent = "NUEVO USUARIO";
        btnAccion.textContent = 'Registrar';
        frm.reset();
        selectRol.value = "Administrador";
        grupoClave.classList.remove("d-none");
        inputClave.setAttribute("required", "required");
        inputClave.value = '';
        myModal.show();
    });
    //submit usuarios
    frm.addEventListener("submit", function(e) {
        e.preventDefault();
        let data = new FormData(this);
        const url = base_url + "usuarios/registrar";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(data);
        http.onreadystatechange = function() {
            procesarRespuesta(this, function(res) {
                if (res && res.icono == "success") {
                    myModal.hide();
                    tblUsuario.ajax.reload();
                }
                if (res && res.msg && res.icono) {
                    Swal.fire("Aviso?", res.msg.toUpperCase(), res.icono);
                }
            });
        }
    });
});

function eliminarUser(idUser, estadoUser) {
    // Verificar si el id es 1 antes de mostrar el cuadro de confirmación
    if (idUser === 1) {
        Swal.fire("Aviso", "No se puede dar de baja al administrador principal", "warning");
        return;
    }
    const estado = Number(estadoUser);
    const mensaje = estado === 1 ? "dar de baja" : "reactivar";
    Swal.fire({
        title: "Aviso?",
        text: `¿Está seguro de ${mensaje} el registro?`,
        icon: estado === 1 ? "warning" : "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, continuar",
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "usuarios/delete/" + idUser;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                procesarRespuesta(this, function(res) {
                    if (res && res.icono == "success") {
                        tblUsuario.ajax.reload();
                    }
                    if (res && res.msg && res.icono) {
                        Swal.fire("Aviso", res.msg.toUpperCase(), res.icono);
                    }
                });
            };
        }
    });
}

function editUser(idUser) {
    if (idUser === 1) {
        Swal.fire("Aviso", "No se puede editar el administrador principal", "warning");
        return;
    }
    const url = base_url + "usuarios/edit/" + idUser;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function() {
        procesarRespuesta(this, function(res) {
            if (!res) {
                Swal.fire("Aviso", "No se pudo obtener la información del usuario", "error");
                return;
            }
            if (res.icono) {
                Swal.fire("Aviso", res.msg.toUpperCase(), res.icono);
                return;
            }
            document.querySelector('#id').value = res.id;
            document.querySelector('#nombre').value = res.nombres;
            document.querySelector('#apellido').value = res.apellidos;
            document.querySelector('#correo').value = res.correo;
            selectRol.value = res.rol;
            grupoClave.classList.add("d-none");
            inputClave.removeAttribute("required");
            inputClave.value = '';
            btnAccion.textContent = 'Actualizar';
            titleModal.textContent = "MODIFICAR USUARIO";
            myModal.show();
        });
    }
}

function procesarRespuesta(http, callback) {
    if (http.readyState !== 4) {
        return;
    }
    if (http.status !== 200) {
        Swal.fire("Aviso", "No se pudo completar la solicitud", "error");
        return;
    }
    try {
        const res = JSON.parse(http.responseText);
        callback(res);
    } catch (error) {
        console.error('Error al procesar la respuesta del servidor', error, http.responseText);
        Swal.fire("Aviso", "Respuesta inválida del servidor", "error");
    }
}