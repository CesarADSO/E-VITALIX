<?php
require_once BASE_PATH . '/app/helpers/session_admin.php';
// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE CONSULTAR PACIENTES
require_once BASE_PATH . '/app/controllers/pacienteController.php';

// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR
$datos = mostrarPacientes();
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

                <!-- Pacientes Section -->
                <div id="pacientesSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Pacientes Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($datos) ?>)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/registrar-paciente" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i> AÑADIR</a>
                    </div>

                    <!-- Pacientes Table -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <table class="table-pacientes">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>
                                        Nombres y Apellidos
                                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                    </th>
                                    <th>Documento</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>EPS</th>
                                    <th>RH</th>
                                    <th>Estado</th>
                                    <th style="width: 80px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($datos)) :  ?>
                                    <?php foreach ($datos as $paciente) : ?>
                                        <tr>
                                            <td>
                                                <img class="imgconsultorio"
                                                    src="<?= BASE_URL ?>/public/uploads/pacientes/<?= $paciente['foto'] ?>"
                                                    alt="<?= $paciente['nombres'] ?>"
                                                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                            </td>
                                            <td><?= $paciente['nombres'] . ' ' . $paciente['apellidos'] ?></td>
                                            <td>
                                                <span style="font-size: 12px; color: var(--gris-proyecto);">
                                                    <?= $paciente['tipo_documento'] ?>
                                                </span><br>
                                                <?= $paciente['numero_documento'] ?>
                                            </td>
                                            <td><?= $paciente['telefono'] ?></td>
                                            <td><?= $paciente['email'] ?></td>
                                            <td><?= $paciente['eps'] ?? 'N/A' ?></td>
                                            <td>
                                                <span class="badge" style="background-color: #dc3545; color: white;">
                                                    <?= $paciente['rh'] ?? 'N/A' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($paciente['estado'] == 'Activo') : ?>
                                                    <span class="badge bg-success">Activo</span>
                                                <?php else : ?>
                                                    <span class="badge bg-secondary">Inactivo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <i class="bi bi-three-dots text-muted" style="cursor: pointer;" data-bs-toggle="dropdown"></i>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye"></i> Ver</a></li>
                                                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin/actualizar-paciente?id=<?= $paciente['id'] ?>"><i class="bi bi-pencil"></i> Editar</a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-danger"
                                                                href="<?= BASE_URL ?>/admin/eliminar-paciente?accion=eliminar&id=<?= $paciente['id'] ?>"
                                                                onclick="return confirm('¿Estás seguro de eliminar este paciente? Esta acción no se puede deshacer.')">
                                                                <i class="bi bi-trash"></i> Eliminar
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center" style="padding: 40px;">
                                            <i class="bi bi-inbox" style="font-size: 48px; color: var(--gris-proyecto);"></i>
                                            <p style="color: var(--gris-proyecto); margin-top: 10px;">No hay pacientes registrados</p>
                                        </td>
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
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>