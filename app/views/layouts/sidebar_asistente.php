<?php
require_once BASE_PATH . '/app/helpers/session_asistente.php';
require_once BASE_PATH . '/app/controllers/perfilController.php';

$id = $_SESSION['user']['id'];

$perfil = mostrarPerfilAsistente($id);

?>

<!-- SIDE BAR RESPONSIVE -->
<nav class="navbar navbar-expand-lg d-lg-none bg-body-tertiary">
    <!-- CONTAINER FLUID PARA TODO AL 100% -->
    <div class="container-fluid">
        <!-- LOGO DE EVITALIX MOBILE -->
        <div class="logo-mobile">
            <img src="<?= BASE_URL ?>/public/assets/dashboard/img/LOGO-PRINCIPAL.png" alt="Logo E-VITALIX3e" width="120px">
        </div>
        <!-- BOTÓN DE TOGGLE -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarEvitalix" aria-controls="sidebarEvitalix" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="offcanvas-lg offcanvas-start col-lg-2 sidebar p-0 vh-100 sticky-lg-top" tabindex="-1" id="sidebarEvitalix">

    <!-- CABECERA DEL OFFCANVAS QUE CONTIENE EL TÍTULO Y EL BOTÓN DE CIERRE -->
    <div class="offcanvas-header d-lg-none border-bottom">
        <h5 class="offcanvas-title" id="sidebarEvitalixLabel">Menú principal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarEvitalix" aria-label="Cerrar"></button>
    </div>

    <!-- COTENIDO DEL OFFCANVAS QUE CONTIENE LOS ITEMS DEL MENÚ -->
    <div class="offcanvas-body d-flex flex-column h-100 p-0 overflow-y-auto">
        <div class="sidebar-header d-none d-lg-flex mt-3">
            <div class="logo">
                <img src="<?= BASE_URL ?>/public/assets/dashboard/img/LOGO-PRINCIPAL.png" alt="Logo E-VITALIX3e" width="80%">
            </div>
        </div>

        <div class="user-profile mt-3">
            <div class="user-avatar text-center">
                <img class="adminImg" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $perfil['foto'] ?>" alt="<?= $perfil['asistente_nombre'] ?>">
            </div>
            <div class="user-info text-center mt-2">
                <!-- <h6><?= $perfil['asistente_nombre'] ?></h6> -->
                <div class="user-role"><?= $perfil['roles_nombre'] ?></div>
            </div>
        </div>

        <nav class="nav-menu w-100 mt-4">
            <a class="nav-item" href="<?= BASE_URL ?>/asistente/dashboard">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-item" href="<?= BASE_URL ?>/asistente/mis-tickets">
                <i class="bi bi-ticket-detailed"></i>
                <span>Soporte técnico</span>
            </a>
        </nav>

        <div class="w-100" style="margin-top: auto; padding: 20px;">
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
</div>