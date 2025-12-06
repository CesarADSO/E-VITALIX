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
                                        <i class="bi bi-building display-1 text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <h2 class="mb-2" id="consultorio-nombre">Consultorio Médico Central</h2>
                                    <p class="text-muted mb-3">
                                        <i class="bi bi-geo-alt-fill me-2"></i>
                                        <span id="consultorio-direccion">Calle 123 #45-67, Bogotá</span>
                                    </p>
                                    <div class="d-flex gap-3 align-items-center">
                                        <span class="badge-estado activo" id="consultorio-estado">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            Activo
                                        </span>
                                        <span class="text-muted">
                                            <i class="bi bi-calendar-check me-1"></i>
                                            Registrado: <span id="consultorio-fecha">15/11/2024</span>
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
                                        <span class="info-value" id="info-nombre">Consultorio Médico Central</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-pin-map me-2"></i>Ciudad:
                                        </span>
                                        <span class="info-value" id="info-ciudad">Bogotá D.C.</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-geo-alt me-2"></i>Dirección:
                                        </span>
                                        <span class="info-value" id="info-direccion">Calle 123 #45-67</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-telephone me-2"></i>Teléfono:
                                        </span>
                                        <span class="info-value" id="info-telefono">601 234 5678</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-envelope me-2"></i>Correo:
                                        </span>
                                        <span class="info-value" id="info-correo">contacto@consultorio.com</span>
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
                                            <span id="info-horario">Lunes a Viernes: 8:00 AM - 6:00 PM</span>
                                        </div>
                                        <div class="horario-item mt-2">
                                            <i class="bi bi-calendar-day text-primary me-2"></i>
                                            <span>Sábados: 8:00 AM - 12:00 PM</span>
                                        </div>
                                        <div class="horario-item mt-2">
                                            <i class="bi bi-x-circle text-danger me-2"></i>
                                            <span>Domingos: Cerrado</span>
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