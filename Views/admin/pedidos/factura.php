<?php
$pedido = isset($data['pedido']) ? $data['pedido'] : array();
$productos = isset($data['productos']) ? $data['productos'] : array();
$moneda = isset($data['moneda']) ? $data['moneda'] : '';
$fecha = isset($pedido['fecha']) && !empty($pedido['fecha']) ? date('d/m/Y H:i:s', strtotime($pedido['fecha'])) : '';
$total = 0;
$estadoProceso = isset($pedido['estado_proceso']) ? strtoupper($pedido['estado_proceso']) : '';
$estadoPago = isset($pedido['estado']) ? strtoupper($pedido['estado']) : '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - <?php echo TITLE; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .invoice-container {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        @media print {
            body {
                background-color: #ffffff;
            }

            .d-print-none {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <div class="invoice-container">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2 class="mb-1">Factura</h2>
                    <p class="text-muted mb-0">Emitida por <?php echo TITLE; ?></p>
                </div>
                <div class="text-end">
                    <?php if (!empty($pedido['id_transaccion'])) : ?>
                        <p class="mb-0"><strong>Transacción:</strong> <?php echo $pedido['id_transaccion']; ?></p>
                    <?php endif; ?>
                    <?php if (!empty($pedido['id'])) : ?>
                        <p class="mb-0"><strong>Pedido:</strong> #<?php echo $pedido['id']; ?></p>
                    <?php endif; ?>
                    <?php if (!empty($fecha)) : ?>
                        <p class="mb-0"><strong>Fecha:</strong> <?php echo $fecha; ?></p>
                    <?php endif; ?>
                    <?php if (!empty($estadoProceso)) : ?>
                        <p class="mb-0"><strong>Estado del pedido:</strong> <?php echo $estadoProceso; ?></p>
                    <?php endif; ?>
                    <?php if (!empty($estadoPago)) : ?>
                        <p class="mb-0"><strong>Estado del pago:</strong> <?php echo $estadoPago; ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="text-uppercase text-muted">Cliente</h6>
                    <p class="mb-1"><strong><?php echo isset($pedido['cliente']) ? $pedido['cliente'] : 'Cliente'; ?></strong></p>
                    <?php if (!empty($pedido['correo'])) : ?>
                        <p class="mb-0">Correo: <?php echo $pedido['correo']; ?></p>
                    <?php endif; ?>
                    <?php if (!empty($pedido['direccion_cliente'])) : ?>
                        <p class="mb-0">Dirección: <?php echo $pedido['direccion_cliente']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6 class="text-uppercase text-muted">Resumen</h6>
                    <?php if (!empty($pedido['monto'])) : ?>
                        <?php $montoPedido = round((float) $pedido['monto'], 2); ?>
                        <p class="mb-0"><strong>Total registrado:</strong> <?php echo $moneda . ' ' . number_format($montoPedido, 2, '.', ''); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="table-responsive mb-3">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-end">Precio</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($productos)) : ?>
                            <?php foreach ($productos as $producto) : ?>
                                <?php
                                $precio = isset($producto['precio']) ? round((float) $producto['precio'], 2) : 0;
                                $cantidad = isset($producto['cantidad']) ? (int) $producto['cantidad'] : 0;
                                $subtotal = round($precio * $cantidad, 2);
                                $total = round($total + $subtotal, 2);
                                ?>
                                <tr>
                                    <td><?php echo isset($producto['producto']) ? $producto['producto'] : ''; ?></td>
                                    <td class="text-end"><?php echo $moneda . ' ' . number_format($precio, 2, '.', ''); ?></td>
                                    <td class="text-center"><?php echo $cantidad; ?></td>
                                    <td class="text-end"><?php echo $moneda . ' ' . number_format($subtotal, 2, '.', ''); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay productos registrados para este pedido.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th class="text-end"><?php echo $moneda . ' ' . number_format(round($total, 2), 2, '.', ''); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0 text-muted">Gracias por su compra.</p>
                <button class="btn btn-primary d-print-none" type="button" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Imprimir
                </button>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/4f3ce16e3e.js" crossorigin="anonymous"></script>
</body>

</html>
