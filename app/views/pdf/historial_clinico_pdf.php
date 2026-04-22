<?php
$hoy = date("Y")
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia clínica</title>
    <style>
        /* 1. IMPORTAR LA FUENTE NUNITO */
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap');

        @page {
            margin: 40px 40px 60px 40px;
            /* márgenes internas */
        }

        /* CONFIGURACIÓN BASE (Estilo Tech-Clean) */
        body {
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
            color: #1c1c1c;
            margin: 0;
            padding: 0;
        }

        /* ENCABEZADO Y LOGO */
        .header {
            position: relative;
            padding-bottom: 20px;
            border-bottom: 3px solid #0c498a;
            margin-bottom: 30px;
        }

        .header-text {
            width: 70%;
        }

        .header h1 {
            color: #0c498a;
            margin: 0 0 5px 0;
            font-size: 24px;
            font-weight: 700;
        }

        .header p {
            margin: 0;
            color: #1a73d3;
            font-size: 14px;
        }

        .logo {
            position: absolute;
            top: 0;
            right: 0;
            width: 180px;
        }

        /* TÍTULOS DE SECCIÓN MODULARES */
        .titulo-seccion {
            background-color: #007bff;
            color: #ffffff;
            padding: 8px 12px;
            font-weight: 700;
            font-size: 14px;
            margin-top: 25px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        /* TABLAS MODULARES */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #e0e0e0;
            padding: 8px 10px;
            text-align: left;
            vertical-align: middle;
        }

        thead th {
            background-color: #f4f7fa;
            color: #0c498a;
            font-weight: 700;
        }

        /* Estilo para los TH que actúan como etiquetas laterales (sin thead) */
        tbody th {
            background-color: #f4f7fa;
            color: #0c498a;
            font-weight: 700;
            width: 25%;
        }

        tbody td {
            width: 25%;
        }

        /* CAJAS DE TEXTO LIBRE */
        .text-box-label {
            font-weight: 700;
            color: #0c498a;
            margin-bottom: 5px;
            margin-top: 15px;
        }

        .text-box {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 12px;
            border-radius: 4px;
            text-align: justify;
        }

        /* CONTROL DE PÁGINA PARA PDF */
        .bloque-cita {
            page-break-inside: avoid;
            margin-bottom: 30px;
            border-left: 3px solid #1a73d3;
            padding-left: 15px;
        }

        .cita-header {
            color: #1c1c1c;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 5px;
            margin-bottom: 10px;
            font-size: 15px;
        }

        /* Footer */
        #footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>
    <p id="footer">© E-VITALIX - <?= $hoy ?></p>

    <div class="header">
        <div class="header-text">
            <h1>E-VITALIX</h1>
            <p>Sistema de Gestión Médica</p>
            <p style="color: #1c1c1c; margin-top: 10px;">
                <strong>Reporte Oficial:</strong> Historia Clínica General<br>
                <strong>Fecha de Emisión:</strong> <?= date('d/m/Y H:i') ?>
            </p>
        </div>
        <img class="logo" src="<?= BASE_URL ?>/public/assets/dashboard/img/LOGO-PRINCIPAL.png" alt="Logo E-VITALIX">
    </div>

    <h2 class="titulo-seccion">INFORMACIÓN DEL PACIENTE</h2>
    <table>
        <tbody>
            <tr>
                <th>Nombre Completo</th>
                <td><?= $paciente['nombre_paciente'] ?> <?= $paciente['apellido_paciente'] ?></td>
                <th>Documento</th>
                <td><?= $paciente['tipo_documento'] ?>: <?= $paciente['numero_documento'] ?></td>
            </tr>
            <tr>
                <th>Edad</th>
                <td><?= $paciente['edad'] ?> años</td>
                <th>Tipo de Sangre</th>
                <td><?= $paciente['rh'] ?></td>
            </tr>
            <tr>
                <th>Género</th>
                <td><?= $paciente['genero'] ?></td>
                <th>Telefono</th>
                <td><?= $paciente['telefono'] ?></td>
            </tr>
        </tbody>
    </table>

    <h2 class="titulo-seccion">REGISTRO CLÍNICO DE ATENCIONES</h2>

    <?php if (empty($historiales)): ?>
        <p style="text-align: center; color: #1a73d3; padding: 20px;">No hay consultas médicas registradas para este paciente.</p>
    <?php else: ?>

        <?php foreach ($historiales as $historial): ?>
            <div class="bloque-cita">

                <div class="cita-header">
                    <strong>Fecha:</strong> <?= date('d/m/Y', strtotime($historial['fecha_consulta'])) ?> |
                    <strong>Médico Tratante:</strong> Dr(a). <?= $historial['nombre_especialista'] ?> <?= $historial['apellido_especialista'] ?> (<?= $historial['especialidad'] ?>)
                </div>

                <p><strong>Motivo de Consulta:</strong> <?= $historial['motivo_consulta'] ?></p>

                <table>
                    <tbody>
                        <tr>
                            <th style="width: 15%;">P. Arterial</th>
                            <td style="width: 10%;"><?= $historial['presion_sistolica'] ?>/<?= $historial['presion_diastolica'] ?></td>
                            <th style="width: 15%;">Temp.</th>
                            <td style="width: 10%;"><?= $historial['temperatura'] ?>°C</td>
                            <th style="width: 15%;">F. Cardíaca</th>
                            <td style="width: 10%;"><?= $historial['frecuencia_cardiaca'] ?> lpm</td>
                            <th style="width: 15%;">F. Respiratoria</th>
                            <td style="width: 10%;"><?= $historial['frecuencia_respiratoria'] ?> rpm</td>
                        </tr>
                    </tbody>
                </table>

                <h2 class="text-box-label">Diagnóstico Clínico</h2>
                <p class="text-box"><?= $historial['diagnostico'] ?></p>

                <h2 class="text-box-label">Plan de Tratamiento / Órdenes Médicas</h2>
                <p class="text-box"><?= $historial['tratamiento'] ?> <?= $historial['orden_medica'] ?></p>

                <?php if (!empty($historial['nombre_medicamento'])): ?>
                    <h2 class="text-box-label" style="margin-top: 10px;">Fórmula Médica</h2>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 40%;">Medicamento</th>
                                <th style="width: 20%;">Dosis</th>
                                <th style="width: 20%;">Frecuencia</th>
                                <th style="width: 20%;">Duración</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $historial['nombre_medicamento'] ?></td>
                                <td><?= $historial['dosis'] ?></td>
                                <td><?= $historial['frecuencia'] ?></td>
                                <td><?= $historial['duracion'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>

    <?php endif; ?>

    
</body>

</html>