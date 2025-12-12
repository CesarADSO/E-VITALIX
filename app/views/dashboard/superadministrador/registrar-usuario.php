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
                <div id="consultoriosSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_superadministrador.php';
                    ?>

                    <!-- Consultorios Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/superadmin/usuarios" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Registrar Superadministrador</h4>
                        <p class="text-muted mb-4 texto">Crear cuenta con permisos de superadministrador</p>

                        <form id="superadminForm" action="<?= BASE_URL ?>/superadmin/guardar-usuario" method="POST" enctype="multipart/form-data">
                            <!-- email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Ingresé el correo electrónico" required>
                            </div>

                            <div class="row">
                                <!-- Nombres -->
                                <div class="col-md-6 mb-3">
                                    <label for="nombres" class="form-label">Nombres</label>
                                    <input type="text" class="form-control" id="nombres" name="nombres"
                                        placeholder="Ingresa los nombres" required>
                                </div>

                                <!-- Apellidos -->
                                <div class="col-md-6 mb-3">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos"
                                        placeholder="Ingresa los apellidos" required>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Foto -->
                                <div class="col-md-6 mb-3">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto"
                                        required>
                                </div>

                                <!-- Teléfono -->
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono"
                                        placeholder="Ingresa el número telefónico" required>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between cont-botones mt-4">
                                <a href="<?= BASE_URL ?>/admin/superadministradores" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn boton">Registrar Superadministrador</button>
                            </div>
                        </form>
                    </div>

                    <?php
                    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
                    ?>