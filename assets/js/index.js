productosMinimos();
topProductos();

function productosMinimos() {
    const url = base_url + "admin/productosMinimos";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            const productos = res.productos || [];
            const productosOrdenados = [...productos].sort((a, b) => Number(a.cantidad) - Number(b.cantidad));
            const productosDestacados = productosOrdenados.slice(0, 3);
            const labels = productosDestacados.map((producto) => producto.nombre);
            const cantidades = productosDestacados.map((producto) => Number(producto.cantidad));

            const resumen = document.querySelector('#menosVendidosResumen');
            if (resumen) {
                resumen.innerHTML = '';
                productosDestacados.forEach((producto, index) => {
                    const badge = document.createElement('span');
                    badge.className = 'badge text-white';
                    badge.style.backgroundColor = ['#ee0979', '#ff6a00', '#7f00ff'][index];
                    badge.textContent = `${producto.nombre} (${producto.cantidad})`;
                    resumen.appendChild(badge);
                });
            }

            var ctx = document.getElementById("chart4").getContext("2d");

            var gradientStroke1 = ctx.createLinearGradient(0, 0, 400, 0);
            gradientStroke1.addColorStop(0, "#ff6a00");
            gradientStroke1.addColorStop(1, "#ffd166");

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 400, 0);
            gradientStroke2.addColorStop(0, "#118ab2");
            gradientStroke2.addColorStop(1, "#06d6a0");

            var gradientStroke3 = ctx.createLinearGradient(0, 0, 400, 0);
            gradientStroke3.addColorStop(0, "#7f00ff");
            gradientStroke3.addColorStop(1, "#ef476f");

            const coloresBase = [gradientStroke1, gradientStroke2, gradientStroke3];
            const colores = coloresBase.slice(0, labels.length);

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Unidades en stock",
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
                            position: "bottom",
                            display: false,
                            labels: {
                                boxWidth: 8,
                            },
                        },
                        tooltip: {
                            enabled: true,
                            displayColors: true,
                        },
                    },
                    scales: {
                        x: {
                            ticks: {
                                beginAtZero: true
                            },
                            grid: {
                                color: "#f0f1f5",
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        },
                    },
                },
            });
        }
    };
}


function topProductos() {
    const url = base_url + "admin/topProductos";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText) || [];
            const topVendidos = Array.isArray(res) ? res.slice(0, 3) : [];

            const nombre = topVendidos.map(item => item['producto']);
            const cantidad = topVendidos.map(item => Number(item['total']));

            const resumen = document.querySelector('#topVendidosResumen');
            if (resumen) {
                const coloresResumen = ['#ee0979', '#283c86', '#7f00ff'];
                resumen.innerHTML = '';
                topVendidos.forEach((producto, index) => {
                    const badge = document.createElement('span');
                    badge.className = 'badge text-white';
                    badge.style.backgroundColor = coloresResumen[index];
                    badge.textContent = `${producto.producto} (${producto.total})`;
                    resumen.appendChild(badge);
                });
            }

            var ctx = document.getElementById("topProductos").getContext("2d");

            var gradientStroke1 = ctx.createLinearGradient(0, 0, 400, 0);
            gradientStroke1.addColorStop(0, "#ee0979");
            gradientStroke1.addColorStop(1, "#ff6a00");

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 400, 0);
            gradientStroke2.addColorStop(0, "#283c86");
            gradientStroke2.addColorStop(1, "#39bd3c");

            var gradientStroke3 = ctx.createLinearGradient(0, 0, 400, 0);
            gradientStroke3.addColorStop(0, "#7f00ff");
            gradientStroke3.addColorStop(1, "#e100ff");

            const palette = [gradientStroke1, gradientStroke2, gradientStroke3];
            const colores = nombre.map((_, index) => palette[index % palette.length]);

            var myChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: nombre,
                    datasets: [{
                        label: "Ventas totales",
                        backgroundColor: colores,
                        hoverBackgroundColor: colores,
                        data: cantidad,
                        borderWidth: 1,
                        barThickness: 18,
                    }],
                },
                options: {
                    indexAxis: 'y',
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "bottom",
                            display: false,
                            labels: {
                                boxWidth: 8,
                            },
                        },
                        tooltip: {
                            enabled: true,
                            displayColors: true,
                        },
                    },
                    scales: {
                        x: {
                            ticks: {
                                beginAtZero: true
                            },
                            grid: {
                                color: "#f0f1f5",
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        },
                    },
                },
            });
        }
    };
}
