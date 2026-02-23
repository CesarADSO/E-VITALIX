<?php
    require_once BASE_PATH . '/app/helpers/session_asistente.php';
    require_once BASE_PATH . '/app/controllers/perfilController.php';

    $id = $_SESSION['user']['id']; 

    $perfil = mostrarPerfilAsistente($id);

?>

<div class="col-lg-2 col-md-3 sidebar p-0">
    <div class="sidebar-header">
        <div class="logo">
            <img src="<?= BASE_URL ?>/public/assets/dashboard/img/LOGO-PRINCIPAL.png" alt="Logo E-VITALIX3e" width="80%">
        </div>
    </div>

    <div class="user-profile">
        <div class="user-avatar">
            <img class="adminImg" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $perfil['foto'] ?>" alt="<?= $perfil['asistente_nombre'] ?>">
        </div>
        <div class="user-info">
            <!-- <h6><?= $perfil['asistente_nombre'] ?></h6> -->
            <div class="user-role"><?= $perfil['roles_nombre'] ?></div>
        </div>
    </div>

    <nav class="nav-menu">
        <a class="nav-item" href="<?= BASE_URL ?>/asistente/dashboard">
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>
        <a class="nav-item" href="<?= BASE_URL ?>/asistente/mis-tickets">
            <i class="bi bi-ticket-detailed"></i>
            <span>Soporte técnico</span>
        </a>
    </nav>

    <div style="margin-top: auto; padding: 20px;">
        <a class="nav-item" href="<?= BASE_URL ?>/asistente/perfil">
            <i class="bi bi-person-circle"></i>
            <span>Perfil</span>
        </a>
        <a class="nav-item" href="<?= BASE_URL ?>/cerrarSesion">
            <i class="bi-box-arrow-right"></i>
            <span>Cerrar Sesión</span>
        </a>
    </div>
</div>