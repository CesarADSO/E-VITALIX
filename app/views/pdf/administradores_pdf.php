<?php
$hoy = date("Y");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 40px 40px 60px 40px;
            /* márgenes internas */
        }

        body {
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

        /* Imagen del administrador */
        .administradorImg {
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
    <h1>Reporte de administradores de consultorios suscritos a la plataforma</h1>

    <!-- DESCRIPCIÓN -->
    <p class="descripcion">
        El presente reporte contiene el listado de los administradores de los consultorios actualmente suscritos a la plataforma E-VITALIX.
        Este documento permite llevar un control administrativo detallado, facilitando la gestión, auditoría
        y supervisión de la información asociada a cada administrador, incluyendo datos de contacto.
    </p>

    <!-- TABLA -->
    <table>

        <thead>
            <tr>
                <th>Foto</th>
                <th>
                    Nombres y apellidos
                </th>
                <th>Teléfono</th>
                <th>Tipo de documento</th>
                <th>Número de documento</th>
                <th>Estado</th>
                <th style="width: 80px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($administradores)) : ?>
                <?php foreach ($administradores as $administrador) : ?>
                    <tr>
                        <td>
                            <div class="user-avatar">
                                <img class="administradorImg" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $administrador['foto'] ?>" alt="<?= $administrador['nombres'] ?>">
                            </div>
                        </td>
                        <td><?= $administrador['nombres'] ?> <?= $administrador['apellidos'] ?></td>
                        <td><?= $administrador['telefono'] ?></td>
                        <td><?= $administrador['tipo_documento'] ?></td>
                        <td><?= $administrador['numero_documento'] ?></td>
                        <td><?= $administrador['estado'] ?></td>
                        <td>
                            <!-- <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a> -->
                            <a href="<?= BASE_URL ?>/superadmin/actualizar-administrador?id=<?= $administrador['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="<?= BASE_URL ?>/superadmin/eliminar-administrador?id=<?= $administrador['id'] ?>&accion=eliminar&id_usuario=<?= $administrador['id_usuario'] ?>"><i class="fa-solid fa-trash-can"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <td>
                    no hay administradores de consultorio registrados
                </td>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- FOOTER -->
    <div id="footer">
        © E-VITALIX - <?= $hoy ?>
    </div>

</body>

</html>