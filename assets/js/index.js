productosMinimos();
topProductos();

function productosMinimos() {
    const url = base_url + "admin/productosMinimos";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            const productos = res.productos || [];
            const totalRegistrados = res.registrados ? Number(res.registrados.total) : 0;
            const nombre = [];
            const cantidad = [];
            for (let i = 0; i < productos.length; i++) {
                nombre.push(productos[i]['nombre']);
                cantidad.push(Number(productos[i]['cantidad']));
            }

            const minComprados = cantidad.length > 0 ? Math.min(...cantidad) : 0;
            const colores = cantidad.map((valor) => {
                return valor === minComprados
                    ? "rgba(238, 9, 121, 0.8)"
                    : "rgba(40, 60, 134, 0.8)";
            });

            var ctx = document.getElementById("chart4").getContext("2d");
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: nombre,
                    datasets: [{
                        label: "Cantidad comprada",
                        backgroundColor: colores,
                        hoverBackgroundColor: colores,
                        data: cantidad,
                        borderWidth: 1,
                    }],
                },
                options: {
                    indexAxis: "y",
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: `Productos registrados: ${totalRegistrados}`,
                            align: "start",
                        },
                        tooltip: {
                            displayColors: true,
                        },
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                            },
                        },
                        y: {
                            ticks: {
                                autoSkip: false,
                            },
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
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            let nombre = [];
            let cantidad = [];
            for (let i = 0; i < res.length; i++) {
                nombre.push(res[i]['producto']);
                cantidad.push(Number(res[i]['total']));
            }

            var ctx = document.getElementById("topProductos").getContext("2d");

            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, "#ee0979");
            gradientStroke1.addColorStop(1, "#ff6a00");

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, "#283c86");
            gradientStroke2.addColorStop(1, "#39bd3c");

            var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke3.addColorStop(0, "#7f00ff");
            gradientStroke3.addColorStop(1, "#e100ff");

            var myChart = new Chart(ctx, {
                type: "pie",
                data: {
                    labels: nombre,
                    datasets: [{
                        backgroundColor: [
                            gradientStroke1,
                            gradientStroke2,
                            gradientStroke3,
                        ],

                        hoverBackgroundColor: [
                            gradientStroke1,
                            gradientStroke2,
                            gradientStroke3,
                        ],

                        data: cantidad,
                        borderWidth: [1, 1, 1],
                    }, ],
                },
                options: {
                    maintainAspectRatio: false,
                    cutoutPercentage: 0,
                    legend: {
                        position: "bottom",
                        display: false,
                        labels: {
                            boxWidth: 8,
                        },
                    },
                    tooltips: {
                        displayColors: false,
                    },
                },
            });
        }
    };
}
