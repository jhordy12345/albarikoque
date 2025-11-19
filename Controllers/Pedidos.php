<?php
class Pedidos extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $isAdmin = !empty($_SESSION['nombre_usuario']);
        $isClient = !empty($_SESSION['idCliente']);

        $segmentos = isset($_GET['url']) ? explode('/', $_GET['url']) : [];
        $metodoActual = $segmentos[1] ?? 'index';
        if (empty($metodoActual)) {
            $metodoActual = 'index';
        }

        $clientePuedeImprimir = ($metodoActual === 'imprimir' && $isClient);

        if (!$isAdmin && !$clientePuedeImprimir) {
            header('Location: '. BASE_URL . 'admin');
            exit;
        }

        if ($isAdmin) {
            verificarUsuarioActivo();
        }
    }
    public function index()
    {
        $data['title'] = 'pedidos';
        $this->views->getView('admin/pedidos', "index", $data);
    }
    public function listarPedidos()
    {
        $data = $this->model->getPedidos(1);
        $data = $this->prepararPedidos($data);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['accion'] = '<div class="d-flex gap-2">
            <button class="btn btn-success" type="button" onclick="verPedido(' . $data[$i]['id'] . ')"><i class="fas fa-eye"></i></button>
            <button class="btn btn-secondary" type="button" onclick="imprimirPedido(' . $data[$i]['id'] . ')"><i class="fas fa-print"></i></button>
            <button class="btn btn-info" type="button" onclick="cambiarProceso(' . $data[$i]['id'] . ', 2)"><i class="fas fa-check-circle"></i></button>
        </div>';
        }
        echo json_encode($data);
        die();
    }
    public function listarProceso()
    {
        $data = $this->model->getPedidos(2);
        $data = $this->prepararPedidos($data);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['accion'] = '<div class="d-flex gap-2">
            <button class="btn btn-success" type="button" onclick="verPedido(' . $data[$i]['id'] . ')"><i class="fas fa-eye"></i></button>
            <button class="btn btn-secondary" type="button" onclick="imprimirPedido(' . $data[$i]['id'] . ')"><i class="fas fa-print"></i></button>
            <button class="btn btn-info" type="button" onclick="cambiarProceso(' . $data[$i]['id'] . ', 3)"><i class="fas fa-check-circle"></i></button>
        </div>';
        }
        echo json_encode($data);
        die();
    }
    public function listarFinalizados()
    {
        $data = $this->model->getPedidos(3);
        $data = $this->prepararPedidos($data);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['accion'] = '<div class="d-flex gap-2">
            <button class="btn btn-success" type="button" onclick="verPedido(' . $data[$i]['id'] . ')"><i class="fas fa-eye"></i></button>
            <button class="btn btn-secondary" type="button" onclick="imprimirPedido(' . $data[$i]['id'] . ')"><i class="fas fa-print"></i></button>
        </div>';
        }
        echo json_encode($data);
        die();
    }
    private function prepararPedidos(array $data)
    {
        for ($i = 0; $i < count($data); $i++) {
            if (!empty($data[$i]['fecha'])) {
                $data[$i]['fecha'] = date('d/m/Y H:i:s', strtotime($data[$i]['fecha']));
            }
            $data[$i]['usuario'] = !empty($data[$i]['usuario']) ? $data[$i]['usuario'] : 'Sin asignar';
            $data[$i]['estado'] = $this->obtenerTextoEstado($data[$i]['proceso']);
            if (isset($data[$i]['monto'])) {
                $monto = round((float) $data[$i]['monto'], 2);
                $data[$i]['monto'] = MONEDA . ' ' . number_format($monto, 2, '.', '');
            }
        }
        return $data;
    }

    private function obtenerTextoEstado($proceso)
    {
        switch ((int)$proceso) {
            case 2:
                return '<span class="badge bg-warning">En proceso</span>';
            case 3:
                return '<span class="badge bg-success">Finalizado</span>';
            default:
                return '<span class="badge bg-primary">Pendiente</span>';
        }
    }
    public function update($datos)
    {
        $array = explode(',', $datos);
        $idPedido = $array[0];
        $proceso = $array[1];
        if (is_numeric($idPedido)) {
            $idUsuario = $this->obtenerIdUsuarioActual();
            $data = $this->model->actualizarEstado($proceso, $idPedido, $idUsuario);
            if ($data == 1) {
                $respuesta = array('msg' => 'pedido actualizado', 'icono' => 'success');
            } else {
                $respuesta = array('msg' => 'error al actualizar', 'icono' => 'error');
            }
            echo json_encode($respuesta);
        }
        die();
    }

    private function obtenerIdUsuarioActual()
    {
        if (!empty($_SESSION['email'])) {
            $usuario = $this->model->getUsuarioPorCorreo($_SESSION['email']);
            if (!empty($usuario) && isset($usuario['id'])) {
                return (int) $usuario['id'];
            }
        }
        return 1;
    }
    public function imprimir($idPedido)
    {
        if (!is_numeric($idPedido)) {
            echo 'Pedido no válido';
            die();
        }
        $pedido = $this->model->getPedidoFactura($idPedido);
        if (empty($pedido)) {
            echo 'Pedido no encontrado';
            die();
        }
        if (!empty($_SESSION['idCliente']) && $pedido['id_cliente'] != $_SESSION['idCliente']) {
            echo 'No tiene permiso para imprimir este pedido';
            die();
        }
        $pedido['estado_proceso'] = $this->obtenerNombreProceso($pedido['proceso'] ?? 1);
        $data['pedido'] = $pedido;
        $data['productos'] = $this->model->getDetalleFactura($idPedido);
        $data['moneda'] = MONEDA;
        $this->views->getView('admin/pedidos', "factura", $data);
    }

    private function obtenerNombreProceso($proceso)
    {
        switch ((int)$proceso) {
            case 2:
                return 'En proceso';
            case 3:
                return 'Finalizado';
            default:
                return 'Pendiente';
        }
    }

}
