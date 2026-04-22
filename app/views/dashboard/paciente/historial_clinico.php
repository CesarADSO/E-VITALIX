<?php
require_once BASE_PATH . '/app/controllers/historialesController.php';

$id_paciente = $_SESSION['user']['id_paciente'];


$datos = consultarHistorialClinicoPaciente($id_paciente);


$paciente    = $datos['paciente'];
$historiales = $datos['historial'];
?>

<?php
include_once __DIR__ . '/../../../views/layouts/header_paciente.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../../views/layouts/sidebar_paciente.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <!-- Top Bar -->
                <?php
                include_once __DIR__ . '/../../../views/layouts/topbar_paciente.php';
                ?>

                <!-- Header del Paciente -->
                <div class="patient-header">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-12 d-grid gap-2 d-md-flex justify-content-md-between">
                                <a href="<?= BASE_URL ?>/paciente/dashboard" class="btn btn-outline-light btn-sm mb-3"><i class="bi bi-arrow-left"></i>Volver al dashboard</a>
                                <a href="<?= BASE_URL ?>/paciente/generar-reporte?tipo=historial_clinico&id_paciente=<?= $id_paciente ?>" class="btn btn-outline-light btn-sm mb-3" target="_blank">Generar reporte pdf</a>
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
                    <div class="timeline d-none d-lg-block">

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
                                                        <a href="<?= BASE_URL ?>/paciente/generar-reporte?tipo=consulta_medica&id_consulta=<?= $historial['id_consulta'] ?>" class="btn btn-primary btn-sm mb-3" target="_blank">Generar reporte pdf</a>
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
                                                            <!-- <li class="nav-item" role="presentation">
                                                                <button class="nav-link" id="examenes<?= $historial['id_consulta'] ?>-tab" data-bs-toggle="tab" data-bs-target="#examenes<?= $historial['id_consulta'] ?>" type="button">
                                                                    <i class="bi bi-clipboard-data"></i> Exámenes
                                                                </button>
                                                            </li> -->
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
                                                                                <td><?= $historial['nombre_medicamento'] ?></td>
                                                                                <td><?= $historial['dosis'] ?></td>
                                                                                <td><?= $historial['frecuencia'] ?></td>
                                                                                <td><?= $historial['duracion'] ?></td>
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
                                                                        <?= $historial['orden_medica'] ?>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                            <!-- Tab Exámenes -->
                                                            <!-- <div class="tab-pane fade" id="examenes<?= $historial['id_consulta'] ?>" role="tabpanel"
                                                                aria-labelledby="examenes<?= $historial['id_consulta'] ?>-tab">
                                                                <div class="alert alert-info">
                                                                    <i class="bi bi-info-circle"></i>
                                                                    No se solicitaron exámenes de laboratorio en esta consulta.
                                                                </div>
                                                            </div> -->
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

                    <!-- Timeline Container Movil -->
                    <div class="timeline d-lg-none">

                        <div class="timeline d-lg-none">
                            <?php if (empty($historiales)) : ?>
                                <div class="alert alert-warning">
                                    No hay consultas registradas
                                </div>
                            <?php else: ?>
                                <?php foreach ($historiales as $historial): ?>
                                    <div class="timeline-item position-relative mb-4 pb-3" style="border-left: 3px solid #007bff; margin-left: 15px; padding-left: 20px;">
                                        <div class="timeline-node position-absolute" style="left: -9px; top: 0; width: 15px; height: 15px; background-color: white; border: 3px solid #007bff; border-radius: 50%;"></div>

                                        <div class="card shadow-sm border-0">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                                    <h5 class="mb-0 text-primary fw-bold">
                                                        <i class="bi bi-calendar-event me-2"></i><?= date('d/m/Y', strtotime($historial['fecha_consulta'])) ?>
                                                    </h5>
                                                    <a href="<?= BASE_URL ?>/paciente/generar-reporte?tipo=consulta_medica&id_consulta=<?= $historial['id_consulta'] ?>" class="btn btn-outline-primary btn-sm" target="_blank">
                                                        <i class="bi bi-file-earmark-pdf"></i> <span class="d-none d-sm-inline">PDF</span>
                                                    </a>
                                                </div>

                                                <div class="mb-3">
                                                    <p class="mb-2" style="font-size: 15px;">
                                                        <strong class="text-secondary">Motivo:</strong> <?= $historial['motivo_consulta'] ?>
                                                    </p>
                                                    <p class="mb-2" style="font-size: 15px;">
                                                        <strong class="text-secondary">Diagnóstico:</strong> <?= $historial['diagnostico'] ?>
                                                    </p>
                                                    <p class="mb-0 text-muted" style="font-size: 14px;">
                                                        <i class="bi bi-person-badge me-1"></i>
                                                        <strong>Especialista:</strong> <?= $historial['nombre_especialista'] ?> - <?= $historial['especialidad'] ?>
                                                    </p>
                                                </div>

                                                <div class="d-grid gap-2">
                                                    <button class="btn btn-primary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#detalleMovil<?= $historial['id_consulta'] ?>">
                                                        <i class="bi bi-eye me-2"></i>Ver detalle completo
                                                    </button>
                                                </div>

                                                <div class="collapse mt-3" id="detalleMovil<?= $historial['id_consulta'] ?>">
                                                    <div class="accordion accordion-flush shadow-sm rounded border" id="accordion<?= $historial['id_consulta'] ?>">

                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDiag<?= $historial['id_consulta'] ?>">
                                                                    <i class="bi bi-clipboard-pulse me-2"></i> Signos y Diagnóstico
                                                                </button>
                                                            </h2>
                                                            <div id="collapseDiag<?= $historial['id_consulta'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordion<?= $historial['id_consulta'] ?>">
                                                                <div class="accordion-body text-muted" style="font-size: 14px;">
                                                                    <div class="row g-2 mb-3 text-center">
                                                                        <div class="col-6 border rounded p-2"><i class="bi bi-heart-pulse text-danger"></i> PA: <?= $historial['presion_sistolica'] ?>/<?= $historial['presion_diastolica'] ?></div>
                                                                        <div class="col-6 border rounded p-2"><i class="bi bi-thermometer-half text-warning"></i> Temp: <?= $historial['temperatura'] ?>°C</div>
                                                                        <div class="col-6 border rounded p-2"><i class="bi bi-activity text-info"></i> FC: <?= $historial['frecuencia_cardiaca'] ?> lpm</div>
                                                                        <div class="col-6 border rounded p-2"><i class="bi bi-lungs text-primary"></i> FR: <?= $historial['frecuencia_respiratoria'] ?> rpm</div>
                                                                    </div>
                                                                    <h6 class="fw-bold text-dark mb-1">Tratamiento:</h6>
                                                                    <p><?= $historial['tratamiento'] ?> <?= $historial['observaciones'] ?></p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMeds<?= $historial['id_consulta'] ?>">
                                                                    <i class="bi bi-capsule me-2"></i> Medicamentos
                                                                </button>
                                                            </h2>
                                                            <div id="collapseMeds<?= $historial['id_consulta'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordion<?= $historial['id_consulta'] ?>">
                                                                <div class="accordion-body bg-light p-2">
                                                                    <div class="card border-0 shadow-sm">
                                                                        <div class="card-body p-3">
                                                                            <h6 class="fw-bold text-dark mb-1"><?= $historial['nombre_medicamento'] ?></h6>
                                                                            <div class="d-flex justify-content-between text-muted" style="font-size: 13px;">
                                                                                <span><strong>Dosis:</strong> <?= $historial['dosis'] ?></span>
                                                                                <span><strong>Frecuencia:</strong> <?= $historial['frecuencia'] ?></span>
                                                                            </div>
                                                                            <div class="text-muted mt-1" style="font-size: 13px;">
                                                                                <span><strong>Duración:</strong> <?= $historial['duracion'] ?></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes<?= $historial['id_consulta'] ?>">
                                                                    <i class="bi bi-file-medical me-2"></i> Órdenes Médicas
                                                                </button>
                                                            </h2>
                                                            <div id="collapseOrdenes<?= $historial['id_consulta'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordion<?= $historial['id_consulta'] ?>">
                                                                <div class="accordion-body">
                                                                    <ul class="list-group list-group-flush" style="font-size: 14px;">
                                                                        <li class="list-group-item px-0">
                                                                            <i class="bi bi-check-circle-fill text-success me-2"></i><?= $historial['orden_medica'] ?>
                                                                        </li>
                                                                    </ul>
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
                

            </div>

            <?php
            include_once __DIR__ . '/../../../views/layouts/footer_paciente.php';
            ?>