<?php
class Principal extends Controller
{
    public function __construct() {
        parent::__construct();
        session_start();
    }
    //obtener producto a partir de la lista de carrito
    public function listaProductos()
    {
        $datos = file_get_contents('php://input');
        $json = json_decode($datos, true);
        $array['productos'] = array();
        $total = 0.00;
        if (!empty($json)) {
            foreach ($json as $producto) {
                $result = $this->model->getProducto($producto['idProducto']);
                $precioUnitario = round($result['precio'], 2);
                $precioUnitarioDolar = round($precioUnitario / TIPO_CAMBIO, 2);

                $data['id'] = $result['id'];
                $data['nombre'] = $result['nombre'];
                $data['precio'] = number_format($precioUnitario, 2, '.', '');
                $data['precio_dolar'] = number_format($precioUnitarioDolar, 2, '.', '');
                $data['cantidad'] = $producto['cantidad'];
                $data['imagen'] = $result['imagen'];

                $subTotal = round($precioUnitario * $producto['cantidad'], 2);
                $data['subTotal'] = number_format($subTotal, 2, '.', '');

                array_push($array['productos'], $data);
                $total += $subTotal;
            }
        }
        $total = round($total, 2);
        $array['total'] = number_format($total, 2, '.', '');
        $array['totalPaypal'] = number_format(round($total / TIPO_CAMBIO, 2), 2, '.', '');
        $array['moneda'] = MONEDA;
        $array['codigo_moneda'] = COD_MONEDA;
        $array['tipo_cambio'] = TIPO_CAMBIO;
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function busqueda($valor)
    {
        $data = $this->model->getBusqueda($valor);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}