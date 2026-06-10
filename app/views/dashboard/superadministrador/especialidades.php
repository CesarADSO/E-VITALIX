<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';
require_once BASE_PATH . '/app/controllers/especialidadController.php';



// Lógica para paginación segura

// 1. Traer todos los especialidades de la base de datos
$todas_las_especialidades = listarParaLosSuperAdministradores();


// 2. Configurar la paginación
$registros_por_pagina = 10; // Mostrar 10 especialidades por página
$total_registros = is_array($todas_las_especialidades) ? count($todas_las_especialidades) : 0;
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
$especialidades = is_array($todas_las_especialidades) ? array_slice($todas_las_especialidades, $indice_inicio, $registros_por_pagina) : [];
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

                <!-- especialidades Section -->
                <div id="especialidadesSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_superadministrador.php';
                    ?>

                    <!-- Pacientes Header -->
                    <h4 class="mb-4">Gestión de especialidades globales del sistema</h4>
                    <p class="mb-4 d-none d-lg-block">Gestione las especialidades globales del sistema.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($especialidades) ?>)
                            </button>
                        </div>
                        <button class="btn btn-primary btn-sm btn-añadir-volver" data-bs-toggle="modal" data-bs-target="#formularioModalRegistrar"><i class="bi bi-plus-lg"></i>AÑADIR</button>
                    </div>

                    <div class="card shadow-sm d-none d-lg-block">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0 text-white">
                                <i class="bi bi-calendar-check me-2"></i>
                                Lista de especialidades
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- <div class="alert alert-info text-center" role="alert">
                                    <i class="bi bi-info-circle me-2"></i>
                                    No tienes especialidades registradas.
                                </div> -->
                            <!-- asistentes Table -->
                            <div class="bg-white rounded shadow-sm p-4">
                                <!-- <a class="btn btn-primary boton-reporte" href="<?= BASE_URL ?>/admin/generar-reporte?tipo=asistentes" target="_blank">Generar reporte pdf</a> -->
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-pacientes table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Nombre
                                                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                                </th>
                                                <th>Descripción</th>
                                                <th>Estado</th>
                                                <th style="width: 80px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($especialidades)): ?>
                                                <?php foreach ($especialidades as $especialidad): ?>
                                                    <tr>
                                                        <td><?= $especialidad['nombre'] ?></td>
                                                        <td><?= $especialidad['descripcion'] ?></td>
                                                        <td>
                                                            <?php if ($especialidad['estado'] === 'ACTIVA'): ?>
                                                                <!-- <span class="badge bg-success status-bagde status text-white"><?= $especialidad['estado'] ?></span> -->
                                                                <a class="badge bg-success status-badge status btn-estado" href="<?= BASE_URL ?>/superadmin/cambiar-estado-especialidad?id=<?= $especialidad['id'] ?>&accion=modificarEstado"><?= $especialidad['estado'] ?></a>
                                                            <?php else: ?>
                                                                <!-- <span class="badge bg-danger status-bagde status text-white"><?= $especialidad['estado'] ?></span> -->
                                                                <a class="badge bg-danger status-badge status btn-estado" href="<?= BASE_URL ?>/superadmin/cambiar-estado-especialidad?id=<?= $especialidad['id'] ?>&accion=modificarEstado"><?= $especialidad['estado'] ?></a>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <!-- <p>No hay acciones disponibles</p> -->
                                                            <a href="<?= BASE_URL ?>/superadmin/editar-especialidad?id=<?= $especialidad['id'] ?>" class="btn btn-sm btn-info btn-editar-especialidad" title="Editar especialidad"><i class="fa-solid fa-pen-to-square editar"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <h2>Aún no has asociado ninguna especialidad a tu consultorio.</h2>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- VISTA MOVIL -->
                <div class="row d-lg-none mt-3">
                    <?php if (!empty($especialidades)): ?>
                        <?php foreach ($especialidades as $especialidad): ?>
                            <div class="col-md-12 mt-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="card-title"><?= $especialidad['nombre'] ?></h5>
                                            <?php if ($especialidad['estado'] === 'ACTIVA'): ?>
                                                <!-- <span class="badge bg-success status-bagde status text-white"><?= $especialidad['estado'] ?></span> -->
                                                <a class="badge bg-success status-badge status btn-estado" href="<?= BASE_URL ?>/superadmin/cambiar-estado-especialidad?id=<?= $especialidad['id'] ?>&accion=modificarEstado"><?= $especialidad['estado'] ?></a>
                                            <?php else: ?>
                                                <!-- <span class="badge bg-danger status-bagde status text-white"><?= $especialidad['estado'] ?></span> -->
                                                <a class="badge bg-danger status-badge status btn-estado" href="<?= BASE_URL ?>/superadmin/cambiar-estado-especialidad?id=<?= $especialidad['id'] ?>&accion=modificarEstado"><?= $especialidad['estado'] ?></a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="card-subtitle mb-2 text-body-secondary">Descripción: <?= $especialidad['descripcion'] ?></h6>
                                        </div>
                                        <div class="cont-botones d-flex justify-content-end gap-2">
                                            <a href="<?= BASE_URL ?>/superadmin/editar-especialidad?id=<?= $especialidad['id'] ?>" class="btn btn-sm btn-info btn-editar-especialidad" title="Editar especialidad"><i class="fa-solid fa-pen-to-square editar"></i></a>
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
                        <p>No hay administradores registrados.</p>
                    <?php endif; ?>
                </div>

                <!-- Modal para registrar una especialidad -->
                <div class="modal fade" id="formularioModalRegistrar" tabindex="-1" aria-labelledby="formularioModalLabelRegistrar" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- Header del Modal -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="formularioModalLabelRegistrar">
                                    Registrar especialidad
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Body del Modal con Formulario -->
                            <div class="modal-body">
                                <form id="miFormularioRegistrar" action="<?= BASE_URL ?>/superadmin/guardar-especialidad" method="POST">
                                    <input type="hidden" name="accion" value="registrarEspecialidad">

                                    <!-- Campo Nombre -->
                                    <div class="mb-4">
                                        <label for="nombre" class="form-label">
                                            Nombre <span class="required">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="nombreRegistrar"
                                            name="nombre"
                                            placeholder="Ingrese el nombre"
                                            required>

                                    </div>

                                    <!-- Campo Descripción -->
                                    <div class="mb-4">
                                        <label for="descripcion" class="form-label">
                                            Descripción <span class="required">*</span>
                                        </label>

                                        <textarea
                                            class="form-control"
                                            id="descripcion"
                                            name="descripcion"
                                            rows="4"
                                            placeholder="Ingrese una descripción detallada"
                                            required></textarea>

                                        <div class="form-text">
                                            Proporcione una descripción clara y detallada
                                        </div>
                                    </div>

                                    <!-- Footer del Modal -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Cancelar
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            Registrar especialidad
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>