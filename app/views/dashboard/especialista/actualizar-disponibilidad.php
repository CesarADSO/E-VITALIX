<?php
require_once BASE_PATH . '/app/helpers/session_especialista.php';
require_once BASE_PATH . '/app/controllers/horarioController.php';

$id = $_GET['id'];

$horario = listarHorarioPorId($id);
$diasSeleccionados = $horario['diasSeleccionados'] ?? [];
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
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="/E-VITALIX/especialista/disponibilidad" class="btn btn-primary btn-sm"
                            style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario de Horarios Médicos -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Actualizar disponibilidad</h4>
                        <p class="text-muted mb-4 texto">Actualiza tu disponibilidad médica seleccionada</p>

                        <form id="horarioForm" action="<?= BASE_URL ?>/especialista/guardar-cambios-disponibilidad" method="POST">
                            <input type="hidden" name="id" value="<?= $horario['id'] ?>">
                            <input type="hidden" name="accion" value="actualizar">

                            <div class="row">
                                <!-- Día de la Semana -->
                                <div class="col-md-6 mb-3">
                                    <label for="dias_semana" class="form-label">Días de la semana</label>
                                    <div class="row">
                                        <div class="form-check col-md-6 check-dia">
                                            <input class="form-check-input" name="dias[]" type="checkbox" value="Lunes" <?= in_array('Lunes', $diasSeleccionados) ? 'checked' : '' ?> id="checkDefault">
                                            <label class="form-check-label mi-label" for="checkDefault">
                                                Lunes
                                            </label>
                                        </div>
                                        <div class="form-check col-md-6 check-dia">
                                            <input type="checkbox" class="form-check-input" name="dias[]" value="Martes" <?= in_array('Martes', $diasSeleccionados) ? 'checked' : '' ?> id="checkDefault">
                                            <label for="checkDefault" class="form-check-label mi-label">Martes</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-check col-md-6 check-dia">
                                            <input type="checkbox" class="form-check-input" name="dias[]" value="Miercoles" <?= in_array('Miercoles', $diasSeleccionados) ? 'checked' : '' ?> id="checkDefault">
                                            <label for="checkDefault" class="form-check-label mi-label">Miercoles</label>
                                        </div>
                                        <div class="form-check col-md-6 check-dia">
                                            <input type="checkbox" class="form-check-input" name="dias[]" value="Jueves" <?= in_array('Jueves', $diasSeleccionados) ? 'checked' : '' ?> id="checkDefault">
                                            <label for="checkDefault" class="form-check-label mi-label">Jueves</label>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="form-check col-md-6 check-dia">
                                            <input type="checkbox" class="form-check-input" name="dias[]" value="Viernes" <?= in_array('Viernes', $diasSeleccionados) ? 'checked' : '' ?> id="checkDefault">
                                            <label for="checkDefault" class="form-check-label mi-label">Viernes</label>
                                        </div>
                                        <div class="form-check col-md-6 check-dia">
                                            <input type="checkbox" class="form-check-input" name="dias[]" value="Sabado" <?= in_array('Sabado', $diasSeleccionados) ? 'checked' : '' ?> id="checkDefault">
                                            <label for="checkDefault" class="form-check-label mi-label ">Sábado</label>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="form-check col-md-6 check-dia">
                                            <input type="checkbox" class="form-check-input" name="dias[]" value="Domingo" <?= in_array('Domingo', $diasSeleccionados) ? 'checked' : '' ?> id="checkDefault">
                                            <label for="checkDefault" class="form-check-label mi-label">Domingo</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Capacidad Máxima de Citas -->
                                <div class="col-md-6 mb-3">
                                    <label for="capacidad_citas" class="form-label">Capacidad Máxima de Citas por
                                        Día</label>
                                    <input type="number" class="form-control" id="capacidad_citas"
                                        name="capacidad_citas" min="1" max="50" placeholder="Ej: 20" value="<?= $horario['capacidad_maxima'] ?>" required>
                                    <div class="form-text">Número máximo de citas que puede atender en este día</div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Hora Inicio -->
                                <div class="col-md-6 mb-3">
                                    <label for="hora_inicio" class="form-label">Hora Inicio de Trabajo</label>
                                    <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="<?= $horario['hora_inicio'] ?>"
                                        required>
                                </div>

                                <!-- Hora Fin -->
                                <div class="col-md-6 mb-3">
                                    <label for="hora_fin" class="form-label">Hora Fin de Trabajo</label>
                                    <input type="time" class="form-control" id="hora_fin" name="hora_fin" value="<?= $horario['hora_fin'] ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Inicio Descanso -->
                                <div class="col-md-6 mb-3">
                                    <label for="inicio_descanso" class="form-label">Inicio de Descanso</label>
                                    <input type="time" class="form-control" id="inicio_descanso" name="inicio_descanso" value="<?= $horario['pausa_inicio'] ?>">
                                </div>

                                <!-- Fin Descanso -->
                                <div class="col-md-6 mb-3">
                                    <label for="fin_descanso" class="form-label">Fin de Descanso</label>
                                    <input type="time" class="form-control" id="fin_descanso" name="fin_descanso" value="<?= $horario['pausa_fin'] ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="<?= $horario['estado_disponibilidad'] ?>"><?= $horario['estado_disponibilidad'] ?></option>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Botones -->
                            <div class="d-flex justify-content-between cont-botones mt-4">
                                <a href="<?= BASE_URL ?>/especialista/disponibilidad" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn boton">Actualizar Horario</button>
                            </div>
                        </form>
                    </div>
                    <?php
                    include_once __DIR__ . '/../../layouts/footer_especialista.php';
                    ?>