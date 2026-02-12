
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

// SCRIPT DEL DATATABLES
$(document).ready(function () {
    $('.table-pacientes').DataTable({
        "pageLength": 10,
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ registros",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "zeroRecords": "No se encontraron resultados"
        }
    });
});

// JS PARA EL FORMULARIO DEL COMPLETAR PERFIL DEL PACIENTE
document.addEventListener('DOMContentLoaded', function () {
    // Navegación entre pasos
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');
    const steps = document.querySelectorAll('.wizard-step');
    const stepIndicators = document.querySelectorAll('.step');

    nextButtons.forEach(button => {
        button.addEventListener('click', function () {
            const currentStep = document.querySelector('.wizard-step.active');
            const nextStepId = this.getAttribute('data-next');
            const nextStep = document.getElementById('step' + nextStepId);

            // Actualizar indicadores de progreso
            updateStepIndicators(nextStepId);

            // Cambiar paso
            currentStep.classList.remove('active');
            nextStep.classList.add('active');

            // Si es el último paso, actualizar resumen
            if (nextStepId === '4') {
                updateSummary();
            }
        });
    });

    prevButtons.forEach(button => {
        button.addEventListener('click', function () {
            const currentStep = document.querySelector('.wizard-step.active');
            const prevStepId = this.getAttribute('data-prev');
            const prevStep = document.getElementById('step' + prevStepId);

            // Actualizar indicadores de progreso
            updateStepIndicators(prevStepId);

            // Cambiar paso
            currentStep.classList.remove('active');
            prevStep.classList.add('active');
        });
    });

    function updateStepIndicators(activeStep) {
        stepIndicators.forEach(indicator => {
            indicator.classList.remove('active');
            if (parseInt(indicator.getAttribute('data-step')) <= parseInt(activeStep)) {
                indicator.classList.add('active');
            }
        });
    }

    function updateSummary() {
        // Datos Personales
        document.getElementById('resumen-fecha-nacimiento').textContent =
            document.getElementById('fecha_nacimiento').value || 'No ingresado';

        const generoSelect = document.getElementById('genero');
        document.getElementById('resumen-genero').textContent =
            generoSelect.options[generoSelect.selectedIndex].text || 'No seleccionado';

        document.getElementById('resumen-ciudad').textContent =
            document.getElementById('ciudad').value || 'No ingresado';
        document.getElementById('resumen-direccion').textContent =
            document.getElementById('direccion').value || 'No ingresado';

        // Información Médica
        const epsSelect = document.getElementById('eps');
        document.getElementById('resumen-eps').textContent =
            epsSelect.options[epsSelect.selectedIndex].text || 'No seleccionado';

        const rhSelect = document.getElementById('rh');
        document.getElementById('resumen-rh').textContent =
            rhSelect.options[rhSelect.selectedIndex].text || 'No seleccionado';

        const historial = document.getElementById('historial_medico').value;
        document.getElementById('resumen-historial').textContent =
            historial || 'No ingresado';

        // Contacto de Emergencia
        document.getElementById('resumen-nombre-contacto').textContent =
            document.getElementById('nombre_contacto').value || 'No ingresado';
        document.getElementById('resumen-telefono-contacto').textContent =
            document.getElementById('telefono_contacto').value || 'No ingresado';

        document.getElementById('resumen-direccion-contacto').textContent =
            document.getElementById('direccion_contacto').value || 'No ingresado';
    }
});

// Cerrar modal
const modal = document.getElementById('formularioModal');
modal.hide();