<?php
    require_once BASE_PATH . '/app/helpers/session_admin.php';
    require_once BASE_PATH . '/app/controllers/rolesController.php';

    $roles = traerRoles();

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
                <div id="EspecialistaSection">
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
                        <a href="<?= BASE_URL ?>/admin/usuarios" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario con Wizard -->
                    <!-- Formulario de Registro de Usuarios -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Registrar Usuario</h4>
                        <p class="text-muted mb-4 texto">Crear nueva cuenta de usuario en el sistema</p>

                        <form id="usuarioForm"  action="<?= BASE_URL ?>/admin/guardar-usuario" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <!-- Correo Electrónico -->
                                <div class="col-md-6 mb-3">
                                    <label for="correo" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="correo" name="correo" 
                                        placeholder="ejemplo@correo.com" required>
                                    <div class="form-text">El correo será usado para iniciar sesión</div>
                                </div>
                                
                                <!-- Contraseña -->
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="contrasena" 
                                        placeholder="Ingresa una contraseña segura" required>
                                    <div class="form-text">Mínimo 8 caracteres</div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Rol -->
                                <div class="col-md-6 mb-3">
                                    <label for="rol" class="form-label">Rol</label>
                                    <select class="form-select" id="rol" name="rol" required>
                                        <option value="">Seleccionar rol</option>
                                        <?php if (!empty($roles)) :?>
                                            <?php foreach($roles as $rol) :?>
                                        <option value="<?= $rol['id'] ?>"><?= $rol['nombre'] ?></option>
                                            <?php endforeach;?>
                                        <?php else: ?>
                                            <option value="">No hay roles registrados</option>
                                        <?php endif;?>
                                        
                                        <!-- Los roles se cargarán desde la base de datos -->

                                    </select>
                                    <div class="form-text">Define los permisos del usuario en el sistema</div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between cont-botones mt-4">
                                <a href="<?= BASE_URL ?>/admin/usuarios" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn boton" >Registrar Usuario</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
    

    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>