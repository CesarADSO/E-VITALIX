<?php
    require_once BASE_PATH . '/app/helpers/session_especialista.php';
    require_once BASE_PATH . '/app/controllers/perfilController.php';

    $id = $_SESSION['user']['id'];

    $perfil = mostrarPerfilEspecialista($id);
?>


<?php
include_once __DIR__ . '/../../layouts/header_especialista.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_especialista.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <!-- Perfil Section -->
                <div id="perfilSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_especialista.php';
                    ?>

                    <h4 class="mb-4">Perfil</h4>

                    <div class="row">
                        <!-- Columna Izquierda - Foto e Información -->
                        <div class="col-md-4">
                            <div class=" cont-form-foto bg-white rounded shadow-sm p-4 text-center mb-4">

                                <form class="form-foto" action="<?= BASE_URL ?>/especialista/guardar-foto-perfil" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= $perfil['id'] ?>">
                                    <input type="hidden" name="accion" value="actualizarFotoAdmin">
                                    <!-- FOTO CON INPUT OCULTO -->
                                    <label for="foto" class="user-avatar avatar-editable"
                                        style="width: 150px; height: 150px; border-radius: 50%; 
                                        background-color: #e9ecef; margin: 0 auto 20px; 
                                        cursor: pointer; display: flex; align-items: center; justify-content: center;">

                                        <img class="adminImg"
                                            src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $perfil['foto'] ?>"
                                            alt="<?= $perfil['especialista_nombre'] ?>">
                                    </label>

                                    <!-- Input file oculto -->  
                                    <input type="file" id="foto" name="foto" accept=".jpg, .png, .jpeg" style="display: none;">
                                    <button class="enviarFoto" type="submit"><i class="bi bi-check-lg"></i></button>
                                </form>
                                <h6 style="font-weight: 600;">@<?= $perfil['especialista_nombre'] ?></h6>
                                <p style="font-size: 13px; color: var(--gris-proyecto);"><?= $perfil['email'] ?></p>
                            </div>

                            <div class="bg-white rounded shadow-sm p-4">
                                <h6 style="font-weight: 600; margin-bottom: 15px;">Información</h6>
                                <div style="font-size: 14px; margin-bottom: 10px;">
                                    <span style="color: var(--gris-proyecto);">Nombres:</span> <span
                                        style="color: var(--color-primario);"><?= $perfil['especialista_nombre'] ?>, <?= $perfil['apellidos'] ?></span>
                                </div>
                                <div style="font-size: 14px; margin-bottom: 10px;">
                                    <span style="color: var(--gris-proyecto);">Email:</span> <?= $perfil['email'] ?>
                                </div>
                                <div style="font-size: 14px; margin-bottom: 10px;">
                                    <span style="color: var(--gris-proyecto);">Tel:</span> <?= $perfil['telefono'] ?>
                                </div>
                                <div style="font-size: 14px; margin-bottom: 10px;">
                                    <span style="color: var(--gris-proyecto);">Plan:</span> <span
                                        style="color: var(--color-primario);">Básico</span>
                                </div>

                                <h6 style="font-weight: 600; margin-top: 25px; margin-bottom: 15px;">Preferencias</h6>
                                <div class="d-flex justify-content-between align-items-center" style="font-size: 14px;">
                                    <span style="color: var(--gris-proyecto);">Plan: <span
                                            style="color: var(--color-primario);">Básico</span></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2"
                                    style="font-size: 14px;">
                                    <span style="color: var(--gris-proyecto);">Día/Noche</span>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="themeSwitch">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna Derecha - Formularios -->
                        <div class="col-md-8">
                            <!-- Configuración de usuario -->
                            <div class="bg-white rounded shadow-sm p-4 mb-4">
                                <h6 style="font-weight: 600; margin-bottom: 20px;">Configuración de usuario</h6>

                                <h6 style="font-size: 14px; font-weight: 600; margin-bottom: 15px;">Detalles</h6>
                                <form action="<?= BASE_URL ?>/especialista/guardar-configuracion-usuario" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= $perfil['id'] ?>">
                                    <input type="hidden" name="accion" value="actualizarInfoPersonalEspecialista">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label
                                                style="font-size: 13px; color: var(--gris-proyecto); margin-bottom: 5px;">Nombres</label>
                                            <input type="text" name="nombres" class="form-control campos-formulario" id="nombresInput"
                                                placeholder="Pepito Rodrick ..." value="<?= $perfil['especialista_nombre'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                style="font-size: 13px; color: var(--gris-proyecto); margin-bottom: 5px;">Apellidos</label>
                                            <input type="text" name="apellidos" class="form-control campos-formulario" id="apellidosInput"
                                                placeholder="Coronel Cifuentes ..." value="<?= $perfil['apellidos'] ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label
                                                style="font-size: 13px; color: var(--gris-proyecto); margin-bottom: 5px;">Email</label>
                                            <input type="email" name="email" class="form-control campos-formulario" id="emailInput"
                                                placeholder="tuxome@gmail.com" value="<?= $perfil['email'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                style="font-size: 13px; color: var(--gris-proyecto); margin-bottom: 5px;">Teléfono</label>
                                            <div class="input-group">
                                                <input type="tel" name="telefono" class="form-control campos-formulario" id="telefonoInput"
                                                    placeholder="969 123 456" value="<?= $perfil['telefono'] ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary"
                                        style="border-radius: 20px; padding: 8px 30px;" type="submit">Guardar Cambios</button>
                                </form>
                            </div>

                            <!-- Contraseña -->
                            <div class="bg-white rounded shadow-sm p-4">
                                <h6 style="font-weight: 600; margin-bottom: 20px;">Cambiar Contraseña</h6>

                                <form action="<?= BASE_URL ?>/admin/cambiar-contrasena" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= $perfil['id'] ?>">
                                    <input type="hidden" name="accion" value="actualizarContrasenaAdmin">
                                    <h6 style="font-size: 14px; font-weight: 600; margin-bottom: 15px;">Contraseña actual
                                    </h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <input type="password" name="claveActual" class="form-control campos-formulario"
                                                id="contrasenaActual" placeholder="Ingresa tu contraseña actual">
                                        </div>
                                    </div>

                                    <h6 style="font-size: 14px; font-weight: 600; margin-bottom: 15px;">Nueva Contraseña</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <input type="password" name="claveNueva" class="form-control campos-formulario"
                                                id="nuevaContrasena" placeholder="Ingresa tu nueva contraseña">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="password" name="confirmarClave" class="form-control campos-formulario"
                                                id="confirmarContrasena" placeholder="Confirmar contraseña">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <button class="btn btn-primary"
                                            style="border-radius: 20px; padding: 8px 30px;" type="submit">Guardar cambios</button>
                                </form>

                                <a href="<?= BASE_URL ?>/recuperacion" target="_blank" style="font-size: 13px; text-decoration: none;">¿Olvidó su
                                    contraseña?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_especialista.php';
    ?>