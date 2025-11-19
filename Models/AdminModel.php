<?php
class AdminModel extends Query{
    private $hasResetColumns;
    private $inventoryColumn;

    public function __construct()
    {
        parent::__construct();
        $this->hasResetColumns = $this->hasRequiredResetColumns();
        $this->inventoryColumn = $this->resolveInventoryColumn();
    }
    public function getUsuario($correo)
    {
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
        return $this->select($sql);
    }

    private function hasRequiredResetColumns()
    {
        $resetTokenColumn = $this->select("SHOW COLUMNS FROM usuarios LIKE 'reset_token'");
        $resetExpiresColumn = $this->select("SHOW COLUMNS FROM usuarios LIKE 'reset_expires_at'");

        return !empty($resetTokenColumn) && !empty($resetExpiresColumn);
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
        $sql = "SELECT pr.nombre, COALESCE(SUM(d.cantidad), 0) AS cantidad FROM productos pr "
            . "LEFT JOIN detalle_pedidos d ON d.id_producto = pr.id "
            . "LEFT JOIN pedidos p ON d.id_pedido = p.id AND p.proceso = 3 "
            . "WHERE pr.estado = 1 GROUP BY pr.id, pr.nombre ORDER BY cantidad ASC LIMIT 3";
        return $this->selectAll($sql);
    }

    public function topProductos()
    {
        $sql = "SELECT pr.nombre AS producto, COALESCE(SUM(d.cantidad), 0) AS total FROM productos pr "
            . "LEFT JOIN detalle_pedidos d ON d.id_producto = pr.id "
            . "LEFT JOIN pedidos p ON d.id_pedido = p.id AND p.proceso = 3 "
            . "WHERE pr.estado = 1 GROUP BY pr.id ORDER BY total DESC LIMIT 3";
        return $this->selectAll($sql);
    }

    private function resolveInventoryColumn()
    {
        $possibleColumns = array('cantidad', 'stock', 'existencias', 'cantidad_producto');

        foreach ($possibleColumns as $column) {
            $columnExists = $this->select("SHOW COLUMNS FROM productos LIKE '$column'");

            if (!empty($columnExists)) {
                return $column;
            }
        }

        return null;
    }
}

?>