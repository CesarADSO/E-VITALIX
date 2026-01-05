<?php
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/slotModel.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        # code...
        break;

    case 'GET':
        $accion = $_GET['accion'] ?? '';
        if ($accion === 'modificarEstado') {
            modificarEstadoSlot($_GET['id']);
        }
        mostrarSlots();
        break;
}

function mostrarSlots()
{
    // Iniciar o reanudar sesión de forma segura y obtener datos del usuario
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $id_especialista = $_SESSION['user']['id_especialista'] ?? null;

    $objSlot = new Slot();

    $resultado = $objSlot->mostrar($id_especialista);

    return $resultado;
}

function modificarEstadoSlot($id)
{
    $objSlot = new Slot();

    $resultado = $objSlot->modificarEstado($id);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación de estado exitosa', 'Se ha modificado el estado del slot', '/E-VITALIX/especialista/slots');
    } else {
        mostrarSweetAlert('error', 'Error al Modificar', 'No se pudo modificar el slot. Intenta nuevamente');
    }
    exit();
}
