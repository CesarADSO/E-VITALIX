<?php
require_once __DIR__ . '/../models/CitasModel.php';
require_once __DIR__ . '/../helpers/session_especialista.php';

/**
 * Función para mostrar la vista de Mis Citas
 */
function mostrarMisCitas()
{
    // Verificar que el usuario sea especialista
    if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 3) {
        header('Location: ' . BASE_URL . '/login');
        exit();
    }

    $id_especialista = $_SESSION['user']['id_especialista'];

    // Instanciar el modelo
    $citasModel = new CitasModel();

    // Obtener las citas del especialista
    $citas = $citasModel->obtenerCitasPorEspecialista($id_especialista);

    // Obtener estadísticas
    $estadisticas = $citasModel->contarCitasPorEstado($id_especialista);

    // DEBUG TEMPORAL - Eliminar después de verificar
    if (isset($_GET['debug'])) {
        echo "<h2>DEBUG - Controlador</h2>";
        echo "<h3>ID Especialista:</h3>";
        echo "<pre>";
        var_dump($id_especialista);
        echo "</pre>";
        echo "<h3>Estadísticas:</h3>";
        echo "<pre>";
        print_r($estadisticas);
        echo "</pre>";
        echo "<h3>Total Citas:</h3>";
        echo "<pre>";
        echo count($citas);
        echo "</pre>";
        echo "<h3>Primeras 3 citas:</h3>";
        echo "<pre>";
        print_r(array_slice($citas, 0, 3));
        echo "</pre>";
        exit();
    }

    // Incluir la vista
    require_once __DIR__ . '/../views/dashboard/especialista/mis_citas_especialista.php';
}

/**
 * Procesar actualización de estado de cita (AJAX)
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Validar sesión
    if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 3) {
        echo json_encode([
            'success' => false,
            'message' => 'Sesión inválida o permisos insuficientes'
        ]);
        exit();
    }

    $action = $_POST['action'];
    $id_especialista = $_SESSION['user']['id_especialista'];
    $citasModel = new CitasModel();

    switch ($action) {
        case 'actualizar_estado':
            $id_cita = isset($_POST['id_cita']) ? (int)$_POST['id_cita'] : 0;
            $nuevo_estado = isset($_POST['estado']) ? trim($_POST['estado']) : '';

            // Validar datos
            if ($id_cita <= 0 || empty($nuevo_estado)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Datos inválidos'
                ]);
                exit();
            }

            // Validar que el estado sea válido
            $estados_validos = ['Aceptada', 'Cancelada', 'Rechazada'];
            if (!in_array($nuevo_estado, $estados_validos)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Estado no válido'
                ]);
                exit();
            }

            // Actualizar estado
            $resultado = $citasModel->actualizarEstadoCita($id_cita, $nuevo_estado, $id_especialista);
            echo json_encode($resultado);
            break;

        case 'obtener_detalle':
            $id_cita = isset($_POST['id_cita']) ? (int)$_POST['id_cita'] : 0;

            if ($id_cita <= 0) {
                echo json_encode([
                    'success' => false,
                    'message' => 'ID de cita inválido'
                ]);
                exit();
            }

            $detalle = $citasModel->obtenerDetalleCita($id_cita, $id_especialista);

            if ($detalle) {
                echo json_encode([
                    'success' => true,
                    'data' => $detalle
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Cita no encontrada'
                ]);
            }
            break;

        default:
            echo json_encode([
                'success' => false,
                'message' => 'Acción no reconocida'
            ]);
            break;
    }
    exit();
}
