<?php
class UsuariosModel extends Query{
    private $hasRolColumn;

    public function __construct()
    {
        parent::__construct();
        $this->hasRolColumn = $this->checkRolColumn();
        if (!$this->hasRolColumn) {
            $this->createRolColumn();
            $this->hasRolColumn = $this->checkRolColumn();
        }
    }
    private function checkRolColumn()
    {
        $sql = "SHOW COLUMNS FROM usuarios LIKE 'rol'";
        $column = $this->select($sql);
        return !empty($column);
    }
    private function createRolColumn()
    {
        try {
            $sql = "ALTER TABLE usuarios ADD COLUMN rol ENUM('Administrador','Empleado') NOT NULL DEFAULT 'Empleado' AFTER correo";
            $this->save($sql, array());
        } catch (Throwable $th) {
            // If we cannot create the column automatically, leave the flag false so callers
            // can gracefully fall back to the legacy behaviour.
        }
    }
    public function getUsuarios($estado)
    {
        if ($this->hasRolColumn) {
            $sql = "SELECT id, nombres, apellidos, correo, perfil, rol FROM usuarios WHERE estado = $estado";
            return $this->selectAll($sql);
        }
        $sql = "SELECT id, nombres, apellidos, correo, perfil FROM usuarios WHERE estado = $estado";
        $usuarios = $this->selectAll($sql);
        for ($i = 0; $i < count($usuarios); $i++) {
            $usuarios[$i]['rol'] = 'Empleado';
        }
        return $usuarios;
    }
    public function registrar($nombre, $apellido, $correo, $clave, $rol)
    {
        if ($this->hasRolColumn) {
            $sql = "INSERT INTO usuarios (nombres, apellidos, correo, clave, rol) VALUES (?,?,?,?,?)";
            $array = array($nombre, $apellido, $correo, $clave, $rol);
            return $this->insertar($sql, $array);
        }
        $sql = "INSERT INTO usuarios (nombres, apellidos, correo, clave) VALUES (?,?,?,?)";
        $array = array($nombre, $apellido, $correo, $clave);
        return $this->insertar($sql, $array);
    }
    public function verificarCorreo($correo)
    {
        $sql = "SELECT correo FROM usuarios WHERE correo = '$correo' AND estado = 1";
        return $this->select($sql);
    }

    public function eliminar($idUser)
    {
        $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
        $array = array(0, $idUser);
        return $this->save($sql, $array);
    }

    public function getUsuario($idUser)
    {
        if ($this->hasRolColumn) {
            $sql = "SELECT id, nombres, apellidos, correo, rol FROM usuarios WHERE id = $idUser";
            return $this->select($sql);
        }
        $sql = "SELECT id, nombres, apellidos, correo FROM usuarios WHERE id = $idUser";
        $usuario = $this->select($sql);
        if (!empty($usuario)) {
            $usuario['rol'] = 'Empleado';
        }
        return $usuario;
    }

    public function modificar($nombre, $apellido, $correo, $rol, $id)
    {
        if ($this->hasRolColumn) {
            $sql = "UPDATE usuarios SET nombres=?, apellidos=?, correo=?, rol=? WHERE id = ?";
            $array = array($nombre, $apellido, $correo, $rol, $id);
            return $this->save($sql, $array);
        }
        $sql = "UPDATE usuarios SET nombres=?, apellidos=?, correo=? WHERE id = ?";
        $array = array($nombre, $apellido, $correo, $id);
        return $this->save($sql, $array);
    }
}

?>
