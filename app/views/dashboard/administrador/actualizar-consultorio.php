<?php
    require_once BASE_PATH . '/app/helpers/session_admin.php';
    // ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE CONSULTAR CONSULTORIOS
    require_once BASE_PATH . '/app/controllers/consultorioController.php';

    // ASIGNAMOS EL VALOR ID DEL REGISTRO SEGÚN LA TABLA
    $id = $_GET['id'];
    // LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR Y LE PASAMOS LOS DATOS A UNA VARIABLE
    // QUE PODAMOS MANIPULAR EN ESTE ARCHIVO
    $consultorio = listarConsultorio($id);
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

                <!-- Consultorios Section -->
                <div id="consultoriosSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Consultorios Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="/E-VITALIX/admin/consultorios" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario con Wizard -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Actualizar Consultorio</h4>
                        <p class="text-muted mb-4">Por favor diligencia este formulario para actualizar el consultorio seleccionado</p>

                        <!-- Indicador de Pasos -->
                        <div class="wizard-progress mb-4">
                            <div class="steps">
                                <div class="step active" data-step="1">
                                    <span class="step-number">1</span>
                                    <span class="step-label">Información Básica</span>
                                </div>
                                <div class="step" data-step="2">
                                    <span class="step-number">2</span>
                                    <span class="step-label">Contacto</span>
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
                        <form id="consultorioForm" action="<?= BASE_URL ?>/admin/guardar-cambios-consultorio" method="POST">
                            <input type="hidden" name="id" value="<?= $consultorio['id'] ?>">
                            <input type="hidden" name="accion" value="actualizar">
                            <!-- Paso 1: Información Básica -->
                            <div class="wizard-step active" id="step1">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ingresa el nombre del consultorio" value="<?= $consultorio['nombre'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Ingresa la dirección" value="<?= $consultorio['direccion'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="ciudad" class="form-label">Ciudad</label>
                                    <input type="text" name="ciudad" class="form-control" id="ciudad" placeholder="Ingresa la ciudad" value="<?= $consultorio['ciudad'] ?>">
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary next-step" data-next="2">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 2: Contacto -->
                            <div class="wizard-step" id="step2">
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="Ingresa tu número telefónico" value="<?= $consultorio['telefono'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="correo_contacto" class="form-label">Correo de Contacto</label>
                                    <input type="email" name="correo" class="form-control" id="correo_contacto" placeholder="Ingresa el correo electrónico" value="<?= $consultorio['correo_contacto'] ?>">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="1">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="3">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 3: Servicios -->
                            <div class="wizard-step" id="step3">
                                <div class="mb-3">
                                    <label for="especialidades" class="form-label">Especialidades</label>
                                    <textarea class="form-control" name="especialidades" id="especialidades" rows="3" placeholder="Ej: Medicina General, Pediatría, Cardiología, Dermatología"><?= $consultorio['especialidades'] ?></textarea>
                                    <div class="form-text"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="horario_atencion" class="form-label">Horario de Atención</label>
                                    <textarea class="form-control" name="horario" id="horario_atencion" rows="3" placeholder="Ej: Lunes a Viernes: 8:00 AM - 6:00 PM, Sábados: 8:00 AM - 12:00 PM"><?= $consultorio['horario_atencion'] ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="servicios_adicionales" class="form-label">Servicios Adicionales</label>
                                    <textarea class="form-control" name="adicionales" id="servicios_adicionales" rows="3" placeholder="Ej: Laboratorio clínico, Rayos X, Ecografías"><?= $consultorio['servicios_adicionales'] ?></textarea>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="4">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 4: Confirmación -->
                            <div class="wizard-step" id="step4">
                                <div class="mb-3">
                                    <h5>Resumen de la información</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <p><strong>Nombre:</strong> <span id="resumen-nombre"></span></p>
                                            <p><strong>Dirección:</strong> <span id="resumen-direccion"></span></p>
                                            <p><strong>Ciudad:</strong> <span id="resumen-ciudad"></span></p>
                                            <p><strong>Teléfono:</strong> <span id="resumen-telefono"></span></p>
                                            <p><strong>Correo:</strong> <span id="resumen-correo"></span></p>
                                            <p><strong>Especialidades:</strong> <span id="resumen-especialidades"></span></p>
                                            <p><strong>Horario:</strong> <span id="resumen-horario"></span></p>
                                            <p><strong>Servicios adicionales:</strong> <span id="resumen-servicios"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- NUEVO CAMPO ESTADO PARA ACTUALIZAR -->
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado del Consultorio</label>
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="<?= $consultorio['estado'] ?>"><?= $consultorio['estado'] ?></option>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between cont-botones">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="3">Anterior</button>
                                    <button type="submit" class="btn boton">Actualizar Consultorio</button>
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
                document.getElementById('resumen-nombre').textContent = document.getElementById('nombre').value || 'No ingresado';
                document.getElementById('resumen-direccion').textContent = document.getElementById('direccion').value || 'No ingresado';
                document.getElementById('resumen-ciudad').textContent = document.getElementById('ciudad').value || 'No ingresado';
                document.getElementById('resumen-telefono').textContent = document.getElementById('telefono').value || 'No ingresado';
                document.getElementById('resumen-correo').textContent = document.getElementById('correo_contacto').value || 'No ingresado';

                // Especialidades como texto
                document.getElementById('resumen-especialidades').textContent = document.getElementById('especialidades').value || 'No ingresado';

                document.getElementById('resumen-horario').textContent = document.getElementById('horario_atencion').value || 'No ingresado';
                document.getElementById('resumen-servicios').textContent = document.getElementById('servicios_adicionales').value || 'No ingresado';
            }

            
        });
    </script>

    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>