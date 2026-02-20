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
                        <a href="<?= BASE_URL ?>/especialista/pacientes-atendidos" class="btn btn-primary btn-sm"
                            style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario de Registro de Consulta Médica -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Formular medicamentos</h4>
                        <p class="text-muted mb-4 texto">Formulé los medicamentos para tu paciente con dosis y tiempo</p>

                        <form id="consultaForm" action="<?= BASE_URL ?>/especialista/guardar-consulta" method="POST">
                            <!-- Motivo de la Consulta -->
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="nombre_medicamento" class="form-label">Nombre del medicamento</label>
                                    <input type="text" class="form-control" name="medicamento" placeholder="Ingrese el nombre del medicamento">
                                    <div class="form-text">Nombre del medicamento a formular</div>
                                </div>

                                <!-- Dosis -->
                                <div class="mb-3 col-md-6">
                                    <label for="dosis" class="form-label">Dosis</label>
                                    <input type="text" class="form-control" name="dosis" placeholder="Ej: 1 tableta">
                                    <div class="form-text">Cuantas tabletas debe tomar el paciente</div>
                                </div>

                                <!-- Frecuencia -->
                                <div class="mb-3 col-md-6">
                                    <label for="frecuencia" class="form-label">Frecuencia</label>
                                    <input type="text" class="form-control" name="frecuencia" placeholder="Ej: Cada 8 horas">
                                    <div class="form-text">Frecuencia de administración del medicamento</div>
                                </div>

                                <!-- Duración -->
                                <div class="mb-3 col-md-6">
                                    <label for="duracion" class="form-label">Duración</label>
                                    <input type="text" class="form-control" name="duracion" placeholder="Ej: 5 días">
                                    <div class="form-text">Duración del tratamiento en días o semanas</div>
                                </div>
                            </div>



                            <!-- Botones -->
                            <div class="d-flex justify-content-between cont-botones mt-4">
                                <a href="<?= BASE_URL ?>/especialista/pacientes-atendidos" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn boton">Formular Medicamento</button>
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