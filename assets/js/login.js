const btnRegister = document.querySelector("#btnRegister");
const btnLogin = document.querySelector("#btnLogin");
const btnForgot = document.querySelector("#btnForgot");
const btnBackForgot = document.querySelector("#btnBackForgot");
const frmLogin = document.querySelector("#frmLogin");
const frmRegister = document.querySelector("#frmRegister");
const frmForgot = document.querySelector("#frmForgot");
const registrarse = document.querySelector("#registrarse");
const login = document.querySelector("#login");
const recuperar = document.querySelector("#recuperar");
const formCambioClave = document.querySelector("#formCambioClave");
const codigoRecuperacion = document.querySelector("#codigoRecuperacion");
const nuevaClaveModal = document.querySelector("#nuevaClaveModal");
const confirmarClaveModal = document.querySelector("#confirmarClaveModal");

const nombreRegistro = document.querySelector("#nombreRegistro");
const claveRegistro = document.querySelector("#claveRegistro");
const correoRegistro = document.querySelector("#correoRegistro");
const direccionRegistro = document.querySelector("#direccionRegistro");

const correoLogin = document.querySelector("#correoLogin");
const claveLogin = document.querySelector("#claveLogin");
const correoRecuperar = document.querySelector("#correoRecuperar");


document.addEventListener("DOMContentLoaded", function () {
  if (btnRegister) {
    btnRegister.addEventListener("click", function () {
      frmLogin.classList.add("d-none");
      frmForgot.classList.add("d-none");
      frmRegister.classList.remove("d-none");
    });
  }

  if (btnLogin) {
    btnLogin.addEventListener("click", function () {
      frmRegister.classList.add("d-none");
      frmForgot.classList.add("d-none");
      frmLogin.classList.remove("d-none");
    });
  }

  if (btnForgot) {
    btnForgot.addEventListener("click", function () {
      frmLogin.classList.add("d-none");
      frmRegister.classList.add("d-none");
      frmForgot.classList.remove("d-none");
    });
  }

  if (btnBackForgot) {
    btnBackForgot.addEventListener("click", function () {
      frmForgot.classList.add("d-none");
      frmLogin.classList.remove("d-none");
    });
  }

  //registro
  if (registrarse) {
    registrarse.addEventListener("click", function () {
      if (
        nombreRegistro.value == "" ||
        correoRegistro.value == "" ||
        claveRegistro.value == "" ||
        direccionRegistro.value == ""
      ) {
        Swal.fire("Aviso?", "TODO LOS CAMPOS SON REQUERIDOS", "warning");
      } else if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s']+$/.test(nombreRegistro.value)) {
        Swal.fire(
          "Aviso?",
          "EL NOMBRE SOLO PUEDE CONTENER LETRAS",
          "warning"
        );
      } else if (!validarCorreo(correoRegistro.value)) {
        Swal.fire("Aviso?", "CORREO ELECTRÓNICO NO VÁLIDO", "warning");
      } else if (direccionRegistro.value.trim().length < 5) {
        Swal.fire("Aviso?", "INGRESE UNA DIRECCIÓN VÁLIDA", "warning");
      } else if (!validarClaveFuerte(claveRegistro.value)) {
        Swal.fire(
          "Aviso?",
          "LA CONTRASEÑA DEBE TENER AL MENOS 8 CARACTERES, UNA MAYÚSCULA, UNA MINÚSCULA Y UN NÚMERO",
          "warning"
        );
      } else {
        let formData = new FormData();
        formData.append("nombre", nombreRegistro.value);
        formData.append("clave", claveRegistro.value);
        formData.append("correo", correoRegistro.value);
        formData.append("direccion", direccionRegistro.value);
        const url = base_url + "clientes/registroDirecto";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(formData);
        http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            Swal.fire("Aviso?", res.msg, res.icono);
            if (res.icono == "success") {
              setTimeout(() => {
                enviarCorreo(correoRegistro.value, res.token);
              }, 2000);
            }
          }
        };
      }
    });
  }
  //login directo
  if (login) {
    login.addEventListener("click", function () {
      if (correoLogin.value == "" || claveLogin.value == "") {
        Swal.fire("Aviso?", "TODO LOS CAMPOS SON REQUERIDOS", "warning");
      } else {
        let formData = new FormData();
        formData.append("correoLogin", correoLogin.value);
        formData.append("claveLogin", claveLogin.value);
        const url = base_url + "clientes/loginDirecto";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(formData);
        http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            Swal.fire("Aviso?", res.msg, res.icono);
            if (res.icono == "success") {
              setTimeout(() => {
                window.location.reload();
              }, 2000);
            }
          }
        };
      }
    });
  }

  if (recuperar) {
    recuperar.addEventListener("click", function () {
      if (correoRecuperar.value == "") {
        Swal.fire("Aviso?", "EL CORREO ES REQUERIDO", "warning");
      } else {
        let formData = new FormData();
        formData.append("correoRecuperar", correoRecuperar.value);
        const url = base_url + "clientes/enviarRecuperacion";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(formData);
        http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            Swal.fire("Aviso?", res.msg, res.icono);
            if (res.icono == "success") {
              frmForgot.classList.add("d-none");
              frmLogin.classList.remove("d-none");
              correoRecuperar.value = "";
            }
          }
        };
      }
    });
  }

  if (formCambioClave) {
    formCambioClave.addEventListener("submit", function (e) {
      e.preventDefault();

      if (
        codigoRecuperacion.value === "" ||
        nuevaClaveModal.value === "" ||
        confirmarClaveModal.value === ""
      ) {
        Swal.fire("Aviso?", "TODO LOS CAMPOS SON REQUERIDOS", "warning");
      } else if (!validarClaveFuerte(nuevaClaveModal.value)) {
        Swal.fire(
          "Aviso?",
          "LA CONTRASEÑA DEBE TENER AL MENOS 8 CARACTERES, UNA MAYÚSCULA, UNA MINÚSCULA Y UN NÚMERO",
          "warning"
        );
      } else if (nuevaClaveModal.value !== confirmarClaveModal.value) {
        Swal.fire("Aviso?", "LAS CONTRASEÑAS NO COINCIDEN", "warning");
      } else {
        let formData = new FormData();
        formData.append("token", codigoRecuperacion.value);
        formData.append("clave", nuevaClaveModal.value);
        formData.append("confirmar", confirmarClaveModal.value);

        const url = base_url + "clientes/actualizarClave";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(formData);
        http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            Swal.fire("Aviso?", res.msg, res.icono);
            if (res.icono == "success") {
              setTimeout(() => {
                $("#modalCambiarClave").modal("hide");
                formCambioClave.reset();
              }, 1500);
            }
          }
        };
      }
    });
  }



});

function enviarCorreo(correo, token) {
  let formData = new FormData();
  formData.append("token", token);
  formData.append("correo", correo);
  const url = base_url + "clientes/enviarCorreo";
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(formData);
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      Swal.fire("Aviso?", res.msg, res.icono);
      if (res.icono == "success") {
        setTimeout(() => {
          window.location.reload();
        }, 2000);
      }
    }
  };
}

function validarCorreo(correo) {
  const correoRegex =
    /^(?:[a-zA-Z0-9_'^&\/+-])+(?:\.(?:[a-zA-Z0-9_'^&\/+-])+)*@(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/;
  return correoRegex.test(correo);
}

function validarClaveFuerte(clave) {
  const tieneLongitud = clave.length >= 8;
  const tieneMayuscula = /[A-Z]/.test(clave);
  const tieneMinuscula = /[a-z]/.test(clave);
  const tieneNumero = /[0-9]/.test(clave);

  return tieneLongitud && tieneMayuscula && tieneMinuscula && tieneNumero;
}

function abrirModalLogin() {
  $('#modalCarrito').modal('hide')
  $('#modalLogin').modal('show')
}
