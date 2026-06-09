<?php
require_once __DIR__ . '/../models/adminConsultorioDashboardModel.php';

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
    $id_consultorio = $_SESSION['user']['id_consultorio'] ?? null;

    // INSTANCIAMOS EL MODELO
    $objDashboard = new AdminConsultorioDashboard();

    // OBTENEMOS LOS DATOS DEL DASHBOARD
    $totalPacientesAtendidos = $objDashboard->contarPacientesAtendidos($id_consultorio);
    $totalCitasProgramadas = $objDashboard->contarCitasProgramadas($id_consultorio);
    $totalCitasProgramadasHoy = $objDashboard->contarCitasProgramadasHoy($id_consultorio);

    // VARIABLE PARA GUARDAR LOS ÚLTIMOS 5 ESPECIALISTAS REGISTRADOS EN EL CONSULTORIO
    $ultimosEspecialistas = $objDashboard->obtenerUltimosEspecialistas($id_consultorio);

    // INCLUIMOS LA VISTA Y PASAMOS LOS DATOS
    require_once __DIR__ . '/../views/dashboard/administrador/dashboard-administrador.php';
}