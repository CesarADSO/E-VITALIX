
// ==================== INICIALIZACIÓN DE GRÁFICOS ====================
// Esta función crea dos gráficos usando la librería Chart.js

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

// ==================== SCRIPT DEL DATATABLES ====================
// DataTables es una librería que hace que las tablas sean interactivas (búsqueda, paginación, etc.)

$(document).ready(function () {
    // $(document).ready() = Espera a que jQuery esté listo
    // Dentro va el código que depende de jQuery
    
    $('.table-pacientes').DataTable({
        // Selecciona la tabla con clase "table-pacientes"
        // DataTable() = la convierte en una tabla interactiva
        
        "pageLength": 10,
        // Muestra 10 filas por página
        
        "language": {
            // Configuración de textos en español
            
            "search": "Buscar:",
            // Etiqueta del campo de búsqueda
            
            "lengthMenu": "Mostrar _MENU_ registros",
            // _MENU_ se reemplaza con opciones como 10, 25, 50, etc.
            
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            // _START_ = primer registro, _END_ = último, _TOTAL_ = total
            // Ejemplo: "Mostrando 1 a 10 de 100 registros"
            
            "paginate": {
                // Configuración de botones de paginación
                
                "next": "Siguiente",
                // Botón para ir a la siguiente página
                
                "previous": "Anterior"
                // Botón para ir a la página anterior
            },
            "zeroRecords": "No se encontraron resultados"
            // Mensaje cuando no hay registros que coincidan con la búsqueda
        }
    });
});

// ==================== FORMULARIO MULTISECCIÓN DEL PERFIL DEL PACIENTE ====================
// Este es un formulario "wizard" con múltiples pasos/secciones que se completan secuencialmente

