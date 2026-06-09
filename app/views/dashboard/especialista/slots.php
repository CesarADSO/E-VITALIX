<?php
require_once BASE_PATH . '/app/helpers/session_especialista.php';
require_once BASE_PATH . '/app/controllers/slotController.php';

// LÓGICA PARA PAGINACIÓN SEGURA

// 1. Traer todos los slots de la base de datos
$todos_los_slots = mostrarSlots();

// 2. Configurar la paginación
$registros_por_pagina = 10; // Muestra 10 registros por página
$total_registros = is_array($todos_los_slots) ? count($todos_los_slots) : 0;
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
$slots = is_array($todos_los_slots) ? array_slice($todos_los_slots, $indice_inicio, $registros_por_pagina) : [];
?>

<?php
include_once __DIR__ . '/../../layouts/header_especialista.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_especialista.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <!-- Horarios Section -->
                <div id="HorariosSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_especialista.php';
                    ?>

                    <!-- Horarios Header -->
                    <h4 class="mb-4">Disponibilidad de horarios</h4>
                    <p class="mb-4 d-none d-md-block">Gestione sus bloques en los cuales puede atender pacientes: Acá podrá visualizarlos, y modificar su estado si es necesario.</p>
                    <!-- Horarios Table -->
                    <div class="card shadow-sm d-none d-lg-block">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0 text-white">
                                <i class="bi bi-calendar-check me-2"></i>
                                Gestión de horarios
                            </h5>
                        </div>
                        <div class="card-body" style="padding: 0;">
                            <?php if (empty($slots)): ?>
                                <div class="alert alert-info text-center" role="alert">
                                    <i class="bi bi-info-circle me-2"></i>
                                    No tienes disponibilidad registrada en este momento
                                </div>
                            <?php else: ?>
                                <div class="bg-white rounded shadow-sm p-4 cont-tabla-consultorios table-responsive">
                                    <table class="table table-hover align-middle table-pacientes table-bordered" id="tablaSlots">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Disponibilidad</th>
                                                <th>
                                                    Especialista
                                                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                                </th>
                                                <th>Consultorio</th>
                                                <th>Fecha</th>
                                                <th>Hora inicio</th>
                                                <th>Hora fin</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($slots)): ?>
                                                <?php foreach ($slots as $slot): ?>
                                                    <tr>
                                                        <td><?= $slot['id_disponibilidad'] ?></td>
                                                        <td><?= $slot['nombres'] ?> <?= $slot['apellidos'] ?></td>
                                                        <td><?= $slot['nombre_consultorio'] ?></td>
                                                        <td><?= date('d/m/Y', strtotime($slot['fecha'])) ?></td>
                                                        <td><?= substr($slot['hora_inicio'], 0, 5) ?></td>
                                                        <td><?= substr($slot['hora_fin'], 0, 5) ?></td>
                                                        <td>

                                                            <?php if ($slot['estado_slot'] === 'Disponible') : ?>
                                                                <a style="text-decoration: none;" class="badge bg-success status-badge status" href="<?= BASE_URL ?>/especialista/actualizar-slot?id=<?= $slot['id'] ?>&accion=modificarEstado"><?= $slot['estado_slot'] ?></a>
                                                            <?php elseif ($slot['estado_slot'] === 'Reservado'): ?>
                                                                <a style="text-decoration: none;" class="badge bg-secondary status-badge status" href="<?= BASE_URL ?>/especialista/actualizar-slot?id=<?= $slot['id'] ?>&accion=modificarEstado"><?= $slot['estado_slot'] ?></a>
                                                            <?php else: ?>
                                                                <a style="text-decoration: none;" class="badge bg-danger status-badge status" href="<?= BASE_URL ?>/especialista/actualizar-slot?id=<?= $slot['id'] ?>&accion=modificarEstado"><?= $slot['estado_slot'] ?></a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <td>No hay disponibilidad registrada</td>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>


                    <!-- VISTA MOVIL -->
                    <div class="row d-lg-none mt-3">
                        <?php if (!empty($slots)): ?>
                            <?php foreach ($slots as $slot): ?>
                                <div class="col-md-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title text-truncate"><?= $slot['nombres'] ?> <?= $slot['apellidos'] ?></h5>
                                                <?php if ($slot['estado_slot'] === 'Disponible') : ?>
                                                    <a style="text-decoration: none;" class="badge bg-success status-badge status" href="<?= BASE_URL ?>/especialista/actualizar-slot?id=<?= $slot['id'] ?>&accion=modificarEstado"><?= $slot['estado_slot'] ?></a>
                                                <?php elseif ($slot['estado_slot'] === 'Reservado'): ?>
                                                    <a style="text-decoration: none;" class="badge bg-secondary status-badge status" href="<?= BASE_URL ?>/especialista/actualizar-slot?id=<?= $slot['id'] ?>&accion=modificarEstado"><?= $slot['estado_slot'] ?></a>
                                                <?php else: ?>
                                                    <a style="text-decoration: none;" class="badge bg-danger status-badge status" href="<?= BASE_URL ?>/especialista/actualizar-slot?id=<?= $slot['id'] ?>&accion=modificarEstado"><?= $slot['estado_slot'] ?></a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="card-subtitle mb-3 text-body-secondary">Fecha: <?= date('d/m/Y', strtotime($slot['fecha']))  ?></h6>
                                                <h6 class="card-subtitle mb-3 text-body-secondary">Hora de inicio: <?= date('h:i A', strtotime($slot['hora_inicio'])) ?></h6>
                                                <h6 class="card-subtitle mb-3 text-body-secondary">Hora de fin: <?= date('h:i A', strtotime($slot['hora_fin'])) ?></h6>
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
                            <p>No hay disponibilidad registrada.</p>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_especialista.php';
    ?>