<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';
// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE CONSULTAR CONSULTORIOS
require_once BASE_PATH . '/app/controllers/consultorioController.php';

// ASIGNAMOS EL VALOR ID DEL REGISTRO SEGÚN LA TABLA
$id = $_GET['id'];
// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR Y LE PASAMOS LOS DATOS A UNA VARIABLE
// QUE PODAMOS MANIPULAR EN ESTE ARCHIVO
$consultorio = listarConsultorio($id);
// Decodificamos el campo "horario_atencion" que viene almacenado en la base de datos.
// Este campo es un JSON con estructura similar a:
// {"dias":["Martes","Miercoles"],"hora_apertura":"23:13","hora_cierre":"23:13"}
//
// json_decode convierte ese texto JSON en un arreglo de PHP.
// El parámetro "true" indica que queremos un array asociativo, no un objeto.
$horario = json_decode($consultorio['horario_atencion'], true);
?>


<?php
include_once __DIR__ . '/../../layouts/header_superadministrador.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_superadministrador.php';
            ?>

            <!-- Main Content -->
            <div class="main-content col-lg-10 col-md-9">
                <!-- Top Bar -->
                <?php
                include_once __DIR__ . '/../../layouts/topbar_superadministrador.php';
                ?>

                <!-- Consultorio Detail Container -->
                <div class="container-fluid mt-4">
                    <!-- Consultorio Header Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    <div class="consultorio-logo">
                                        <img class="logo-consultorio" src="<?= BASE_URL ?>/public/uploads/consultorios/<?= $consultorio['foto'] ?>" alt="<?= $consultorio['nombre'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <h2 class="mb-2" id="consultorio-nombre"><?= $consultorio['nombre'] ?></h2>
                                    <p class="text-muted mb-3">
                                        <i class="bi bi-geo-alt-fill me-2"></i>
                                        <span id="consultorio-direccion"><?= $consultorio['direccion'] ?>, <?= $consultorio['ciudad'] ?></span>
                                    </p>
                                    <div class="d-flex gap-3 align-items-center">
                                        <span class="badge-estado activo" id="consultorio-estado">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            <?= $consultorio['estado'] ?>
                                        </span>
                                        <span class="text-muted">
                                            <i class="bi bi-calendar-check me-1"></i>
                                            Registrado: <span id="consultorio-fecha"><?= $consultorio['fecha_registro'] ?></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <span class="badge bg-info-custom p-3">
                                        <i class="bi bi-eye me-2"></i>Vista de Solo Lectura
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-12">
                            <!-- General Information -->
                            <div class="card shadow-sm mb-4">
                                <div class="card-header card-header-primary">
                                    <h5 class="mb-0">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        Información General
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-building me-2"></i>Nombre:
                                        </span>
                                        <span class="info-value" id="info-nombre"><?= $consultorio['nombre'] ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-pin-map me-2"></i>Ciudad:
                                        </span>
                                        <span class="info-value" id="info-ciudad"><?= $consultorio['ciudad'] ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-geo-alt me-2"></i>Dirección:
                                        </span>
                                        <span class="info-value" id="info-direccion"><?= $consultorio['direccion'] ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-telephone me-2"></i>Teléfono:
                                        </span>
                                        <span class="info-value" id="info-telefono"><?= $consultorio['telefono'] ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-envelope me-2"></i>Correo:
                                        </span>
                                        <span class="info-value" id="info-correo"><?= $consultorio['correo_contacto'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Right Column -->
                        <div class="col-lg-6">
                            <!-- Especialidades -->
                            <div class="card shadow-sm mb-4">
                                <div class="card-header card-header-tertiary">
                                    <h5 class="mb-0">
                                        <i class="bi bi-heart-pulse-fill me-2"></i>
                                        Especialidades Médicas
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="especialidades-container" id="especialidades-lista">
                                        <span class="badge-especialidad">
                                            <i class="bi bi-bandaid"></i> Medicina General
                                        </span>
                                        <span class="badge-especialidad">
                                            <i class="bi bi-heart"></i> Cardiología
                                        </span>
                                        <span class="badge-especialidad">
                                            <i class="bi bi-people"></i> Pediatría
                                        </span>
                                        <span class="badge-especialidad">
                                            <i class="bi bi-person"></i> Dermatología
                                        </span>
                                        <span class="badge-especialidad">
                                            <i class="bi bi-eye"></i> Oftalmología
                                        </span>
                                        <span class="badge-especialidad">
                                            <i class="bi bi-tooth"></i> Odontología
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Horario de Atención -->
                            <div class="card shadow-sm mb-4">
                                <div class="card-header card-header-secondary">
                                    <h5 class="mb-0">
                                        <i class="bi bi-clock-fill me-2"></i>
                                        Horario de Atención
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="horario-container">
                                        <div class="horario-item">
                                            <i class="bi bi-calendar-week text-primary me-2"></i>
                                            <span id="info-horario"><?= implode(", ", $horario['dias']) ?>: <?= $horario['hora_apertura'] ?> - <?= $horario['hora_cierre'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Estadísticas (Opcional)
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card shadow-sm stat-card">
                                <div class="card-body text-center">
                                    <i class="bi bi-people-fill stat-icon"></i>
                                    <h3 class="stat-number">1,245</h3>
                                    <p class="stat-label">Pacientes Atendidos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card shadow-sm stat-card">
                                <div class="card-body text-center">
                                    <i class="bi bi-calendar-check-fill stat-icon"></i>
                                    <h3 class="stat-number">89</h3>
                                    <p class="stat-label">Citas Este Mes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card shadow-sm stat-card">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-badge-fill stat-icon"></i>
                                    <h3 class="stat-number">12</h3>
                                    <p class="stat-label">Profesionales</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card shadow-sm stat-card">
                                <div class="card-body text-center">
                                    <i class="bi bi-star-fill stat-icon"></i>
                                    <h3 class="stat-number">4.8</h3>
                                    <p class="stat-label">Calificación</p>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>