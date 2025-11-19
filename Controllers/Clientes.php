<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Clientes extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        if (empty($_SESSION['correoCliente'])) {
            header('Location: ' . BASE_URL);
        }
        $data['perfil'] = 'si';
        $data['title'] = 'Tu Perfil';
        $data['categorias'] = $this->model->getCategorias();
        $data['verificar'] = $this->model->getVerificar($_SESSION['correoCliente']);
        $this->views->getView('principal', "perfil", $data);
    }
    public function registroDirecto()
    {
        if (isset($_POST['nombre']) && isset($_POST['clave']) && isset($_POST['direccion'])) {
            $nombre = trim($_POST['nombre']);
            $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
            $clave = trim($_POST['clave']);
            $direccion = trim($_POST['direccion']);

            if (empty($nombre) || empty($correo) || empty($clave) || empty($direccion)) {
                $mensaje = array('msg' => 'TODO LOS CAMPOS SON REQUERIDOS', 'icono' => 'warning');
            } elseif (!preg_match("/^[\p{L}\s']+$/u", $nombre)) {
                $mensaje = array('msg' => 'EL NOMBRE SOLO PUEDE CONTENER LETRAS', 'icono' => 'warning');
            } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $mensaje = array('msg' => 'CORREO ELECTRÓNICO NO VÁLIDO', 'icono' => 'warning');
            } elseif (strlen($direccion) < 5) {
                $mensaje = array('msg' => 'INGRESE UNA DIRECCIÓN VÁLIDA', 'icono' => 'warning');
            } elseif (!$this->validarFortalezaClave($clave)) {
                $mensaje = array('msg' => 'LA CONTRASEÑA DEBE TENER AL MENOS 8 CARACTERES, UNA MAYÚSCULA, UNA MINÚSCULA Y UN NÚMERO', 'icono' => 'warning');
            } else {
                $verificar = $this->model->getVerificar($correo);
                if (empty($verificar)) {
                    $token = md5($correo);
                    $hash = password_hash($clave, PASSWORD_DEFAULT);
                    $data = $this->model->registroDirecto($nombre, $correo, $hash, $token, $direccion);
                    if ($data > 0) {
                        $_SESSION['idCliente'] = $data;
                        $_SESSION['correoCliente'] = $correo;
                        $_SESSION['nombreCliente'] = $nombre;
                        $mensaje = array('msg' => 'registrado con éxito', 'icono' => 'success', 'token' => $token);
                    } else {
                        $mensaje = array('msg' => 'error al registrarse', 'icono' => 'error');
                    }
                } else {
                    $mensaje = array('msg' => 'YA TIENES UNA CUENTA', 'icono' => 'warning');
                }
            }
            echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    private function validarFortalezaClave($clave)
    {
        $tieneLongitud = strlen($clave) >= 8;
        $tieneMayuscula = preg_match('/[A-Z]/', $clave);
        $tieneMinuscula = preg_match('/[a-z]/', $clave);
        $tieneNumero = preg_match('/[0-9]/', $clave);

        return $tieneLongitud && $tieneMayuscula && $tieneMinuscula && $tieneNumero;
    }
    public function enviarCorreo()
    {
        if (isset($_POST['correo']) && isset($_POST['token'])) {
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = HOST_SMTP;                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = USER_SMTP;                     //SMTP username
                $mail->Password   = PASS_SMTP;                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = PUERTO_SMTP;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('yuwenjhor@gmail.com', TITLE);
                $mail->addAddress($_POST['correo']);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Mensaje desde la: ' . TITLE;
                $mail->Body    = 'Para verificar tu correo en nuestra tienda <a href="' . BASE_URL . 'clientes/verificarCorreo/' . $_POST['token'] . '">CLIC AQUÍ</a>';
                $mail->AltBody = 'GRACIAS POR LA PREFERENCIA';

                $mail->send();
                $mensaje = array('msg' => 'CORREO ENVIADO, REVISA TU BANDEJA DE ENTRADA - SPAN', 'icono' => 'success');
            } catch (Exception $e) {
                $mensaje = array('msg' => 'ERROR AL ENVIAR CORREO: ' . $mail->ErrorInfo, 'icono' => 'error');
            }
        } else {
            $mensaje = array('msg' => 'ERROR FATAL: ', 'icono' => 'error');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function verificarCorreo($token)
    {
        $verificar = $this->model->getToken($token);
        if (!empty($verificar)) {
            $this->model->actualizarVerify($verificar['id']);
            header('Location: ' . BASE_URL . 'clientes');
        }
    }

    //login directo
    public function loginDirecto()
    {
        if (isset($_POST['correoLogin']) && isset($_POST['claveLogin'])) {
            if (empty($_POST['correoLogin']) || empty($_POST['claveLogin'])) {
                $mensaje = array('msg' => 'TODO LOS CAMPOS SON REQUERIDOS', 'icono' => 'warning');
            } else {
                $correo = $_POST['correoLogin'];
                $clave = $_POST['claveLogin'];
                $verificar = $this->model->getVerificar($correo);
                if (!empty($verificar)) {
                    if (password_verify($clave, $verificar['clave'])) {
                        $_SESSION['idCliente'] = $verificar['id'];
                        $_SESSION['correoCliente'] = $verificar['correo'];
                        $_SESSION['nombreCliente'] = $verificar['nombre'];
                        $mensaje = array('msg' => 'OK', 'icono' => 'success');
                    } else {
                        $mensaje = array('msg' => 'CONTRASEÑA INCORRECTA', 'icono' => 'error');
                    }
                } else {
                    $mensaje = array('msg' => 'EL CORREO NO EXISTE', 'icono' => 'warning');
                }
            }
            echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function enviarRecuperacion()
    {
        if (isset($_POST['correoRecuperar'])) {
            $correo = trim($_POST['correoRecuperar']);
            if (empty($correo)) {
                $mensaje = array('msg' => 'EL CORREO ES REQUERIDO', 'icono' => 'warning');
            } else {
                $cliente = $this->model->getVerificar($correo);
                if (!empty($cliente)) {
                    try {
                        $token = bin2hex(random_bytes(16));
                    } catch (\Exception $e) {
                        $token = md5(uniqid($correo, true));
                    }
                    $actualizar = $this->model->actualizarTokenCliente($token, $cliente['id']);
                    if ($actualizar > 0) {
                        $mail = new PHPMailer(true);
                        try {
                            $mail->SMTPDebug = 0;
                            $mail->isSMTP();
                            $mail->Host       = HOST_SMTP;
                            $mail->SMTPAuth   = true;
                            $mail->Username   = USER_SMTP;
                            $mail->Password   = PASS_SMTP;
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                            $mail->Port       = PUERTO_SMTP;

                            $mail->setFrom('breysonhuamaniestph@gmail.com', TITLE);
                            $mail->addAddress($correo);

                            $mail->isHTML(true);
                            $mail->Subject = 'Restablecer contraseña - ' . TITLE;
                            $mail->Body    = 'Para restablecer tu contraseña en nuestra tienda <a href="' . BASE_URL . 'clientes/restablecer/' . $token . '">CLIC AQUÍ</a>';
                            $mail->AltBody = 'Para restablecer tu contraseña visita: ' . BASE_URL . 'clientes/restablecer/' . $token;

                            $mail->send();
                            $mensaje = array('msg' => 'HEMOS ENVIADO UN CORREO CON LAS INSTRUCCIONES', 'icono' => 'success');
                        } catch (Exception $e) {
                            $mensaje = array('msg' => 'ERROR AL ENVIAR CORREO: ' . $mail->ErrorInfo, 'icono' => 'error');
                        }
                    } else {
                        $mensaje = array('msg' => 'NO SE PUDO GENERAR EL TOKEN DE RECUPERACIÓN', 'icono' => 'error');
                    }
                } else {
                    $mensaje = array('msg' => 'EL CORREO NO EXISTE', 'icono' => 'warning');
                }
            }
            echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function restablecer($token)
    {
        $token = str_replace(',', '', $token);
        $cliente = $this->model->getToken($token);
        $data['categorias'] = $this->model->getCategorias();
        $data['title'] = 'Restablecer Contraseña';
        $data['token'] = $token;
        $data['cliente'] = $cliente;
        $this->views->getView('principal', 'restablecer', $data);
    }
    public function actualizarClave()
    {
        if (isset($_POST['token']) && isset($_POST['clave']) && isset($_POST['confirmar'])) {
            $token = $_POST['token'];
            $clave = $_POST['clave'];
            $confirmar = $_POST['confirmar'];
            if (empty($token) || empty($clave) || empty($confirmar)) {
                $mensaje = array('msg' => 'TODO LOS CAMPOS SON REQUERIDOS', 'icono' => 'warning');
            } elseif ($clave != $confirmar) {
                $mensaje = array('msg' => 'LAS CONTRASEÑAS NO COINCIDEN', 'icono' => 'warning');
            } elseif (!$this->validarFortalezaClave($clave)) {
                $mensaje = array('msg' => 'LA CONTRASEÑA DEBE TENER AL MENOS 8 CARACTERES, UNA MAYÚSCULA, UNA MINÚSCULA Y UN NÚMERO', 'icono' => 'warning');
            } else {
                $cliente = $this->model->getToken($token);
                if (!empty($cliente)) {
                    $hash = password_hash($clave, PASSWORD_DEFAULT);
                    $actualizar = $this->model->actualizarClaveCliente($hash, $cliente['id']);
                    if ($actualizar > 0) {
                        $mensaje = array('msg' => 'CONTRASEÑA MODIFICADA CORRECTAMENTE', 'icono' => 'success');
                    } else {
                        $mensaje = array('msg' => 'ERROR AL ACTUALIZAR LA CONTRASEÑA', 'icono' => 'error');
                    }
                } else {
                    $mensaje = array('msg' => 'TOKEN NO VÁLIDO', 'icono' => 'warning');
                }
            }
            echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    //registrar pedidos
    public function registrarPedido()
    {
        $datos = file_get_contents('php://input');
        $json = json_decode($datos, true);
        $pedidos = $json['pedidos'];
        $productos = $json['productos'];
        if (is_array($pedidos) && is_array($productos)) {
            $id_transaccion = isset($pedidos['id']) ? $pedidos['id'] : '';
            $monto = isset($pedidos['purchase_units'][0]['amount']['value']) ? (float) $pedidos['purchase_units'][0]['amount']['value'] : 0;
            $monedaPago = isset($pedidos['purchase_units'][0]['amount']['currency_code'])
                ? strtoupper($pedidos['purchase_units'][0]['amount']['currency_code'])
                : COD_MONEDA;
            $montoCarritoSoles = $this->calcularTotalSoles($productos);
            $montoConvertido = ($monedaPago === 'USD')
                ? round($monto * TIPO_CAMBIO, 2)
                : round($monto, 2);
            $monto = $montoCarritoSoles > 0 ? $montoCarritoSoles : $montoConvertido;
            $estado = isset($pedidos['status']) ? $pedidos['status'] : 'COMPLETED';
            $fecha = date('Y-m-d H:i:s');
            $id_cliente = isset($_SESSION['idCliente']) ? $_SESSION['idCliente'] : 0;
            $cliente = $this->model->getCliente($id_cliente);
            $direccion = '';
            if (!empty($cliente)) {
                $direccion = isset($cliente['direccion']) ? $cliente['direccion'] : '';
            }
            $proceso = 1;
            $id_usuario = 1;
            $data = $this->model->registrarPedido(
                $id_transaccion,
                $monto,
                $estado,
                $fecha,
                $direccion,
                $id_cliente,
                $proceso,
                $id_usuario
            );
            if ($data > 0) {
                foreach ($productos as $producto) {
                    $temp = $this->model->getProducto($producto['idProducto']);
                    $this->model->registrarDetalle($temp['precio'], $producto['cantidad'], $data, $producto['idProducto']);
                }
                $mensaje = array('msg' => 'pedido registrado', 'icono' => 'success');
            } else {
                $mensaje = array('msg' => 'error al registrar el pedido', 'icono' => 'error');
            }
        } else {
            $mensaje = array('msg' => 'error fatal con los datos', 'icono' => 'error');
        }
        echo json_encode($mensaje);
        die();
    }

    private function calcularTotalSoles(array $productos)
    {
        $total = 0.0;

        foreach ($productos as $producto) {
            if (!isset($producto['idProducto'], $producto['cantidad'])) {
                continue;
            }

            $temp = $this->model->getProducto($producto['idProducto']);
            if (empty($temp) || !isset($temp['precio'])) {
                continue;
            }

            $precioUnitario = ceil((float) $temp['precio']);
            $cantidad = (int) $producto['cantidad'];
            $subTotal = ceil($precioUnitario * $cantidad);
            $total += $subTotal;
        }

        return (float) number_format(ceil($total), 2, '.', '');
    }
    //listar productos pendientes
    public function listarPendientes()
    {
        if (empty($_SESSION['idCliente'])) {
            echo json_encode([]);
            die();
        }

        $id_cliente = $_SESSION['idCliente'];
        $data = $this->model->getPedidos($id_cliente);
        for ($i = 0; $i < count($data); $i++) {
            if (!empty($data[$i]['fecha'])) {
                $data[$i]['fecha'] = date('d/m/Y H:i:s', strtotime($data[$i]['fecha']));
            }
            if (isset($data[$i]['monto'])) {
                $monto = round((float) $data[$i]['monto'], 2);
                $data[$i]['monto'] = MONEDA . ' ' . number_format($monto, 2, '.', '');
            }
            $data[$i]['accion'] = '<div class="text-center">'
                . '<button class="btn btn-primary" type="button" onclick="verPedido(' . $data[$i]['id'] . ')"><i class="fas fa-eye"></i></button> '
                . '<button class="btn btn-secondary" type="button" onclick="imprimirPedido(' . $data[$i]['id'] . ')"><i class="fas fa-print"></i></button>'
                . '</div>';
        }
        echo json_encode($data);
        die();
    }
    public function verPedido($idPedido)
    {
        $data['pedido'] = $this->model->getPedido($idPedido);
        $data['productos'] = $this->model->verPedidos($idPedido);
        $data['moneda'] = MONEDA;
        echo json_encode($data);
        die();
    }

    public function salir()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
    }
}