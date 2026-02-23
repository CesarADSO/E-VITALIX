<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../models/CalendarioModel.php';
header('Content-Type: application/json');

// Validación de seguridad para AJAX
if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 3) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Sesión expirada']);
    exit();
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$model = new CalendarioModel();

switch ($action) {
    case 'obtener_eventos_especialista':
        $start = $_GET['start'] ?? null;
        $end = $_GET['end'] ?? null;
        $id_esp = $_SESSION['user']['id_especialista'];

        // FullCalendar envía start y end en formato ISO8601, extraemos solo la fecha
        $fecha_inicio = date('Y-m-d', strtotime($start));
        $fecha_fin = date('Y-m-d', strtotime($end));

        echo json_encode($model->obtenerEventosEspecialista($id_esp, $fecha_inicio, $fecha_fin));
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}
