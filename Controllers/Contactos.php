<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Contactos extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index()
    {
        $data['perfil'] = 'no';
        $data['title'] = 'Contáctanos';
        $data['categorias'] = $this->model->getCategorias();
        $this->views->getView('contactos', 'index', $data);
    }

    public function enviar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $mensaje = array('msg' => 'ACCESO NO PERMITIDO', 'icono' => 'error');
            echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
            die();
        }

        $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
        $correo = isset($_POST['email']) ? trim($_POST['email']) : '';
        $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
        $mensajeContacto = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

        if (empty($nombre) || empty($correo) || empty($mensajeContacto)) {
            $mensaje = array('msg' => 'TODOS LOS CAMPOS SON REQUERIDOS', 'icono' => 'warning');
            echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
            die();
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $mensaje = array('msg' => 'INGRESA UN CORREO VÁLIDO', 'icono' => 'warning');
            echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
            die();
        }

        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = HOST_SMTP;
            $mail->SMTPAuth = true;
            $mail->Username = USER_SMTP;
            $mail->Password = PASS_SMTP;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = PUERTO_SMTP;

            $mail->setFrom(USER_SMTP, TITLE);
            $mail->addAddress(USER_SMTP, TITLE . ' Web');
            if (!empty($correo)) {
                $mail->addReplyTo($correo, $nombre);
                $mail->addCC($correo);
            }

            $telefonoTexto = !empty($telefono) ? $telefono : 'No proporcionado';
            $mensajeSeguro = nl2br(htmlspecialchars($mensajeContacto));

            $mail->isHTML(true);
            $mail->Subject = 'Nuevo mensaje de contacto - ' . $nombre;
            $mail->Body = "<h2>Nuevo mensaje desde el sitio web</h2>"
                . "<p><strong>Nombre:</strong> {$nombre}</p>"
                . "<p><strong>Correo:</strong> {$correo}</p>"
                . "<p><strong>Teléfono:</strong> {$telefonoTexto}</p>"
                . "<hr><p>{$mensajeSeguro}</p>";
            $mail->AltBody = "Nuevo mensaje de contacto\n"
                . "Nombre: {$nombre}\n"
                . "Correo: {$correo}\n"
                . "Teléfono: {$telefonoTexto}\n\n"
                . "Mensaje:\n{$mensajeContacto}";

            $mail->send();
            $mensaje = array('msg' => '¡Gracias por escribirnos! Te contactaremos pronto.', 'icono' => 'success');
        } catch (Exception $e) {
            $mensaje = array('msg' => 'ERROR AL ENVIAR EL CORREO: ' . $mail->ErrorInfo, 'icono' => 'error');
        }

        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
}
