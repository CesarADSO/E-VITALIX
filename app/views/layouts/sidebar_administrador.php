<?php

// Controlador que obtiene los datos del perfil
require_once BASE_PATH . '/app/controllers/perfilController.php';

// Validamos que exista el usuario en sesión
$id = $_SESSION['user']['id'] ?? null;

if (!$id) {
    // Si no hay usuario logueado, mostramos datos por defecto
    $perfil = [
        'foto' => 'default.png',
        'admin_nombre' => 'Invitado',
        'roles_nombre' => 'Sin rol'
    ];
} else {
    // Obtenemos el perfil real
    $perfil = mostrarPerfilAdmin($id);

    // Si la consulta devolvió false (sin datos) evitamos warnings
    if (!$perfil || !is_array($perfil)) {
        $perfil = [
            'foto' => 'default.png',
            'admin_nombre' => 'Administrador',
            'roles_nombre' => 'Sin rol'
        ];
    }
}

?>

<div class="col-lg-2 col-md-3 sidebar p-0">
    <div class="sidebar-header">
        <div class="logo">
            <img src="<?= BASE_URL ?>/public/assets/dashboard/img/LOGO-PRINCIPAL.png" alt="Logo E-VITALIX3e" width="80%">
        </div>
    </div>

    <div class="user-profile">
        <div class="user-avatar">
            <img class="adminImg" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $perfil['foto'] ?>" 
                 alt="<?= $perfil['admin_nombre'] ?>">
        </div>
        <div class="user-info">
            <h6><?= $perfil['admin_nombre'] ?></h6>
            <div class="user-role"><?= $perfil['roles_nombre'] ?></div>
        </div>
    </div>

    <nav class="nav-menu">
        <a class="nav-item" href="<?= BASE_URL ?>/administrador/dashboard">
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>

        <a class="nav-item" href="<?= BASE_URL ?>/admin/especialistas">
            <i class="fa-solid fa-user-doctor"></i>
            <span>Especialistas</span>
        </a>

        <a class="nav-item" href="<?= BASE_URL ?>/admin/asistentes">
            <i class="bi bi-person-gear"></i>
            <span>Asistentes</span>
        </a>
    </nav>

    <div style="margin-top: auto; padding: 20px;">
        <a class="nav-item" href="<?= BASE_URL ?>/admin/perfil">
            <i class="bi bi-person-circle"></i>
            <span>Perfil</span>
        </a>
        <a class="nav-item" href="<?= BASE_URL ?>/cerrarSesion">
            <i class="bi-box-arrow-right"></i>
            <span>Cerrar Sesión</span>
        </a>
    </div>
</div>
