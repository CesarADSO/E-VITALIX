<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/servicioController.php';


// Lógica para paginación segura

// 1. Traer todos los servicios de la base de datos
$todos_los_servicios = mostrarServicios();

// 2. Configurar la paginación
$registros_por_pagina = 10; // Mostrar 10 servicios por página
$total_registros = is_array($todos_los_servicios) ? count($todos_los_servicios) : 0;
$total_paginas = ceil($total_registros / $registros_por_pagina);

// 3. Capturar en que página estamos
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// 4. Validar que la pagina actual sea un número válido y esté dentro del rango permitido
if ($pagina_actual < 1) {
    $pagina_actual = 1;
}

if ($pagina_actual > $total_paginas && $total_paginas > 0) {
    $pagina_actual = $total_paginas;
}

// 5. Calcular el índice de inicio para la consulta SQL
$indice_inicio = ($pagina_actual - 1) * $registros_por_pagina;
$servicios = is_array($todos_los_servicios) ? array_slice($todos_los_servicios, $indice_inicio, $registros_por_pagina) : [];


?>


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
            <div class="col-lg-10 col-md-9 main-content">

                <!-- Servicios Section -->
                <div id="serviciosSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Pacientes Header -->
                    <h4 class="mb-4">Gestión de servicios del consultorio</h4>
                    <p class="mb-4 d-none d-md-block">Gestione los servicios de su consultorio: registre nuevos servicios, actualice los existentes, consulte sus datos y administre su estado dentro del sistema.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($servicios) ?>)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/registrar-servicio" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i> AÑADIR</a>
                    </div>

                    <!-- Servicios Table -->
                    <div class="bg-white rounded shadow-sm p-4 d-none d-lg-block">
                        <!-- <a class="btn btn-primary boton-reporte" href="<?= BASE_URL ?>/admin/generar-reporte?tipo=asistentes" target="_blank">Generar reporte pdf</a> -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-pacientes table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>
                                            Especialidad
                                        </th>
                                        <th>Consultorio</th>
                                        <th>Duración</th>
                                        <th>Precio</th>
                                        <th>Estado</th>
                                        <th style="width: 80px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($servicios)) : ?>
                                        <?php foreach ($servicios as $servicio) : ?>
                                            <tr>
                                                <td><?= $servicio['nombre'] ?></td>
                                                <td><?= $servicio['nombre_especialidad'] ?></td>
                                                <td><?= $servicio['nombre_consultorio'] ?></td>
                                                <td><?= $servicio['duracion_minutos'] ?></td>
                                                <td>$<?= $servicio['precio'] ?></td>
                                                <td><?= $servicio['estado_servicio'] ?></td>
                                                <td>
                                                    <a href="<?= BASE_URL ?>/admin/actualizar-servicio?id=<?= $servicio['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="<?= BASE_URL ?>/admin/consultar-servicio?id=<?= $servicio['id'] ?>" class="btn btn-info btn-sm text-white"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                    <a href="<?= BASE_URL ?>/admin/eliminar-servicio?id=<?= $servicio['id'] ?>&accion=eliminar" class="btn btn-danger btn-sm text-white"><i class="fa-solid fa-trash-can"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <td>No hay servicios registrados</td>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- VISTA MOVIL -->
                    <div class="row d-lg-none mt-3">
                        <?php if (!empty($servicios)): ?>
                            <?php foreach ($servicios as $servicio): ?>
                                <div class="col-md-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title text-truncate"><?= $servicio['nombre'] ?></h5>
                                                <?php if ($servicio['estado_servicio'] === 'Activo'): ?>
                                                    <span class="status-badge bg-success text-white"><?= $servicio['estado_servicio'] ?></span>
                                                <?php else: ?>
                                                    <span class="status-badge bg-danger text-white"><?= $servicio['estado_servicio'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Especialidad: <?= $servicio['nombre_especialidad'] ?></h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Duración: <?= $servicio['duracion_minutos'] ?></h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Precio: <?= $servicio['precio'] ?></h6>
                                            </div>
                                            <div class="cont-botones d-flex justify-content-end gap-2">
                                                <a href="<?= BASE_URL ?>/admin/actualizar-servicio?id=<?= $servicio['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="<?= BASE_URL ?>/admin/consultar-servicio?id=<?= $servicio['id'] ?>" class="btn btn-info btn-sm text-white"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                <a href="<?= BASE_URL ?>/admin/eliminar-servicio?id=<?= $servicio['id'] ?>&accion=eliminar" class="btn btn-danger btn-sm text-white"><i class="fa-solid fa-trash-can"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <?php if (isset($total_paginas) && $total_paginas > 1) : ?>
                                <div class="col-12 mt-4 mb-5">
                                    <nav aria-label="Navegación de horarios móvil">
                                        <ul class="pagination pagination-sm justify-content-center">

                                            <!-- Si la página actual es menor o igual a 1 entonces ponemos la clase disabled para evitar que se pueda ir a una página "0" que no existe y al botón anterior cogemos la página actual y le restamos 1 para volver una página atrás -->
                                            <li class="page-item <?= ($pagina_actual <= 1) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="?pagina=<?= $pagina_actual - 1 ?>">
                                                    <i class="bi bi-chevron-left"></i>
                                                </a>
                                            </li>

                                            <!-- Si la página actual es igual a 1 entonces ponemos la clase active que pinta el botón de azulito y a ese botón le ponemos el número 1 -->

                                            <li class="page-item <?= ($pagina_actual == 1) ? 'active' : '' ?>">
                                                <a class="page-link" href="?pagina=1">1</a>
                                            </li>
                                            <!-- Si la página actual es mayor a 3 entonces mostramos un botón con puntos suspensivos pero con la clase disabled eso quiere decir que se muestran de a 3 botones disponibles para presionar -->
                                            <?php if ($pagina_actual > 3): ?>
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            <?php endif; ?>

                                            <!-- Aquí hacemos el bucle para que los botones de paginación se muestren según el número de página que sean necesarias para mostrar todos los registros -->
                                            <?php for ($i = max(2, $pagina_actual - 1); $i <= min($total_paginas - 1, $pagina_actual + 1); $i++) : ?>
                                                <li class="page-item <?= ($pagina_actual == $i) ? 'active' : '' ?>">
                                                    <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- Si la página actual es menor que el total de páginas menos 2 entonces mostramos un botón con puntos suspensivos pero con la clase disabled -->
                                            <?php if ($pagina_actual < $total_paginas - 2): ?>
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            <?php endif; ?>

                                            <!-- Si la página actual es igual al total de páginas entonces ponemos la clase active que pinta el botón de azulito -->
                                            <li class="page-item <?= ($pagina_actual == $total_paginas) ? 'active' : '' ?>">
                                                <a class="page-link" href="?pagina=<?= $total_paginas ?>"><?= $total_paginas ?></a>
                                            </li>


                                            <!-- Si la página actual es mayor o igual al total de páginas entonces desabilitamos la flecha derecha para evitar que siga avanzando a una página que no existe -->
                                            <li class="page-item <?= ($pagina_actual >= $total_paginas) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="?pagina=<?= $pagina_actual + 1 ?>">
                                                    <i class="bi bi-chevron-right"></i>
                                                </a>
                                            </li>

                                        </ul>
                                    </nav>
                                </div>

                            <?php endif; ?>
                        <?php else: ?>
                            <p>No hay servicios registrados.</p>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>