document.addEventListener('DOMContentLoaded', function () {
    // DOMContentLoaded = Espera a que todo el HTML cargue antes de ejecutar este código
    
    // Navegación entre pasos
    const nextButtons = document.querySelectorAll('.next-step');
    // Busca todos los botones con clase "next-step" (botones para ir al siguiente paso)
    
    const prevButtons = document.querySelectorAll('.prev-step');
    // Busca todos los botones con clase "prev-step" (botones para ir atrás)
    
    const steps = document.querySelectorAll('.wizard-step');
    // Busca todos los div con clase "wizard-step" (cada paso/sección del formulario)
    
    const stepIndicators = document.querySelectorAll('.step');
    // Busca los indicadores visuales (puntos o números que muestran el progreso)

    // ========== BOTONES PARA IR AL SIGUIENTE PASO ==========
    nextButtons.forEach(button => {
        // Por cada botón "Siguiente"...
        
        button.addEventListener('click', function () {
            // Cuando se haga clic...
            
            const currentStep = document.querySelector('.wizard-step.active');
            // Obtén el paso que está actualmente visible (con clase "active")
            
            const nextStepId = this.getAttribute('data-next');
            // Lee el atributo data-next del botón (ej: data-next="2" significa ir al paso 2)
            
            const nextStep = document.getElementById('step' + nextStepId);
            // Obtén el elemento HTML del siguiente paso (ej: id="step2")

            // Actualizar indicadores de progreso
            updateStepIndicators(nextStepId);
            // Llama a la función que resalta los puntos de progreso

            // Cambiar paso
            currentStep.classList.remove('active');
            // Oculta el paso actual removiendo la clase "active"
            
            nextStep.classList.add('active');
            // Muestra el siguiente paso agregando la clase "active"

            // Si es el último paso, actualizar resumen
            if (nextStepId === '4') {
                // Si es el paso 4 (el último)...
                
                updateSummary();
                // Llama a la función que llena el resumen con todos los datos
            }
        });
    });

    // ========== BOTONES PARA IR AL PASO ANTERIOR ==========
    prevButtons.forEach(button => {
        // Por cada botón "Anterior"...
        
        button.addEventListener('click', function () {
            // Cuando se haga clic...
            
            const currentStep = document.querySelector('.wizard-step.active');
            // Obtén el paso actual
            
            const prevStepId = this.getAttribute('data-prev');
            // Lee el atributo data-prev del botón (ej: data-prev="1")
            
            const prevStep = document.getElementById('step' + prevStepId);
            // Obtén el elemento HTML del paso anterior

            // Actualizar indicadores de progreso
            updateStepIndicators(prevStepId);
            // Resalta los puntos hasta el paso anterior

            // Cambiar paso
            currentStep.classList.remove('active');
            // Oculta el paso actual
            
            prevStep.classList.add('active');
            // Muestra el paso anterior
        });
    });

    // ========== FUNCIÓN: ACTUALIZAR INDICADORES DE PROGRESO ==========
    function updateStepIndicators(activeStep) {
        // activeStep = número del paso que está activo
        
        stepIndicators.forEach(indicator => {
            // Por cada indicador (punto/número del progreso)...
            
            indicator.classList.remove('active');
            // Primero remueve la clase "active" de todos
            
            if (parseInt(indicator.getAttribute('data-step')) <= parseInt(activeStep)) {
                // Si el indicador es menor o igual al paso actual...
                
                indicator.classList.add('active');
                // Agrega la clase "active" (esto lo resalta visualmente)
            }
        });
    }

    // ========== FUNCIÓN: LLENAR EL RESUMEN FINAL ==========
    function updateSummary() {
        // Esta función se ejecuta en el último paso para mostrar un resumen de todo lo llenado
        
        // ===== DATOS PERSONALES =====
        document.getElementById('resumen-fecha-nacimiento').textContent =
            document.getElementById('fecha_nacimiento').value || 'No ingresado';
        // Toma la fecha del campo "fecha_nacimiento" y la pone en el resumen
        // || 'No ingresado' = Si está vacío, muestra "No ingresado"

        const generoSelect = document.getElementById('genero');
        // Obtén el select de género
        
        document.getElementById('resumen-genero').textContent =
            generoSelect.options[generoSelect.selectedIndex].text || 'No seleccionado';
        // Muestra el texto de la opción seleccionada (no el valor)

        document.getElementById('resumen-ciudad').textContent =
            document.getElementById('ciudad').value || 'No ingresado';
        // Copia el valor de la ciudad
        
        document.getElementById('resumen-direccion').textContent =
            document.getElementById('direccion').value || 'No ingresado';
        // Copia el valor de la dirección

        // ===== INFORMACIÓN MÉDICA =====
        const epsSelect = document.getElementById('eps');
        // Obtén el select de EPS (aseguradora médica)
        
        document.getElementById('resumen-eps').textContent =
            epsSelect.options[epsSelect.selectedIndex].text || 'No seleccionado';
        // Muestra el nombre de la EPS seleccionada

        const rhSelect = document.getElementById('rh');
        // Obtén el select de tipo de sangre
        
        document.getElementById('resumen-rh').textContent =
            rhSelect.options[rhSelect.selectedIndex].text || 'No seleccionado';
        // Muestra el tipo de sangre seleccionado

        const historial = document.getElementById('historial_medico').value;
        // Obtén el texto del historial médico
        
        document.getElementById('resumen-historial').textContent =
            historial || 'No ingresado';
        // Muestra el historial en el resumen

        // ===== CONTACTO DE EMERGENCIA =====
        document.getElementById('resumen-nombre-contacto').textContent =
            document.getElementById('nombre_contacto').value || 'No ingresado';
        // Copia el nombre del contacto de emergencia
        
        document.getElementById('resumen-telefono-contacto').textContent =
            document.getElementById('telefono_contacto').value || 'No ingresado';
        // Copia el teléfono del contacto
        
        document.getElementById('resumen-direccion-contacto').textContent =
            document.getElementById('direccion_contacto').value || 'No ingresado';
        // Copia la dirección del contacto
    }
});

// ==================== MANEJO DE MODALES DE ESPECIALIDADES ====================
/**
 * Este código abre el modal de actualización cuando haces clic en el botón "Editar"
 * de una especialidad en la tabla
 */

document.addEventListener('DOMContentLoaded', function () {
    // DOMContentLoaded = Espera a que la página HTML esté completamente cargada
    // Esto asegura que todos los botones existan en el DOM antes de ejecutar el código
    
    document.querySelectorAll('.btn-editar-especialidad').forEach(button => {
        // Busca TODOS los botones con la clase "btn-editar-especialidad"
        // forEach(button => {...}) = Ejecuta el código para cada botón encontrado
        
        button.addEventListener('click', function () {
            // addEventListener('click', ...) = Escucha cuando el usuario hace clic en el botón
            // function() {...} = Función que se ejecuta cuando ocurre el clic
            
            const modalActualizar = new bootstrap.Modal(
                // new bootstrap.Modal() = Crea una nueva instancia del modal
                // (es necesario para poder abrirlo con .show())
                
                document.getElementById('formularioModalActualizar')
                // getElementById('formularioModalActualizar') = Busca el div del modal en el HTML
                // Este div tiene el atributo id="formularioModalActualizar"
            );
            
            modalActualizar.show();
            // .show() = Abre/muestra el modal en la pantalla
            // El usuario verá el formulario para editar la especialidad
        });
    });
});
