<?php
require_once BASE_PATH . '/app/controllers/historialesController.php';

$id_paciente = $_GET['id_paciente'];


$datos = consultarHistorialClinicoPaciente($id_paciente);


$paciente    = $datos['paciente'];
$historiales = $datos['historial'];
?>

<?php
include_once __DIR__ . '/../../../views/layouts/header_especialista.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../../views/layouts/sidebar_especialista.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <!-- Top Bar -->
                <?php
                include_once __DIR__ . '/../../../views/layouts/topbar_especialista.php';
                ?>

                <!-- Header del Paciente -->
                <div class="patient-header">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <a href="<?= BASE_URL ?>/especialista/pacientes-atendidos" class="btn btn-outline-light btn-sm mb-3"><i class="bi bi-arrow-left"></i>Volver a pacientes atendidos</a>
                            </div>
                        </div>

                        <div class="card patient-card shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-auto text-center mb-3 mb-md-0">
                                        <div class="patient-avatar">
                                            <img class="img-usuario" src="<?= BASE_URL ?>/public/uploads/pacientes/<?= $paciente['foto'] ?>" alt="<?= $paciente['nombre_paciente'] ?>">
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h2 class="patient-name mb-2"><?= $paciente['nombre_paciente'] ?> <?= $paciente['apellido_paciente'] ?></h2>
                                                <p class="patient-info mb-1">
                                                    <i class="bi bi-card-text text-primary"></i>
                                                    <strong><?= $paciente['tipo_documento'] ?>:</strong> <?= $paciente['numero_documento'] ?>
                                                </p>
                                                <p class="patient-info mb-1">
                                                    <i class="bi bi-calendar text-primary"></i>
                                                    <strong>Edad:</strong> <?= $paciente['edad'] ?> años
                                                </p>
                                            </div>

                                            <div class="col-md-6">
                                                <p class="patient-info mb-1">
                                                    <i class="bi bi-droplet-fill text-danger"></i>
                                                    <strong>Tipo de sangre:</strong> <?= $paciente['rh'] ?>
                                                </p>
                                                <p class="patient-info mb-1">
                                                    <i class="fa-solid fa-user"></i>
                                                    <strong>Sexo:</strong> <?= $paciente['genero'] ?>
                                                </p>
                                                <span class="badge badge-readonly">
                                                    <i class="bi bi-lock-fill"></i> Solo lectura
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline de Consultas -->
                <div class="container my-5">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="timeline-title mb-4">
                                <i class="bi bi-clock-history"></i> Historial de Consultas Médicas
                            </h3>
                        </div>
                    </div>

                    <!-- Timeline Container -->
                    <div class="timeline">

                        <!-- Consulta 1 -->


                        <?php if (empty($historiales)) : ?>
                            <div class="alert alert-warning">
                                No hay consultas registradas
                            </div>
                        <?php else: ?>
                            <?php foreach ($historiales as $historial): ?>
                                <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <div class="card consultation-card">
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <h5 class="consultation-date mb-0">
                                                            <i class="bi bi-calendar-event"></i>
                                                            <?= date('d/m/Y', strtotime($historial['fecha_consulta']))  ?>
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                                        <span class="badge badge-control">Control</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="consultation-summary">
                                                    <p class="consultation-reason">
                                                        <strong>Motivo:</strong> <?= $historial['motivo_consulta'] ?>
                                                    </p>
                                                    <p class="consultation-diagnosis">
                                                        <strong>Diagnóstico:</strong> <?= $historial['diagnostico'] ?>
                                                    </p>
                                                    <p class="consultation-doctor">
                                                        <i class="bi bi-person-badge"></i>
                                                        <strong>Especialista:</strong> <?= $historial['nombre_especialista'] ?> <?= $historial['apellido_especialista'] ?> - <?= $historial['especialidad'] ?>
                                                    </p>
                                                </div>

                                                <button class="btn btn-primary btn-sm mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#detalle<?= $historial['id_consulta'] ?>">
                                                    <i class="bi bi-eye"></i> Ver detalle completo
                                                </button>

                                                <!-- Detalle expandible -->
                                                <div class="collapse mt-3" id="detalle<?= $historial['id_consulta'] ?>">
                                                    <div class="detail-container">
                                                        <ul class="nav nav-tabs" id="tabs<?= $historial['id_consulta'] ?>" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link active" id="diagnostico<?= $historial['id_consulta'] ?>-tab" data-bs-toggle="tab" data-bs-target="#diagnostico<?= $historial['id_consulta'] ?>" type="button">
                                                                    <i class="bi bi-clipboard-pulse"></i> Diagnóstico
                                                                </button>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link" id="medicamentos<?= $historial['id_consulta'] ?>-tab" data-bs-toggle="tab" data-bs-target="#medicamentos<?= $historial['id_consulta'] ?>" type="button">
                                                                    <i class="bi bi-capsule"></i> Medicamentos
                                                                </button>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link" id="ordenes<?= $historial['id_consulta'] ?>-tab" data-bs-toggle="tab" data-bs-target="#ordenes<?= $historial['id_consulta'] ?>" type="button">
                                                                    <i class="bi bi-file-medical"></i> Órdenes Médicas
                                                                </button>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link" id="examenes<?= $historial['id_consulta'] ?>-tab" data-bs-toggle="tab" data-bs-target="#examenes<?= $historial['id_consulta'] ?>" type="button">
                                                                    <i class="bi bi-clipboard-data"></i> Exámenes
                                                                </button>
                                                            </li>
                                                        </ul>

                                                        <div class="tab-content p-3" id="tabsContent<?= $historial['id_consulta'] ?>">
                                                            <!-- Tab Diagnóstico -->
                                                            <div class="tab-pane fade show active" id="diagnostico<?= $historial['id_consulta'] ?>" role="tabpanel"
                                                                aria-labelledby="diagnostico<?= $historial['id_consulta'] ?>-tab">
                                                                <h6 class="detail-subtitle">Signos Vitales</h6>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-3">
                                                                        <div class="vital-sign">
                                                                            <i class="bi bi-heart-pulse"></i>
                                                                            <span class="vital-label">Presión Arterial</span>
                                                                            <span class="vital-value"><?= $historial['presion_sistolica'] ?>/<?= $historial['presion_diastolica'] ?> mmHg</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="vital-sign">
                                                                            <i class="bi bi-thermometer-half"></i>
                                                                            <span class="vital-label">Temperatura</span>
                                                                            <span class="vital-value"><?= $historial['temperatura'] ?>°C</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="vital-sign">
                                                                            <i class="bi bi-activity"></i>
                                                                            <span class="vital-label">Frecuencia Cardíaca</span>
                                                                            <span class="vital-value"><?= $historial['frecuencia_cardiaca'] ?> lpm</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="vital-sign">
                                                                            <i class="bi bi-lungs"></i>
                                                                            <span class="vital-label">Frecuencia Respiratoria</span>
                                                                            <span class="vital-value"><?= $historial['frecuencia_respiratoria'] ?> rpm</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <h6 class="detail-subtitle mt-4">Diagnóstico Completo</h6>
                                                                <p><?= $historial['diagnostico'] ?>.</p>

                                                                <h6 class="detail-subtitle mt-4">Tratamiento y Recomendaciones</h6>
                                                                <p><?= $historial['tratamiento'] ?> <?= $historial['observaciones'] ?>.</p>
                                                            </div>

                                                            <!-- Tab Medicamentos -->
                                                            <div class="tab-pane fade" id="medicamentos<?= $historial['id_consulta'] ?>" role="tabpanel"
                                                                aria-labelledby="medicamentos<?= $historial['id_consulta'] ?>-tab">
                                                                <div class=" table-responsive">
                                                                    <table class="table table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Medicamento</th>
                                                                                <th>Dosis</th>
                                                                                <th>Frecuencia</th>
                                                                                <th>Duración</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Ibuprofeno 400mg</td>
                                                                                <td>1 tableta</td>
                                                                                <td>Cada 8 horas</td>
                                                                                <td>5 días</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Omeprazol 20mg</td>
                                                                                <td>1 cápsula</td>
                                                                                <td>Cada 24 horas</td>
                                                                                <td>7 días</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                            <!-- Tab Órdenes Médicas -->
                                                            <div class="tab-pane fade" id="ordenes<?= $historial['id_consulta'] ?>" role="tabpanel"
                                                                aria-labelledby="ordenes<?= $historial['id_consulta'] ?>-tab">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item">
                                                                        <i class="bi bi-check-circle-fill text-success"></i>
                                                                        Control post-operatorio en 1 mes
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <i class="bi bi-check-circle-fill text-success"></i>
                                                                        Curación de herida cada 3 días
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <i class="bi bi-check-circle-fill text-success"></i>
                                                                        Evitar ejercicio físico intenso por 3 semanas
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                            <!-- Tab Exámenes -->
                                                            <div class="tab-pane fade" id="examenes<?= $historial['id_consulta'] ?>" role="tabpanel"
                                                                aria-labelledby="examenes<?= $historial['id_consulta'] ?>-tab">
                                                                <div class="alert alert-info">
                                                                    <i class="bi bi-info-circle"></i>
                                                                    No se solicitaron exámenes de laboratorio en esta consulta.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php
            include_once __DIR__ . '/../../../views/layouts/footer_especialista.php';
            ?>