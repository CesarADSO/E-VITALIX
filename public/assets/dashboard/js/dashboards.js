
document.addEventListener('DOMContentLoaded', function () {

    // ==================== CLASE ACTIVE EN SIDEBAR ====================
    // Marca automáticamente el ítem del menú lateral que corresponde a la URL
    // actual. Funciona en móvil, tablet y desktop porque todos usan el mismo
    // bloque HTML del sidebar — Bootstrap Offcanvas solo cambia cómo se muestra,
    // no duplica los elementos en el DOM.
    //
    // Flujo general:
    //   1. Se lee la ruta actual del navegador (window.location.pathname).
    //   2. Se recorren todos los ítems del menú (.nav-item dentro de .nav-menu).
    //   3. Se compara la ruta de cada ítem con la ruta actual.
    //   4. Si coinciden, se le agrega la clase "active"; al resto se les quita.
    //
    // Por qué basarse en la URL y no en el clic:
    //   Esta es una aplicación PHP que recarga la página completa en cada navegación.
    //   Detectar el clic no sirve porque el estado se pierde al recargar.
    //   En cambio, leer la URL al cargar la página es persistente y siempre correcto.

    function activarItemSidebar() {

        // Lee solo el "path" de la URL actual, sin protocolo, dominio ni query string.
        // Ejemplo: si el usuario está en "http://localhost/E-VITALIX/paciente/dashboard"
        //          window.location.pathname devuelve "/E-VITALIX/paciente/dashboard"
        const rutaActual = window.location.pathname;

        // Selecciona todos los <a class="nav-item"> que estén dentro de un .nav-menu.
        // Un solo selector cubre los sidebars de todos los roles (paciente, admin,
        // especialista, superadmin, asistente) sin necesitar identificar el rol.
        // querySelectorAll devuelve un NodeList que se puede recorrer con forEach.
        const itemsNav = document.querySelectorAll('.nav-menu .nav-item');

        // Recorre cada ítem del menú uno por uno.
        // En cada vuelta "item" es el elemento <a> correspondiente a un enlace del menú.
        itemsNav.forEach(function (item) {

            // Quita la clase "active" de este ítem antes de comparar.
            // Esto limpia cualquier estado previo, incluidas las clases hardcodeadas
            // en el HTML, y garantiza que solo un ítem quede activo al final.
            item.classList.remove('active');

            // Obtiene únicamente la parte del "path" del href del enlace.
            // "new URL(item.href)" construye un objeto URL a partir del atributo href,
            // que el navegador ya resuelve como URL absoluta.
            // ".pathname" extrae el path sin protocolo, dominio ni parámetros de consulta.
            // Ejemplo: href="http://localhost/E-VITALIX/especialista/mis-citas"
            //          → rutaItem = "/E-VITALIX/especialista/mis-citas"
            const rutaItem = new URL(item.href).pathname;

            // Excluye el ítem de "Cerrar Sesión" de la comparación.
            // Al cerrar sesión se redirige inmediatamente, por lo que nunca debe
            // quedar marcado como ítem activo.
            if (rutaItem.includes('cerrarSesion')) {
                return; // "return" dentro de forEach actúa como "continue": salta a la siguiente iteración
            }

            // Compara la ruta actual con la ruta del ítem usando dos condiciones:
            //
            //   Condición A — rutaActual === rutaItem
            //     Coincidencia exacta. Cubre el caso más común: el usuario está
            //     exactamente en la página del ítem.
            //     Ejemplo: rutaActual="/E-VITALIX/paciente/dashboard"
            //              rutaItem ="/E-VITALIX/paciente/dashboard" → ✓ activo
            //
            //   Condición B — rutaActual.startsWith(rutaItem + '/')
            //     Coincidencia por prefijo con separador "/".
            //     Cubre subrutas: si el módulo tiene páginas de detalle o parámetros
            //     en la URL, el ítem del menú padre sigue resaltado.
            //     Ejemplo: rutaActual="/E-VITALIX/paciente/historial-clinico/detalle/5"
            //              rutaItem ="/E-VITALIX/paciente/historial-clinico" → ✓ activo
            //     El "+ '/'" evita falsos positivos entre rutas con prefijo similar.
            //     Ejemplo sin él: "/paciente/lista-de-citas" coincidiría con
            //     "/paciente/lista-de-citas-pasadas" — con él, no coincide.
            if (rutaActual === rutaItem || rutaActual.startsWith(rutaItem + '/')) {

                // Si alguna de las dos condiciones se cumple, agrega la clase "active".
                // El CSS del sidebar usa esta clase para cambiar el color de fondo,
                // el color del texto y el ícono del ítem seleccionado.
                item.classList.add('active');
            }
        });
    }

    // Ejecuta la función al cargar la página.
    // Al estar dentro de DOMContentLoaded el DOM ya existe, así que la llamada
    // directa es suficiente — no se necesita otro evento de espera.
    activarItemSidebar();

    

    // ==================== INICIALIZACIÓN DE GRÁFICOS ====================
    // Esta función crea dos gráficos usando la librería Chart.js

    

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

            if (nextStep.classList.contains('is-last')) {
                // Detecta cuál es el formulario activo buscando un elemento clave de cada resumen,
                // y llama a la función correcta. Antes había una sola llamada a updateSummary(),
                // pero como las tres funciones tenían el mismo nombre en el mismo scope, JavaScript
                // solo guardaba la última (la del especialista) y sobreescribía las anteriores.
                const tienePaciente = !!(document.getElementById('resumen-fecha-nacimiento') && document.getElementById('resumen-eps'));

                if (tienePaciente) {
                    // El resumen tiene campos del paciente → llamar a la función del paciente
                    updateSummaryPaciente();
                } else if (document.getElementById('resumen-nombre-administrador')) {
                    // El resumen tiene campos del consultorio → llamar a la función del consultorio
                    updateSummaryConsultorio();
                } else if (document.getElementById('resumen-especialidad')) {
                    // El resumen tiene campos del especialista → llamar a la función del especialista
                    updateSummaryEspecialista();
                }
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

    // ========== FUNCIÓN: LLENAR EL RESUMEN FINAL DEL PACIENTE ==========
    // FALTABA: esta función se llamaba "updateSummary", igual que las dos de abajo.
    // En JavaScript, dentro del mismo scope, si declaras varias funciones con el mismo nombre
    // solo sobrevive la ÚLTIMA. Por eso esta nunca se ejecutaba: la pisaban las otras dos.
    // Solución: renombrarla a "updateSummaryPaciente" para que tenga identidad propia.
    function updateSummaryPaciente() {
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
        // FALTABA: "eps" es un input tipo texto, no un <select>, por lo que usar
        // .options[selectedIndex].text lanzaría un error. Se usa .value directamente.
        document.getElementById('resumen-eps').textContent =
            document.getElementById('eps').value || 'No ingresado';

        const rhSelect = document.getElementById('rh');
        // Obtén el select de tipo de sangre

        document.getElementById('resumen-rh').textContent =
            rhSelect.options[rhSelect.selectedIndex].text || 'No seleccionado';
        // Muestra el tipo de sangre seleccionado

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


    // LLENAR EL RESUMEN FINAL DEL CONSULTORIO
    // Renombrada de "updateSummary" a "updateSummaryConsultorio" para evitar el conflicto de nombres.
    function updateSummaryConsultorio() {

        // --- Campos normales tipo texto ---
        // Cada línea toma el valor del input y si está vacío muestra "No ingresado".

        document.getElementById('resumen-nombre').textContent =
            document.getElementById('nombre').value || 'No ingresado';

        document.getElementById('resumen-direccion').textContent =
            document.getElementById('direccion').value || 'No ingresado';

        document.getElementById('resumen-foto').textContent =
            document.getElementById('foto').value || 'No ingresado';

        document.getElementById('resumen-ciudad').textContent =
            document.getElementById('ciudad').value || 'No ingresado';

        document.getElementById('resumen-telefono').textContent =
            document.getElementById('telefono').value || 'No ingresado';

        document.getElementById('resumen-correo').textContent =
            document.getElementById('correo_contacto').value || 'No ingresado';

        document.getElementById('resumen-correo-administrador').textContent =
            document.getElementById('correo_admin').value || 'No ingresado';

        document.getElementById('resumen-nombre-administrador').textContent =
            document.getElementById('nombre_admin').value || 'No ingresado';

        document.getElementById('resumen-apellidos-administrador').textContent =
            document.getElementById('apellido_admin').value || 'No ingresado';

        document.getElementById('resumen-foto-administrador').textContent =
            document.getElementById('foto_admin').value || 'No ingresado';

        document.getElementById('resumen-telefono-administrador').textContent =
            document.getElementById('telefono_admin').value || 'No ingresado';

        // Actualiza el resumen del tipo de documento del administrador.
        // Busca el elemento <span> donde se mostrará el resumen.
        // Obtiene el texto de la opción seleccionada en el <select> de tipo de documento.
        // Si no hay ninguna opción seleccionada, muestra "No ingresado".
        // Esto permite que el usuario vea en el resumen el nombre legible del tipo de documento elegido.
        document.getElementById('resumen-tipo-documento').textContent =
            document.getElementById('tipo_documento').options[
                document.getElementById('tipo_documento').selectedIndex
            ].text || 'No ingresado';

        document.getElementById('resumen-numero-documento').textContent =
            document.getElementById('numero_documento_admin').value || 'No ingresado';


        // ----------------------------------------------------------------------
        // --- Especialidades seleccionadas (nueva lógica para los checkboxes) ---
        // ----------------------------------------------------------------------

        // PASO 1:
        // Seleccionamos TODOS los checkboxes cuyo name sea "especialidades[]"
        // y que estén marcados (checked).
        //
        // querySelectorAll devuelve un NodeList (no es array), por eso usamos "..."
        // para convertirlo en un arreglo real.

        // --- Horario de atención ---
        /* 1. Seleccionamos todos los checkboxes de días que estén marcados
           querySelectorAll devuelve una NodeList → Array.from lo convierte en arreglo
           map extrae solo el valor de cada checkbox */
        const diasSeleccionados = Array.from(
            document.querySelectorAll('input[name="dias[]"]:checked')
        ).map(dia => dia.value);

        /* 2. Obtenemos los valores de hora de apertura y hora de cierre desde los inputs correspondientes */
        const horaApertura = document.getElementById('hora_apertura').value;
        const horaCierre = document.getElementById('hora_cierre').value;

        /* 3. Inicializamos la variable que contendrá el texto final del horario */
        let textoHorario = '';

        /* 4. Validamos si no se seleccionó ningún día */
        if (diasSeleccionados.length === 0) {
            // Si no hay días seleccionados, mostramos "No ingresado"
            textoHorario = 'No ingresado';
        } else {
            /* 5. Convertimos el arreglo de días seleccionados en un texto separado por comas
               Ejemplo: ["Lunes", "Miércoles"] → "Lunes, Miércoles" */
            const diasTexto = diasSeleccionados.join(', ');

            /* 6. Validamos si falta la hora de apertura o cierre */
            if (!horaApertura || !horaCierre) {
                // Si alguna de las horas no está completa, mostramos los días y un aviso
                textoHorario = `${diasTexto} (horas no completadas)`;
            } else {
                /* 7. Si todo está completo, armamos el texto final del horario
                   Ejemplo: "Lunes, Miércoles • 08:00 - 17:00" */
                textoHorario = `${diasTexto} • ${horaApertura} - ${horaCierre}`;
            }
        }

        /* 8. Finalmente colocamos el texto generado en el span del resumen
               Esto actualiza dinámicamente lo que ve el usuario */
        document.getElementById('resumen-horario').textContent = textoHorario;
    }


    // FUNCION PARA ACTUALIZAR EL RESUMEN AL REGISTRAR UN ESPECIALISTA
    // Renombrada de "updateSummary" a "updateSummaryEspecialista" para evitar el conflicto de nombres.
    function updateSummaryEspecialista() {
        // Información Personal
        document.getElementById('resumen-tipo-documento').textContent = document.getElementById('tipo_documento').options[document.getElementById('tipo_documento').selectedIndex].text || 'No seleccionado';
        document.getElementById('resumen-numero-documento').textContent = document.getElementById('numero_documento').value || 'No ingresado';
        document.getElementById('resumen-nombres').textContent = document.getElementById('nombres').value || 'No ingresado';
        document.getElementById('resumen-apellidos').textContent = document.getElementById('apellidos').value || 'No ingresado';
        document.getElementById('resumen-fecha-nacimiento').textContent = document.getElementById('fecha_nacimiento').value || 'No ingresado';
        document.getElementById('resumen-genero').textContent = document.getElementById('genero').options[document.getElementById('genero').selectedIndex].text || 'No seleccionado';

        // Contacto
        document.getElementById('resumen-telefono').textContent = document.getElementById('telefono').value || 'No ingresado';
        document.getElementById('resumen-direccion').textContent = document.getElementById('direccion').value || 'No ingresado';
        document.getElementById('resumen-foto').textContent = document.getElementById('foto').value || 'No ingresado';
        document.getElementById('resumen-email').textContent = document.getElementById('email').value || 'No ingresado';

        // Profesional
        document.getElementById('resumen-especialidad').textContent = document.getElementById('especialidad').value || 'No ingresado';
        document.getElementById('resumen-registro-profesional').textContent = document.getElementById('registro_profesional').value || 'No ingresado';
    }

});

// // ===================================================
// // 1. EVENTO DEL FORMULARIO
// // ===================================================
// /**
//  * Escucha el evento 'submit' del formulario de búsqueda
//  * Cuando el usuario hace clic en "Buscar", se ejecuta esta función
//  */
// document.getElementById('formBusquedaConsultorio').addEventListener('submit', function (e) {
//     // Previene el comportamiento por defecto del formulario (que recargue la página)
//     e.preventDefault();

//     // Obtiene el valor seleccionado del select de especialidad
//     const especialidadId = document.getElementById('especialidad').value;
//     const especialidadTexto = document.getElementById('especialidad').options[document.getElementById('especialidad').selectedIndex].text;

//     // Llama a la función que busca los consultorios
//     buscarConsultorios(especialidadId, especialidadTexto);
// });

// function buscarConsultorios(especialidadId, especialidadTexto) {
//     // Oculta el mensaje inicial
//     document.getElementById('mensajeInicial').classList.add('d-none');
//     document.getElementById('mensajeSinResultados').classList.add('d-none');
//     document.getElementById('tituloResultados').classList.add('d-none');

//     // Limpia resultados anteriores
//     document.getElementById('resultadosConsultorios').innerHTML = '';

//     // Muestra el loader (mientras "carga")
//     document.getElementById('loaderResultados').classList.remove('d-none');

//     // SIMULACIÓN DE PETICIÓN AJAX A LA BASE DE DATOS
//     // En tu proyecto real, aquí harías un fetch() o XMLHttpRequest a tu backend PHP
//     setTimeout(() => {
//         // Oculta el loader
//         document.getElementById('loaderResultados').classList.add('d-none');

//         // AQUÍ SIMULO DATOS DE LA BASE DE DATOS
//         // En tu proyecto real, estos datos vendrán de tu servidor PHP
//         const consultorios = obtenerConsultoriosSimulados(especialidadId);

//         // Si hay resultados, los muestra
//         if (consultorios.length > 0) {
//             mostrarResultados(consultorios, especialidadTexto);
//         } else {
//             // Si no hay resultados, muestra mensaje
//             document.getElementById('mensajeSinResultados').classList.remove('d-none');
//         }
//     }, 1500); // Simula 1.5 segundos de "carga"
// }