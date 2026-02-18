<?php
require_once BASE_PATH . '/app/controllers/misCitasController.php';

// OBTENEMOS LOS DATOS DE LA CITA Y EL PACIENTE
$id_cita = $_GET['id_cita'] ?? '';
$id_paciente = $_GET['id_paciente'] ?? '';

$cita = obtenerIdCitaYPaciente($id_cita, $id_paciente);
?>

<?php
include_once __DIR__ . '/../../layouts/header_especialista.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_especialista.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <!-- Horarios Section -->
                <div id="HorariosSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_especialista.php';
                    ?>

                    <!-- Horarios Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <!-- <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div> -->
                        <a href="<?= BASE_URL ?>/especialista/disponibilidad" class="btn btn-primary btn-sm"
                            style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario de Registro de Consulta Médica -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Registrar Consulta Médica</h4>
                        <p class="text-muted mb-4 texto">Registrar información de la consulta médica</p>

                        <form id="consultaForm" action="<?= BASE_URL ?>/especialista/guardar-consulta" method="POST">
                            <!-- Motivo de la Consulta -->
                            <input type="hidden" name="id_cita" value="<?= $cita['id_cita'] ?>">
                            <input type="hidden" name="id_paciente" value="<?= $cita['id_paciente'] ?>">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="motivo_consulta" class="form-label">Motivo de la Consulta</label>
                                    <textarea class="form-control" id="motivo_consulta" name="motivo_consulta"
                                        rows="3" placeholder="Describa el motivo principal de la consulta" required></textarea>
                                    <div class="form-text">¿Por qué el paciente acude a consulta?</div>
                                </div>

                                <!-- Síntomas -->
                                <div class="mb-3 col-md-6">
                                    <label for="sintomas" class="form-label">Síntomas</label>
                                    <textarea class="form-control" id="sintomas" name="sintomas"
                                        rows="3" placeholder="Describa los síntomas presentados por el paciente" required></textarea>
                                    <div class="form-text">Liste los síntomas, su intensidad y duración</div>
                                </div>

                                <!-- Diagnóstico -->
                                <div class="mb-3 col-md-6">
                                    <label for="diagnostico" class="form-label">Diagnóstico</label>
                                    <textarea class="form-control" id="diagnostico" name="diagnostico"
                                        rows="3" placeholder="Diagnóstico médico" required></textarea>
                                    <div class="form-text">Diagnóstico principal y códigos CIE-10 si aplica</div>
                                </div>

                                <!-- Tratamiento -->
                                <div class="mb-3 col-md-6">
                                    <label for="tratamiento" class="form-label">Tratamiento Prescrito</label>
                                    <textarea class="form-control" id="tratamiento" name="tratamiento"
                                        rows="3" placeholder="Describa el tratamiento recomendado" required></textarea>
                                    <div class="form-text">Medicamentos, dosis, frecuencia, duración y recomendaciones</div>
                                </div>

                                <!-- signos vitales -->

                                <div class="mb-3 col-md-6">
                                    <label for="presion_sistolica" class="form-label">Presión sistólica</label>
                                    <input type="number" class="form-control" name="presion_sistolica" placeholder="Ingrese la presión sistólica">
                                    <div class="form-text">Presión arterial sistólica en mmHg</div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="presion_diastolica" class="form-label">Presión diastólica</label>
                                    <input type="number" class="form-control" name="presion_diastolica" placeholder="Ingrese la presión diastólica">
                                    <div class="form-text">Presión arterial diastólica en mmHg</div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="temperatura" class="form-label">Temperatura</label>
                                    <input type="number" class="form-control" name="temperatura" placeholder="Ingrese la temperatura">
                                    <div class="form-text">Temperatura corporal en grados Celsius</div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="frecuencia_cardiaca" class="form-label">Frecuencia Cardíaca</label>
                                    <input type="number" class="form-control" name="frecuencia_cardiaca" placeholder="Ingrese la frecuencia cardíaca">
                                    <div class="form-text">Frecuencia cardíaca en latidos por minuto</div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="frecuencia_respiratoria" class="form-label">Frecuencia Respiratoria</label>
                                    <input type="number" class="form-control" name="frecuencia_respiratoria" placeholder="Ingrese la frecuencia respiratoria">
                                    <div class="form-text">Frecuencia respiratoria en respiraciones por minuto</div>
                                </div>

                                <!-- Observaciones -->
                                <div class="mb-3 col-md-6">
                                    <label for="observaciones" class="form-label">Observaciones Adicionales</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones"
                                        rows="3" placeholder="Observaciones, recomendaciones o notas adicionales"></textarea>
                                    <div class="form-text">Información adicional relevante para el seguimiento</div>
                                </div>
                            </div>



                            <!-- Botones -->
                            <div class="d-flex justify-content-between cont-botones mt-4">
                                <a href="<?= BASE_URL ?>/especialista/mis-citas" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn boton">Completar Cita</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../layouts/footer_especialista.php';
    ?>