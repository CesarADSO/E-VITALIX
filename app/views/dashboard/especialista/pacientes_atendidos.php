    <?php
    include_once __DIR__ . '/../../../views/layouts/header_especialista.php';
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
                    <h4 class="mb-4">Gestión de historiales clínicos de pacientes atendidos</h4>
                    <p class="mb-4">Consulte los historiales clínicos de los pacientes atendidos por usted.</p>

                    <div class="card shadow-sm">
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
                                            <tr>
                                                <td>Julio Morales</td>
                                                <td>CC</td>
                                                <td>123456789</td>
                                                <td>2024-05-20</td>
                                                <td><a href="<?= BASE_URL ?>/especialista/historial_clinico" class="btn btn-sm btn-info"
                                                        title="Consultar historial clínico">
                                                        <i class="bi bi-check-circle"></i></a></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include_once __DIR__ . '/../../../views/layouts/footer_especialista.php';
        ?>