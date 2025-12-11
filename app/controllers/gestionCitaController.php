<?php
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/gestionCitaModel.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'POST':
        $accion = $_POST['accion'] ?? '';

        if ($accion === 'actualizar') {
            actualizarCita();
        } else {
            registrarCita();
        }
        break;

    case 'GET':
        $accion = $_GET['accion'] ?? '';

        if ($accion === 'eliminar') {
            eliminarCita($_GET['id']);
        }

        if (isset($_GET['id'])) {
            listarCitaPorId($_GET['id']);
        } else {
            mostrarCitas();
        }
        break;
}



/* ============================
    REGISTRAR CITA
============================ */
function registrarCita()
{
    $data = [
        'id_paciente'        => $_POST['id_paciente'] ?? null,
        'id_especialista'    => $_POST['id_especialista'] ?? null,
        'fecha_cita'         => $_POST['fecha_cita'] ?? null,
        'hora_inicio'        => $_POST['hora_inicio'] ?? null,
        'hora_fin'           => $_POST['hora_fin'] ?? null,
        'id_servicio'        => $_POST['id_servicio'] ?? null,
        'id_consultorio'     => $_POST['id_consultorio'] ?? null,
        'motivo_consulta'    => $_POST['motivo_consulta'] ?? null,
        'tipo_cita'          => $_POST['tipo_cita'] ?? null,
        'prioridad'          => $_POST['prioridad'] ?? null,
        'sintomas_reportados'=> $_POST['sintomas_reportados'] ?? null
    ];

    // Validación
    if (
        empty($data['id_paciente']) ||
        empty($data['id_especialista']) ||
        empty($data['fecha_cita']) ||
        empty($data['hora_inicio'])
    ) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Completa los campos obligatorios.');
        exit();
    }

    $model = new AgendarCita();
    $resultado = $model->registrar($data);

    if ($resultado === true) {
        mostrarSweetAlert(
            'success',
            'Cita registrada',
            'La cita se ha agendado exitosamente.',
            '/E-VITALIX/paciente/citas'
        );
    } else {
        mostrarSweetAlert('error', 'Error', 'No se pudo registrar la cita.');
    }

    exit();
}



/* ============================
    MOSTRAR CITAS
============================ */
function mostrarCitas()
{
    $model = new AgendarCita();
    return $model->mostrar();
}



/* ============================
    LISTAR CITA POR ID
============================ */
function listarCitaPorId($id)
{
    $model = new AgendarCita();
    return $model->listarPorId($id);
}


/* ============================
    ACTUALIZAR CITA
============================ */
function actualizarCita()
{
    $data = [
        'id' => $_POST['id'] ?? '',
        'fecha_cita' => $_POST['fecha_cita'] ?? '',
        'hora_inicio' => $_POST['hora_inicio'] ?? '',
        'hora_fin' => $_POST['hora_fin'] ?? '',
        'motivo_consulta' => $_POST['motivo_consulta'] ?? '',
        'tipo_cita' => $_POST['tipo_cita'] ?? '',
        'prioridad' => $_POST['prioridad'] ?? '',
        'sintomas_reportados' => $_POST['sintomas_reportados'] ?? '',
        'id_estado_cita' => $_POST['id_estado_cita'] ?? ''
    ];

    if (empty($data['fecha_cita']) || empty($data['hora_inicio'])) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Completa los campos obligatorios');
        exit();
    }

    $model = new AgendarCita();

    $resultado = $model->actualizar($data);

    if ($resultado === true) {
        mostrarSweetAlert(
            'success',
            'Cita actualizada',
            'Los datos han sido modificados',
            '/E-VITALIX/paciente/citas'
        );
    } else {
        mostrarSweetAlert('error', 'Error', 'No se pudo actualizar la cita');
    }
    exit();
}


/* ============================
    ELIMINAR CITA
============================ */
function eliminarCita($id)
{
    $model = new AgendarCita();
    $resultado = $model->eliminar($id);

    if ($resultado === true) {
        mostrarSweetAlert(
            'success',
            'Eliminación exitosa',
            'La cita ha sido eliminada',
            '/E-VITALIX/paciente/citas'
        );
    } else {
        mostrarSweetAlert('error', 'Error', 'No se pudo eliminar la cita');
    }
    exit();
}

?>
