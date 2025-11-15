<?php
class PedidosModel extends Query{
 
    public function __construct()
    {
        parent::__construct();
    }
    public function getPedidos($proceso)
    {
        $sql = "SELECT p.id, p.id_transaccion, p.monto, p.estado, p.fecha, p.direccion AS direccion_pedido, p.ciudad, p.id_cliente, p.proceso, p.id_usuario, c.nombre AS cliente, c.correo AS correo, c.direccion AS direccion, u.nombres AS usuario FROM pedidos p INNER JOIN clientes c ON p.id_cliente = c.id LEFT JOIN usuarios u ON p.id_usuario = u.id WHERE p.proceso = $proceso";
        return $this->selectAll($sql);
    }
    public function actualizarEstado($proceso, $idPedido)
    {
        $sql = "UPDATE pedidos SET proceso=? WHERE id = ?";
        $array = array($proceso, $idPedido);
        return $this->save($sql, $array);
    }

    
}
 
?>