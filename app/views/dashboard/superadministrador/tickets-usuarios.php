<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';
require_once BASE_PATH . '/app/controllers/ticketController.php';



// Lógica para paginación segura

// 1. Traer todos los tickets de la base de datos
$todos_los_tickets = listarTodosParaSuperAdmin();


// 2. Configurar la paginación
$registros_por_pagina = 10; // Mostrar 10 tickets por página
$total_registros = is_array($todos_los_tickets) ? count($todos_los_tickets) : 0;
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
$tickets = is_array($todos_los_tickets) ? array_slice($todos_los_tickets, $indice_inicio, $registros_por_pagina) : [];
?>

<?php
include_once __DIR__ . '/../../layouts/header_superadministrador.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_superadministrador.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <div class="section-tickets">
                    <!-- TOP BAR -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_superadministrador.php';
                    ?>

                    <!-- TICKETS HEADER -->
                    <h4 class="mb-4">Tickets de los usuarios</h4>
                    <p class="mb-4 d-none d-md-block">En esta interfaz usted podrá consultar los tickets de soporte técnico que han enviado los usuarios, podrá visualizar su estado y podrá dar por finalizado el ticket cuando usted quiera</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0" style="text-decoration: none; font-size: 14px;">← Todos(<?= count($tickets) ?>)</button>
                        </div>
                    </div>

                    <div class="card shadow-sm d-none d-md-block">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0 text-white"><i class="bi bi-calendar-check me-2"></i>Lista de tickets</h5>
                        </div>

                        <div class="card-body">
                            <div class="bg-white rounded shadow-sm mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-pacientes table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Email</th>
                                                <th>Rol</th>
                                                <th>Título</th>
                                                <th>Estado</th>
                                                <th>Fecha de creación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($tickets)): ?>
                                                <?php foreach ($tickets as $ticket): ?>

                                                    <tr>
                                                        <td><?= $ticket['email'] ?></td>
                                                        <td><?= $ticket['rol'] ?></td>
                                                        <td><?= $ticket['titulo'] ?></td>
                                                        <td>
                                                            <?php if ($ticket['estado'] === 'ABIERTO'): ?>
                                                                <span class="badge bg-info status-badge status text-white"><?= $ticket['estado'] ?></span>
                                                            <?php elseif ($ticket['estado'] === 'RESPONDIDO'): ?>
                                                                <span class="badge bg-success status-badge status text-white"><?= $ticket['estado'] ?></span>
                                                            <?php else: ?>
                                                                <span class="badge bg-danger status-badge status text-white"><?= $ticket['estado'] ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= $ticket['created_at'] ?></td>
                                                        <td>
                                                            <?php if ($ticket['estado'] === 'ABIERTO'): ?>
                                                                <a href="<?= BASE_URL ?>/superadmin/consultar-ticket?id=<?= $ticket['id'] ?>" class="btn btn-sm btn-info" title="Consultar ticket"><i class="fa-solid fa-magnifying-glass lupa"></i></a>
                                                                <a href="<?= BASE_URL ?>/superadmin/responder-ticket?id=<?= $ticket['id'] ?>" class="btn btn-sm btn-success" title="Responder ticket"><i class="fa-solid fa-pen-to-square editar"></i></a>
                                                            <?php elseif ($ticket['estado'] === 'RESPONDIDO'): ?>
                                                                <a href="<?= BASE_URL ?>/superadmin/consultar-ticket?id=<?= $ticket['id'] ?>" class="btn btn-sm btn-info" title="Consultar ticket"><i class="fa-solid fa-magnifying-glass lupa"></i></a>
                                                            <?php else: ?>
                                                                <a href="<?= BASE_URL ?>/superadmin/consultar-ticket?id=<?= $ticket['id'] ?>" class="btn btn-sm btn-info" title="Consultar ticket"><i class="fa-solid fa-magnifying-glass lupa"></i></a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <td>No hay tickets creados</td>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- VISTA MOVIL -->
                    <div class="row d-lg-none mt-3">
                        <?php if (!empty($tickets)): ?>
                            <?php foreach ($tickets as $ticket): ?>
                                <div class="col-md-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title text-truncate"><?= $ticket['email'] ?></h5>
                                                <?php if ($ticket['estado'] === 'ABIERTO'): ?>
                                                    <span class="badge bg-info status-badge status text-white"><?= $ticket['estado'] ?></span>
                                                <?php elseif ($ticket['estado'] === 'RESPONDIDO'): ?>
                                                    <span class="badge bg-success status-badge status text-white"><?= $ticket['estado'] ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger status-badge status text-white"><?= $ticket['estado'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Rol: <?= $ticket['rol'] ?></h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Título: <?= $ticket['titulo'] ?></h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Fecha de creación: <?= $ticket['created_at'] ?></h6>
                                            </div>
                                            <div class="cont-botones d-flex justify-content-end gap-2">
                                                <?php if ($ticket['estado'] === 'ABIERTO'): ?>
                                                    <a href="<?= BASE_URL ?>/superadmin/consultar-ticket?id=<?= $ticket['id'] ?>" class="btn btn-sm btn-info" title="Consultar ticket"><i class="fa-solid fa-magnifying-glass lupa"></i></a>
                                                    <a href="<?= BASE_URL ?>/superadmin/responder-ticket?id=<?= $ticket['id'] ?>" class="btn btn-sm btn-success" title="Responder ticket"><i class="fa-solid fa-pen-to-square editar"></i></a>
                                                <?php elseif ($ticket['estado'] === 'RESPONDIDO'): ?>
                                                    <a href="<?= BASE_URL ?>/superadmin/consultar-ticket?id=<?= $ticket['id'] ?>" class="btn btn-sm btn-info" title="Consultar ticket"><i class="fa-solid fa-magnifying-glass lupa"></i></a>
                                                <?php else: ?>
                                                    <a href="<?= BASE_URL ?>/superadmin/consultar-ticket?id=<?= $ticket['id'] ?>" class="btn btn-sm btn-info" title="Consultar ticket"><i class="fa-solid fa-magnifying-glass lupa"></i></a>
                                                <?php endif; ?>
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
                            <p>No hay tickets creados.</p>

                        <?php endif; ?>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>