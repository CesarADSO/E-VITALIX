<!-- AQUI VA EL INCLUDE DEL HEADER -->
<?php
include_once __DIR__ . '/../../../views/layouts/header_especialista.php';
require_once BASE_PATH . '/app/helpers/session_especialista.php';
require_once BASE_PATH . '/app/controllers/misCitasController.php';
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

                <!-- Título de la sección -->
                <div class="mb-4">
                    <h3 class="fw-bold">Mis Citas</h3>
                    <p class="text-muted">Gestiona las citas que los pacientes han agendado contigo</p>
                </div>

                <!-- Estadísticas de Citas -->
                <div class="stats-cards mb-4">
                    <div class="stat-card">
                        <div class="stat-label">Citas Pendientes</div>
                        <div class="stat-value"><?= $estadisticas['Pendiente'] ?? 0 ?></div>
                        <div class="stat-subtitle">Por revisar</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Citas Aceptadas</div>
                        <div class="stat-value"><?= $estadisticas['Aceptada'] ?? 0 ?></div>
                        <div class="stat-subtitle">Confirmadas</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Citas Canceladas</div>
                        <div class="stat-value"><?= $estadisticas['Cancelada'] ?? 0 ?></div>
                        <div class="stat-subtitle">No realizadas</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Citas Rechazadas</div>
                        <div class="stat-value"><?= $estadisticas['Rechazada'] ?? 0 ?></div>
                        <div class="stat-subtitle">Declinadas</div>
                    </div>
                </div>

                <!-- Tabla de Citas -->
                <div class="card shadow-sm">
                    <div class="card-header card-header-primary">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar-check me-2"></i>
                            Lista de Citas
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($citas)): ?>
                            <div class="alert alert-info text-center" role="alert">
                                <i class="bi bi-info-circle me-2"></i>
                                No tienes citas registradas en este momento
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="tablaCitas">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Paciente</th>
                                            <th>Fecha</th>
                                            <th>Hora Inicio</th>
                                            <th>Hora Fin</th>
                                            <th>Servicio</th>
                                            <th>Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($citas as $cita): ?>
                                            <tr data-cita-id="<?= $cita['id'] ?>">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar me-2">
                                                            <i class="bi bi-person-circle" style="font-size: 32px; color: var(--color-primario);"></i>
                                                        </div>
                                                        <div>
                                                            <strong><?= htmlspecialchars($cita['nombre_paciente']) ?></strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    <?= date('d/m/Y', strtotime($cita['fecha'])) ?>
                                                </td>
                                                <td>
                                                    <i class="bi bi-clock me-1"></i>
                                                    <?= date('h:i A', strtotime($cita['hora_inicio'])) ?>
                                                </td>
                                                <td>
                                                    <i class="bi bi-clock-fill me-1"></i>
                                                    <?= date('h:i A', strtotime($cita['hora_fin'])) ?>
                                                </td>
                                                <td><?= htmlspecialchars($cita['servicio_nombre'] ?? 'Sin servicio') ?></td>
                                                <td>
                                                    <span class="status-badge status-<?= strtolower($cita['estado_cita']) ?>">
                                                        <?= $cita['estado_cita'] ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <?php if ($cita['estado_cita'] === 'Pendiente'): ?>
                                                            <button
                                                                class="btn btn-sm btn-success btn-aceptar"
                                                                data-cita-id="<?= $cita['id'] ?>"
                                                                title="Aceptar cita">
                                                                <i class="bi bi-check-circle"></i>
                                                            </button>
                                                            <button
                                                                class="btn btn-sm btn-danger btn-cancelar"
                                                                data-cita-id="<?= $cita['id'] ?>"
                                                                title="Cancelar cita">
                                                                <i class="bi bi-x-circle"></i>
                                                            </button>
                                                        <?php else: ?>
                                                            <span class="text-muted small">Sin acciones disponibles</span>
                                                        <?php endif; ?>

                                                        <button
                                                            class="btn btn-sm btn-info btn-detalle ms-1"
                                                            data-cita-id="<?= $cita['id'] ?>"
                                                            title="Ver detalles">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="modalConfirmacion" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitulo">Confirmar Acción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalMensaje">
                    ¿Estás seguro de realizar esta acción?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnConfirmarAccion">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalle de Cita -->
    <div class="modal fade" id="modalDetalle" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header card-header-primary">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-info-circle me-2"></i>
                        Detalles de la Cita
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalDetalleContenido">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Estilos personalizados para el módulo de Mis Citas */
        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            text-transform: uppercase;
        }

        .status-pendiente {
            background-color: #FFF3CD;
            color: #856404;
        }

        .status-aceptada {
            background-color: #D1ECF1;
            color: #0C5460;
        }

        .status-cancelada {
            background-color: #F8D7DA;
            color: #721C24;
        }

        .status-rechazada {
            background-color: #F5C6CB;
            color: #721C24;
        }

        #tablaCitas tbody tr {
            transition: background-color 0.2s;
        }

        #tablaCitas tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-group .btn {
            margin: 0 2px;
        }

        .card-header-primary {
            background: linear-gradient(135deg, var(--color-primario) 0%, var(--tercer-azul) 100%);
        }
    </style>

    <script>
        // Variables globales
        let citaIdActual = null;
        let estadoActual = null;

        // Inicializar DataTable
        $(document).ready(function() {
            <?php if (!empty($citas)): ?>
                $('#tablaCitas').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                    },
                    order: [
                        [1, 'desc']
                    ], // Ordenar por fecha descendente
                    pageLength: 10,
                    responsive: true
                });
            <?php endif; ?>

            // Eventos de botones
            setupEventListeners();
        });

        function setupEventListeners() {
            // Botón Aceptar
            $(document).on('click', '.btn-aceptar', function() {
                citaIdActual = $(this).data('cita-id');
                estadoActual = 'Aceptada';

                $('#modalTitulo').text('Aceptar Cita');
                $('#modalMensaje').html('<p>¿Estás seguro de que deseas <strong>aceptar</strong> esta cita?</p><p class="text-success small">Esta acción reservará el slot en tu agenda.</p>');
                $('#btnConfirmarAccion').removeClass('btn-danger').addClass('btn-success');

                new bootstrap.Modal(document.getElementById('modalConfirmacion')).show();
            });

            // Botón Cancelar
            $(document).on('click', '.btn-cancelar', function() {
                citaIdActual = $(this).data('cita-id');
                estadoActual = 'Cancelada';

                $('#modalTitulo').text('Cancelar Cita');
                $('#modalMensaje').html('<p>¿Estás seguro de que deseas <strong>cancelar</strong> esta cita?</p><p class="text-danger small">El slot quedará disponible nuevamente.</p>');
                $('#btnConfirmarAccion').removeClass('btn-success').addClass('btn-danger');

                new bootstrap.Modal(document.getElementById('modalConfirmacion')).show();
            });

            // Confirmar acción
            $('#btnConfirmarAccion').on('click', function() {
                actualizarEstadoCita(citaIdActual, estadoActual);
            });

            // Botón Ver Detalle
            $(document).on('click', '.btn-detalle', function() {
                const citaId = $(this).data('cita-id');
                cargarDetalleCita(citaId);
            });
        }

        function actualizarEstadoCita(citaId, estado) {
            $.ajax({
                url: '<?= BASE_URL ?>/especialista/mis-citas',
                method: 'POST',
                data: {
                    action: 'actualizar_estado',
                    id_cita: citaId,
                    estado: estado
                },
                dataType: 'json',
                success: function(response) {
                    bootstrap.Modal.getInstance(document.getElementById('modalConfirmacion')).hide();

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    bootstrap.Modal.getInstance(document.getElementById('modalConfirmacion')).hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al procesar la solicitud'
                    });
                }
            });
        }

        function cargarDetalleCita(citaId) {
            const modal = new bootstrap.Modal(document.getElementById('modalDetalle'));
            modal.show();

            $.ajax({
                url: '<?= BASE_URL ?>/especialista/mis-citas',
                method: 'POST',
                data: {
                    action: 'obtener_detalle',
                    id_cita: citaId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        mostrarDetalleCita(response.data);
                    } else {
                        $('#modalDetalleContenido').html(`
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                ${response.message}
                            </div>
                        `);
                    }
                },
                error: function() {
                    $('#modalDetalleContenido').html(`
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Error al cargar los detalles
                        </div>
                    `);
                }
            });
        }

        function mostrarDetalleCita(data) {
            const fecha = new Date(data.fecha).toLocaleDateString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            const contenido = `
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="bi bi-person me-2"></i>Información del Paciente
                                </h6>
                                <hr>
                                <div class="info-row">
                                    <span class="info-label">Nombre:</span>
                                    <span class="info-value">${data.nombre_paciente}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Teléfono:</span>
                                    <span class="info-value">${data.telefono_paciente || 'No registrado'}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Email:</span>
                                    <span class="info-value">${data.email_paciente || 'No registrado'}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="bi bi-calendar-event me-2"></i>Detalles de la Cita
                                </h6>
                                <hr>
                                <div class="info-row">
                                    <span class="info-label">Fecha:</span>
                                    <span class="info-value">${fecha}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Hora:</span>
                                    <span class="info-value">${data.hora_inicio} - ${data.hora_fin}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Estado:</span>
                                    <span class="info-value">
                                        <span class="status-badge status-${data.estado_cita.toLowerCase()}">
                                            ${data.estado_cita}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="bi bi-hospital me-2"></i>Servicio
                                </h6>
                                <hr>
                                <div class="info-row">
                                    <span class="info-label">Servicio:</span>
                                    <span class="info-value">${data.servicio_nombre || 'Sin servicio asignado'}</span>
                                </div>
                                ${data.servicio_duracion ? `
                                <div class="info-row">
                                    <span class="info-label">Duración:</span>
                                    <span class="info-value">${data.servicio_duracion} minutos</span>
                                </div>
                                ` : ''}
                                ${data.servicio_precio ? `
                                <div class="info-row">
                                    <span class="info-label">Precio:</span>
                                    <span class="info-value">$${parseFloat(data.servicio_precio).toFixed(2)}</span>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                    </div>

                    ${data.motivo_consulta ? `
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="bi bi-chat-left-text me-2"></i>Motivo de Consulta
                                </h6>
                                <hr>
                                <p class="mb-0">${data.motivo_consulta}</p>
                            </div>
                        </div>
                    </div>
                    ` : ''}
                </div>
            `;

            $('#modalDetalleContenido').html(contenido);
        }
    </script>

    <!-- AQUI VA EL FOOTER INCLUDE -->
    <?php
    include_once __DIR__ . '/../../../views/layouts/footer_especialista.php';
    ?>
</body>