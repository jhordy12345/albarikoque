<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Admin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        if (!empty($_SESSION['nombre_usuario'])) {
            header('Location: '. BASE_URL . 'admin/home');
            exit;
        }
        $data['title'] = 'Acceso al sistema';
        $this->views->getView('admin', "login", $data);
    }
    public function validar()
    {
        if (isset($_POST['email']) && isset($_POST['clave'])) {
            if (empty($_POST['email']) || empty($_POST['clave'])) {
                $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            } else {
                $data = $this->model->getUsuario($_POST['email']);
                if (empty($data)) {
                    $respuesta = array('msg' => 'el correo no existe', 'icono' => 'warning');
                } elseif ((int) $data['estado'] !== 1) {
                    $respuesta = array('msg' => 'usuario inactivo', 'icono' => 'warning');
                } elseif (password_verify($_POST['clave'], $data['clave'])) {
                    $_SESSION['email'] = $data['correo'];
                    $_SESSION['nombre_usuario'] = $data['nombres'];
                    $rol = isset($data['rol']) ? $data['rol'] : 'Empleado';
                    $_SESSION['rol_usuario'] = $rol;
                    $respuesta = array('msg' => 'datos correcto', 'icono' => 'success');
                } else {
                    $respuesta = array('msg' => 'contraseña incorrecta', 'icono' => 'warning');
                }
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function recuperar()
    {
        if (isset($_POST['correoRecuperacion'])) {
            $correo = trim($_POST['correoRecuperacion']);

            if (empty($correo)) {
                $respuesta = array('msg' => 'el correo es obligatorio', 'icono' => 'warning');
                echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
                die();
            }

            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $respuesta = array('msg' => 'correo no válido', 'icono' => 'warning');
                echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
                die();
            }

            $usuario = $this->model->getUsuario($correo);
            if (empty($usuario)) {
                $respuesta = array('msg' => 'el correo no está registrado', 'icono' => 'warning');
            } elseif ((int) $usuario['id'] <= 1) {
                $respuesta = array('msg' => 'el usuario principal no permite recuperación automática', 'icono' => 'warning');
            } elseif ((int) $usuario['estado'] !== 1) {
                $respuesta = array('msg' => 'el usuario está inactivo', 'icono' => 'warning');
            } else {
                $claveTemporal = $this->generarClaveTemporal();
                $claveAnterior = $usuario['clave'];
                $hash = password_hash($claveTemporal, PASSWORD_DEFAULT);
                $actualizado = $this->model->actualizarClave($usuario['id'], $hash);

                if ($actualizado == 1) {
                    $correoEnviado = $this->enviarCorreoRecuperacion($correo, $usuario['nombres'], $claveTemporal);
                    if ($correoEnviado) {
                        $respuesta = array('msg' => 'se envió una contraseña temporal a tu correo', 'icono' => 'success');
                    } else {
                        $this->model->actualizarClave($usuario['id'], $claveAnterior);
                        $respuesta = array('msg' => 'no se pudo enviar el correo, intente nuevamente', 'icono' => 'error');
                    }
                } else {
                    $respuesta = array('msg' => 'no se pudo generar la contraseña temporal', 'icono' => 'error');
                }
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

    private function generarClaveTemporal()
    {
        $cadena = bin2hex(random_bytes(5));
        return strtoupper(substr($cadena, 0, 10));
    }

    private function enviarCorreoRecuperacion($correo, $nombre, $claveTemporal)
    {
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

            $mail->setFrom('no-responder@albarikoque.com', TITLE);
            $mail->addAddress($correo, $nombre);

            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de acceso - ' . TITLE;
            $mail->Body = 'Hola ' . $nombre . ',<br><br>Recibimos una solicitud para restablecer tu acceso al panel de administración. ' .
                'Tu contraseña temporal es: <strong>' . $claveTemporal . '</strong><br><br>' .
                'Inicia sesión con esta contraseña y actualízala desde tu perfil.';
            $mail->AltBody = 'Tu contraseña temporal es: ' . $claveTemporal . '. Inicia sesión y cámbiala cuanto antes.';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function home()
    {
        if (empty($_SESSION['nombre_usuario'])) {
            header('Location: '. BASE_URL . 'admin');
            exit;
        }
        $data['title'] = 'administracion';
        $data['pendientes'] = $this->model->getTotales(1);
        $data['procesos'] = $this->model->getTotales(2);
        $data['finalizados'] = $this->model->getTotales(3);
        $data['productos'] = $this->model->getProductos();
        $this->views->getView('admin/administracion', "index", $data);
    }

    public function productosMinimos()
    {
        if (empty($_SESSION['nombre_usuario'])) {
            header('Location: '. BASE_URL . 'admin');
            exit;
        }
        $data = $this->model->productosMinimos();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }

    public function topProductos()
    {
        if (empty($_SESSION['nombre_usuario'])) {
            header('Location: '. BASE_URL . 'admin');
            exit;
        }
        $data = $this->model->topProductos();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }

    public function salir()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
    }
}
