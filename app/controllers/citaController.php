<?php
// IMPORTAMOS LA DEPENDENCIAS NECESARIAS
// EN ESTE CASO EL ALERT HELPER Y EL MODELO
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/citaModel.php';

$method = $_SERVER['REQUEST_METHOD'];

// HACEMOS EL SWITCH CASE PARA VALIDAR LOS CASOS POSIBLES
switch ($method) {
    case 'POST':
        $accion = $_POST['accion'] ?? '';

        if ($accion === 'reagendar') {
            reagendarCita();
            break;
        } else {
            agendarCita();
        }


        break;

    case 'GET':
        $accion = $_GET['accion'] ?? '';
        if ($accion === 'cancelar') {
            cancelarCita($_GET['id']);
        }

        if (isset($_GET['id'])) {
            listarCita($_GET['id']);
            break;
        }
        mostrarCitas();
        break;
}

function agendarCita()
{
    $slot = $_POST['horario'] ?? '';
    $servicio = $_POST['servicio'] ?? '';
    $motivo = $_POST['motivo'] ?? '';

    // Validamos los campos que son obligatorios
    if (empty($slot) || empty($servicio) || empty($motivo)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    // Iniciar o reanudar sesión de forma segura y obtener datos del usuario
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Obtenemos el id del paciente
    $id_paciente = $_SESSION['user']['id_paciente'];

    $ObjCita = new Cita();

    $data = [
        'id_paciente' => $id_paciente,
        'horario' => $slot,
        'servicio' => $servicio,
        'motivo' => $motivo
    ];

    $resultado = $ObjCita->agendar($data);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Cita registrada correctamente', 'Por favor esperar a que el especialista la acepte', '/E-VITALIX/paciente/ListaDeCitas');
    } else {
        mostrarSweetAlert('error', 'No se pudo registrar la cita', 'Intente nuevamente');
    }
}

function mostrarCitas()
{
    // Iniciar o reanudar sesión de forma segura y obtener datos del usuario
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $id_paciente = $_SESSION['user']['id_paciente'];

    $objCita = new Cita();

    $resultado = $objCita->mostrar($id_paciente);

    return $resultado;
}

function listarCita($id)
{
    $objCita = new Cita();

    $resultado = $objCita->listarCita($id);

    return $resultado;
}

function reagendarCita() {
    $id_cita = $_POST['id'] ?? '';
    $slot = $_POST['horario'] ?? '';
    $servicio = $_POST['servicio'] ?? '';
    $motivo = $_POST['motivo'] ?? '';

    // Validamos los campos que son obligatorios
    if (empty($slot) || empty($servicio) || empty($motivo)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    $ObjCita = new Cita();

    $data = [
        'id_cita' => $id_cita,
        'horario' => $slot,
        'servicio' => $servicio,
        'motivo' => $motivo
    ];

    $resultado = $ObjCita->reagendar($data);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Cita reagendada correctamente', 'Por favor esperar a que el especialista la acepte', '/E-VITALIX/paciente/ListaDeCitas');
    } else {
        mostrarSweetAlert('error', 'No se pudo reagendar la cita', 'Intente nuevamente');
    }
}

function cancelarCita($id) {
    $ObjCita = new Cita();

    $resultado = $ObjCita->cancelar($id);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Cita cancelada correctamente', 'La cita fue cancelada exitosamente', '/E-VITALIX/paciente/ListaDeCitas');
    } else {
        mostrarSweetAlert('error', 'No se pudo cancelar la cita', 'Intente nuevamente');
    }
}