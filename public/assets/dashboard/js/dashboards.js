



// ==================== INICIALIZACIÓN DE GRÁFICOS ====================

function initCharts() {
    // Gráfico de barras mensual
    const ctxMonthly = document.getElementById('monthlyChart');
    if (ctxMonthly) {
        new Chart(ctxMonthly.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Nuevos',
                    data: [45, 60, 75, 55, 40, 50, 65, 72, 60, 50, 45, 70],
                    backgroundColor: '#007bff',
                    borderRadius: 4,
                    barThickness: 20
                }, {
                    label: 'Recurrentes',
                    data: [55, 65, 70, 60, 50, 58, 60, 75, 63, 48, 42, 72],
                    backgroundColor: '#90CAF9',
                    borderRadius: 4,
                    barThickness: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: '#f0f0f0'
                        },
                        ticks: {
                            stepSize: 20
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Gráfico de dona
    const ctxDonut = document.getElementById('donutChart');
    if (ctxDonut) {
        new Chart(ctxDonut.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Exitosas', 'Canceladas'],
                datasets: [{
                    data: [65, 35],
                    backgroundColor: ['#007bff', '#90CAF9'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    }
}

