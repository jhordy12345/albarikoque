<?php
class ClientesModel extends Query{
 
    public function __construct()
    {
        parent::__construct();
    }
    public function getCategorias() {
        $sql = "SELECT * FROM categorias WHERE estado = 1";
        return $this->selectAll($sql);
    }
    public function registroDirecto($nombre, $correo, $clave, $token, $direccion)
    {
        $columnQuery = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . DB . "' AND TABLE_NAME = 'clientes'";
        $columnas = $this->selectAll($columnQuery);
        $tieneDireccion = false;
        $tienePerfil = false;

        if (!empty($columnas)) {
            foreach ($columnas as $columna) {
                if ($columna['COLUMN_NAME'] === 'direccion') {
                    $tieneDireccion = true;
                }
                if ($columna['COLUMN_NAME'] === 'perfil') {
                    $tienePerfil = true;
                }
            }
        }

        $campos = ['nombre', 'correo', 'clave'];
        $placeholders = ['?', '?', '?'];
        $datos = array($nombre, $correo, $clave);

        if ($tienePerfil) {
            $campos[] = 'perfil';
            $placeholders[] = '?';
            $datos[] = 'default.png';
        }

        if ($tieneDireccion) {
            $campos[] = 'direccion';
            $placeholders[] = '?';
            $datos[] = $direccion;
        }

        $campos[] = 'token';
        $placeholders[] = '?';
        $datos[] = $token;

        $sql = "INSERT INTO clientes (" . implode(', ', $campos) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $data = $this->insertar($sql, $datos);
        if ($data > 0) {
            $res = $data;
        } else {
            $res = 0;
        }
        return $res;
    }
    public function getToken($token)
    {
        $sql = "SELECT * FROM clientes WHERE token = '$token'";
        return $this->select($sql);
    }
    public function actualizarVerify($id)
    {
        $sql = "UPDATE clientes SET token=?, verify=? WHERE id=?";
        $datos = array(null, 1, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = $data;
        } else {
            $res = 0;
        }
        return $res;
    }
    public function actualizarTokenCliente($token, $id)
    {
        $sql = "UPDATE clientes SET token=? WHERE id=?";
        $datos = array($token, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = $data;
        } else {
            $res = 0;
        }
        return $res;
    }
    public function actualizarClaveCliente($clave, $id)
    {
        $sql = "UPDATE clientes SET clave=?, token=? WHERE id=?";
        $datos = array($clave, null, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = $data;
        } else {
            $res = 0;
        }
        return $res;
    }
    public function getVerificar($correo)
    {
        $sql = "SELECT * FROM clientes WHERE correo = '$correo'";
        return $this->select($sql);
    }

    public function getCliente($id_cliente)
    {
        $sql = "SELECT * FROM clientes WHERE id = $id_cliente";
        return $this->select($sql);
    }

    public function registrarPedido($id_transaccion, $monto, $estado, $fecha, $direccion, $id_cliente, $proceso, $id_usuario)
    {
        $sql = "INSERT INTO pedidos (id_transaccion, monto, estado, fecha, direccion, id_cliente, proceso, id_usuario) VALUES (?,?,?,?,?,?,?,?)";
        $datos = array($id_transaccion, $monto, $estado, $fecha, $direccion, $id_cliente, $proceso, $id_usuario);
        $data = $this->insertar($sql, $datos);
        if ($data > 0) {
            $res = $data;
        } else {
            $res = 0;
        }
        return $res;
    }
    public function getProducto($id_producto)
    {
        $sql = "SELECT * FROM productos WHERE id = $id_producto";
        return $this->select($sql);
    }
    public function registrarDetalle($precio, $cantidad, $id_pedido, $id_producto)
    {
        $sql = "INSERT INTO detalle_pedidos (precio, cantidad, id_pedido, id_producto) VALUES (?,?,?,?)";
        $datos = array($precio, $cantidad, $id_pedido, $id_producto);
        $data = $this->insertar($sql, $datos);
        if ($data > 0) {
            $res = $data;
        } else {
            $res = 0;
        }
        return $res;
    }
    public function getPedidos($id_cliente)
    {
        $sql = "SELECT p.*, c.nombre AS cliente, COALESCE(c.direccion, p.direccion) AS direccion_cliente FROM pedidos p INNER JOIN clientes c ON p.id_cliente = c.id WHERE p.id_cliente = $id_cliente";
        return $this->selectAll($sql);
    }
    public function getPedido($idPedido)
    {
        $sql = "SELECT * FROM pedidos WHERE id = $idPedido";
        return $this->select($sql);
    }
    public function verPedidos($idPedido)
    {
        $sql = "SELECT d.* FROM pedidos p INNER JOIN detalle_pedidos d ON p.id = d.id_pedido WHERE p.id = $idPedido";
        return $this->selectAll($sql);
    }
}
 
?>