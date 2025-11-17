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
}
