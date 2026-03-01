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

        if (isset($_GET['id_servicio'])) {
            consultarNombreServicio($_GET['id_servicio']);
        }

        if (isset($_GET['id_consultorio']) && isset($_GET['id_especialidad']) && isset($_GET['id_servicio'])) {

            listarDisponibilidad($_GET['id_consultorio'], $_GET['id_especialidad'], $_GET['id_servicio']);
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

function mostrarSlots2()
{

    $objSlot = new Slot();

    $resultado = $objSlot->mostrarParaTodos();

    return $resultado;
}

 function consultarNombreServicio($id_servicio) {
    $objSlot = new Slot();

    $resultado = $objSlot->consultarNombreServicio($id_servicio);

    return $resultado;
 }

function listarDisponibilidad($id_consultorio, $id_especialidad, $id_servicio)
{
    $objSlot = new Slot();

    $resultado = $objSlot->listarDisponibilidad($id_consultorio, $id_especialidad, $id_servicio);

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
