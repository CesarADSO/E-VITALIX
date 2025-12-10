<?php
    require_once BASE_PATH . '/app/helpers/session_superadmin.php';
    // ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE CONSULTAR CONSULTORIOS
    require_once BASE_PATH . '/app/controllers/usuarioController.php';

    // ASIGNAMOS EL VALOR ID DEL REGISTRO SEGÚN LA TABLA
    $id = $_GET['id'];
    // LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR Y LE PASAMOS LOS DATOS A UNA VARIABLE
    // QUE PODAMOS MANIPULAR EN ESTE ARCHIVO
    $usuarios = listarUsuario($id);
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

                <!-- usuarios Section -->
                <div id="EspecialistaSection">
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
                        <a href="<?= BASE_URL ?>/admin/usuarios" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario con Wizard -->
                    <!-- Formulario de Registro de Usuarios -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Actualizar Usuario</h4>
                        <p class="text-muted mb-4 texto">Edite la información del usuario seleccionado.</p>

                        <form id="usuarioForm"  action="<?= BASE_URL ?>/superadmin/actualizar-usuario" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $usuarios['id'] ?>"> 
                            <input type="hidden" name="accion" value="actualizar"> 
                            <div class="row">
                                <!-- Correo Electrónico -->
                                <div class="col-md-6 mb-3">
                                    <label for="correo" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="correo" name="correo" 
                                         value="<?= $usuarios['email'] ?>" required>
                                    <div class="form-text">El correo será usado para iniciar sesión</div>
                                </div>
                                
                                <!-- Contraseña -->
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="contrasena" 
                                        placeholder="Ingresa una contraseña segura">
                                    <div class="form-text">Mínimo 8 caracteres</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" name="estado" id="estado" required>
                                    
                                        <option value="<?= $usuarios['estado'] ?>"><?= $usuarios['estado'] ?></option>
                                
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                           
                                    </select>
                                </div>
                            </div>

                            

                            <!-- Botones -->
                            <div class="d-flex justify-content-between cont-botones mt-4">
                                <a href="<?= BASE_URL ?>/superadmin/usuarios" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn boton" >Actualizar Usuario</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
    

    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>