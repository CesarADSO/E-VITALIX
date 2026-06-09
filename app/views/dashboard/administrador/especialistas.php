<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS EN ESTE CASO EL SESSION ADMIN Y EL CONTROLADOR
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/especialistaController.php';

// DECLARAMOS UNA VARIABLE PARA GUARDAR LA FUNCIÓN DEL MODELO Y ASÍ PODER USAR ESA VARIABLE PARA PINTAR LOS DATOS EN LA TABLA

// Lógica para paginación segura

// 1. Traer todos los especialistas de la base de datos
$todos_los_especialistas = mostrarEspecialistas();


// 2. Configurar la paginación
$registros_por_pagina = 10; // Mostrar 10 especialistas por página
$total_registros = is_array($todos_los_especialistas) ? count($todos_los_especialistas) : 0;
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
$especialistas = is_array($todos_los_especialistas) ? array_slice($todos_los_especialistas, $indice_inicio, $registros_por_pagina) : [];


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

                <!-- Especialistas Section -->
                <div id="EspecialistasSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Especialista Header -->
                    <h4 class="mb-4">Gestión De Especialistas</h4>
                    <p class="mb-4 d-none d-md-block">Gestione a los especialistas de su consultorio: registre nuevos profesionales, actualice su información, consulte sus datos y administre su estado dentro del sistema.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($especialistas) ?>)
                            </button>
                        </div>
                        <div class="d-grid gap-2 d-lg-flex justify-content-lg-end align-items-lg-center">
                            <a href="/E-VITALIX/admin/registrar-especialista" class="btn btn-primary btn-sm btn-añadir-volver rounded-pill px-3"><i class="bi bi-plus-lg"></i> AÑADIR</a>
                            <a class="btn btn-outline-primary boton-reporte rounded-pill px-4" href="<?= BASE_URL ?>/admin/generar-reporte?tipo=especialistas" target="_blank">Generar reporte pdf</a>
                        </div>

                    </div>

                    <!-- Especialistas Table -->
                    <div class="bg-white rounded shadow-sm p-4 d-none d-lg-block">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-pacientes table-bordered">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>
                                            Nombres y apellidos
                                            <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                        </th>
                                        <th>Telefono</th>
                                        <th>Especialidad</th>
                                        <th>Estado</th>
                                        <th style="width: 80px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($especialistas)) : ?>
                                        <?php foreach ($especialistas as $especialista): ?>
                                            <tr>
                                                <td>
                                                    <div class="user-avatar">
                                                        <img class="especialistaImg" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $especialista['foto'] ?>" alt="<?= $especialista['nombres'] ?>">
                                                    </div>
                                                </td>
                                                <td><?= $especialista['nombres'] ?> <?= $especialista['apellidos'] ?></td>
                                                <td><?= $especialista['telefono'] ?></td>
                                                <td><?= $especialista['nombre_especialidad'] ?></td>
                                                <td><?= $especialista['estado'] ?></td>
                                                <td>
                                                    <a href="<?= BASE_URL ?>/admin/actualizar-especialista?id=<?= $especialista['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="<?= BASE_URL ?>/admin/consultar-especialista?id=<?= $especialista['id'] ?>" class="btn btn-info btn-sm text-white"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <td>No hay especialistas registrados.</td>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- VISTA MOVIL -->
                    <div class="row d-lg-none mt-3">
                        <?php if (!empty($especialistas)): ?>
                            <?php foreach ($especialistas as $especialista): ?>
                                <div class="col-md-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title text-truncate"><?= $especialista['nombres'] ?> <?= $especialista['apellidos'] ?></h5>
                                                <?php if ($especialista['estado'] === 'Activo'): ?>
                                                    <span class="status-badge bg-success text-white"><?= $especialista['estado'] ?></span>
                                                <?php else: ?>
                                                    <span class="status-badge bg-danger text-white"><?= $especialista['estado'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Teléfono: <?= $especialista['telefono'] ?></h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Especialidad: <?= $especialista['nombre_especialidad'] ?></h6>
                                            </div>
                                            <div class="cont-botones d-flex justify-content-end gap-2">
                                                <a href="<?= BASE_URL ?>/admin/actualizar-especialista?id=<?= $especialista['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="<?= BASE_URL ?>/admin/consultar-especialista?id=<?= $especialista['id'] ?>" class="btn btn-info btn-sm text-white"><i class="fa-solid fa-magnifying-glass"></i></a>
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
                            <p>No hay especialistas registrados.</p>

                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>