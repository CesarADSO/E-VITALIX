<?php
    require_once BASE_PATH . '/app/helpers/session_admin.php';
    // ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE CONSULTAR CONSULTORIOS
    require_once BASE_PATH . '/app/controllers/consultorioController.php';

    // LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR

    $datos = mostrarConsultorios();
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

                <!-- Consultorios Section -->
                <div id="consultoriosSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Consultorios Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/registrar-consultorio" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i> AÑADIR</a>
                    </div>

                    <!-- Consultorios Table -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <a href="<?= BASE_URL ?>/admin/generar-reporte?tipo=consultorios" target="_blank">generar reporte pdf</a>
                        <table class="table-pacientes">
                            
                            <thead>
                                <tr>
                                    <th>Foto</th>
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
                                    <th>Estado</th>
                                    <th style="width: 80px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($datos)) :  ?>
                                <?php foreach ($datos as $consultorio) : ?>
                                <tr>
                                    <td><img class="imgconsultorio" src="<?= BASE_URL ?>/public/uploads/consultorios/<?= $consultorio['foto'] ?>" alt="<?= $consultorio['nombre'] ?>"></td>
                                    <td><?=  $consultorio['nombre'] ?></td>
                                    <td><?=  $consultorio['direccion'] ?></td>
                                    <td><?=  $consultorio['telefono'] ?></td>
                                    <td><?=  $consultorio['ciudad'] ?></td>
                                    <td><?=  $consultorio['estado'] ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <i class="bi bi-three-dots text-muted" style="cursor: pointer;" data-bs-toggle="dropdown"></i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="/E-VITALIX/admin/consultar-consultorio"><i class="bi bi-search"></i>Ver</a></li>
                                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin/actualizar-consultorio?id=<?= $consultorio['id'] ?>"><i class="bi bi-pencil"></i>Editar</a></li>
                                                <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/admin/eliminar-consultorio?accion=eliminar&id=<?= $consultorio['id'] ?>"><i class="bi bi-trash"></i> Eliminar</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                                <?php else: ?>
                                    <tr>
                                        <td>No hay consultorios registrados!</td>
                                    </tr>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                    
                    

                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>