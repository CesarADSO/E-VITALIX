<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
require_once __DIR__ . '/../helpers/alert_helper.php';

// traemos los modelos que vamos a usar tanto para listado como para crear/reagendar
require_once __DIR__ . '/../models/citasModel.php'; // usado en algunas consultas genéricas
require_once __DIR__ . '/../models/citaModel.php';  // maneja agendar / reagendar / cancelar desde el paciente

// arrancamos sesión si todavía no se ha hecho
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $accion = $_POST['accion'] ?? '';

        if ($accion === 'reagendar') {
            reagendarCita();
        } else {
            agendarCita();
        }
        break;

    case 'GET':
        $accion = $_GET['accion'] ?? '';

        // CASO 1: Retornar JSON para el Modal de detalles
        if ($accion === 'detalle_json') {
            obtenerDetalleJSON();
            exit();
        }

        // CASO 2: Cancelar cita
        if ($accion === 'cancelar') {
            cancelarCita($_GET['id']);
            exit();
        }

        // CASO 3: Listar una cita específica (si lo usas para edición)
        if (isset($_GET['id']) && empty($accion)) {
            listarCita($_GET['id']);
            exit();
        }

        // POR DEFECTO: Mostrar la lista de citas (Cards)
        mostrarCitas();
        break;
}

/**
 * Función para enviar los datos detallados de una cita al modal vía AJAX
 */
function obtenerDetalleJSON()
{
    header('Content-Type: application/json');
    $id_cita = $_GET['id'] ?? null;

    if (!$id_cita) {
        echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
        return;
    }

    // en la interfaz de paciente usamos el modelo "Cita" y su método listarCita,
    // porque el método de CitasModel requiere un id_especialista y no está disponible
    // cuando quien consulta es un paciente.
    $modeloPaciente = new Cita();
    $detalle = $modeloPaciente->listarCita($id_cita);

    if ($detalle) {
        echo json_encode($detalle);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'No se encontró la cita']);
    }
}

/**
 * Carga la vista de "Mis Citas" con los datos necesarios para las Cards
 */
function mostrarCitas()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    // Validar sesión
    if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 1) {
        header('Location: ' . BASE_URL . '/login');
        exit();
    }

    $id_paciente = $_SESSION['user']['id_paciente'];
    $citasModel = new CitasModel();

    // Obtenemos todas las citas para pasarlas a la vista
    $citas = $citasModel->obtenerCitasPorPaciente($id_paciente);

    // Cargamos la vista de Cards
    require_once BASE_PATH . '/app/views/dashboard/paciente/ListaDeCitas.php';
}

// --- TUS FUNCIONES EXISTENTES (Mantenlas igual) ---

/**
 * Devuelve un arreglo con los datos de la cita solicitada.
 * Se usa desde la vista de reagendar (reagendar_cita.php).
 */
function listarCita($id)
{
    $modelo = new Cita();
    return $modelo->listarCita($id);
}

/**
 * Procesa la petición de agendar una nueva cita desde el formulario del paciente.
 */
function agendarCita()
{
    // validación básica de sesión y rol
    if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 1) {
        header('Location: ' . BASE_URL . '/login');
        exit();
    }

    $id_paciente = $_SESSION['user']['id_paciente'];
    $horario = $_POST['horario'] ?? null;
    $servicio = $_POST['servicio'] ?? null;
    $motivo   = trim($_POST['motivo'] ?? '');

    if (empty($horario) || empty($servicio)) {
        mostrarSweetAlert('error', 'Datos incompletos', 'Debe seleccionar horario y servicio');
        return;
    }

    $modelo = new Cita();
    $ok = $modelo->agendar([
        'horario'     => $horario,
        'id_paciente' => $id_paciente,
        'servicio'    => $servicio,
        'motivo'      => $motivo
    ]);

    if ($ok) {
        mostrarSweetAlert('success', 'Cita agendada', 'Tu cita ha sido registrada', BASE_URL . '/paciente/ListaDeCitas');
    } else {
        mostrarSweetAlert('error', 'Error', 'No se pudo agendar la cita, inténtalo de nuevo');
    }
}

/**
 * Procesa la petición de reagendar una cita existente.
 */
function reagendarCita()
{
    if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 1) {
        header('Location: ' . BASE_URL . '/login');
        exit();
    }

    $id_cita  = $_POST['id'] ?? null;
    $horario  = $_POST['horario'] ?? null;
    $servicio = $_POST['servicio'] ?? null;
    $motivo   = trim($_POST['motivo'] ?? '');

    if (empty($id_cita) || empty($horario) || empty($servicio)) {
        mostrarSweetAlert('error', 'Datos incompletos', 'Faltan campos obligatorios');
        return;
    }

    $modelo = new Cita();
    $ok = $modelo->reagendar([
        'id_cita' => $id_cita,
        'horario' => $horario,
        'servicio' => $servicio,
        'motivo'  => $motivo
    ]);

    if ($ok) {
        mostrarSweetAlert('success', 'Cita reagendada', 'Se actualizó la fecha/hora de tu cita', BASE_URL . '/paciente/ListaDeCitas');
    } else {
        mostrarSweetAlert('error', 'Error', 'No se pudo reagendar la cita');
    }
}

function cancelarCita($id)
{
    $ObjCita = new CitasModel();
    $resultado = $ObjCita->cancelarCita($id); // Ajustado al nombre de tu método en el modelo

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Cita cancelada', 'Tu cita ha sido cancelada correctamente', BASE_URL . '/paciente/ListaDeCitas');
    } else {
        mostrarSweetAlert('error', 'Error', 'No se pudo cancelar la cita');
    }
}
