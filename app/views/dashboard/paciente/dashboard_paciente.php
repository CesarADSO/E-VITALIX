
<?php
require_once BASE_PATH . '/app/helpers/session_paciente.php';
require_once BASE_PATH . '/app/controllers/pacienteController.php';

?>


<!DOCTYPE html>
<html lang="es">


<?php
    include_once __DIR__. '/../../layouts/header_paciente.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
                include_once __DIR__ . '/../../layouts/sidebar_paciente.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <!-- Dashboard Section -->
                <div id="dashboardSection">
                    <!-- Top Bar -->
                    <?php 
                        include_once __DIR__ . '/../../layouts/topbar_paciente.php';
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
                            <div class="stat-value">77</div>
                            <div class="stat-subtitle">Asistentes</div>
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

                <!-- Pacientes Section -->
                <div id="pacientesSection" style="display: none;">
                    <!-- Top Bar -->
                    <div class="top-bar">
                        <div class="search-bar">
                            <input type="text" class="form-control" placeholder="Buscar">
                        </div>
                        <div class="notification-icon">
                            <i class="bi bi-bell-fill text-primary"></i>
                        </div>
                    </div>

                    <!-- Pacientes Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (56)
                            </button>
                        </div>
                        <button class="btn btn-primary btn-sm" style="border-radius: 20px;">
                            <i class="bi bi-plus-lg"></i> AÑADIR
                        </button>
                    </div>

                    <!-- Pacientes Table -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <table class="table-pacientes">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" class="form-check-input">
                                    </th>
                                    <th style="width: 60px;">Foto</th>
                                    <th>
                                        Nombres
                                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                    </th>
                                    <th>Edad</th>
                                    <th>
                                        Email
                                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                    </th>
                                    <th style="width: 80px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Los pacientes se cargan dinámicamente con JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Perfil Section -->
                <div id="perfilSection" style="display: none;">
                    <!-- Top Bar -->
                    <div class="top-bar">
                        <div class="search-bar">
                            <input type="text" class="form-control" placeholder="Buscar">
                        </div>
                        <div class="notification-icon">
                            <i class="bi bi-bell-fill text-primary"></i>
                        </div>
                    </div>

                    <h4 class="mb-4">Perfil</h4>

                    <div class="row">
                        <!-- Columna Izquierda - Foto e Información -->
                        <div class="col-md-4">
                            <div class="bg-white rounded shadow-sm p-4 text-center mb-4">
                                <div
                                    style="width: 150px; height: 150px; border-radius: 50%; background-color: #e9ecef; margin: 0 auto 20px;">
                                </div>
                                <h6 style="font-weight: 600;">@Nombre-Usuario</h6>
                                <p style="font-size: 13px; color: var(--gris-proyecto);">correo@gmail.com</p>
                            </div>

                            <div class="bg-white rounded shadow-sm p-4">
                                <h6 style="font-weight: 600; margin-bottom: 15px;">Información</h6>
                                <div style="font-size: 14px; margin-bottom: 10px;">
                                    <span style="color: var(--gris-proyecto);">Nombres:</span> <span
                                        style="color: var(--color-primario);">Nombres, Apellidos</span>
                                </div>
                                <div style="font-size: 14px; margin-bottom: 10px;">
                                    <span style="color: var(--gris-proyecto);">Email:</span> correo@gmail.com
                                </div>
                                <div style="font-size: 14px; margin-bottom: 10px;">
                                    <span style="color: var(--gris-proyecto);">Tel:</span> +51 966 686 123
                                </div>
                                <div style="font-size: 14px; margin-bottom: 10px;">
                                    <span style="color: var(--gris-proyecto);">Plan:</span> <span
                                        style="color: var(--color-primario);">Básico</span>
                                </div>

                                <h6 style="font-weight: 600; margin-top: 25px; margin-bottom: 15px;">Preferencias</h6>
                                <div class="d-flex justify-content-between align-items-center" style="font-size: 14px;">
                                    <span style="color: var(--gris-proyecto);">Plan: <span
                                            style="color: var(--color-primario);">Básico</span></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2"
                                    style="font-size: 14px;">
                                    <span style="color: var(--gris-proyecto);">Día/Noche</span>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="themeSwitch">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna Derecha - Formularios -->
                        <div class="col-md-8">
                            <!-- Configuración de usuario -->
                            <div class="bg-white rounded shadow-sm p-4 mb-4">
                                <h6 style="font-weight: 600; margin-bottom: 20px;">Configuración de usuario</h6>

                                <h6 style="font-size: 14px; font-weight: 600; margin-bottom: 15px;">Detalles</h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label
                                            style="font-size: 13px; color: var(--gris-proyecto); margin-bottom: 5px;">Nombres</label>
                                        <input type="text" class="form-control campos-formulario" id="nombresInput"
                                            placeholder="Pepito Rodrick ...">
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            style="font-size: 13px; color: var(--gris-proyecto); margin-bottom: 5px;">Apellidos</label>
                                        <input type="text" class="form-control campos-formulario" id="apellidosInput"
                                            placeholder="Coronel Cifuentes ...">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label
                                            style="font-size: 13px; color: var(--gris-proyecto); margin-bottom: 5px;">Email</label>
                                        <input type="email" class="form-control campos-formulario" id="emailInput"
                                            placeholder="tuxome@gmail.com">
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            style="font-size: 13px; color: var(--gris-proyecto); margin-bottom: 5px;">Teléfono</label>
                                        <div class="input-group">
                                            <span class="input-group-text campos-formulario">+51</span>
                                            <input type="tel" class="form-control campos-formulario" id="telefonoInput"
                                                placeholder="969 123 456">
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary" onclick="guardarCambiosPerfil()"
                                    style="border-radius: 20px; padding: 8px 30px;">Guardar Cambios</button>
                            </div>

                            <!-- Contraseña -->
                            <div class="bg-white rounded shadow-sm p-4">
                                <h6 style="font-weight: 600; margin-bottom: 20px;">Contraseña</h6>

                                <h6 style="font-size: 14px; font-weight: 600; margin-bottom: 15px;">Cambiar Contraseña
                                </h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input type="password" class="form-control campos-formulario"
                                            id="contrasenaActual" placeholder="Ingresa tu contraseña actual">
                                    </div>
                                </div>

                                <h6 style="font-size: 14px; font-weight: 600; margin-bottom: 15px;">New password</h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input type="password" class="form-control campos-formulario"
                                            id="nuevaContrasena" placeholder="Ingresa tu nueva contraseña">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" class="form-control campos-formulario"
                                            id="confirmarContrasena" placeholder="Confirmar contraseña">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn btn-primary" onclick="guardarCambiosContrasena()"
                                        style="border-radius: 20px; padding: 8px 30px;">Guardar cambios</button>
                                    <a href="#" style="font-size: 13px; text-decoration: none;">¿Olvidó su
                                        contraseña?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Consultorios Section -->
                <div id="consultoriosSection" style="display: none;">
                    <!-- Top Bar -->
                    <div class="top-bar">
                        <div class="search-bar">
                            <input type="text" class="form-control" placeholder="Buscar">
                        </div>
                        <div class="notification-icon">
                            <i class="bi bi-bell-fill text-primary"></i>
                        </div>
                    </div>

                    <!-- Consultorios Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <button class="btn btn-primary btn-sm" style="border-radius: 20px;">
                            <i class="bi bi-plus-lg"></i> AÑADIR
                        </button>
                    </div>

                    <!-- Consultorios Table -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <table class="table-pacientes">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" class="form-check-input">
                                    </th>
                                    <th>
                                        Nombre
                                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                    </th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>
                                        Ciudad
                                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                    </th>
                                    <th style="width: 80px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Los consultorios se cargan dinámicamente con JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Consultorios Section -->

                <!-- Profesionales Section -->
                <div id="profesionalesSection" style="display: none;">
                    <!-- Top Bar -->
                    <div class="top-bar">
                        <div class="search-bar">
                            <input type="text" class="form-control" placeholder="Buscar">
                        </div>
                        <div class="notification-icon">
                            <i class="bi bi-bell-fill text-primary"></i>
                        </div>
                    </div>

                    <!-- Profesionales Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <button class="btn btn-primary btn-sm" style="border-radius: 20px;">
                            <i class="bi bi-plus-lg"></i> AÑADIR
                        </button>
                    </div>

                    <!-- Profesionales Table -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <table class="table-pacientes">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" class="form-check-input">
                                    </th>
                                    <th style="width: 60px;">Foto</th>
                                    <th>
                                        Nombre
                                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                    </th>
                                    <th>Edad</th>
                                    <th>Email</th>
                                    <th>Especialidad</th>
                                    <th>Consultorio</th>
                                    <th style="width: 80px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Los profesionales se cargan dinámicamente con JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Profesionales Section -->

            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>