<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';


?>

<!-- AQUI VA EL INCLUDE DEL HEADER -->
<?php
include_once __DIR__ . '/../../layouts/header_superadministrador.php';

?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <!-- AQUI VA EL INCLUDE EL SIDEBAR -->

            <?php
            include_once __DIR__ . '/../../layouts/sidebar_superadministrador.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <!-- Dashboard Section -->
                <div id="dashboardSection">
                    <!-- Top Bar -->
                    <!-- AQUI VA EL INCLUDE DEL TOP BAR -->

                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_superadministrador.php';
                    ?>


                    <!-- Stats Cards -->
                    <div class="stats-cards">
                        <div class="stat-card">
                            <div class="stat-label">Total de consultorios</div>
                            <div class="stat-value"><?= $totalConsultorios ?></div>
                            <div class="stat-subtitle">registrados</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Total de usuarios</div>
                            <div class="stat-value"><?= $totalUsuarios ?></div>
                            <div class="stat-subtitle">Registrados</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Especialidades activas</div>
                            <div class="stat-value"><?= $totalEspecialidades ?></div>
                            <div class="stat-subtitle">Registradas</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Nuevos consultorios<br>este mes</div>
                            <div class="stat-value"><?= $nuevosConsultoriosPorMes ?></div>
                            <div class="stat-subtitle">En este mes</div>
                        </div>
                    </div>

                    <!-- Chart -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3 class="chart-title">Crecimiento de la infraestructura</h3>
                            <div class="d-flex align-items-center gap-3">
                                <div class="chart-legend">
                                    <div class="legend-item">
                                        <div class="legend-dot" style="background-color: #007bff;"></div>
                                        <span>Nuevas sedes</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-dot" style="background-color: #90CAF9;"></div>
                                        <span>Nuevos usuarios</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>

                    <!-- Bottom Section -->
                    <div class="bottom-section">
                        <!-- Specialists Table -->
                        <div class="specialists-card d-none d-lg-block">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="section-title mb-0">últimos 5 consultorios</h3>
                            </div>
                            <div class="table-header">
                                <div>Consultorio</div>
                                <div>Ciudad</div>
                                <div>Administrador</div>
                                <div>Estado</div>
                            </div>
                            <?php if (!empty($ultimosConsultorios)): ?>
                                <?php foreach ($ultimosConsultorios as $consultorio): ?>
                                    <div class="specialist-row">
                                        <div class="specialist-info">
                                            <div class="specialist-name"><?= $consultorio['nombre'] ?></div>
                                        </div>
                                        <div><?= $consultorio['ciudad'] ?></div>
                                        <div><?= $consultorio['nombres'] ?> <?= $consultorio['apellidos'] ?></div>
                                        <div>
                                            <span class="status-badge status-espera"><?= $consultorio['estado'] ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-4">No hay consultorios registrados.</div>
                            <?php endif; ?>
                        </div>

                        <!-- VISTA MOVIL -->
                    <div class="row d-lg-none mt-3">
                        <?php if (!empty($ultimosConsultorios)): ?>
                            <?php foreach ($ultimosConsultorios as $consultorio): ?>
                                <div class="col-md-6 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title"><?= $consultorio['nombre'] ?></h5>
                                                <?php if ($consultorio['estado'] === 'Activo'): ?>
                                                    <span class="status-badge bg-primary text-white"><?= $consultorio['estado'] ?></span>
                                                <?php else: ?>
                                                    <span class="status-badge bg-danger text-white"><?= $consultorio['estado'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Ciudad: <?= $consultorio['ciudad'] ?></h6>
                                            </div>
                                            <div class="cont-botones d-flex justify-content-end gap-2">
                                                <a href="<?= BASE_URL ?>/superadmin/actualizar-consultorio?id=<?= $consultorio['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="<?= BASE_URL ?>/superadmin/consultar-consultorio?id=<?= $consultorio['id'] ?>" class="btn btn-info btn-sm text-white"><i class="fa-solid fa-magnifying-glass"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center py-4">No hay consultorios registrados.</div>
                        <?php endif; ?>
                    </div>

                        <!-- Appointments Chart -->
                        <div class="appointments-card">
                            <h3 class="section-title">Estado de Afiliaciones Global</h3>
                            <div class="donut-chart">
                                <canvas id="donutChart"></canvas>
                                <div class="donut-center">
                                    <div class="donut-value"><?= $totalConsultorios ?></div>
                                    <div class="donut-label">Sedes totales</div>
                                </div>
                            </div>
                            <div class="appointments-legend">
                                <div class="legend-item">
                                    <div class="legend-dot" style="background-color: #007bff;"></div>
                                    <span>Sedes activas</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-dot" style="background-color: #90CAF9;"></div>
                                    <span>Sedes inactivas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <!-- End Consultorios Section -->


                <!-- End Profesionales Section -->

            </div>
        </div>
    </div>
    <!-- AQUI VA EL FOOTER INCLUDE -->

    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>