document.addEventListener('DOMContentLoaded', function() {
    const inputDesde = document.querySelector('#desde');
    const inputHasta = document.querySelector('#hasta');
    const totalIngresos = document.querySelector('#totalIngresos');
    const btnGenerar = document.querySelector('#btnGenerar');

    const hoy = new Date();
    const primerDia = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
    inputDesde.value = primerDia.toISOString().slice(0, 10);
    inputHasta.value = hoy.toISOString().slice(0, 10);

    let tblIngresos = $('#tblIngresos').DataTable({
        data: [],
        columns: [
            { data: 'id' },
            { data: 'id_transaccion' },
            { data: 'monto_formateado' },
            { data: 'estado' },
            { data: 'fecha_formateada' }
        ],
        language,
        dom,
        buttons
    });

    btnGenerar.addEventListener('click', function() {
        generarIngresos(inputDesde.value, inputHasta.value, tblIngresos, totalIngresos);
    });
});

function generarIngresos(desde, hasta, tabla, totalElemento) {
    if (desde === '' || hasta === '') {
        Swal.fire('Aviso', 'Seleccione ambas fechas para generar el reporte', 'warning');
        return;
    }

    const url = base_url + 'reportes/ingresos';
    const formData = new FormData();
    formData.append('desde', desde);
    formData.append('hasta', hasta);

    fetch(url, { method: 'POST', body: formData })
        .then((response) => response.json())
        .then((data) => {
            if (data.icono) {
                Swal.fire('Aviso', data.msg, data.icono);
                return;
            }
            tabla.clear();
            tabla.rows.add(data.detalle || []);
            tabla.draw();
            totalElemento.textContent = data.total_formateado || '';
        })
        .catch(() => {
            Swal.fire('Error', 'No se pudo generar el reporte de ingresos', 'error');
        });
}
