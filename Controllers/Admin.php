<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Admin extends Controller
{ 
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    private function ensureAuthenticated()
    {
        if (empty($_SESSION['nombre_usuario'])) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
        verificarUsuarioActivo();
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
        if (isset($_POST['correoRecuperar'])) {
            $correo = trim($_POST['correoRecuperar']);
            if (empty($correo)) {
                $respuesta = array('msg' => 'el correo es requerido', 'icono' => 'warning');
            } else {
                $usuario = $this->model->getUsuario($correo);
                if (empty($usuario)) {
                    $respuesta = array('msg' => 'el correo no existe', 'icono' => 'warning');
                } elseif ((int) $usuario['estado'] !== 1) {
                    $respuesta = array('msg' => 'usuario inactivo', 'icono' => 'warning');
                } else {
                    $token = bin2hex(random_bytes(16));
                    $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));
                    $guardar = $this->model->guardarTokenRecuperacion($usuario['id'], $token, $expira);
                    if ($guardar > 0) {
                        $envio = $this->enviarCorreoRecuperacion($correo, $token);
                        $respuesta = $envio;
                    } else {
                        $respuesta = array('msg' => 'no fue posible generar el enlace', 'icono' => 'error');
                    }
                }
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

    private function enviarCorreoRecuperacion($correo, $token)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = HOST_SMTP;
            $mail->SMTPAuth = true;
            $mail->Username = USER_SMTP;
            $mail->Password = PASS_SMTP;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = PUERTO_SMTP;

            $mail->setFrom(USER_SMTP, TITLE);
            $mail->addAddress($correo);

            $mail->isHTML(true);
            $mail->Subject = 'Recupera tu acceso a ' . TITLE;
            $mail->Body = 'Recibimos una solicitud para restablecer tu contraseña. <br> ' .
                'Haz clic en el siguiente enlace para continuar: <a href="' . BASE_URL . 'admin/restablecer/' . $token . '">Restablecer contraseña</a><br><br>' .
                'Si no solicitaste este cambio, puedes ignorar este mensaje.';
            $mail->AltBody = 'Copia y pega este enlace en tu navegador: ' . BASE_URL . 'admin/restablecer/' . $token;

            $mail->send();
            return array('msg' => 'enlace enviado, revisa tu correo', 'icono' => 'success');
        } catch (Exception $e) {
            return array('msg' => 'error al enviar el correo: ' . $mail->ErrorInfo, 'icono' => 'error');
        }
    }

    public function restablecer($token)
    {
        $usuario = $this->model->getUsuarioPorToken($token);
        if (empty($usuario)) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
        $data['title'] = 'Restablecer contraseña';
        $data['token'] = $token;
        $this->views->getView('admin', "restablecer", $data);
    }

    public function actualizarPassword()
    {
        if (isset($_POST['tokenReset']) && isset($_POST['nueva_clave']) && isset($_POST['confirmar_clave'])) {
            $token = $_POST['tokenReset'];
            $nuevaClave = $_POST['nueva_clave'];
            $confirmar = $_POST['confirmar_clave'];
            if (empty($token) || empty($nuevaClave) || empty($confirmar)) {
                $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            } elseif ($nuevaClave !== $confirmar) {
                $respuesta = array('msg' => 'las contraseñas no coinciden', 'icono' => 'warning');
            } elseif (strlen($nuevaClave) < 8) {
                $respuesta = array('msg' => 'la contraseña debe tener al menos 8 caracteres', 'icono' => 'warning');
            } else {
                $usuario = $this->model->getUsuarioPorToken($token);
                if (empty($usuario)) {
                    $respuesta = array('msg' => 'el enlace ya no es válido', 'icono' => 'warning');
                } else {
                    $hash = password_hash($nuevaClave, PASSWORD_DEFAULT);
                    $actualizar = $this->model->actualizarClaveConToken($usuario['id'], $hash);
                    if ($actualizar == 1) {
                        $respuesta = array('msg' => 'contraseña actualizada', 'icono' => 'success');
                    } else {
                        $respuesta = array('msg' => 'error al actualizar', 'icono' => 'error');
                    }
                }
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function home()
    {
        $this->ensureAuthenticated();
        $data['title'] = 'administracion';
        $data['pendientes'] = $this->model->getTotales(1);
        $data['procesos'] = $this->model->getTotales(2);
        $data['finalizados'] = $this->model->getTotales(3);
        $data['productos'] = $this->model->getProductos();
        $this->views->getView('admin/administracion', "index", $data);
    }

    public function productosMinimos()
    {
        $this->ensureAuthenticated();
        $data = array(
            'productos' => $this->model->productosMinimos(),
            'registrados' => $this->model->getProductos(),
        );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }

    public function topProductos()
    {
        $this->ensureAuthenticated();
        $data = $this->model->topProductos();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }

    public function salir()
    {
        session_destroy();
        header('Location: ' . BASE_URL . 'admin');
        exit;
    }
}
