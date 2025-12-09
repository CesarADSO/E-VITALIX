<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';
// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE CONSULTAR CONSULTORIOS
require_once BASE_PATH . '/app/controllers/consultorioController.php';

// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR

$datos = mostrarConsultorios();
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
                    <h4 class="mb-4">Asignación de administradores a consultorios</h4>
                    <p class="mb-4">Asigne o modifique el administrador responsable de cada consultorio desde este módulo.</p>
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
                        <!-- <a class="btn btn-primary boton-reporte" href="<?= BASE_URL ?>/superadmin/generar-reporte?tipo=consultorios" target="_blank">generar reporte pdf</a> -->
                        <table class="table-pacientes">

                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>
                                        Consultorio
                                    </th>
                                    <th>Administrador</th>
                                    <th style="width: 80px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($datos)) :  ?>
                                    <?php foreach ($datos as $consultorio) : ?>
                                        <tr>
                                            <td><img class="imgconsultorio" src="<?= BASE_URL ?>/public/uploads/consultorios/<?= $consultorio['foto'] ?>" alt="<?= $consultorio['nombre'] ?>"></td>
                                            <td><?= $consultorio['nombre'] ?></td>
                                            <td><?= $consultorio['nombres'] ?> <?= $consultorio['apellidos'] ?></td>
                                            <td>
                                                <a href="<?= BASE_URL ?>/superadmin/asignar-administrador?id=<?= $consultorio['id'] ?>"><i class="fa-solid fa-plus"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td>No hay consultorios registrados!</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>



                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>