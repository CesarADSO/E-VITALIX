<?php
    require_once BASE_PATH . '/app/helpers/session_administrador.php';
    require_once BASE_PATH . '/app/controllers/servicioController.php';

    $servicios = mostrarServicios();

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
                    <p class="mb-4">Gestione los servicios de su consultorio: registre nuevos servicios, actualice los existentes, consulte sus datos y administre su estado dentro del sistema.</p>
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
                    <div class="bg-white rounded shadow-sm p-4">
                        <!-- <a class="btn btn-primary boton-reporte" href="<?= BASE_URL ?>/admin/generar-reporte?tipo=asistentes" target="_blank">Generar reporte pdf</a> -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-pacientes table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>
                                        Especialista
                                    </th>
                                    <th>Consultorio</th>
                                    <th>Duración</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th style="width: 80px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($servicios)) :?>
                                    <?php foreach($servicios as $servicio) :?>
                                <tr>
                                    <td><?= $servicio['nombre'] ?></td>
                                    <td><?= $servicio['nombre_especialista'] ?> <?= $servicio['apellido_especialista'] ?></td>
                                    <td><?= $servicio['nombre_consultorio'] ?></td>
                                    <td><?= $servicio['duracion_minutos'] ?></td>
                                    <td>$<?= $servicio['precio'] ?></td>
                                    <td><?= $servicio['estado_servicio'] ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>/admin/consultar-servicio?id=<?= $servicio['id'] ?>"><i class="fa-solid fa-magnifying-glass"></i></a>
                                        <a href="<?= BASE_URL ?>/admin/actualizar-servicio?id=<?= $servicio['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="<?= BASE_URL ?>/admin/eliminar-servicio?id=<?= $servicio['id'] ?>&accion=eliminar"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                                <?php else :?>
                                    <td>No hay servicios registrados</td>
                                <?php endif;?>
                            </tbody>
                        </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>