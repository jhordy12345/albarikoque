let chartMenosVendidos;
let chartMasVendidos;

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

    inicializarGraficosVentas();
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

function inicializarGraficosVentas() {
    cargarGraficoVentas({
        orden: 'asc',
        canvasId: 'chartMenosVendidos',
        resumenId: 'resumenMenosVendidos',
        referencia: 'chartMenosVendidos'
    });
    cargarGraficoVentas({
        orden: 'desc',
        canvasId: 'chartMasVendidos',
        resumenId: 'resumenMasVendidos',
        referencia: 'chartMasVendidos'
    });
}

function cargarGraficoVentas({ orden, canvasId, resumenId, referencia }) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) {
        return;
    }

    const url = `${base_url}reportes/estadisticasProductos?orden=${orden}&limite=5`;

    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            const productos = (data && data.productos) ? data.productos : [];
            const labels = productos.map((producto) => producto.nombre);
            const cantidades = productos.map((producto) => Number(producto.total_vendidos));

            actualizarResumenVentas(resumenId, productos);

            const ctx = canvas.getContext('2d');
            const colores = generarGradientes(ctx, labels.length);

            if (referencia === 'chartMenosVendidos' && chartMenosVendidos) {
                chartMenosVendidos.destroy();
            }
            if (referencia === 'chartMasVendidos' && chartMasVendidos) {
                chartMasVendidos.destroy();
            }

            const chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Unidades vendidas',
                        backgroundColor: colores,
                        hoverBackgroundColor: colores,
                        data: cantidades,
                        borderWidth: 1,
                        barThickness: 18,
                    }],
                },
                options: {
                    indexAxis: 'y',
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            display: false,
                        },
                        tooltip: {
                            enabled: true,
                            displayColors: true,
                        },
                    },
                    scales: {
                        x: {
                            ticks: {
                                beginAtZero: true,
                            },
                            grid: {
                                color: '#f0f1f5',
                            },
                        },
                        y: {
                            grid: {
                                display: false,
                            },
                        },
                    },
                },
            });

            if (referencia === 'chartMenosVendidos') {
                chartMenosVendidos = chartInstance;
            } else {
                chartMasVendidos = chartInstance;
            }
        })
        .catch(() => {
            actualizarResumenVentas(resumenId, []);
        });
}

function actualizarResumenVentas(resumenId, productos) {
    const resumen = document.getElementById(resumenId);
    if (!resumen) {
        return;
    }
    resumen.innerHTML = '';

    if (!productos.length) {
        const mensaje = document.createElement('span');
        mensaje.className = 'text-muted small';
        mensaje.textContent = 'No hay datos para mostrar en este momento';
        resumen.appendChild(mensaje);
        return;
    }

    const palette = ['#ee0979', '#ff6a00', '#118ab2', '#06d6a0', '#7f00ff'];
    productos.forEach((producto, index) => {
        const badge = document.createElement('span');
        badge.className = 'badge text-white';
        badge.style.backgroundColor = palette[index % palette.length];
        badge.textContent = `${producto.nombre} (${producto.total_vendidos})`;
        resumen.appendChild(badge);
    });
}

function generarGradientes(ctx, cantidad) {
    const degradadosBase = [
        ['#ff6a00', '#ffd166'],
        ['#118ab2', '#06d6a0'],
        ['#7f00ff', '#ef476f'],
        ['#2193b0', '#6dd5ed'],
        ['#FDC830', '#F37335'],
    ];

    return Array.from({ length: cantidad }).map((_, index) => {
        const colores = degradadosBase[index % degradadosBase.length];
        const gradient = ctx.createLinearGradient(0, 0, 400, 0);
        gradient.addColorStop(0, colores[0]);
        gradient.addColorStop(1, colores[1]);
        return gradient;
    });
}
