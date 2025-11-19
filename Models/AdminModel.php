<?php
class AdminModel extends Query{
    private $hasResetColumns;

    public function __construct()
    {
        parent::__construct();
        $this->hasResetColumns = $this->ensureResetColumns();
    }
    public function getUsuario($correo)
    {
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
        return $this->select($sql);
    }

    private function ensureResetColumns()
    {
        $resetTokenColumn = $this->select("SHOW COLUMNS FROM usuarios LIKE 'reset_token'");
        $resetExpiresColumn = $this->select("SHOW COLUMNS FROM usuarios LIKE 'reset_expires_at'");

        if (!empty($resetTokenColumn) && !empty($resetExpiresColumn)) {
            return true;
        }

        try {
            if (empty($resetTokenColumn)) {
                $this->save("ALTER TABLE usuarios ADD COLUMN reset_token VARCHAR(120) NULL AFTER clave", array());
            }
            if (empty($resetExpiresColumn)) {
                $this->save("ALTER TABLE usuarios ADD COLUMN reset_expires_at DATETIME NULL AFTER reset_token", array());
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function guardarTokenRecuperacion($usuarioId, $token, $expira)
    {
        if (!$this->hasResetColumns) {
            return 0;
        }
        $sql = "UPDATE usuarios SET reset_token = ?, reset_expires_at = ? WHERE id = ?";
        $array = array($token, $expira, $usuarioId);
        return $this->save($sql, $array);
    }

    public function getUsuarioPorToken($token)
    {
        if (!$this->hasResetColumns) {
            return array();
        }
        $sql = "SELECT * FROM usuarios WHERE reset_token = '$token' AND reset_expires_at >= NOW()";
        return $this->select($sql);
    }

    public function actualizarClaveConToken($usuarioId, $clave)
    {
        if (!$this->hasResetColumns) {
            return 0;
        }
        $sql = "UPDATE usuarios SET clave = ?, reset_token = NULL, reset_expires_at = NULL WHERE id = ?";
        $array = array($clave, $usuarioId);
        return $this->save($sql, $array);
    }
    public function getTotales($estado)
    {
        $sql = "SELECT COUNT(*) AS total FROM pedidos WHERE proceso = $estado";
        return $this->select($sql);
    }
    public function getProductos()
    {
        $sql = "SELECT COUNT(*) AS total FROM productos WHERE estado = 1";
        return $this->select($sql);
    }

    public function productosMinimos()
    {
        $sql = "SELECT * FROM productos WHERE cantidad < 15 AND estado = 1 ORDER BY cantidad DESC LIMIT 3";
        return $this->selectAll($sql);
    }

    public function topProductos()
    {
        $sql = "SELECT pr.nombre AS producto, SUM(d.cantidad) AS total FROM detalle_pedidos d "
            . "INNER JOIN productos pr ON d.id_producto = pr.id GROUP BY d.id_producto ORDER BY total DESC LIMIT 3";
        return $this->selectAll($sql);
    }
}
 
?>