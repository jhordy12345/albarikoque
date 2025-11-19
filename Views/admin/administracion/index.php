<?php include_once 'Views/template/header-admin.php'; ?>
<?php
    $totalPedidos = $data['pendientes']['total'] + $data['procesos']['total'] + $data['finalizados']['total'];
    $pendientesPercent = $totalPedidos > 0 ? round(($data['pendientes']['total'] / $totalPedidos) * 100) : 0;
    $procesoPercent = $totalPedidos > 0 ? round(($data['procesos']['total'] / $totalPedidos) * 100) : 0;
    $finalizadosPercent = $totalPedidos > 0 ? round(($data['finalizados']['total'] / $totalPedidos) * 100) : 0;
    $avanceEntrega = $totalPedidos > 0 ? $finalizadosPercent : 0;
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-gradient-primary border-radius-xl shadow-primary">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-white text-sm mb-1">Panel operativo</p>
                        <h4 class="text-white mb-2">Resumen diario del equipo</h4>
                        <p class="text-white text-sm opacity-9 mb-0">Monitorea pedidos e inventario en un solo vistazo y accede rápido a las tareas críticas.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-white text-primary" href="<?php echo BASE_URL . 'pedidos'; ?>"><i class="material-icons opacity-10 me-1">fact_check</i> Revisar pedidos</a>
                        <a class="btn btn-outline-light text-white" href="<?php echo BASE_URL . 'productos'; ?>"><i class="material-icons opacity-10 me-1">inventory_2</i> Inventario</a>
                        <a class="btn btn-outline-light text-white" href="<?php echo BASE_URL . 'reportes'; ?>"><i class="material-icons opacity-10 me-1">insights</i> Reportes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-3 col-sm-6">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-sm text-secondary mb-1">Pedidos pendientes</p>
                        <h4 class="mb-0"><?php echo $data['pendientes']['total']; ?></h4>
                        <p class="text-xs text-danger mb-0">Dar prioridad para liberar capacidad.</p>
                    </div>
                    <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                        <i class="material-icons opacity-10">schedule</i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: <?php echo $pendientesPercent; ?>%;" aria-valuenow="<?php echo $pendientesPercent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="text-xs text-secondary mt-2 mb-0"><?php echo $pendientesPercent; ?>% de los pedidos activos.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-sm text-secondary mb-1">Pedidos en proceso</p>
                        <h4 class="mb-0"><?php echo $data['procesos']['total']; ?></h4>
                        <p class="text-xs text-warning mb-0">Supervisa cuellos de botella.</p>
                    </div>
                    <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                        <i class="material-icons opacity-10">autorenew</i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: <?php echo $procesoPercent; ?>%;" aria-valuenow="<?php echo $procesoPercent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="text-xs text-secondary mt-2 mb-0"><?php echo $procesoPercent; ?>% de los pedidos activos.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-sm text-secondary mb-1">Pedidos finalizados</p>
                        <h4 class="mb-0"><?php echo $data['finalizados']['total']; ?></h4>
                        <p class="text-xs text-success mb-0">Entrega completada.</p>
                    </div>
                    <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                        <i class="material-icons opacity-10">task_alt</i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-gradient-success" role="progressbar" style="width: <?php echo $finalizadosPercent; ?>%;" aria-valuenow="<?php echo $finalizadosPercent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="text-xs text-secondary mt-2 mb-0"><?php echo $finalizadosPercent; ?>% de avance sobre el total.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-sm text-secondary mb-1">Productos activos</p>
                        <h4 class="mb-0"><?php echo $data['productos']['total']; ?></h4>
                        <p class="text-xs text-info mb-0">Controla rotación e inventario mínimo.</p>
                    </div>
                    <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                        <i class="material-icons opacity-10">inventory</i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="text-xs text-secondary mt-2 mb-0">Mantén actualizado el catálogo.</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-5 mb-4 mb-lg-0">
        <div class="card h-100 shadow-sm">
            <div class="card-header pb-0 d-flex align-items-start justify-content-between">
                <div>
                    <p class="text-sm text-secondary mb-1">Distribución de pedidos</p>
                    <h6 class="mb-0">Estado actual</h6>
                </div>
                <span class="badge bg-gradient-success">Avance <?php echo $avanceEntrega; ?>%</span>
            </div>
            <div class="card-body pt-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                    <div>
                        <h4 class="mb-0"><?php echo $totalPedidos; ?></h4>
                        <p class="text-xs text-secondary mb-0">Pedidos</p>
                    </div>
                    <div>
                        <p class="text-xs text-secondary mb-1">Pendientes <?php echo $pendientesPercent; ?>% · En proceso <?php echo $procesoPercent; ?>% · Finalizados <?php echo $finalizadosPercent; ?>%</p>
                    </div>
                </div>
                <div class="chart-container-2 chart-container-equal">
                    <canvas id="reportePedidos"></canvas>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <span class="badge bg-gradient-danger">Pendientes: <?php echo $data['pendientes']['total']; ?></span>
                    <span class="badge bg-gradient-warning">Proceso: <?php echo $data['procesos']['total']; ?></span>
                    <span class="badge bg-gradient-success">Finalizados: <?php echo $data['finalizados']['total']; ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">Productos menos vendidos</h6>
                       
                    </div>
                    <div class="card-body">
                        <div id="menosVendidosResumen" class="d-flex flex-wrap gap-2 mb-3"></div>
                        <div class="chart-container-1 chart-container-equal">
                            <canvas id="chart4"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">Productos más vendidos</h6>
                    
                    </div>
                    <div class="card-body">
                        <p class="text-xs text-secondary mb-2">Utiliza esta vista para anticipar reposiciones y combos.</p>
                        <div class="chart-container-1 chart-container-equal">
                            <canvas id="topProductos"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'Views/template/footer-admin.php'; ?>

<script>
    var ctx = document.getElementById("reportePedidos").getContext('2d');

    var gradientPendientes = ctx.createLinearGradient(0, 0, 400, 0);
    gradientPendientes.addColorStop(0, '#fc1a5b');
    gradientPendientes.addColorStop(1, '#f7b733');

    var gradientProceso = ctx.createLinearGradient(0, 0, 400, 0);
    gradientProceso.addColorStop(0, '#5bfc1a');
    gradientProceso.addColorStop(1, '#8e54e9');

    var gradientFinalizados = ctx.createLinearGradient(0, 0, 400, 0);
    gradientFinalizados.addColorStop(0, '#4a1afc');
    gradientFinalizados.addColorStop(1, '#3bb2b8');

    const pedidosData = [
        <?php echo $data['pendientes']['total']; ?>,
        <?php echo $data['procesos']['total']; ?>,
        <?php echo $data['finalizados']['total']; ?>
    ];

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pendientes', 'En proceso', 'Finalizados'],
            datasets: [{
                label: 'Pedidos',
                backgroundColor: [
                    gradientPendientes,
                    gradientProceso,
                    gradientFinalizados
                ],
                hoverBackgroundColor: [
                    gradientPendientes,
                    gradientProceso,
                    gradientFinalizados
                ],
                data: pedidosData,
                borderWidth: 1,
                barThickness: 24,
            }]
        },
        options: {
            indexAxis: 'y',
            maintainAspectRatio: false,
            scales: {
                x: {
                    ticks: {
                        beginAtZero: true,
                        suggestedMax: Math.max(...pedidosData) + 2
                    },
                    grid: {
                        color: '#f0f1f5'
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.x + ' pedidos';
                        }
                    }
                }
            }
        }
    });
</script>

<script src="<?php echo BASE_URL; ?>assets/js/index.js"></script>
</body>
</html>
