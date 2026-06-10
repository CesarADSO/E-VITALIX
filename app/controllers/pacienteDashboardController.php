<?php
require_once __DIR__ . '/../models/pacienteDashboardModel.php';

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        mostrarDatosDashboard();
        break;

}

function mostrarDatosDashboard() {
    // REANUDAMOS LA SESIÓN PARA OBTENER EL ID DEL CONSULTORIO
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // OBTENEMOS EL ID DEL CONSULTORIO DESDE LA SESIÓN
    $id_paciente = $_SESSION['user']['id_paciente'] ?? null;

    // INSTANCIAMOS EL MODELO
    $objDashboard = new PacienteDashboard();

    // OBTENEMOS LOS DATOS DEL DASHBOARD
    $totalcitasPaciente = $objDashboard->obtenerHistorialDeCitas($id_paciente);
    $totalCitasHoy = $objDashboard->obtenerCitasParaHoy($id_paciente);
    $totalCitasCompletadas = $objDashboard->obtenerCitasCompletadas($id_paciente);
    $totalCitasCanceladas = $objDashboard->obtenerCitasCanceladas($id_paciente);

    $mostrarUltimasCitas = $objDashboard->obtenerUltimasCitas($id_paciente);

    // INCLUIMOS LA VISTA Y PASAMOS LOS DATOS
    require_once __DIR__ . '/../views/dashboard/paciente/dashboard-paciente.php';
}