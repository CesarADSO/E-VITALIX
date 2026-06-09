    <?php
    include_once __DIR__ . '/../../../views/layouts/header_especialista.php';

    require_once BASE_PATH . '/app/controllers/historialesController.php';

    $pacienteConConsulta = mostrarPacientesConConsulta();
    ?>

    <body>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <?php
                include_once __DIR__ . '/../../../views/layouts/sidebar_especialista.php';
                ?>

                <!-- Main Content -->
                <div class="col-lg-10 col-md-9 main-content">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../../views/layouts/topbar_especialista.php';
                    ?>

                    <!-- historiales Header -->
                    <h4 class="mb-4">Gestión de los pacientes atendidos</h4>
                    <p class="mb-4 d-none d-md-block">Consulte la información de los pacientes que usted ha atendido.</p>

                    <div class="card shadow-sm d-none d-lg-block">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0 text-white">
                                <i class="bi bi-calendar-check me-2"></i>
                                Pacientes atendidos
                            </h5>
                        </div>
                        <div class="card-body" style="padding: 0;">
                            <!-- Pacientes Table -->
                            <div class="bg-white rounded shadow-sm p-4 cont-tabla-pacientes">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-pacientes table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Nombre del paciente
                                                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                                </th>
                                                <th>Tipo de documento</th>
                                                <th>Número de documento</th>
                                                <th>
                                                    última consulta
                                                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                                </th>
                                                <th style="width: 80px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($pacienteConConsulta)): ?>
                                                <?php foreach ($pacienteConConsulta as $paciente): ?>
                                                    <tr>
                                                        <td><?= $paciente['nombres'] . ' ' . $paciente['apellidos'] ?></td>
                                                        <td><?= $paciente['tipo_documento'] ?></td>
                                                        <td><?= $paciente['numero_documento'] ?></td>
                                                        <td><?= $paciente['ultima_consulta'] ?></td>
                                                        <td><a href="<?= BASE_URL ?>/especialista/historial_clinico?id_paciente=<?= $paciente['id_paciente'] ?>" class="btn btn-sm btn-success text-white"
                                                                title="Consultar historial clínico">
                                                                <i class="fa-solid fa-book"></i></a>
                                                            <a href="<?= BASE_URL ?>/especialista/consultar-paciente?id=<?= $paciente['id_paciente'] ?>" class="btn btn-info btn-sm text-white" title="Consultar Paciente"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No se han encontrado pacientes atendidos.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- VISTA MOVIL -->
                    <div class="row d-lg-none mt-3">
                        <?php if (!empty($pacienteConConsulta)): ?>
                            <?php foreach ($pacienteConConsulta as $paciente): ?>
                                <div class="col-md-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title text-truncate"><?= $paciente['nombres'] ?> <?= $paciente['apellidos'] ?></h5>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Tipo de documento: <?= $paciente['tipo_documento'] ?></h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Número de documento: <?= $paciente['numero_documento'] ?></h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Última consulta: <?= $paciente['ultima_consulta'] ?></h6>
                                            </div>
                                            <div class="cont-botones d-flex justify-content-end gap-2">
                                                <a href="<?= BASE_URL ?>/especialista/historial_clinico?id_paciente=<?= $paciente['id_paciente'] ?>" class="btn btn-sm btn-success text-white"
                                                    title="Consultar historial clínico">
                                                    <i class="fa-solid fa-book"></i></a>
                                                <a href="<?= BASE_URL ?>/especialista/consultar-paciente?id=<?= $paciente['id_paciente'] ?>" class="btn btn-info btn-sm text-white" title="Consultar Paciente"><i class="fa-solid fa-magnifying-glass"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No se han encontrado pacientes atendidos.</p>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include_once __DIR__ . '/../../../views/layouts/footer_especialista.php';
        ?>