<!DOCTYPE html>
<html lang="es">


<?php
include_once __DIR__ . '/../../layouts/header_paciente.php';
?>

<body>
    <div class="container-fluid">
            <!-- Main Content -->
            <div class="main-content">

                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body p-4">
                            <!-- Encabezado -->
                            <div class="text-center mb-4">
                                <h3 class="mb-2" style="font-weight: 600;">Completar Perfil del Paciente</h3>
                                <p class="text-muted">Por favor complete la información de su cuenta para que pueda agendar citas médicas</p>
                            </div>

                            <!-- Indicador de Pasos -->
                            <div class="wizard-progress mb-4">
                                <div class="steps">
                                    <div class="step active" data-step="1">
                                        <span class="step-number">1</span>
                                        <span class="step-label">Datos Personales</span>
                                    </div>
                                    <div class="step" data-step="2">
                                        <span class="step-number">2</span>
                                        <span class="step-label">Información Médica</span>
                                    </div>
                                    <div class="step" data-step="3">
                                        <span class="step-number">3</span>
                                        <span class="step-label">Contacto de Emergencia</span>
                                    </div>
                                    <div class="step" data-step="4">
                                        <span class="step-number">4</span>
                                        <span class="step-label">Confirmación</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Formulario -->
                            <form id="pacienteForm" action="<?= BASE_URL ?>/paciente/terminar-perfil" method="POST">
                                <!-- Paso 1: Datos Personales -->
                                <div class="wizard-step active" id="step1">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="genero" class="form-label">Género</label>
                                            <select class="form-select" id="genero" name="genero" required>
                                                <option value="">Seleccionar género</option>
                                                <option value="M">Masculino</option>
                                                <option value="F">Femenino</option>
                                                <option value="O">Otro</option>
                                                <option value="PN">Prefiero no decir</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="ciudad" class="form-label">Ciudad</label>
                                            <input type="text" class="form-control" id="ciudad" name="ciudad"
                                                placeholder="Ingresa tu ciudad" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="direccion" class="form-label">Dirección</label>
                                            <input type="text" class="form-control" id="direccion" name="direccion"
                                                placeholder="Ingresa tu dirección" required>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary next-step" data-next="2">Siguiente</button>
                                    </div>
                                </div>

                                <!-- Paso 2: Información Médica -->
                                <div class="wizard-step" id="step2">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="eps" class="form-label">EPS</label>
                                            <input type="text" class="form-control" id="eps" name="eps"
                                                placeholder="Ingresa el nombre de tu EPS" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="rh" class="form-label">Grupo Sanguíneo y RH</label>
                                            <select class="form-select" id="rh" name="rh" required>
                                                <option value="">Seleccionar tipo sanguíneo</option>
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
                                        <label for="historial_medico" class="form-label">Historial Médico</label>
                                        <textarea class="form-control" id="historial_medico" name="historial_medico"
                                            rows="4" placeholder="Alergias, enfermedades crónicas, medicamentos actuales, cirugías anteriores, etc."></textarea>
                                        <div class="form-text">Esta información es crucial para tu atención médica</div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary prev-step" data-prev="1">Anterior</button>
                                        <button type="button" class="btn btn-primary next-step" data-next="3">Siguiente</button>
                                    </div>
                                </div>

                                <!-- Paso 3: Contacto de Emergencia -->
                                <div class="wizard-step" id="step3">
                                    <div class="mb-3">
                                        <label for="nombre_contacto" class="form-label">Nombre del Contacto de Emergencia</label>
                                        <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto"
                                            placeholder="Nombre completo del contacto" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="telefono_contacto" class="form-label">Teléfono del Contacto</label>
                                            <input type="tel" class="form-control" id="telefono_contacto" name="telefono_contacto"
                                                placeholder="Número telefónico" required>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                        <label for="direccion_contacto" class="form-label">Dirección del Contacto</label>
                                        <input type="text" class="form-control" id="direccion_contacto" name="direccion_contacto"
                                            placeholder="Dirección del contacto de emergencia">
                                        <div class="form-text">Opcional, pero recomendado</div>
                                    </div>
                                    </div>

                                    

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">Anterior</button>
                                        <button type="button" class="btn btn-primary next-step" data-next="4">Siguiente</button>
                                    </div>
                                </div>

                                <!-- Paso 4: Confirmación -->
                                <div class="wizard-step" id="step4">
                                    <div class="mb-3">
                                        <h5>Resumen de la Información</h5>
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="mb-3">Datos Personales</h6>
                                                <p><strong>Fecha de Nacimiento:</strong> <span id="resumen-fecha-nacimiento"></span></p>
                                                <p><strong>Género:</strong> <span id="resumen-genero"></span></p>
                                                <p><strong>Ciudad:</strong> <span id="resumen-ciudad"></span></p>
                                                <p><strong>Dirección:</strong> <span id="resumen-direccion"></span></p>

                                                <hr>
                                                <h6 class="mb-3">Información Médica</h6>
                                                <p><strong>EPS:</strong> <span id="resumen-eps"></span></p>
                                                <p><strong>Grupo Sanguíneo:</strong> <span id="resumen-rh"></span></p>
                                                <p><strong>Historial Médico:</strong> <span id="resumen-historial"></span></p>

                                                <hr>
                                                <h6 class="mb-3">Contacto de Emergencia</h6>
                                                <p><strong>Nombre:</strong> <span id="resumen-nombre-contacto"></span></p>
                                                <p><strong>Teléfono:</strong> <span id="resumen-telefono-contacto"></span></p>
                                                <p><strong>Dirección:</strong> <span id="resumen-direccion-contacto"></span></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary prev-step" data-prev="3">Anterior</button>
                                        <button type="submit" class="btn boton">Completar Registro</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <?php
            include_once __DIR__ . '/../../layouts/footer_paciente.php';
            ?>