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
            <div class="main-content col-lg-10 col-md-9">
                <!-- Top Bar -->
                <?php 
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                ?>

                <h4 class="mb-4">Detalle del paciente: Juan Pérez González</h4>

                <!-- Patient Detail Container -->
                <div class="container-fluid mt-4">
                    <!-- Patient Header Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    <div class="patient-avatar">
                                        <img src="https://via.placeholder.com/150" alt="Foto Paciente" class="rounded-circle" width="120" height="120">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <h3 class="mb-1" id="paciente-nombre">Juan Pérez González</h3>
                                    <p class="text-muted mb-2">
                                        <i class="bi bi-credit-card me-2"></i>
                                        <span id="paciente-documento">CC 1234567890</span>
                                    </p>
                                    <div class="d-flex gap-3">
                                        <span class="badge bg-info">
                                            <i class="bi bi-gender-male me-1"></i>
                                            <span id="paciente-genero">Masculino</span>
                                        </span>
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-calendar me-1"></i>
                                            <span id="paciente-edad">35 años</span>
                                        </span>
                                        <span class="badge bg-success">
                                            <i class="bi bi-shield-check me-1"></i>
                                            <span id="paciente-eps">Sura EPS</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <span class="badge bg-success p-3">
                                        <i class="bi bi-eye me-2"></i>Vista de Solo Lectura
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-lg-6">
                            <!-- Personal Information -->
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-person-vcard me-2"></i>
                                        Información Personal
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="info-row">
                                        <span class="info-label">Nombres:</span>
                                        <span class="info-value" id="info-nombres">Juan</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Apellidos:</span>
                                        <span class="info-value" id="info-apellidos">Pérez González</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Tipo de Documento:</span>
                                        <span class="info-value" id="info-tipo-doc">Cédula de Ciudadanía</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Número de Documento:</span>
                                        <span class="info-value" id="info-num-doc">1234567890</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Fecha de Nacimiento:</span>
                                        <span class="info-value" id="info-fecha-nac">15/05/1989</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Género:</span>
                                        <span class="info-value" id="info-genero">Masculino</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">RH:</span>
                                        <span class="info-value" id="info-rh">O+</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-telephone me-2"></i>
                                        Información de Contacto
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="info-row">
                                        <span class="info-label">Teléfono:</span>
                                        <span class="info-value" id="info-telefono">300 123 4567</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Ciudad:</span>
                                        <span class="info-value" id="info-ciudad">Bogotá</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Dirección:</span>
                                        <span class="info-value" id="info-direccion">Calle 123 #45-67</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-6">
                            <!-- Medical Information -->
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-heart-pulse me-2"></i>
                                        Información Médica
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="info-row">
                                        <span class="info-label">EPS:</span>
                                        <span class="info-value" id="info-eps">Sura EPS</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Historial Médico:</span>
                                        <span class="info-value" id="info-historial">
                                            Hipertensión arterial, diabetes tipo 2
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Emergency Contact -->
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        Contacto de Emergencia
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="info-row">
                                        <span class="info-label">Nombre:</span>
                                        <span class="info-value" id="info-contacto-nombre">María González</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Teléfono:</span>
                                        <span class="info-value" id="info-contacto-telefono">310 987 6543</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Dirección:</span>
                                        <span class="info-value" id="info-contacto-direccion">Calle 456 #78-90</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Aseguradora:</span>
                                        <span class="info-value" id="info-aseguradora">Seguros Bolívar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Medical History Section -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-file-medical me-2"></i>
                                Historial de Consultas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Consultorio</th>
                                            <th>Motivo</th>
                                            <th>Diagnóstico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>15/11/2024</td>
                                            <td>Medicina General</td>
                                            <td>Control de rutina</td>
                                            <td>Paciente estable</td>
                                        </tr>
                                        <tr>
                                            <td>10/10/2024</td>
                                            <td>Cardiología</td>
                                            <td>Control hipertensión</td>
                                            <td>Presión controlada</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
?>