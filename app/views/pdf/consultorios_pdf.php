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

        /* Imagen de consultorio */
        .imgconsultorio {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 4px;
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
    <h1>Reporte de Consultorios Suscritos a la Plataforma</h1>

    <!-- DESCRIPCIÓN -->
    <p class="descripcion">
        El presente reporte contiene el listado de los consultorios actualmente suscritos a la plataforma E-VITALIX.
        Este documento permite llevar un control administrativo detallado, facilitando la gestión, auditoría
        y supervisión de la información asociada a cada consultorio, incluyendo datos de contacto y ubicación.
    </p>

    <!-- TABLA -->
    <table>
        <thead>
            <tr>
                <th>Logo</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Ciudad</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($consultorios)): ?>
                <?php foreach ($consultorios as $consultorio): ?>
                    <tr>
                        <td>
                            <img class="imgconsultorio"
                                src="<?= BASE_URL ?>/public/uploads/consultorios/<?= $consultorio['foto'] ?>"
                                alt="<?= $consultorio['nombre'] ?>">
                        </td>
                        <td><?= $consultorio['nombre'] ?></td>
                        <td><?= $consultorio['direccion'] ?></td>
                        <td><?= $consultorio['telefono'] ?></td>
                        <td><?= $consultorio['ciudad'] ?></td>
                        <td><?= $consultorio['estado'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay consultorios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- FOOTER -->
    <div id="footer">
        © E-VITALIX - <?= $hoy ?>
    </div>

</body>

</html>