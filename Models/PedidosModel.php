<?php
class PedidosModel extends Query{
 
    public function __construct()
    {
        parent::__construct();
    }
    public function getPedidos($proceso)
    {
        $sql = "SELECT p.id, p.id_transaccion, p.monto, p.estado, p.fecha, p.direccion AS direccion_pedido, p.ciudad, p.id_cliente, p.proceso, p.id_usuario, c.nombre AS cliente, c.correo AS correo, c.direccion AS direccion, u.nombres AS usuario FROM pedidos p INNER JOIN clientes c ON p.id_cliente = c.id LEFT JOIN usuarios u ON p.id_usuario = u.id WHERE p.proceso = $proceso ORDER BY p.fecha DESC";
        return $this->selectAll($sql);
    }
    public function actualizarEstado($proceso, $idPedido, $id_usuario)
    {
        $sql = "UPDATE pedidos SET proceso = ?, id_usuario = COALESCE(?, id_usuario) WHERE id = ?";
        $array = array($proceso, $id_usuario, $idPedido);
        return $this->save($sql, $array);
    }

    public function getPedidoFactura($idPedido)
    {
        $sql = "SELECT p.id, p.id_transaccion, p.monto, p.estado, p.fecha, p.direccion, p.ciudad, p.id_cliente, c.nombre AS cliente, c.correo, COALESCE(c.direccion, p.direccion) AS direccion_cliente FROM pedidos p INNER JOIN clientes c ON p.id_cliente = c.id WHERE p.id = $idPedido";
        return $this->select($sql);
    }

    public function getDetalleFactura($idPedido)
    {
        $sql = "SELECT producto, precio, cantidad FROM detalle_pedidos WHERE id_pedido = $idPedido";
        return $this->selectAll($sql);
    }


}

?>
