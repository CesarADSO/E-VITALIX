<?php
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/ticket.php';
require_once __DIR__ . '/../views/dashboard/administrador/crear-ticket.php';



$method = $_SERVER['REQUEST_METHOD'];

function crear() {

    // 1️⃣ Verificar sesión
    if (!isset($_SESSION['id'])) {
        header("Location: login");
        exit;
    }

    // 2️⃣ Verificar método POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // 3️⃣ Validaciones básicas
        if (empty($_POST['titulo']) || empty($_POST['descripcion'])) {
            $_SESSION['error'] = "Todos los campos son obligatorios";
            header("Location: /admin/crear-ticket ");
            exit;
        }

        // 4️⃣ Manejo de imagen
        $imagen = null;
        if (!empty($_FILES['imagen']['name'])) {

            $permitidos = ['image/jpeg', 'image/png'];
            if (!in_array($_FILES['imagen']['type'], $permitidos)) {
                $_SESSION['error'] = "Formato de imagen no permitido";
                header("Location: /admin/crear-ticket");
                exit;
            }

            if ($_FILES['imagen']['size'] > 2000000) {
                $_SESSION['error'] = "La imagen no debe superar 2MB";
                header("Location: /admin/crear-ticket");
                exit;
            }

            $imagen = time() . "_" . $_FILES['imagen']['name'];
            move_uploaded_file(
                $_FILES['imagen']['tmp_name'],
                "public/uploads/" . $imagen
            );
        }

        // 5️⃣ Guardar ticket
        $ticket = new Ticket($GLOBALS['db']);
        $ticket->crear(
            $_SESSION['id'],        // FK usuario_id
            $_POST['titulo'],
            $_POST['descripcion'],
            $imagen
        );

        // 6️⃣ Correo al superadmin
        mail(
            "superadmin@e-vitalix.com",
            "Nuevo Ticket de Soporte - E-VITALIX",
            "Un usuario ha creado un nuevo ticket.\n\nTítulo: {$_POST['titulo']}"
        );

        // 7️⃣ Redirección
        header("Location: tickets");
        exit;
    }

    // 8️⃣ Vista
    require 'views/tickets/crear.php';
}