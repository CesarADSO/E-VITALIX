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
                            <h3 class="chart-title">Pacientes nuevos vs recurrentes por mes</h3>
                            <div class="d-flex align-items-center gap-3">
                                <div class="chart-legend">
                                    <div class="legend-item">
                                        <div class="legend-dot" style="background-color: #007bff;"></div>
                                        <span>Nuevos</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-dot" style="background-color: #90CAF9;"></div>
                                        <span>Recurrentes</span>
                                    </div>
                                </div>
                                <button class="filter-btn">
                                    Meses <i class="bi bi-chevron-down"></i>
                                </button>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>

                    <!-- Bottom Section -->
                    <div class="bottom-section">
                        <!-- Specialists Table -->
                        <div class="specialists-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="section-title mb-0">últimos 5 consultorios</h3>
                            </div>
                            <div class="table-header">
                                <div>Consultorio</div>
                                <div>Ciudad</div>
                                <div>Administrador</div>
                                <div>Estado</div>
                            </div>
                            <?php if(!empty($ultimosConsultorios)):?>
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

                        <!-- Appointments Chart -->
                        <div class="appointments-card">
                            <h3 class="section-title">Promedio de Citas</h3>
                            <div class="donut-chart">
                                <canvas id="donutChart"></canvas>
                                <div class="donut-center">
                                    <div class="donut-value">856</div>
                                    <div class="donut-label">citas agendas</div>
                                </div>
                            </div>
                            <div class="appointments-legend">
                                <div class="legend-item">
                                    <div class="legend-dot" style="background-color: #007bff;"></div>
                                    <span>Exitosas</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-dot" style="background-color: #90CAF9;"></div>
                                    <span>Canceladas</span>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <div style="font-weight: 600; font-size: 18px;">65%</div>
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