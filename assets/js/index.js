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
            const productosOrdenados = [...productos].sort((a, b) => Number(a.cantidad) - Number(b.cantidad));
            const labels = productosOrdenados.map((producto) => producto.nombre);
            const cantidades = productosOrdenados.map((producto) => Number(producto.cantidad));

            const coloresDestacados = ["#ee0979", "#ff6a00", "#7f00ff"];
            const colorNeutro = "rgba(99, 115, 129, 0.35)";
            const colores = productosOrdenados.map((_, index) => index < 3 ? coloresDestacados[index] : colorNeutro);
            const offsets = productosOrdenados.map((_, index) => index < 3 ? 12 : 0);

            var ctx = document.getElementById("chart4").getContext("2d");
            new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Productos menos vendidos",
                        backgroundColor: colores,
                        hoverBackgroundColor: colores,
                        data: cantidades,
                        borderWidth: 1,
                        offset: offsets,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    rotation: -0.5 * Math.PI,
                    plugins: {
                        legend: {
                            display: true,
                            position: "top",
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
