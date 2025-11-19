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

            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, "#ff6a00");
            gradientStroke1.addColorStop(1, "#ffd166");

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, "#118ab2");
            gradientStroke2.addColorStop(1, "#06d6a0");

            var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke3.addColorStop(0, "#7f00ff");
            gradientStroke3.addColorStop(1, "#ef476f");

            new Chart(ctx, {
                type: "pie",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Productos menos vendidos",
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
                        data: cantidades,
                        borderWidth: [1, 1, 1],
                    }],
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
