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
                            <div class="stat-label">Total citas agendadas</div>
                            <div class="stat-value"><?= $totalCitasProgramadas ?></div>
                            <div class="stat-subtitle">Contigo</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Total citas pendientes</div>
                            <div class="stat-value"><?= $totalCitasPendientes ?></div>
                            <div class="stat-subtitle">Por atender</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Pacientes atendidos</div>
                            <div class="stat-value"><?= $totalPacientesAtendidos ?></div>
                            <div class="stat-subtitle">Por ti</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Citas programadas para hoy</div>
                            <div class="stat-value"><?= $totalCitasProgramadasHoy ?></div>
                            <div class="stat-subtitle">Para hoy</div>
                        </div>
                    </div>

                    <!-- Chart -->
                    <!-- <div class="chart-card">
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
                    </div> -->

                    <!-- Bottom Section -->
                    <div class="bottom-section">
                        <!-- Specialists Table -->
                        <div class="specialists-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="section-title mb-0">Citas pendientes por atender</h3>
                            </div>
                            <div class="table-header">
                                <div>Paciente</div>
                                <div>Hora</div>
                                <div>Estado</div>
                                <div>Acciones</div>
                            </div>
                            <?php if (!empty($citas)): ?>
                                <?php foreach ($citas as $cita) ?>
                                <div class="specialist-row">
                                    <div class="specialist-name"><?= $cita['nombre_paciente'] ?> <?= $cita['apellido_paciente'] ?></div>
                                    <div><?= $cita['fecha'] ?></div>
                                    <div>
                                        <?php if ($cita['estado_cita'] === 'CONFIRMADA'): ?>
                                                        <span class="status-badge status status-aceptada">
                                                            <?= $cita['estado_cita'] ?>
                                                        </span>
                                                    <?php elseif ($cita['estado_cita'] === 'PENDIENTE'): ?>
                                                        <span class="status-badge status status-pendiente">
                                                            <?= $cita['estado_cita'] ?>
                                                        </span>
                                                    <?php elseif ($cita['estado_cita'] === 'COMPLETADA'): ?>
                                                        <span class="status-badge status status-completada">
                                                            <?= $cita['estado_cita'] ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="status-badge status status-cancelada">
                                                            <?= $cita['estado_cita'] ?>
                                                        </span>
                                                    <?php endif; ?>
                                    </div>
                                    <div>
                                        <?php if ($cita['estado_cita'] === 'PENDIENTE'): ?>
                                            <a href="<?= BASE_URL ?>/especialista/aceptar-cita?id=<?= $cita['id_cita'] ?>&accion=aceptar" class="btn btn-sm btn-success btn-aceptar"
                                                data-cita-id="<?= $cita['id_cita'] ?>"
                                                title="Aceptar cita">
                                                <i class="bi bi-check-circle"></i></a>
                                            <a href="<?= BASE_URL ?>/especialista/cancelar-cita?id=<?= $cita['id_cita'] ?>&accion=cancelar" class="btn btn-sm btn-danger btn-cancelar"
                                                data-cita-id="<?= $cita['id_cita'] ?>"
                                                title="Cancelar cita">
                                                <i class="bi bi-x-circle"></i></a>
                                        <?php elseif ($cita['estado_cita'] === 'CONFIRMADA'): ?>
                                            <a href="<?= BASE_URL ?>/especialista/iniciar-consulta?id_cita=<?= $cita['id_cita'] ?>&id_paciente=<?= $cita['id_paciente'] ?>&id_servicio=<?= $cita['id_servicio'] ?>" class="btn btn-sm btn-info" title="Iniciar consulta"><i class="fa-solid fa-book" style="color: #fff;"></i></a>
                                        <?php else: ?>
                                            <span class="text-muted small">Sin acciones disponibles</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php else :?>
                                <div class="text-center p-4">
                                    <p class="mb-0">No hay citas pendientes.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Appointments Chart -->
                        <div class="appointments-card">
                            <h3 class="section-title">Promedio de Citas</h3>
                            <div class="donut-chart">
                                <canvas id="donutChart"></canvas>
                                <div class="donut-center">
                                    <div class="donut-value"><?= $totalCitasProgramadas ?></div>
                                    <div class="donut-label">citas agendadas</div>
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