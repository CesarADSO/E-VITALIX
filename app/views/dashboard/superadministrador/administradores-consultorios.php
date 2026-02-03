<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';
// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE CONSULTAR CONSULTORIOS
require_once BASE_PATH . '/app/controllers/administradorConsultorioController.php';

// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR

$datos = mostrarAdministradoresConsultorios();
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

                <!-- Consultorios Section -->
                <div id="consultoriosSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_superadministrador.php';
                    ?>

                    <!-- Consultorios Header -->
                    <h4 class="mb-4">Asignación de consultorios a administradores</h4>
                    <p class="mb-4">Asigne o modifique un consultorio a cada administrador desde este módulo.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($datos) ?>)
                            </button>
                        </div>
                        <!-- <a href="<?= BASE_URL ?>/superadmin/registrar-consultorio" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i> AÑADIR</a> -->
                    </div>

                    <!-- Consultorios Table -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <!-- <a class="btn btn-primary boton-reporte" href="<?= BASE_URL ?>/superadmin/generar-reporte?tipo=asignaciones" target="_blank">generar reporte pdf</a> -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-pacientes table-bordered">

                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>
                                        Administrador
                                    </th>
                                    <th>Consultorio</th>
                                    <th style="width: 80px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($datos)) :  ?>
                                    <?php foreach ($datos as $administrador) : ?>
                                        <tr>
                                            <td><img class="imgconsultorio" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $administrador['foto'] ?>" alt="<?= $administrador['nombres'] ?>"></td>
                                            <td><?= $administrador['nombres'] ?> <?= $administrador['apellidos'] ?></td>
                                            <td>
                                                <?php
                                                    if (empty($administrador['id_consultorio']) || $administrador['id_consultorio'] === 0) {
                                                        echo '<span>Sin consultorio asignado</span>';
                                                    }
                                                    else {
                                                        echo $administrador['nombre_consultorio'];
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?= BASE_URL ?>/superadmin/asignar-consultorio?id=<?= $administrador['id'] ?>"><i class="fa-solid fa-plus"></i></a>
                                                <a href="<?= BASE_URL ?>/superadmin/desasignar-consultorio?accion=desasignar&id=<?= $administrador['id'] ?>"><i class="fa-solid fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td>No hay administradores registrados</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>