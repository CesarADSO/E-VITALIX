function showSection(section) {
    const dashboardSection = document.getElementById('dashboardSection');
    const pacientesSection = document.getElementById('pacientesSection');
    const consultoriosSection = document.getElementById('consultoriosSection');
    const profesionalesSection = document.getElementById('profesionalesSection');
    const perfilSection = document.getElementById('perfilSection');
    const navItems = document.querySelectorAll('.nav-item');

    // Verificar que los elementos existen
    if (!dashboardSection || !pacientesSection || !perfilSection) {
        console.error('Una o más secciones no se encontraron en el DOM');
        return;
    }

    // Ocultar todas las secciones
    dashboardSection.style.display = 'none';
    pacientesSection.style.display = 'none';
    if (consultoriosSection) consultoriosSection.style.display = 'none';
    if (profesionalesSection) profesionalesSection.style.display = 'none';
    perfilSection.style.display = 'none';

    // Remover clase active de todos los nav-items
    navItems.forEach(item => {
        item.classList.remove('active');
    });

    // Mostrar la sección seleccionada
    if (section === 'dashboard') {
        dashboardSection.style.display = 'block';
        if (navItems[0]) navItems[0].classList.add('active');
    } else if (section === 'pacientes') {
        pacientesSection.style.display = 'block';
        if (navItems[1]) navItems[1].classList.add('active');
    } else if (section === 'consultorios') {
        if (consultoriosSection) {
            consultoriosSection.style.display = 'block';
            if (navItems[2]) navItems[2].classList.add('active');
        }
    } else if (section === 'profesionales') {
        if (profesionalesSection) {
            profesionalesSection.style.display = 'block';
            if (navItems[3]) navItems[3].classList.add('active');
        }
    } else if (section === 'perfil') {
        perfilSection.style.display = 'block';
        if (navItems[4]) navItems[4].classList.add('active');
    }
}




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
