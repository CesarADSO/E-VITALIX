<?php 
    include_once __DIR__ . '/../../layouts/header_paciente.php';
?>

<div class="container-fluid">
    <div class="row">

        <?php include_once __DIR__ . '/../../layouts/sidebar_paciente.php'; ?>

        <div class="col-lg-10 col-md-9 main-content">

            <!-- Top Bar -->
            <?php include_once __DIR__ . '/../../layouts/topbar_paciente.php'; ?>

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="<?= BASE_URL ?>/paciente/agendarCita" class="btn btn-primary btn-sm" style="border-radius: 20px;">
                    <i class="bi bi-plus-lg"></i> Agendar cita
                </a>
            </div>

            <!-- Tabla de Citas -->
            <div class="bg-white rounded shadow-sm p-4">
                
                <table id="tablaCitas" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Especialista</th>
                            <th>Consultorio</th>
                            <th>Estado</th>
                            <th style="width: 80px;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Si no hay citas -->
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                ¡No hay citas agendadas!
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Inicialización DataTable -->
<script>
    new DataTable("#tablaCitas", {
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 20, 50],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });
</script>

<?php include_once __DIR__ . '/../../layouts/footer_paciente.php'; ?>
