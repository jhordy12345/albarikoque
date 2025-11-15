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
        $data = $this->model->getUsuarios(1);
        for ($i = 0; $i < count($data); $i++) {
            if ((int) $data[$i]['id'] === 1) {
                $data[$i]['accion'] = '<span class="badge bg-secondary">Protegido</span>';
                continue;
            }
            $acciones = '<div class="d-flex">';
            $acciones .= '<button class="btn btn-primary" type="button" onclick="editUser(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>';
            $acciones .= '<button class="btn btn-danger ms-2" type="button" onclick="eliminarUser(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>';
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
            $hash = password_hash($clave, PASSWORD_DEFAULT);
            if (empty($nombre) || empty($apellido) || empty($rol)) {
                $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            } else {
                if (empty($id)) {
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
                        $data = $this->model->modificar($nombre, $apellido, $correo, $rol, $id);
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
            $respuesta = array('msg' => 'el usuario principal no se puede eliminar', 'icono' => 'warning');
            echo json_encode($respuesta);
            die();
        }
        if (is_numeric($idUser)) {
            $data = $this->model->eliminar($idUser);
            if ($data == 1) {
                $respuesta = array('msg' => 'usuario dado de baja', 'icono' => 'success');
            } else {
                $respuesta = array('msg' => 'error al eliminar', 'icono' => 'error');
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
