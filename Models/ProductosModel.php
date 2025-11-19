<?php
class ProductosModel extends Query{

    private $inventoryColumn;
 
    public function __construct()
    {
        parent::__construct();
        $this->inventoryColumn = $this->resolveInventoryColumn();
    }
    public function getProductos($estado = null)
    {
        $sql = "SELECT * FROM productos";
        if ($estado !== null) {
            $sql .= " WHERE estado = $estado";
        }
        $sql .= " ORDER BY id DESC";
        return $this->selectAll($sql);
    }
    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias WHERE estado = 1";
        return $this->selectAll($sql);
    }

    public function registrar($nombre, $descripcion, $precio, $cantidad, $imagen, $categoria)
    {
        if ($this->inventoryColumn !== null) {
            $sql = "INSERT INTO productos (nombre, descripcion, precio, {$this->inventoryColumn}, imagen, id_categoria) VALUES (?,?,?,?,?,?)";
            $array = array($nombre, $descripcion, $precio, $cantidad, $imagen, $categoria);
        } else {
            $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen, id_categoria) VALUES (?,?,?,?,?)";
            $array = array($nombre, $descripcion, $precio, $imagen, $categoria);
        }
        return $this->insertar($sql, $array);
    }

    public function eliminar($idPro)
    {
        $sql = "UPDATE productos SET estado = ? WHERE id = ?";
        $array = array(0, $idPro);
        return $this->save($sql, $array);
    }

    public function actualizarEstado($estado, $idPro)
    {
        $sql = "UPDATE productos SET estado = ? WHERE id = ?";
        $array = array($estado, $idPro);
        return $this->save($sql, $array);
    }

    public function getProducto($idPro)
    {
        $sql = "SELECT * FROM productos WHERE id = $idPro";
        return $this->select($sql);
    }

    public function modificar($nombre, $descripcion, $precio, $cantidad, $destino, $categoria, $id)
    {
        if ($this->inventoryColumn !== null) {
            $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, {$this->inventoryColumn}=?, imagen=?, id_categoria=? WHERE id = ?";
            $array = array($nombre, $descripcion, $precio, $cantidad, $destino, $categoria, $id);
        } else {
            $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, imagen=?, id_categoria=? WHERE id = ?";
            $array = array($nombre, $descripcion, $precio, $destino, $categoria, $id);
        }
        return $this->save($sql, $array);
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