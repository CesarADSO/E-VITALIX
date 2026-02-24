<?php
require_once BASE_PATH . '/app/helpers/session_paciente.php';
require_once BASE_PATH . '/app/controllers/especialidadController.php';
require_once BASE_PATH . '/app/controllers/consultorioController.php';



$especialidades = listarParaLosPacientes();

// ⚠️ Inicializamos el arreglo vacío.
// La vista NO debe ejecutar lógica de consulta directamente.
// El controlador debe enviar los datos cuando exista POST.
$consultorios = $consultorios ?? [];


?>

<!-- AQUI VA EL INCLUDE DEL HEADER -->
<?php
include_once __DIR__ . '/../../layouts/header_paciente.php';

?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <!-- AQUI VA EL INCLUDE EL SIDEBAR -->

            <?php
            include_once __DIR__ . '/../../layouts/sidebar_paciente.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <!-- Dashboard Section -->
                <div class="buscarSection">
                    <!-- Top Bar -->
                    <!-- AQUI VA EL INCLUDE DEL TOP BAR -->

                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_paciente.php';
                    ?>
                    <!-- Header de la sección -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="page-header">
                                <h1 class="page-title text-white">
                                    <i class="bi bi-calendar-check text-white"></i>
                                    Agendar Cita Médica
                                </h1>
                                <p class="page-subtitle">
                                    Busca un consultorio disponible por especialidad médica
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de búsqueda -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="search-card">
                                <div class="search-card-header">
                                    <h5 class="search-card-title">
                                        <i class="bi bi-search"></i>
                                        Buscar Consultorio
                                    </h5>
                                </div>
                                <div class="search-card-body">
                                    <form id="formBusquedaConsultorio" action="<?= BASE_URL ?>/paciente/buscar-consultorio" method="POST" class="search-form">
                                        <input type="hidden" name="accion" value="buscarPorEspecialidad">
                                        <div class="row align-items-end">

                                            <!-- Select de Especialidad -->
                                            <div class="col-md-9 mb-3 mb-md-0">
                                                <label for="especialidad" class="form-label">
                                                    <i class="bi bi-stethoscope"></i>
                                                    Especialidad Médica <span class="required">*</span>
                                                </label>
                                                <select
                                                    class="form-select select-especialidad"
                                                    id="especialidad"
                                                    name="id_especialidad">
                                                    <option value="" selected disabled>Seleccione una especialidad...</option>
                                                    <!-- Opciones que se cargarán desde la BD -->
                                                    <?php if (!empty($especialidades)): ?>
                                                        <?php foreach ($especialidades as $especialidad): ?>

                                                            <option value="<?= $especialidad['id'] ?>"><?= $especialidad['nombre'] ?></option>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <option value="" disabled>No hay especialidades disponibles</option>
                                                    <?php endif; ?>

                                                </select>
                                                <div class="form-text">
                                                    <i class="bi bi-info-circle"></i>
                                                    Seleccione la especialidad médica que necesita
                                                </div>
                                            </div>

                                            <!-- Botón Buscar -->
                                            <div class="col-md-3">
                                                <button
                                                    type="submit"
                                                    class="btn btn-buscar w-100"
                                                    id="btnBuscar">
                                                    <i class="bi bi-search"></i>
                                                    Buscar Consultorios
                                                </button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Título de resultados -->
                    <div class="row d-none" id="tituloResultados">
                        <div class="col-12">
                            <div class="results-header">
                                <h4 class="results-title">
                                    <i class="bi bi-building-check"></i>
                                    Consultorios Disponibles
                                </h4>
                                <p class="results-subtitle" id="cantidadResultados"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Grid de resultados (Cards de consultorios) -->
                    <div class="row" id="resultadosConsultorios">
                        <!-- CARD TIPO A -->
                        <?php if (!empty($consultorios)): ?>
                            <?php foreach ($consultorios as $consultorio): ?>
                                <div class="consultorio-card-tipo-a">

                                    <!-- Imagen del consultorio -->
                                    <div class="consultorio-imagen-container">
                                        <!-- Badge de estado -->
                                        <div class="badge-estado">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <?= $consultorio['estado'] ?>
                                        </div>

                                        <!-- Imagen (puedes reemplazar con una imagen real desde tu BD) -->
                                        <img
                                            src="<?= BASE_URL ?>/public/uploads/consultorios/<?= $consultorio['foto'] ?>"
                                            alt="<?= $consultorio['nombre'] ?>"
                                            class="consultorio-imagen">

                                        <!-- Overlay con nombre -->
                                        <div class="consultorio-imagen-overlay">
                                            <h3 class="consultorio-nombre-imagen">
                                                <?= $consultorio['nombre'] ?>
                                            </h3>
                                        </div>
                                    </div>

                                    <!-- Cuerpo de la card -->
                                    <div class="consultorio-card-body-tipo-a">

                                        <!-- Dirección -->
                                        <div class="consultorio-direccion">
                                            <i class="bi bi-geo-alt-fill consultorio-direccion-icon"></i>
                                            <div class="consultorio-direccion-text">
                                                <span class="consultorio-direccion-label">Ubicación</span>
                                                <div class="consultorio-direccion-value">
                                                    <?= $consultorio['ciudad'] ?> - <?= $consultorio['direccion'] ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Especialidades -->
                                        <div class="consultorio-seccion">
                                            <h6 class="consultorio-seccion-titulo">
                                                <i class="bi bi-clipboard2-pulse"></i>
                                                Especialidades
                                            </h6>
                                            <div class="especialidades-container">
                                                <?php
                                                // Dividimos la cadena de especialidades por comas
                                                // Ejemplo: "Cardiología, Pediatría, Dermatología" se convierte en un array
                                                $especialidades = explode(', ', $consultorio['nombres_especialidades']);

                                                // Iteramos sobre cada especialidad para crear un cuadrito azul independiente
                                                foreach ($especialidades as $especialidad):
                                                ?>
                                                    <span class="badge-especialidad">
                                                        <i class="bi bi-heart-pulse-fill"></i>
                                                        <!-- trim() elimina espacios en blanco al inicio y final -->
                                                        <?= trim($especialidad) ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <!-- Servicios -->
                                        <div class="consultorio-seccion">
                                            <h6 class="consultorio-seccion-titulo">
                                                <i class="bi bi-list-check"></i>
                                                Servicios Disponibles
                                            </h6>
                                            <ul class="servicios-lista">
                                                <?php
                                                if (!empty($consultorio['servicios_agrupados'])):
                                                    // 1. Separamos cada bloque de servicio por el pipe |
                                                    $servicios = explode('|', $consultorio['servicios_agrupados']);
                                                    foreach ($servicios as $item): 
                                                    // 2. Separamos el ID del Nombre por los dos puntos :
                                                    list($id_serv, $nombre_serv, $precio_serv) = explode(':', $item);
                                                ?>
                                                    <li class="servicio-item">
                                                            <i class="bi bi-check-circle-fill servicio-icon"></i>
                                                            <span class="servicio-texto"><!-- trim() elimina espacios en blanco al inicio y final -->
                                                                <?= trim($nombre_serv) ?> -
                                                            </span>
                                                            <span class="servicio-texto">Precio: $<?= trim($precio_serv) ?></span>

                                                        <a href="<?= BASE_URL ?>/paciente/agendar_paso2?id_consultorio=<?= $consultorio['id_consultorio'] ?>&id_especialidad=<?= $consultorio['id_especialidad'] ?>&id_servicio=<?= $id_serv ?>"
                                                            class="btn btn-sm btn-outline-primary py-0" style="font-size: 0.8rem;">
                                                            Agendar
                                                        </a>

                                                    </li>
                                                <?php endforeach; ?>
                                                <?php else:?>
                                                    <p>No hay servicios disponibles de esta especialidad</p>
                                                <?php endif; ?>
                                            </ul>
                                        </div>

                                    </div>

                                    <!-- Footer
                                    <div class="consultorio-card-footer-tipo-a">
                                        <button class="btn btn-ver-detalles" onclick="verDetalles()">
                                            <i class="bi bi-eye-fill"></i>
                                            Ver Detalles y Agendar
                                        </button>
                                    </div> -->

                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../layouts/footer_paciente.php';
    ?>