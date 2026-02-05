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

                <!-- Header del Paciente -->
                <div class="patient-header">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <button class="btn btn-outline-light btn-sm mb-3" onclick="window.history.back()">
                                    <i class="bi bi-arrow-left"></i> Volver a pacientes atendidos
                                </button>
                            </div>
                        </div>

                        <div class="card patient-card shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-auto text-center mb-3 mb-md-0">
                                        <div class="patient-avatar">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h2 class="patient-name mb-2">María Fernanda González Pérez</h2>
                                                <p class="patient-info mb-1">
                                                    <i class="bi bi-card-text text-primary"></i>
                                                    <strong>CC:</strong> 1.045.678.901
                                                </p>
                                                <p class="patient-info mb-1">
                                                    <i class="bi bi-calendar text-primary"></i>
                                                    <strong>Edad:</strong> 34 años
                                                </p>
                                            </div>

                                            <div class="col-md-6">
                                                <p class="patient-info mb-1">
                                                    <i class="bi bi-droplet-fill text-danger"></i>
                                                    <strong>Tipo de sangre:</strong> O+
                                                </p>
                                                <p class="patient-info mb-1">
                                                    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                                                    <strong>Alergias:</strong> Penicilina, Polen
                                                </p>
                                                <span class="badge badge-readonly">
                                                    <i class="bi bi-lock-fill"></i> Solo lectura
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline de Consultas -->
                <div class="container my-5">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="timeline-title mb-4">
                                <i class="bi bi-clock-history"></i> Historial de Consultas Médicas
                            </h3>
                        </div>
                    </div>

                    <!-- Timeline Container -->
                    <div class="timeline">

                        <!-- Consulta 1 -->
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <div class="card consultation-card">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h5 class="consultation-date mb-0">
                                                    <i class="bi bi-calendar-event"></i>
                                                    15 de Enero, 2026 - 10:30 AM
                                                </h5>
                                            </div>
                                            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                                <span class="badge badge-control">Control</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="consultation-summary">
                                            <p class="consultation-reason">
                                                <strong>Motivo:</strong> Control post-operatorio - Revisión de herida quirúrgica
                                            </p>
                                            <p class="consultation-diagnosis">
                                                <strong>Diagnóstico:</strong> Evolución satisfactoria post-apendicectomía
                                            </p>
                                            <p class="consultation-doctor">
                                                <i class="bi bi-person-badge"></i>
                                                <strong>Especialista:</strong> Dr. Carlos Rodríguez - Cirugía General
                                            </p>
                                        </div>

                                        <button class="btn btn-primary btn-sm mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#detalle1">
                                            <i class="bi bi-eye"></i> Ver detalle completo
                                        </button>

                                        <!-- Detalle expandible -->
                                        <div class="collapse mt-3" id="detalle1">
                                            <div class="detail-container">
                                                <ul class="nav nav-tabs" id="tabs1" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="diagnostico1-tab" data-bs-toggle="tab" data-bs-target="#diagnostico1" type="button">
                                                            <i class="bi bi-clipboard-pulse"></i> Diagnóstico
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="medicamentos1-tab" data-bs-toggle="tab" data-bs-target="#medicamentos1" type="button">
                                                            <i class="bi bi-capsule"></i> Medicamentos
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="ordenes1-tab" data-bs-toggle="tab" data-bs-target="#ordenes1" type="button">
                                                            <i class="bi bi-file-medical"></i> Órdenes Médicas
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="examenes1-tab" data-bs-toggle="tab" data-bs-target="#examenes1" type="button">
                                                            <i class="bi bi-clipboard-data"></i> Exámenes
                                                        </button>
                                                    </li>
                                                </ul>

                                                <div class="tab-content p-3" id="tabsContent1">
                                                    <!-- Tab Diagnóstico -->
                                                    <div class="tab-pane fade show active" id="diagnostico1">
                                                        <h6 class="detail-subtitle">Signos Vitales</h6>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <div class="vital-sign">
                                                                    <i class="bi bi-heart-pulse"></i>
                                                                    <span class="vital-label">Presión Arterial</span>
                                                                    <span class="vital-value">120/80 mmHg</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="vital-sign">
                                                                    <i class="bi bi-thermometer-half"></i>
                                                                    <span class="vital-label">Temperatura</span>
                                                                    <span class="vital-value">36.5°C</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="vital-sign">
                                                                    <i class="bi bi-activity"></i>
                                                                    <span class="vital-label">Frecuencia Cardíaca</span>
                                                                    <span class="vital-value">72 lpm</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="vital-sign">
                                                                    <i class="bi bi-lungs"></i>
                                                                    <span class="vital-label">Frecuencia Respiratoria</span>
                                                                    <span class="vital-value">18 rpm</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h6 class="detail-subtitle mt-4">Diagnóstico Completo</h6>
                                                        <p>Paciente con evolución satisfactoria a 10 días de apendicectomía laparoscópica. Herida quirúrgica en proceso de cicatrización sin signos de infección. No presenta dolor abdominal significativo. Se observa buena movilidad intestinal.</p>

                                                        <h6 class="detail-subtitle mt-4">Tratamiento y Recomendaciones</h6>
                                                        <p>Continuar con cuidados de herida. Retomar actividades normales de forma gradual. Evitar levantamiento de objetos pesados por 2 semanas más. Control en 1 mes.</p>
                                                    </div>

                                                    <!-- Tab Medicamentos -->
                                                    <div class="tab-pane fade" id="medicamentos1">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Medicamento</th>
                                                                        <th>Dosis</th>
                                                                        <th>Frecuencia</th>
                                                                        <th>Duración</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Ibuprofeno 400mg</td>
                                                                        <td>1 tableta</td>
                                                                        <td>Cada 8 horas</td>
                                                                        <td>5 días</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Omeprazol 20mg</td>
                                                                        <td>1 cápsula</td>
                                                                        <td>Cada 24 horas</td>
                                                                        <td>7 días</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <!-- Tab Órdenes Médicas -->
                                                    <div class="tab-pane fade" id="ordenes1">
                                                        <ul class="list-group">
                                                            <li class="list-group-item">
                                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                                Control post-operatorio en 1 mes
                                                            </li>
                                                            <li class="list-group-item">
                                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                                Curación de herida cada 3 días
                                                            </li>
                                                            <li class="list-group-item">
                                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                                Evitar ejercicio físico intenso por 3 semanas
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <!-- Tab Exámenes -->
                                                    <div class="tab-pane fade" id="examenes1">
                                                        <div class="alert alert-info">
                                                            <i class="bi bi-info-circle"></i>
                                                            No se solicitaron exámenes de laboratorio en esta consulta.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Consulta 2 -->
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <div class="card consultation-card">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h5 class="consultation-date mb-0">
                                                    <i class="bi bi-calendar-event"></i>
                                                    05 de Enero, 2026 - 03:15 PM
                                                </h5>
                                            </div>
                                            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                                <span class="badge badge-urgencia">Urgencia</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="consultation-summary">
                                            <p class="consultation-reason">
                                                <strong>Motivo:</strong> Dolor abdominal agudo en fosa ilíaca derecha
                                            </p>
                                            <p class="consultation-diagnosis">
                                                <strong>Diagnóstico:</strong> Apendicitis aguda - Requiere intervención quirúrgica
                                            </p>
                                            <p class="consultation-doctor">
                                                <i class="bi bi-person-badge"></i>
                                                <strong>Especialista:</strong> Dr. Carlos Rodríguez - Cirugía General
                                            </p>
                                        </div>

                                        <button class="btn btn-primary btn-sm mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#detalle2">
                                            <i class="bi bi-eye"></i> Ver detalle completo
                                        </button>

                                        <!-- Detalle expandible -->
                                        <div class="collapse mt-3" id="detalle2">
                                            <div class="detail-container">
                                                <ul class="nav nav-tabs" id="tabs2" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="diagnostico2-tab" data-bs-toggle="tab" data-bs-target="#diagnostico2" type="button">
                                                            <i class="bi bi-clipboard-pulse"></i> Diagnóstico
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="medicamentos2-tab" data-bs-toggle="tab" data-bs-target="#medicamentos2" type="button">
                                                            <i class="bi bi-capsule"></i> Medicamentos
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="ordenes2-tab" data-bs-toggle="tab" data-bs-target="#ordenes2" type="button">
                                                            <i class="bi bi-file-medical"></i> Órdenes Médicas
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="examenes2-tab" data-bs-toggle="tab" data-bs-target="#examenes2" type="button">
                                                            <i class="bi bi-clipboard-data"></i> Exámenes
                                                        </button>
                                                    </li>
                                                </ul>

                                                <div class="tab-content p-3" id="tabsContent2">
                                                    <!-- Tab Diagnóstico -->
                                                    <div class="tab-pane fade show active" id="diagnostico2">
                                                        <h6 class="detail-subtitle">Signos Vitales</h6>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <div class="vital-sign">
                                                                    <i class="bi bi-heart-pulse"></i>
                                                                    <span class="vital-label">Presión Arterial</span>
                                                                    <span class="vital-value">135/85 mmHg</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="vital-sign">
                                                                    <i class="bi bi-thermometer-half"></i>
                                                                    <span class="vital-label">Temperatura</span>
                                                                    <span class="vital-value">38.2°C</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="vital-sign">
                                                                    <i class="bi bi-activity"></i>
                                                                    <span class="vital-label">Frecuencia Cardíaca</span>
                                                                    <span class="vital-value">95 lpm</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="vital-sign">
                                                                    <i class="bi bi-lungs"></i>
                                                                    <span class="vital-label">Frecuencia Respiratoria</span>
                                                                    <span class="vital-value">22 rpm</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h6 class="detail-subtitle mt-4">Diagnóstico Completo</h6>
                                                        <p>Paciente femenina de 34 años con cuadro clínico de 24 horas de evolución, caracterizado por dolor abdominal que inició en región periumbilical y migró a fosa ilíaca derecha. Signo de McBurney positivo. Leucocitosis con desviación a la izquierda. Ecografía abdominal evidencia apéndice aumentado de tamaño con signos inflamatorios.</p>

                                                        <h6 class="detail-subtitle mt-4">Tratamiento y Recomendaciones</h6>
                                                        <p>Se indica intervención quirúrgica urgente (apendicectomía laparoscópica). Antibioticoterapia preoperatoria. NPO. Hidratación parenteral. Consentimiento informado firmado. Se programa para sala de cirugía.</p>
                                                    </div>

                                                    <!-- Tab Medicamentos -->
                                                    <div class="tab-pane fade" id="medicamentos2">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Medicamento</th>
                                                                        <th>Dosis</th>
                                                                        <th>Frecuencia</th>
                                                                        <th>Duración</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Ceftriaxona 1g IV</td>
                                                                        <td>1 ampolla</td>
                                                                        <td>Cada 12 horas</td>
                                                                        <td>Pre y post operatorio</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Metronidazol 500mg IV</td>
                                                                        <td>1 ampolla</td>
                                                                        <td>Cada 8 horas</td>
                                                                        <td>Pre y post operatorio</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Tramadol 100mg IV</td>
                                                                        <td>1 ampolla</td>
                                                                        <td>Cada 8 horas PRN</td>
                                                                        <td>Según dolor</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <!-- Tab Órdenes Médicas -->
                                                    <div class="tab-pane fade" id="ordenes2">
                                                        <ul class="list-group">
                                                            <li class="list-group-item">
                                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                                Apendicectomía laparoscópica urgente
                                                            </li>
                                                            <li class="list-group-item">
                                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                                NPO absoluto
                                                            </li>
                                                            <li class="list-group-item">
                                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                                Canalización de vía periférica
                                                            </li>
                                                            <li class="list-group-item">
                                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                                Hidratación parenteral con SSN 0.9%
                                                            </li>
                                                            <li class="list-group-item">
                                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                                Valoración preanestésica
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <!-- Tab Exámenes -->
                                                    <div class="tab-pane fade" id="examenes2">
                                                        <h6 class="detail-subtitle">Hemograma Completo</h6>
                                                        <div class="table-responsive mb-4">
                                                            <table class="table table-sm">
                                                                <tbody>
                                                                    <tr>
                                                                        <td><strong>Leucocitos:</strong></td>
                                                                        <td>15,200/mm³</td>
                                                                        <td><span class="badge bg-warning">Elevado</span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Neutrófilos:</strong></td>
                                                                        <td>82%</td>
                                                                        <td><span class="badge bg-warning">Elevado</span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Hemoglobina:</strong></td>
                                                                        <td>13.5 g/dL</td>
                                                                        <td><span class="badge bg-success">Normal</span></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <h6 class="detail-subtitle">Ecografía Abdominal</h6>
                                                        <p><strong>Hallazgos:</strong> Apéndice cecal aumentado de tamaño (9mm de diámetro). Pared engrosada. Líquido libre periapendicular. Signo de McBurney ecográfico positivo.</p>
                                                        <p><strong>Conclusión:</strong> Hallazgos compatibles con apendicitis aguda.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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