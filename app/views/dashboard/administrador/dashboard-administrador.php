<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/especialistaController.php';
require_once BASE_PATH . '/app/helpers/alert_helper.php';


// IMPORTAMOS EL CONTROLADOR DE LOS CONSULTORIOS PARA TRAER EL ID DEL PLAN QUE TIENE EL CONSULTORIO Y ASÍ MOSTRAR LA INFORMACIÓN DEL PLAN CONTRATADO
require_once BASE_PATH . '/app/controllers/consultorioController.php';

// IMPORTAMOS EL CONTROLADOR DE LOS PLANES PARA TRAER LA INFORMACIÓN DEL PLAN CONTRATADO
require_once BASE_PATH . '/app/controllers/planesController.php';

// IMPORTAMOS EL CONTROLADOR DE LAS CITAS PARA TRAER EL NÚMERO DE CITAS AGENDADAS EN EL MES Y MOSTRARLO EN EL DASHBOARD
require_once BASE_PATH . '/app/controllers/citaController.php';

// TRAEMOS EL ID DEL CONSULTORIO DESDE LA SESIÓN PARA AGREGARSELO A LA FUNCIÓN listarConsultorio()
$id_consultorio = $_SESSION['user']['id_consultorio'] ?? '';

// LLAMAMOS LA FUNCION contrarCitasMensuales() y le pasamos el id del consultorio para mostrar el número de citas agendadas en el mes en el dashboard
$conteo_citas_agendadas = contarCitasMensuales($id_consultorio);

// ESTA VARIABLE GUARDA TODOS LOS DATOS DEL CONSULTORIO, ENTRE ELLOS EL ID DEL PLAN PARA MOSTRAR LA INFORMACIÓN DE ESE PLAN EN EL DASHBOARD
$datosConsultorio = listarConsultorio($id_consultorio);

// EXTRAEMOS EL ID DEL PLAN DE ESE CONSULTORIO
$id_plan = $datosConsultorio['id_plan'] ?? 1; // Si no tiene plan asignado, asumimos que es el plan semilla (id 1)

// EXTRAEMOS LA FECHA DE VENCIMIENTO DEL PLAN PARA MOSTRARLA EN EL DASHBOARD
$fecha_vencimiento = $datosConsultorio['fecha_vencimiento_plan'];

// AHORA SI LLAMAMOS LA FUNCIÓN mostrarInfoPlanContratado($id_plan) para mostrar los datos de ese plan en el Dashboard
$plan = mostrarInfoPlanContratado($id_plan);

// EXTRAEMOS EL LÍMITE DE CITAS MENSUALES DEL PLAN PARA HACER EL CÁLCULO MATEMÁTICO Y MOSTRAR EL PORCENTAJE DE CITAS AGENDADAS EN EL MES RESPECTO AL LÍMITE DE CITAS DEL PLAN CONTRATADO
$limite_citas = $plan['limite_citas_mensuales'];

// Cálculo matemático para mostrar el porcentaje de citas agendadas en el mes respecto al límite de citas del plan contratado, para mostrarlo en el dashboard
$porcentaje_citas = 0;
if ($limite_citas > 0) {
    $porcentaje_citas = ($conteo_citas_agendadas / $limite_citas) * 100;
}

// Este paso es enfocado al frontend y es que si el porcentaje se pasa del 100% lo dejamos en 100% para que la barra de progreso no se salga de su contenedor y rompa el diseño
if ($porcentaje_citas > 100) {
    $porcentaje_citas = 100;
}


$especialitas = mostrarEspecialistas();

?>

<?php
// Verificamos si la sesión trae la "nota" de vencimiento
if (isset($_SESSION['alerta_vencimiento']) && $_SESSION['alerta_vencimiento'] === true) {
    // Mostramos la alerta
    mostrarSweetAlert('info', 'Suscripción vencida', 'Tu plan premium ha terminado. Has regresado automáticamente al plan semilla', '/E-VITALIX/administrador/dashboard');

    // Destruimos la nota para que no se repita al recargar
    unset($_SESSION['alerta_vencimiento']);
}
?>

<!-- AQUI VA EL INCLUDE DEL HEADER -->
<?php
include_once __DIR__ . '/../../layouts/header_administrador.php';

?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <!-- AQUI VA EL INCLUDE EL SIDEBAR -->

            <?php
            include_once __DIR__ . '/../../layouts/sidebar_administrador.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <!-- Dashboard Section -->
                <div id="dashboardSection">
                    <!-- Top Bar -->
                    <!-- AQUI VA EL INCLUDE DEL TOP BAR -->

                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
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
                            <div class="stat-value"><?= count($especialitas) ?></div>
                            <div class="stat-subtitle">Registrados</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Nuevo pacientes registrados<br>este mes</div>
                            <div class="stat-value">20</div>
                            <div class="stat-subtitle">En este mes</div>
                        </div>
                    </div>

                    <!-- Chart -->
                    <div class="chart-card subscription-widget">
                        <div class="chart-header">
                            <h3 class="chart-title">Estado de su Suscripción</h3>
                            <div class="d-flex align-items-center gap-3 cont-estado-plan">
                                <?php if ($plan['estado'] === 'ACTIVO'): ?>
                                    <span class="status-badge status-active"><?= $plan['estado'] ?></span>
                                <?php else: ?>
                                    <span class="status-badge status-expired"><?= $plan['estado'] ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="subscription-body">

                            <div class="plan-info-row">
                                <div class="plan-name-container">
                                    <small class="text-auxiliar">Plan Actual</small>
                                    <p class="plan-active-name"><?= $plan['nombre'] ?></p>
                                </div>
                                <?php if($plan['nombre'] === 'Plan élite'):?>
                            
                                <span class="status-badge status-azul">Tienes el plan máximo</span>

                                <?php elseif($plan['nombre'] === 'Plan profesional'): ?>
                                <a href="<?= BASE_URL ?>/admin/confirmar-compra?id_plan=3" class="btn-primary text-white">
                                    <i class="bi bi-star-fill"></i> Mejorar a plan élite
                                </a>

                                <?php else: ?>
                                <a href="<?= BASE_URL ?>/admin/precios" class="btn-primary text-white">
                                    <i class="bi bi-star-fill"></i> Mejorar Plan
                                </a>
                                <?php endif; ?>
                            </div>

                            <div class="appointment-meter-section">
                                <div class="meter-labels">
                                    <span class="meter-title">Consumo de citas mensual</span>
                                    <span class="meter-count"><?= $conteo_citas_agendadas ?> de <?= $plan['limite_citas_mensuales'] ?> citas</span>
                                </div>
                                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: <?= $porcentaje_citas ?>%"></div>
                                </div>
                                <small class="text-auxiliar mt-1 d-block text-end">Agendadas este mes</small>
                            </div>

                            <div class="expiry-date-section">
                                <i class="bi bi-calendar3"></i>
                                <span>Fecha de próximo corte:</span>
                                <strong class="expiry-date"><?php if (empty($fecha_vencimiento)): ?>
                                        No tiene fecha de vencimiento
                                    <?php else: ?>
                                        <?= date('d/m/Y', strtotime($fecha_vencimiento)) ?>
                                    <?php endif; ?>
                                </strong>
                            </div>
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
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>