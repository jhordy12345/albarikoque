<?php
class Reportes extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['nombre_usuario'])) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
        verificarUsuarioActivo();
    }

    public function index()
    {
        $data['title'] = 'reportes';
        $this->views->getView('admin/reportes', "index", $data);
    }

    public function ingresos()
    {
        if (empty($_POST['desde']) || empty($_POST['hasta'])) {
            $respuesta = array('msg' => 'el rango de fechas es obligatorio', 'icono' => 'warning');
            echo json_encode($respuesta);
            die();
        }

        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];

        if (!$this->esFechaValida($desde) || !$this->esFechaValida($hasta)) {
            $respuesta = array('msg' => 'las fechas no son válidas', 'icono' => 'warning');
            echo json_encode($respuesta);
            die();
        }

        if ($desde > $hasta) {
            $respuesta = array('msg' => 'la fecha inicial no puede ser mayor a la final', 'icono' => 'warning');
            echo json_encode($respuesta);
            die();
        }

        $ingresos = $this->model->getIngresosPorFecha($desde, $hasta);
        $total = 0;

        for ($i = 0; $i < count($ingresos); $i++) {
            $monto = isset($ingresos[$i]['monto']) ? (float) $ingresos[$i]['monto'] : 0;
            $total += $monto;
            $ingresos[$i]['monto_formateado'] = MONEDA . ' ' . number_format($monto, 2);
            $ingresos[$i]['fecha_formateada'] = !empty($ingresos[$i]['fecha']) ? date('d/m/Y', strtotime($ingresos[$i]['fecha'])) : '';
        }

        $respuesta = array(
            'detalle' => $ingresos,
            'total' => $total,
            'total_formateado' => MONEDA . ' ' . number_format($total, 2)
        );
        echo json_encode($respuesta);
        die();
    }

    private function esFechaValida($fecha)
    {
        $date = DateTime::createFromFormat('Y-m-d', $fecha);
        return $date && $date->format('Y-m-d') === $fecha;
    }
}
