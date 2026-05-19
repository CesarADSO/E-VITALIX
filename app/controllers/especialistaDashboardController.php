<?php
require_once __DIR__ . '/../models/especialistaDashboardModel.php';

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        mostrarDatosDashboard();
        break;

}

function mostrarDatosDashboard() {
    // REANUDAMOS LA SESIÓN PARA OBTENER EL ID DEL ESPECIALISTA
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // OBTENEMOS EL ID DEL ESPECIALISTA DESDE LA SESIÓN
    $id_especialista = $_SESSION['user']['id_especialista'] ?? null;

    // INSTANCIAMOS EL MODELO
    $objDashboard = new EspecialistaDashboard();

    // OBTENEMOS LOS DATOS DEL DASHBOARD
    $totalCitasProgramadas = $objDashboard->contarCitasProgramadas($id_especialista);
    $totalCitasPendientes = $objDashboard->contarCitasPendientes($id_especialista);
    $totalPacientesAtendidos = $objDashboard->contarPacientesAtendidos($id_especialista);
    $totalCitasProgramadasHoy = $objDashboard->contarCitasProgramadasHoy($id_especialista);

    // VARIABLE PARA GUARDAR LOS DATOS QUE VAMOS A PASAR A A LA VISTA
    $citas = $objDashboard->obtenerUltimasCitasPendientes($id_especialista);
    

    // INCLUIMOS LA VISTA Y PASAMOS LOS DATOS
    require_once __DIR__ . '/../views/dashboard/especialista/dashboard-especialista.php';
}