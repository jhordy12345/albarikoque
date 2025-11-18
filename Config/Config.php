<?php
const BASE_URL = "http://localhost/albarikoque/";
const HOST = "localhost";
const USER = "root";
const PASS = "";
const DB = "albarikoque";
const CHARSET = "charset=utf8";
const TITLE = "ALBARIKOQUE";
const MONEDA = "S/";
const MONEDA_CODE = "USD";
// Tipo de cambio referencial de soles a dólares para procesar pagos en PayPal.
// Ajusta este valor según el tipo de cambio actual (monto en soles / TIPO_CAMBIO_DOLAR = monto en dólares).
const TIPO_CAMBIO_DOLAR = 3.80;
const CLIENT_ID = "AbPJ4N7PEV-goEUAOHAd91bOmZfyaKOGTDwKjdL5h8AIkuVbpPLwypTP5zwsSsVtwjmDG7H1yeE0BoeC";

const USER_SMTP = "jhordyyue@gmail.com";
const PASS_SMTP = "dwdbtqhrjovltoif";
const PUERTO_SMTP = 465;
const HOST_SMTP = "smtp.gmail.com";
const TIMEZONE = "America/Lima";

date_default_timezone_set(TIMEZONE);
?>