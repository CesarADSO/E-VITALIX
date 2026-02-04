<?php
require_once BASE_PATH . '/app/controllers/tipoDocumentoController.php';

$datos = traertipoDocumento();
?>


<?php
include_once __DIR__ . '/../../layouts/header_superadministrador.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_superadministrador.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <!-- Consultorios Section -->
                <div id="consultoriosSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_superadministrador.php';
                    ?>

                    <!-- Consultorios Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/superadmin/consultorios" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario con Wizard -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Registrar Consultorio</h4>
                        <p class="text-muted mb-4 texto">Por favor diligencia este formulario para registrar un consultorio</p>

                        <!-- Indicador de Pasos -->
                        <div class="wizard-progress mb-4">
                            <div class="steps">
                                <div class="step active" data-step="1">
                                    <span class="step-number">1</span>
                                    <span class="step-label">Información Básica</span>
                                </div>
                                <!-- <div class="step" data-step="2">
                                    <span class="step-number">2</span>
                                    <span class="step-label">Contacto</span>
                                </div> -->
                                <div class="step" data-step="2">
                                    <span class="step-number">2</span>
                                    <span class="step-label">Administrador</span>
                                </div>
                                <div class="step" data-step="3">
                                    <span class="step-number">3</span>
                                    <span class="step-label">Servicios</span>
                                </div>
                                <div class="step" data-step="4">
                                    <span class="step-number">4</span>
                                    <span class="step-label">Confirmación</span>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario -->
                        <form id="consultorioForm" action="<?= BASE_URL ?>/superadmin/guardar-consultorio" method="POST" enctype="multipart/form-data">
                            <!-- Paso 1: Información Básica -->
                            <div class="wizard-step active" id="step1">
                                <div class="row">
                                    

                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ingresa el nombre del consultorio">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="ciudad" class="form-label">Ciudad</label>
                                        <input type="text" name="ciudad" class="form-control" id="ciudad" placeholder="Ingresa la ciudad">
                                    </div>
                                </div>

                                <div class="row">
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Ingresa la dirección">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="Ingresa el número telefónico del consultorio">
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="correo_contacto" class="form-label">Correo de Contacto</label>
                                        <input type="email" name="correo" class="form-control" id="correo_contacto" placeholder="Ingresa el correo electrónico">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="foto" class="form-label">Foto</label>
                                        <input type="file" name="foto" class="form-control" id="foto" accept=".jpg, .png, .svg">
                                    </div>
                                </div>

                                

                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary next-step" data-next="2">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 2: Contacto
                            <div class="wizard-step" id="step2">
                                <div class="row">
                                    

                                    
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="1">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="3">Siguiente</button>
                                </div>
                            </div> -->

                            <!-- Paso 3: Administrador -->
                            <div class="wizard-step" id="step2">

                               

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombres_admin" class="form-label">Nombres</label>
                                        <input type="text" name="nombres_admin" class="form-control" id="nombre_admin" placeholder="Ingresa los nombres">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="apellidos_admin" class="form-label">Apellidos</label>
                                        <input type="text" name="apellidos_admin" class="form-control" id="apellido_admin" placeholder="Ingresa los apellidos">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_documento_admin" class="form-label">Tipo de documento</label>
                                        <select class="form-select" name="tipo_documento_admin" id="tipo_documento">
                                            <option value="">Seleccionar tipo</option>
                                            <?php if (!empty($datos)) : ?>
                                                <?php foreach ($datos as $tipoDocumento) : ?>
                                                    <option value="<?= $tipoDocumento['id'] ?>"><?= $tipoDocumento['nombre'] ?></option>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <option value="">No hay tipos de documento registrados</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="numero_documento_admin" class="form-label">Número de documento</label>
                                        <input type="text" name="numero_documento_admin" class="form-control" id="numero_documento_admin" placeholder="Ingresa el número de documento">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="correo_admin" class="form-label">Email</label>
                                        <input type="email" name="correo_admin" class="form-control" id="correo_admin" placeholder="Ingresa el correo electrónico">
                                    </div>
                                   
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono_admin" class="form-label">Teléfono</label>
                                        <input type="tel" name="telefono_admin" class="form-control" id="telefono_admin" placeholder="Ingresa el número telefónico">
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label for="foto_admin" class="form-label">Foto</label>
                                        <input type="file" name="foto_admin" class="form-control" id="foto_admin" accept=".jpg, .png, .svg">
                                    </div>

                                </div>


                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="3">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 4: Servicios -->
                            <div class="wizard-step" id="step3">
                                <div class="mb-3">
                                    <label class="form-label" for="especialidades">Especialidades (Selecciona una o varias)</label>
                                    <div class="form-check check-especialidad">
                                        <input class="form-check-input" type="checkbox" id="dermatologia" name="especialidades[]" value="Dermatologia">
                                        <label for="dermatologia" class="form-check-label mi-label">Dermatología</label>
                                    </div>
                                    <div class="form-check check-especialidad">
                                        <input class="form-check-input" type="checkbox" id="urologia" name="especialidades[]" value="urologia">
                                        <label for="urologia" class="form-check-label mi-label">Urología</label>
                                    </div>
                                    <div class="form-check check-especialidad">
                                        <input class="form-check-input" type="checkbox" id="cardiologia" name="especialidades[]" value="Cardiologia">
                                        <label for="cardiologia" class="form-check-label mi-label">Cardiología</label>
                                    </div>
                                    <div class="form-check check-especialidad">
                                        <input class="form-check-input" type="checkbox" id="medicina-general" name="especialidades[]" value="Medicina_general">
                                        <label for="medicinaGeneral" class="form-check-label mi-label">Medicina General</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="horario_atencion" class="form-label">Días de Atención</label>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Lunes">
                                        <label class="form-check-label mi-label">Lunes</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Martes">
                                        <label class="form-check-label mi-label">Martes</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Miercoles">
                                        <label class="form-check-label mi-label">Miercoles</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Jueves">
                                        <label class="form-check-label mi-label">Jueves</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Viernes">
                                        <label class="form-check-label mi-label">Viernes</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Sabado">
                                        <label class="form-check-label mi-label">Sabado</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Domingo">
                                        <label class="form-check-label mi-label">Domingo</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Horario de atención</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="hora_apertura" class="form-label">Hora apertura</label>
                                            <input type="time" id="hora_apertura" name="hora_apertura" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="hora_cierre" class="form-label">Hora cierre</label>
                                            <input type="time" id="hora_cierre" name="hora_cierre" class="form-control">
                                        </div>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="4">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 5: Confirmación -->
                            <div class="wizard-step" id="step4">
                                <div class="mb-3">
                                    <h5>Resumen de la información</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <p><strong>Nombre del consultorio:</strong> <span id="resumen-nombre"></span></p>
                                            <p><strong>Dirección del consultorio:</strong> <span id="resumen-direccion"></span></p>
                                            <p><strong>Foto del consultorio:</strong> <span id="resumen-foto"></span></p>
                                            <p><strong>Ciudad:</strong> <span id="resumen-ciudad"></span></p>
                                            <p><strong>Teléfono del consultorio:</strong> <span id="resumen-telefono"></span></p>
                                            <p><strong>Correo del consultorio:</strong> <span id="resumen-correo"></span></p>
                                            <p><strong>Correo del administrador:</strong> <span id="resumen-correo-administrador"></span></p>
                                            <p><strong>Nombres del administrador:</strong> <span id="resumen-nombre-administrador"></span></p>
                                            <p><strong>Apellidos del administrador:</strong> <span id="resumen-apellidos-administrador"></span></p>
                                            <p><strong>Foto del administrador:</strong> <span id="resumen-foto-administrador"></span></p>
                                            <p><strong>Teléfono del administrador:</strong> <span id="resumen-telefono-administrador"></span></p>
                                            <p><strong>Tipo de documento del administrador:</strong> <span id="resumen-tipo-documento"></span></p>
                                            <p><strong>Número de documento del administrador:</strong> <span id="resumen-numero-documento"></span></p>
                                            <p><strong>Correo del consultorio:</strong> <span id="resumen-correo"></span></p>
                                            <p><strong>Especialidades:</strong> <span id="resumen-especialidades"></span></p>
                                            <p><strong>Horario del consultorio:</strong> <span id="resumen-horario"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between cont-botones">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="3">Anterior</button>
                                    <button type="submit" class="btn boton">Registrar Consultorio</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SOLO EL JAVASCRIPT DEL WIZARD - SIN ESTILOS CSS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navegación entre pasos
            const nextButtons = document.querySelectorAll('.next-step');
            const prevButtons = document.querySelectorAll('.prev-step');
            const steps = document.querySelectorAll('.wizard-step');
            const stepIndicators = document.querySelectorAll('.step');

            nextButtons.forEach(button => {
                button.addEventListener('click', function() {
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
                button.addEventListener('click', function() {
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
                const especialidadesSeleccionadas = [
                        ...document.querySelectorAll('input[name="especialidades[]"]:checked')
                    ]

                    // PASO 2:
                    // Con .map(cb => cb.value) obtenemos el valor "value" de cada checkbox marcado.
                    // Esto convierte una lista de inputs en un arreglo de strings.
                    // Ejemplo:
                    // [inputCheckbox1, inputCheckbox2] → ["dermatologia", "urologia"]
                    .map(cb => cb.value);

                // PASO 3:
                // Si hay al menos una especialidad marcada, las mostramos separadas por comas.
                // Si no hay ninguna, mostramos "No ingresado".
                document.getElementById('resumen-especialidades').textContent =
                    especialidadesSeleccionadas.length > 0 ?
                    especialidadesSeleccionadas.join(', ') // Ejemplo: "dermatologia, urologia"
                    :
                    'No ingresado';

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



        });
    </script>

    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>