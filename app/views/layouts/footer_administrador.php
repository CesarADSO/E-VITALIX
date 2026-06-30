<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
<script src="<?= BASE_URL ?>/public/assets/dashboard/js/dashboards.js"></script>
<script src="<?= BASE_URL ?>/public/assets/js/password-toggle.js"></script>

<script>
    function initCharts() {
        // Gráfico de barras mensual
        const ctxMonthly = document.getElementById('monthlyChart');
        // Busca el elemento canvas en el HTML con id "monthlyChart"

        if (ctxMonthly) {
            // Si el elemento existe, continúa (evita errores si no está en la página)

            new Chart(ctxMonthly.getContext('2d'), {
                // Crea un nuevo gráfico en ese elemento
                // getContext('2d') = obtiene el contexto 2D para dibujar

                type: 'bar',
                // Tipo de gráfico: barras

                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    // Labels = etiquetas de los meses en el eje X

                    datasets: [{
                        // datasets = datos que se van a mostrar (pueden ser varios)
                        label: 'Nuevos',
                        // Etiqueta para la leyenda

                        data: [45, 60, 75, 55, 40, 50, 65, 72, 60, 50, 45, 70],
                        // Números que se mostrarán en las barras (0-100 en este caso)

                        backgroundColor: '#007bff',
                        // Color de las barras azul

                        borderRadius: 4,
                        // Radio de las esquinas redondeadas

                        barThickness: 20
                        // Grosor de las barras
                    }, {
                        label: 'Recurrentes',
                        // Segunda serie de datos

                        data: [55, 65, 70, 60, 50, 58, 60, 75, 63, 48, 42, 72],
                        backgroundColor: '#90CAF9',
                        // Color azul más claro

                        borderRadius: 4,
                        barThickness: 20
                    }]
                },
                options: {
                    // Configuraciones adicionales del gráfico
                    responsive: true,
                    // Se adapta al tamaño de la pantalla

                    maintainAspectRatio: false,
                    // No mantiene proporción fija (se estira según el contenedor)

                    plugins: {
                        legend: {
                            display: false
                            // No muestra la leyenda (etiquetas de "Nuevos" y "Recurrentes")
                        }
                    },
                    scales: {
                        // Configurar los ejes X e Y
                        y: {
                            beginAtZero: true,
                            // El eje Y comienza en 0

                            grid: {
                                display: true,
                                // Muestra las líneas de la cuadrícula

                                color: '#f0f0f0'
                                // Color gris claro
                            },
                            ticks: {
                                stepSize: 20
                                // Las marcas del eje van de 20 en 20 (0, 20, 40, 60...)
                            }
                        },
                        x: {
                            grid: {
                                display: false
                                // No muestra líneas de cuadrícula en el eje X
                            }
                        }
                    }
                }
            });
        }

        // Gráfico de dona
        const ctxDonut = document.getElementById('donutChart');
        // Busca el elemento canvas con id "donutChart"

        if (ctxDonut) {
            new Chart(ctxDonut.getContext('2d'), {
                type: 'doughnut',
                // Tipo gráfico: dona (anillo)

                data: {
                    labels: ['Exitosas', 'Canceladas'],
                    // Las dos categorías a mostrar

                    datasets: [{
                        data: [65, 35],
                        // 65% Exitosas, 35% Canceladas

                        backgroundColor: ['#007bff', '#90CAF9'],
                        // Colores: azul fuerte y azul claro

                        borderWidth: 0
                        // Sin borde entre los colores
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '70%',
                    // Tamaño del agujero central (70% del radio total)

                    plugins: {
                        legend: {
                            display: false
                            // No muestra leyenda
                        },
                        tooltip: {
                            enabled: true
                            // Muestra información al pasar el ratón
                        }
                    }
                }
            });
        }

    }

    // 2. EL DISPARADOR (Esto va FUERA de la función)
    document.addEventListener('DOMContentLoaded', function() {
        initCharts();
    });
</script>
</body>

</html>