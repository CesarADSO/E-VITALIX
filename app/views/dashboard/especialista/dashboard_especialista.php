

<!-- AQUI VA EL INCLUDE DEL HEADER -->
<?php
include_once __DIR__ . '/../../layouts/header_especialista.php';

?>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <!-- AQUI VA EL INCLUDE EL SIDEBAR -->

            <?php
            include_once __DIR__ . '/../../layouts/sidebar_especialista.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <!-- Dashboard Section -->
                <div id="dashboardSection">
                    <!-- Top Bar -->
                    <!-- AQUI VA EL INCLUDE DEL TOP BAR -->

                <?php
                include_once __DIR__ . '/../../layouts/topbar_especialista.php';
                ?>


                    <!-- Stats Cards -->
                    <div class="stats-cards">
                        <div class="stat-card">
                            <div class="stat-label">Citas Agendas</div>
                            <div class="stat-value">856</div>
                            <div class="stat-subtitle">por semana</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Citas exitosas</div>
                            <div class="stat-value">200</div>
                            <div class="stat-subtitle">Por día</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Especialistas</div>
                            <div class="stat-value">30</div>
                            <div class="stat-subtitle">Registrados</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Nuevo pacientes registrados<br>este mes</div>
                            <div class="stat-value">20</div>
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
                                <h3 class="section-title mb-0">Estado de los especialistas</h3>
                                <button class="filter-btn">
                                    Filtros <i class="bi bi-sliders"></i>
                                </button>
                            </div>
                            <div class="table-header">
                                <div>Nombres</div>
                                <div>Especialidad</div>
                                <div>Edad</div>
                                <div>Disponible</div>
                                <div>Estado</div>
                            </div>
                            <div class="specialist-row">
                                <div class="specialist-info">
                                    <div class="specialist-avatar"></div>
                                    <div class="specialist-name">Justin Lipshutz</div>
                                </div>
                                <div>Médico General</div>
                                <div>22</div>
                                <div class="progress-text">+100%</div>
                                <div><span class="status-badge status-espera">En espera</span></div>
                            </div>
                            <div class="specialist-row">
                                <div class="specialist-info">
                                    <div class="specialist-avatar"></div>
                                    <div class="specialist-name">Marcus Culhane</div>
                                </div>
                                <div>Cardiólogo</div>
                                <div>24</div>
                                <div class="progress-text">+95%</div>
                                <div><span class="status-badge status-bloqueado">Bloqueado</span></div>
                            </div>
                            <div class="specialist-row">
                                <div class="specialist-info">
                                    <div class="specialist-avatar"></div>
                                    <div class="specialist-name">Leo Stanton</div>
                                </div>
                                <div>Dermatólogo</div>
                                <div>28</div>
                                <div class="progress-text">+88%</div>
                                <div><span class="status-badge status-active">Activo</span></div>
                            </div>
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

            </div>
        </div>
    </div>
<!-- AQUI VA EL FOOTER INCLUDE -->

<?php
include_once __DIR__ . '/../../layouts/footer_especialista.php';
?>