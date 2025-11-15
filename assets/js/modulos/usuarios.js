const nuevo = document.querySelector("#nuevo_registro");
const frm = document.querySelector("#frmRegistro");
const titleModal = document.querySelector("#titleModal");
const btnAccion = document.querySelector("#btnAccion");
const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));
const selectRol = document.querySelector("#rol");
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
        document.querySelector('#clave').removeAttribute('readonly');
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
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                if (res.icono == "success") {
                    myModal.hide();
                    tblUsuario.ajax.reload();
                }
                Swal.fire("Aviso?", res.msg.toUpperCase(), res.icono);
            }
        }
    });
});

function eliminarUser(idUser) {
    // Verificar si el id es 1 antes de mostrar el cuadro de confirmación
    if (idUser === 1) {
        Swal.fire("Aviso", "No se puede eliminar el administrador principal", "warning");
        return;
    }

    Swal.fire({
        title: "Aviso?",
        text: "¿Está seguro de eliminar el registro?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "usuarios/delete/" + idUser;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        tblUsuario.ajax.reload();
                    }
                    Swal.fire("Aviso", res.msg.toUpperCase(), res.icono);
                }
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
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            if (res.icono) {
                Swal.fire("Aviso", res.msg.toUpperCase(), res.icono);
                return;
            }
            document.querySelector('#id').value = res.id;
            document.querySelector('#nombre').value = res.nombres;
            document.querySelector('#apellido').value = res.apellidos;
            document.querySelector('#correo').value = res.correo;
            selectRol.value = res.rol;
            document.querySelector('#clave').setAttribute('readonly', 'readonly');
            btnAccion.textContent = 'Actualizar';
            titleModal.textContent = "MODIFICAR USUARIO";
            myModal.show();
            //$('#nuevoModal').modal('show');
        }
    }
}