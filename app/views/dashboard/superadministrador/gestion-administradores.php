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
                    <h4 class="mb-4">Gestión de administradores de los consultorios</h4>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos ()
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/superadmin/registrar-administrador" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i> AÑADIR</a>
                    </div>

                    <!-- Consultorios Table -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <!-- <a class="btn btn-primary boton-reporte" href="<?= BASE_URL ?>/superadmin/generar-reporte?tipo=consultorios" target="_blank">generar reporte pdf</a> -->
                        <table class="table-pacientes">

                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>
                                        Nombres y apellidos
                                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                    </th>
                                    <th>Teléfono</th>
                                    <th>Tipo de documento</th>
                                    <th>Número de documento</th>
                                    <th>Estado</th>
                                    <th style="width: 80px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                        <tr>
                                            <td><img class="imgconsultorio" src="#" alt=""></td>
                                            <td>Julio César Morales Valencia</td>
                                            <td>3112417663</td>
                                            <td>CC</td>
                                            <td>19318781</td>
                                            <td>Activo</td>
                                            <td>
                                                <!-- <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a> -->
                                                <a href="<?= BASE_URL ?>/superadmin/actualizar-administrador"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="#"><i class="fa-solid fa-trash-can"></i></a>
                                            </td>
                                        </tr>
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