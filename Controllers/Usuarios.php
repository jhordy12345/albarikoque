<?php
class Usuarios extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['nombre_usuario'])) {
            header('Location: '. BASE_URL . 'admin');
            exit;
        }
        verificarUsuarioActivo();
        if (empty($_SESSION['rol_usuario']) || $_SESSION['rol_usuario'] !== 'Administrador') {
            header('Location: '. BASE_URL . 'admin/home');
            exit;
        }
    }
    public function index()
    {
        $data['title'] = 'usuarios';
        $this->views->getView('admin/usuarios', "index", $data);
    }
    public function listar()
    {
        $data = $this->model->getUsuarios();
        for ($i = 0; $i < count($data); $i++) {
            $estadoActual = (int) $data[$i]['estado'];
            $data[$i]['estado'] = ($estadoActual === 1) ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>';
            if ((int) $data[$i]['id'] === 1) {
                $data[$i]['accion'] = '<span class="badge bg-secondary">Protegido</span>';
                continue;
            }
            $btnEstado = ($estadoActual === 1) ? 'btn-warning' : 'btn-success';
            $iconoEstado = ($estadoActual === 1) ? 'fa-power-off' : 'fa-rotate-left';
            $acciones = '<div class="d-flex">';
            $acciones .= '<button class="btn btn-primary" type="button" onclick="editUser(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>';
            $acciones .= '<button class="btn ' . $btnEstado . ' ms-2" type="button" onclick="eliminarUser(' . $data[$i]['id'] . ',' . $estadoActual . ')"><i class="fas ' . $iconoEstado . '"></i></button>';
            $acciones .= '</div>';
            $data[$i]['accion'] = $acciones;
        }
        echo json_encode($data);
        die();
    }
    public function registrar()
    {
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $correo = $_POST['correo'];
            $clave = $_POST['clave'];
            $rol = $_POST['rol'];
            $id = $_POST['id'];
            $hash = (!empty($clave)) ? password_hash($clave, PASSWORD_DEFAULT) : null;
            if (empty($nombre) || empty($apellido) || empty($rol)) {
                $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            } else {
                if (empty($id)) {
                    if (empty($clave)) {
                        $respuesta = array('msg' => 'la contraseña es requerida', 'icono' => 'warning');
                        echo json_encode($respuesta);
                        die();
                    }
                    $result = $this->model->verificarCorreo($correo);
                    if (empty($result)) {
                        $data = $this->model->registrar($nombre, $apellido, $correo, $hash, $rol);
                        if ($data > 0) {
                            $respuesta = array('msg' => 'usuario registrado', 'icono' => 'success');
                        } else {
                            $respuesta = array('msg' => 'error al registrar', 'icono' => 'error');
                        }
                    } else {
                        $respuesta = array('msg' => 'correo ya existe', 'icono' => 'warning');
                    }
                } else {
                    if ((int) $id === 1) {
                        $respuesta = array('msg' => 'el usuario principal no se puede modificar', 'icono' => 'warning');
                    } else {
                        $data = $this->model->modificar($nombre, $apellido, $correo, $rol, $id, $hash);
                        if ($data == 1) {
                            $respuesta = array('msg' => 'usuario modificado', 'icono' => 'success');
                        } else {
                            $respuesta = array('msg' => 'error al modificar', 'icono' => 'error');
                        }
                    }
                }
            }
            echo json_encode($respuesta);
        }
        die();
    }
    //eliminar user
    public function delete($idUser)
    {
        if ((int) $idUser === 1) {
            $respuesta = array('msg' => 'el usuario principal no se puede dar de baja', 'icono' => 'warning');
            echo json_encode($respuesta);
            die();
        }
        if (is_numeric($idUser)) {
            $usuario = $this->model->getUsuario($idUser);
            if (!empty($usuario)) {
                $estado = ($usuario['estado'] == 1) ? 0 : 1;
                $data = $this->model->actualizarEstado($estado, $idUser);
                if ($data == 1) {
                    $mensaje = ($estado == 1) ? 'usuario reactivado' : 'usuario dado de baja';
                    $respuesta = array('msg' => $mensaje, 'icono' => 'success');
                } else {
                    $respuesta = array('msg' => 'error al actualizar estado', 'icono' => 'error');
                }
            } else {
                $respuesta = array('msg' => 'usuario no encontrado', 'icono' => 'warning');
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta);
        die();
    }
    //editar user
    public function edit($idUser)
    {
        if ((int) $idUser === 1) {
            $respuesta = array('msg' => 'el usuario principal no se puede editar', 'icono' => 'warning');
            echo json_encode($respuesta);
            die();
        }
        if (is_numeric($idUser)) {
            $data = $this->model->getUsuario($idUser);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
