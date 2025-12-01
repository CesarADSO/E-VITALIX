<?php
// ENLAZAMOS EL ARCHIVO DE SEGURIDAD
require_once BASE_PATH . '/app/helpers/session_admin.php';

// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE traertipoDocumento()
require_once BASE_PATH . '/app/controllers/tipoDocumentoController.php';

// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR DE ASEGURADORAS
require_once BASE_PATH . '/app/controllers/aseguradoraController.php';

// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR
$tipos_documento = traertipoDocumento();

// LLAMAMOS LA FUNCIÓN DE ASEGURADORAS
$aseguradoras = mostrarAseguradoras();
?>

<?php
include_once __DIR__ . '/../../layouts/header_administrador.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_administrador.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <!-- Pacientes Section -->
                <div id="pacienteSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Pacientes Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="/E-VITALIX/admin/pacientes" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario con Wizard -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Registrar Paciente</h4>
                        <p class="text-muted mb-4">Por favor diligencia este formulario para registrar un paciente</p>

                        <!-- Indicador de Pasos -->
                        <div class="wizard-progress mb-4">
                            <div class="steps">
                                <div class="step active" data-step="1">
                                    <span class="step-number">1</span>
                                    <span class="step-label">Información Personal</span>
                                </div>
                                <div class="step" data-step="2">
                                    <span class="step-number">2</span>
                                    <span class="step-label">Contacto</span>
                                </div>
                                <div class="step" data-step="3">
                                    <span class="step-number">3</span>
                                    <span class="step-label">Salud</span>
                                </div>
                                <div class="step" data-step="4">
                                    <span class="step-number">4</span>
                                    <span class="step-label">Emergencia</span>
                                </div>
                                <div class="step" data-step="5">
                                    <span class="step-number">5</span>
                                    <span class="step-label">Confirmación</span>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario -->
                        <form id="pacienteForm" action="<?= BASE_URL ?>/admin/guardar-paciente" method="POST" enctype="multipart/form-data">
                            <!-- Paso 1: Información Personal -->
                            <div class="wizard-step active" id="step1">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_documento" class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                                        <select name="tipoDocumento" class="form-select" id="tipo_documento" required>
                                            <option value="">Seleccionar tipo</option>
                                            <?php if (!empty($tipos_documento)) : ?>
                                                <?php foreach ($tipos_documento as $tipoDocumento) : ?>
                                                    <option value="<?= $tipoDocumento['id'] ?>"><?= $tipoDocumento['nombre'] ?></option>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <option value="">No hay tipos de documento registrados</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="numero_documento" class="form-label">Número de Documento <span class="text-danger">*</span></label>
                                        <input type="text" name="numeroDocumento" class="form-control" id="numero_documento" placeholder="Ingresa el número de documento" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombres" class="form-label">Nombres <span class="text-danger">*</span></label>
                                        <input type="text" name="nombres" class="form-control" id="nombres" placeholder="Ingresa los nombres" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                                        <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Ingresa los apellidos" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
                                        <input type="date" name="nacimiento" class="form-control" id="fecha_nacimiento" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="genero" class="form-label">Género <span class="text-danger">*</span></label>
                                        <select name="genero" class="form-select" id="genero" required>
                                            <option value="">Seleccionar género</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary next-step" data-next="2">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 2: Contacto -->
                            <div class="wizard-step" id="step2">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                                        <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="Ingresa el número telefónico" required>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                                        <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Ingresa la dirección" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="foto" class="form-label">Foto</label>
                                        <input type="file" name="foto" class="form-control" id="foto" accept=".jpg,.png,.jpeg">
                                        <div class="form-text">Formatos permitidos: jpg, png, jpeg. Tamaño máximo: 2MB</div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="correo" class="form-control" id="email" placeholder="Ingresa el correo electrónico" required>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="1">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="3">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 3: Información de Salud -->
                            <div class="wizard-step" id="step3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="eps" class="form-label">EPS <span class="text-danger">*</span></label>
                                        <input type="text" name="eps" class="form-control" id="eps" placeholder="Ingresa la EPS" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="rh" class="form-label">Tipo de Sangre (RH) <span class="text-danger">*</span></label>
                                        <select name="rh" class="form-select" id="rh" required>
                                            <option value="">Seleccionar tipo</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="aseguradora" class="form-label">Aseguradora</label>
                                    <select name="aseguradora" class="form-select" id="aseguradora">
                                        <option value="">Seleccionar aseguradora (Opcional)</option>
                                        <?php if (!empty($aseguradoras)) : ?>
                                            <?php foreach ($aseguradoras as $aseguradora) : ?>
                                                <option value="<?= $aseguradora['id'] ?>"><?= $aseguradora['nombre'] ?></option>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <option value="">No hay aseguradoras registradas</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="historial_medico" class="form-label">Historial Médico</label>
                                    <textarea class="form-control" name="historial" id="historial_medico" rows="4" placeholder="Ingresa antecedentes médicos, alergias, enfermedades crónicas, cirugías previas, etc. (Opcional)"></textarea>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="4">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 4: Contacto de Emergencia -->
                            <div class="wizard-step" id="step4">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="nombre_contacto" class="form-label">Nombre Completo del Contacto</label>
                                        <input type="text" name="nombreContacto" class="form-control" id="nombre_contacto" placeholder="Nombre del contacto de emergencia">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="telefono_contacto" class="form-label">Teléfono del Contacto</label>
                                        <input type="tel" name="telefonoContacto" class="form-control" id="telefono_contacto" placeholder="Teléfono de emergencia">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="direccion_contacto" class="form-label">Dirección del Contacto</label>
                                    <input type="text" name="direccionContacto" class="form-control" id="direccion_contacto" placeholder="Dirección del contacto de emergencia">
                                </div>
                                <div class="alert alert-info" role="alert">
                                    <i class="bi bi-info-circle"></i> Los datos del contacto de emergencia son opcionales pero recomendados.
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="3">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="5">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 5: Confirmación -->
                            <div class="wizard-step" id="step5">
                                <div class="mb-3">
                                    <h5>Resumen de la información</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-3 text-primary">Información Personal</h6>
                                            <p><strong>Tipo Documento:</strong> <span id="resumen-tipo-documento"></span></p>
                                            <p><strong>Número Documento:</strong> <span id="resumen-numero-documento"></span></p>
                                            <p><strong>Nombres:</strong> <span id="resumen-nombres"></span></p>
                                            <p><strong>Apellidos:</strong> <span id="resumen-apellidos"></span></p>
                                            <p><strong>Fecha Nacimiento:</strong> <span id="resumen-fecha-nacimiento"></span></p>
                                            <p><strong>Género:</strong> <span id="resumen-genero"></span></p>

                                            <hr>
                                            <h6 class="card-subtitle mb-3 text-primary">Contacto</h6>
                                            <p><strong>Teléfono:</strong> <span id="resumen-telefono"></span></p>
                                            <p><strong>Dirección:</strong> <span id="resumen-direccion"></span></p>
                                            <p><strong>Foto:</strong> <span id="resumen-foto"></span></p>
                                            <p><strong>Email:</strong> <span id="resumen-email"></span></p>

                                            <hr>
                                            <h6 class="card-subtitle mb-3 text-primary">Información de Salud</h6>
                                            <p><strong>EPS:</strong> <span id="resumen-eps"></span></p>
                                            <p><strong>Tipo de Sangre:</strong> <span id="resumen-rh"></span></p>
                                            <p><strong>Aseguradora:</strong> <span id="resumen-aseguradora"></span></p>
                                            <p><strong>Historial Médico:</strong> <span id="resumen-historial"></span></p>

                                            <hr>
                                            <h6 class="card-subtitle mb-3 text-primary">Contacto de Emergencia</h6>
                                            <p><strong>Nombre:</strong> <span id="resumen-nombre-contacto"></span></p>
                                            <p><strong>Teléfono:</strong> <span id="resumen-telefono-contacto"></span></p>
                                            <p><strong>Dirección:</strong> <span id="resumen-direccion-contacto"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="4">Anterior</button>
                                    <button type="submit" class="btn btn-primary">Registrar Paciente</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript del Wizard -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nextButtons = document.querySelectorAll('.next-step');
            const prevButtons = document.querySelectorAll('.prev-step');
            const steps = document.querySelectorAll('.wizard-step');
            const stepIndicators = document.querySelectorAll('.step');

            nextButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentStep = document.querySelector('.wizard-step.active');
                    const nextStepId = this.getAttribute('data-next');
                    const nextStep = document.getElementById('step' + nextStepId);

                    updateStepIndicators(nextStepId);
                    currentStep.classList.remove('active');
                    nextStep.classList.add('active');

                    if (nextStepId === '5') {
                        updateSummary();
                    }
                });
            });

            prevButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentStep = document.querySelector('.wizard-step.active');
                    const prevStepId = this.getAttribute('data-prev');
                    const prevStep = document.getElementById('step' + prevStepId);

                    updateStepIndicators(prevStepId);
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
                // Información Personal
                const tipoDocSelect = document.getElementById('tipo_documento');
                document.getElementById('resumen-tipo-documento').textContent = tipoDocSelect.options[tipoDocSelect.selectedIndex]?.text || 'No seleccionado';
                document.getElementById('resumen-numero-documento').textContent = document.getElementById('numero_documento').value || 'No ingresado';
                document.getElementById('resumen-nombres').textContent = document.getElementById('nombres').value || 'No ingresado';
                document.getElementById('resumen-apellidos').textContent = document.getElementById('apellidos').value || 'No ingresado';
                document.getElementById('resumen-fecha-nacimiento').textContent = document.getElementById('fecha_nacimiento').value || 'No ingresado';

                const generoSelect = document.getElementById('genero');
                document.getElementById('resumen-genero').textContent = generoSelect.options[generoSelect.selectedIndex]?.text || 'No seleccionado';

                // Contacto
                document.getElementById('resumen-telefono').textContent = document.getElementById('telefono').value || 'No ingresado';
                document.getElementById('resumen-direccion').textContent = document.getElementById('direccion').value || 'No ingresado';
                document.getElementById('resumen-foto').textContent = document.getElementById('foto').value || 'Sin foto';
                document.getElementById('resumen-email').textContent = document.getElementById('email').value || 'No ingresado';

                // Información de Salud
                document.getElementById('resumen-eps').textContent = document.getElementById('eps').value || 'No ingresado';

                const rhSelect = document.getElementById('rh');
                document.getElementById('resumen-rh').textContent = rhSelect.options[rhSelect.selectedIndex]?.text || 'No seleccionado';

                const aseguradoraSelect = document.getElementById('aseguradora');
                document.getElementById('resumen-aseguradora').textContent = aseguradoraSelect.options[aseguradoraSelect.selectedIndex]?.text || 'Sin aseguradora';
                document.getElementById('resumen-historial').textContent = document.getElementById('historial_medico').value || 'Sin historial';

                // Contacto de Emergencia
                document.getElementById('resumen-nombre-contacto').textContent = document.getElementById('nombre_contacto').value || 'No ingresado';
                document.getElementById('resumen-telefono-contacto').textContent = document.getElementById('telefono_contacto').value || 'No ingresado';
                document.getElementById('resumen-direccion-contacto').textContent = document.getElementById('direccion_contacto').value || 'No ingresado';
            }
        });
    </script>

    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>