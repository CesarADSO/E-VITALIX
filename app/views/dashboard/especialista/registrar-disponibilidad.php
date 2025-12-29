<?php
require_once BASE_PATH . '/app/helpers/session_especialista.php';
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
                        <a href="<?= BASE_URL ?>/especialista/disponibilidad" class="btn btn-primary btn-sm"
                            style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario de Horarios Médicos -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Registrar Disponibilidad</h4>
                        <p class="text-muted mb-4 texto">Como rol especialista, crea tu disponibilidad médica</p>

                        <form id="horarioForm" action="<?= BASE_URL ?>/especialista/guardar-disponibilidad" method="POST">

                            <div class="row">
                                <!-- Día de la Semana -->
                                <div class="col-md-6 mb-3">
                                    <label for="dias_semana" class="form-label">Días de la semana</label>
                                    <div class="row">
                                        <div class="form-check col-md-6 check-dia">
                                            <input class="form-check-input" name="dias[]" type="checkbox" value="Lunes" id="checkDefault">
                                            <label class="form-check-label mi-label" for="checkDefault">
                                                Lunes
                                            </label>
                                        </div>
                                        <div class="form-check col-md-6 check-dia">
                                            <input type="checkbox" class="form-check-input" name="dias[]" value="Martes" id="checkDefault">
                                            <label for="checkDefault" class="form-check-label mi-label">Martes</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-check col-md-6 check-dia">
                                            <input type="checkbox" class="form-check-input" name="dias[]" value="Miercoles" id="checkDefault">
                                            <label for="checkDefault" class="form-check-label mi-label">Miercoles</label>
                                        </div>
                                        <div class="form-check col-md-6 check-dia">
                                            <input type="checkbox" class="form-check-input" name="dias[]" value="Jueves" id="checkDefault">
                                            <label for="checkDefault" class="form-check-label mi-label">Jueves</label>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="form-check col-md-6 check-dia">
                                            <input type="checkbox" class="form-check-input" name="dias[]" value="Viernes" id="checkDefault">
                                            <label for="checkDefault" class="form-check-label mi-label">Viernes</label>
                                        </div>
                                        <div class="form-check col-md-6 check-dia">
                                            <input type="checkbox" class="form-check-input" name="dias[]" value="Sabado" id="checkDefault">
                                            <label for="checkDefault" class="form-check-label mi-label ">Sábado</label>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="form-check col-md-6 check-dia">
                                            <input type="checkbox" class="form-check-input" name="dias[]" value="Domingo" id="checkDefault">
                                            <label for="checkDefault" class="form-check-label mi-label">Domingo</label>
                                        </div>
                                    </div>

                                </div>

                                <!-- Capacidad Máxima de Citas -->
                                <div class="col-md-6 mb-3">
                                    <label for="capacidad_citas" class="form-label">Capacidad Máxima de Citas por
                                        Día</label>
                                    <input type="number" class="form-control" id="capacidad_citas"
                                        name="capacidad_citas" min="1" max="50" placeholder="Ej: 20" required>
                                    <div class="form-text">Número máximo de citas que puede atender en este día</div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Hora Inicio -->
                                <div class="col-md-6 mb-3">
                                    <label for="hora_inicio" class="form-label">Hora Inicio de Trabajo</label>
                                    <input type="time" class="form-control" id="hora_inicio" name="hora_inicio"
                                        required>
                                </div>

                                <!-- Hora Fin -->
                                <div class="col-md-6 mb-3">
                                    <label for="hora_fin" class="form-label">Hora Fin de Trabajo</label>
                                    <input type="time" class="form-control" id="hora_fin" name="hora_fin" required>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Inicio Descanso -->
                                <div class="col-md-6 mb-3">
                                    <label for="inicio_descanso" class="form-label">Inicio de Descanso</label>
                                    <input type="time" class="form-control" id="inicio_descanso" name="inicio_descanso">
                                </div>

                                <!-- Fin Descanso -->
                                <div class="col-md-6 mb-3">
                                    <label for="fin_descanso" class="form-label">Fin de Descanso</label>
                                    <input type="time" class="form-control" id="fin_descanso" name="fin_descanso">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="duracion_slot">Duración de cada cita (En minutos)</label>
                                <input type="number" name="duracion_cita" class="form-control" required >
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between cont-botones mt-4">
                                <a href="<?= BASE_URL ?>/especialista/disponibilidad" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn boton">Registrar disponibilidad</button>
                            </div>
                        </form>
                    </div>

                    <?php
                    include_once __DIR__ . '/../../layouts/footer_especialista.php';
                    ?>