<?php
class ReportesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getIngresosPorFecha($desde, $hasta)
    {
        $sql = "SELECT id, id_transaccion, monto, estado, fecha FROM pedidos WHERE DATE(fecha) BETWEEN '$desde' AND '$hasta' AND proceso = 3 ORDER BY fecha DESC";
        return $this->selectAll($sql);
    }

    public function getVentasPorProducto($order = 'ASC', $limit = 5)
    {
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $limit = (int) $limit;
        if ($limit <= 0 || $limit > 20) {
            $limit = 5;
        }

        $sql = "SELECT p.nombre, IFNULL(SUM(d.cantidad), 0) AS total_vendidos "
            . "FROM productos p "
            . "LEFT JOIN detalle_pedidos d ON p.id = d.id_producto "
            . "WHERE p.estado = 1 "
            . "GROUP BY p.id "
            . "ORDER BY total_vendidos $order, p.nombre ASC "
            . "LIMIT $limit";
        return $this->selectAll($sql);
    }
}
