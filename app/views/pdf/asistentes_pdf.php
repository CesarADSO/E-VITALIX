<?php
$hoy = date("Y");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        /* 1. IMPORTAR LA FUENTE NUNITO */
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap');


        @page {
            margin: 40px 40px 60px 40px;
            /* márgenes internas */
        }

        body {
            /* 2. APLICAR NUNITO COMO FUENTE PRINCIPAL */
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
            color: #333;
        }

        /* Encabezado */
        .header {
            width: 100%;
            text-align: right;
            margin-bottom: 20px;
        }

        .header img {
            width: 140px;
        }

        /* Título */
        h1 {
            color: #007BFF;
            text-align: center;
            margin-bottom: 5px;
            font-size: 22px;
            letter-spacing: 0.5px;
        }

        /* Párrafo descriptivo */
        .descripcion {
            text-align: justify;
            margin: 0 10px 30px 10px;
            line-height: 1.5;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
        }

        thead {
            background: #E9ECEF;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            font-weight: bold;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #e9ecef;
        }

        /* Imagen de especialista */
        .especialistaImg {
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            border-radius: 50%;
            object-fit: cover;
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

    <!-- ENCABEZADO -->
    <div class="header">
        <img src="<?= BASE_URL ?>/public/assets/dashboard/img/LOGO-PRINCIPAL.png" alt="Logo">
    </div>

    <!-- TÍTULO -->
    <h1>Reporte de asistentes suscritos al consultorio asociado al administrador</h1>

    <!-- DESCRIPCIÓN -->
    <p class="descripcion">
        El presente reporte presenta el listado de los asistentes actualmente registrados en el consultorio asociado al administrador.
        Este documento permite llevar un control administrativo detallado, facilitando la gestión, auditoría
        y supervisión de la información asociada a cada asistente, incluyendo datos de contacto.
    </p>

    <!-- TABLA -->
    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nombres y apellidos</th>
                <th>Tipo de documento</th>
                <th>Número de documento</th>
                <th>Teléfono</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($asistentes)) : ?>
                <?php foreach ($asistentes as $asistente): ?>
                    <tr>
                        <td>
                            <div class="user-avatar">
                                <img class="especialistaImg" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $asistente['foto'] ?>" alt="<?= $asistente['nombres'] ?>">
                            </div>
                        </td>
                        <td><?= $asistente['nombres'] ?> <?= $asistente['apellidos'] ?></td>
                        <td><?= $asistente['tipo_documento'] ?></td>
                        <td><?= $asistente['numero_documento'] ?></td>
                        <td><?= $asistente['telefono'] ?></td>
                        <td><?= $asistente['estado'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <td>No hay asistentes registrados</td>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- FOOTER -->
    <div id="footer">
        © E-VITALIX - <?= $hoy ?>
    </div>

</body>

</html>