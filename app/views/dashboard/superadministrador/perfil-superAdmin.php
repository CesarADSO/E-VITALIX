<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';
require_once BASE_PATH . '/app/controllers/perfilController.php';

$id = $_SESSION['user']['id'];
$perfil = mostrarPerfilSuperAdmin($id);
?>

<?php
include_once __DIR__ . '/../../layouts/header_superadministrador.php';
?>

<body>
<div class="container-fluid">
<div class="row">

<?php include_once __DIR__ . '/../../layouts/sidebar_superadministrador.php'; ?>

<div class="col-lg-10 col-md-9 main-content">

<div id="perfilSection" style="display: block;">

<?php include_once __DIR__ . '/../../layouts/topbar_superadministrador.php'; ?>

<h4 class="mb-4">Perfil</h4>

<div class="row">

<!-- ===================== COLUMNA IZQUIERDA ===================== -->
<div class="col-md-4">
<div class="cont-form-foto bg-white rounded shadow-sm p-4 text-center mb-4">

<form id="formFotoPerfil"
      class="form-foto"
      action="<?= BASE_URL ?>/admin/guardar-foto-perfil"
      method="POST"
      enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $perfil['id'] ?>">
    <input type="hidden" name="accion" value="actualizarFotoSuperAdmin">

    <label for="foto" class="user-avatar avatar-editable"
        style="width:150px;height:150px;border-radius:50%;
        background-color:#e9ecef;margin:0 auto 20px;
        cursor:pointer;display:flex;align-items:center;justify-content:center;overflow:hidden;">

        <img class="adminImg"
            src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $perfil['foto'] ?>"
            alt="<?= $perfil['superadmin_nombre'] ?>"
            style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
    </label>

    <input type="file"
           id="foto"
           name="foto"
           accept=".jpg,.png,.jpeg"
           style="display:none;">

</form>

<h6 style="font-weight:600;">@<?= $perfil['superadmin_nombre'] ?></h6>
<p style="font-size:13px;color:var(--gris-proyecto);"><?= $perfil['email'] ?></p>

</div>

<div class="bg-white rounded shadow-sm p-4">
<h6 style="font-weight:600;margin-bottom:15px;">Información</h6>

<div style="font-size:14px;margin-bottom:10px;">
<span style="color:var(--gris-proyecto);">Nombres:</span>
<span style="color:var(--color-primario);">
<?= $perfil['superadmin_nombre'] ?>, <?= $perfil['apellidos'] ?>
</span>
</div>

<div style="font-size:14px;margin-bottom:10px;">
<span style="color:var(--gris-proyecto);">Email:</span>
<?= $perfil['email'] ?>
</div>

<div style="font-size:14px;margin-bottom:10px;">
<span style="color:var(--gris-proyecto);">Tel:</span>
<?= $perfil['telefono'] ?>
</div>

</div>
</div>

<!-- ===================== COLUMNA DERECHA ===================== -->
<div class="col-md-8">

<div class="bg-white rounded shadow-sm p-4 mb-4">
<h6 style="font-weight:600;margin-bottom:20px;">Configuración de usuario</h6>

<form action="<?= BASE_URL ?>/admin/guardar-configuracion-usuario"
      method="POST">

<input type="hidden" name="id" value="<?= $perfil['id'] ?>">
<input type="hidden" name="accion" value="actualizarInfoPersonalSuperAdmin">

<div class="row mb-3">
<div class="col-md-6">
<label style="font-size:13px;color:var(--gris-proyecto);">Nombres</label>
<input type="text" name="nombres"
       class="form-control campos-formulario"
       value="<?= $perfil['superadmin_nombre'] ?>">
</div>

<div class="col-md-6">
<label style="font-size:13px;color:var(--gris-proyecto);">Apellidos</label>
<input type="text" name="apellidos"
       class="form-control campos-formulario"
       value="<?= $perfil['apellidos'] ?>">
</div>
</div>

<div class="row mb-3">
<div class="col-md-6">
<label style="font-size:13px;color:var(--gris-proyecto);">Email</label>
<input type="email" name="email"
       class="form-control campos-formulario"
       value="<?= $perfil['email'] ?>">
</div>

<div class="col-md-6">
<label style="font-size:13px;color:var(--gris-proyecto);">Teléfono</label>
<input type="tel" name="telefono"
       class="form-control campos-formulario"
       value="<?= $perfil['telefono'] ?>">
</div>
</div>

<button class="btn btn-primary"
        style="border-radius:20px;padding:8px 30px;"
        type="submit">
Guardar Cambios
</button>

</form>
</div>

<!-- ===================== CONTRASEÑA ===================== -->
<div class="bg-white rounded shadow-sm p-4">
<h6 style="font-weight:600;margin-bottom:20px;">Cambiar Contraseña</h6>

<form action="<?= BASE_URL ?>/admin/cambiar-contrasena"
      method="POST">

<input type="hidden" name="id" value="<?= $perfil['id'] ?>">
<input type="hidden" name="accion" value="actualizarContrasenaSuperAdmin">

<div class="row mb-3">
<div class="col-md-6">
<input type="password" name="claveActual"
       class="form-control campos-formulario"
       placeholder="Contraseña actual">
</div>
</div>

<div class="row mb-3">
<div class="col-md-6">
<input type="password" name="claveNueva"
       class="form-control campos-formulario"
       placeholder="Nueva contraseña">
</div>

<div class="col-md-6">
<input type="password" name="confirmarClave"
       class="form-control campos-formulario"
       placeholder="Confirmar contraseña">
</div>
</div>

<button class="btn btn-primary"
        style="border-radius:20px;padding:8px 30px;"
        type="submit">
Guardar cambios
</button>

</form>

<a href="<?= BASE_URL ?>/recuperacion"
   target="_blank"
   style="font-size:13px;text-decoration:none;">
¿Olvidó su contraseña?
</a>

</div>
</div>

</div>
</div>
</div>
</div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer_superadministrador.php'; ?>

<!-- ===================== SCRIPT AUTO GUARDADO FOTO ===================== -->
<script>
document.getElementById("foto").addEventListener("change", function () {

    if (this.files && this.files[0]) {

        // Preview inmediata
        const reader = new FileReader();
        reader.onload = function (e) {
            document.querySelector(".adminImg").src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);

        // Enviar automáticamente el formulario
        document.getElementById("formFotoPerfil").submit();
    }

});
</script>