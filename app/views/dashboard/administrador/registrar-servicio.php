<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/especialistaController.php';
require_once BASE_PATH . '/app/controllers/metodoPagoController.php';

$especialistas = mostrarEspecialistas();

$metodosPago = mostrarMetodosPago();
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

                <!-- Servicios Section -->
                <div id="serviciosSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Asistentes Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/servicios" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario de Registro de Servicios -->
                    <!-- Formulario de Registro de Servicios con Wizard -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Registrar Servicio</h4>
                        <p class="text-muted mb-4 texto">Crear nuevo servicio médico</p>

                        <!-- Indicador de Pasos -->
                        <div class="wizard-progress mb-4">
                            <div class="steps">
                                <div class="step active" data-step="1">
                                    <span class="step-number">1</span>
                                    <span class="step-label">Información Básica</span>
                                </div>
                                <div class="step" data-step="2">
                                    <span class="step-number">2</span>
                                    <span class="step-label">Configuración</span>
                                </div>
                                <div class="step" data-step="3">
                                    <span class="step-number">3</span>
                                    <span class="step-label">Confirmación</span>
                                </div>
                            </div>
                        </div>

                        <form id="servicioForm" action="<?= BASE_URL ?>/admin/guardar-servicio" method="POST">
                            <!-- Paso 1: Información Básica -->
                            <div class="wizard-step active" id="step1">
                                <!-- Nombre del Servicio -->
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre del Servicio</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Ej: Consulta General, Examen de Sangre, Radiografía"
                                        maxlength="50" required>
                                    <div class="form-text">Máximo 50 caracteres</div>
                                </div>

                                <!-- Descripción -->
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion"
                                        rows="3" placeholder="Descripción detallada del servicio"></textarea>
                                </div>

                                <!-- Código de Servicio -->
                                <div class="mb-3">
                                    <label for="codigo_servicio" class="form-label">Código del Servicio</label>
                                    <input type="text" class="form-control" id="codigo_servicio" name="codigo_servicio"
                                        placeholder="Ej: SERV-001" maxlength="20">
                                    <div class="form-text">Código interno del servicio (máximo 20 caracteres, opcional)</div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary next-step" data-next="2">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 2: Configuración -->
                            <div class="wizard-step" id="step2">
                                <div class="row">
                                    <!-- Especialista -->
                                    <div class="col-md-6 mb-3">
                                        <label for="id_especialista" class="form-label">Especialista</label>
                                        <select class="form-select" id="id_especialista" name="id_especialista" required>
                                            <option value="">Seleccionar especialista</option>
                                            <?php if (!empty($especialistas)) : ?>
                                                <?php foreach ($especialistas as $especialista) : ?>
                                                    <option value="<?= $especialista['id'] ?>"><?= $especialista['nombres'] ?> <?= $especialista['apellidos'] ?></option>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <option value="">No hay especialistas disponibles</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <!-- Duración en Minutos -->
                                    <div class="col-md-6 mb-3">
                                        <label for="duracion_minutos" class="form-label">Duración (Minutos)</label>
                                        <input type="time" class="form-control" id="duracion_minutos" name="duracion_minutos" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Precio -->
                                    <div class="col-md-6 mb-3">
                                        <label for="precio" class="form-label">Precio ($)</label>
                                        <input type="number" class="form-control" id="precio" name="precio"
                                            placeholder="0.00" step="0.01" min="0">
                                        <div class="form-text">Precio del servicio en pesos colombianos</div>
                                    </div>

                                    <!-- Método de Pago -->
                                    <div class="col-md-6 mb-3">
                                        <label for="id_metodo_pago" class="form-label">Método de Pago</label>
                                        <select class="form-select" id="id_metodo_pago" name="id_metodo_pago" required>
                                            <option value="">Seleccionar método de pago</option>
                                            <?php if (!empty($metodosPago)) : ?>
                                                <?php foreach ($metodosPago as $metodo) : ?>
                                                    <option value="<?= $metodo['id'] ?>"><?= $metodo['nombre'] ?></option>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <option value="">No hay métodos de pago disponibles</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                </div>



                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="1">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="3">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 3: Confirmación -->
                            <div class="wizard-step" id="step3">
                                <div class="mb-3">
                                    <h5>Resumen del Servicio</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <p><strong>Nombre:</strong> <span id="resumen-nombre"></span></p>
                                            <p><strong>Descripción:</strong> <span id="resumen-descripcion"></span></p>
                                            <p><strong>Código:</strong> <span id="resumen-codigo"></span></p>
                                            <p><strong>Especialista:</strong> <span id="resumen-especialista"></span></p>
                                            <p><strong>Duración:</strong> <span id="resumen-duracion"></span></p>
                                            <p><strong>Precio:</strong> <span id="resumen-precio"></span></p>
                                            <p><strong>Método Pago:</strong> <span id="resumen-metodo-pago"></span></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">Anterior</button>
                                    <button type="submit" class="btn boton">Registrar Servicio</button>
                                </div>
                            </div>
                        </form>
                    </div>

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
                                    if (nextStepId === '3') {
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
                                // Información Básica
                                document.getElementById('resumen-nombre').textContent = document.getElementById('nombre').value || 'No ingresado';
                                document.getElementById('resumen-descripcion').textContent = document.getElementById('descripcion').value || 'No ingresado';
                                document.getElementById('resumen-codigo').textContent = document.getElementById('codigo_servicio').value || 'No ingresado';

                                // Configuración
                                document.getElementById('resumen-especialista').textContent =
                                    document.getElementById('id_especialista').options[document.getElementById('id_especialista').selectedIndex].text || 'No seleccionado';
                                // Duración (convertir time a minutos)
                                const duracionTime = document.getElementById('duracion_minutos').value;
                                let duracionTexto = 'No ingresado';
                                if (duracionTime) {
                                    const [horas, minutos] = duracionTime.split(':');
                                    const totalMinutos = (parseInt(horas) * 60) + parseInt(minutos);
                                    duracionTexto = `${totalMinutos} minutos`;
                                }
                                document.getElementById('resumen-duracion').textContent = duracionTexto;
                                document.getElementById('resumen-precio').textContent =
                                    document.getElementById('precio').value ? '$' + document.getElementById('precio').value : 'No ingresado';
                                document.getElementById('resumen-metodo-pago').textContent =
                                    document.getElementById('id_metodo_pago').options[document.getElementById('id_metodo_pago').selectedIndex].text || 'No seleccionado';

                                // Estado
                                const estadoActivo = document.getElementById('estado_activo').checked;
                                document.getElementById('resumen-estado').textContent = estadoActivo ? 'Activo' : 'Inactivo';
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>