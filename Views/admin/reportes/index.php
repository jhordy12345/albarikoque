<?php include_once 'Views/template/header-admin.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <h6 class="mb-0">Reporte de ingresos</h6>
                <p class="text-sm mb-0">Genera el total de ingresos por pedidos finalizados en un rango de fechas.</p>
            </div>
            <div class="card-body">
                <form class="row g-3" id="formReporte">
                    <div class="col-sm-6 col-lg-4">
                        <label style="color: #000" for="desde" class="form-label">Fecha inicial</label>
                        <input type="date" id="desde" name="desde" class="form-control" required>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <label style="color: #000" for="hasta" class="form-label">Fecha final</label>
                        <input type="date" id="hasta" name="hasta" class="form-control" required>
                    </div>
                    <div class="col-12 col-lg-4 d-flex align-items-end">
                        <button class="btn btn-primary w-100" type="button" id="btnGenerar">
                            <i class="fas fa-file-alt me-2"></i>Generar reporte
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <h6 class="mb-0">Ingresos por pedidos finalizados</h6>
                <div class="badge bg-gradient-success fs-6">
                    Total: <span id="totalIngresos"><?php echo MONEDA; ?> 0.00</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle" style="width: 100%;" id="tblIngresos">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Id Transacción</th>
                                <th>Monto</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'Views/template/footer-admin.php'; ?>

<script src="<?php echo BASE_URL . 'assets/js/modulos/reportes.js'; ?>"></script>

</body>

</html>
