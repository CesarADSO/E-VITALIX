<?php
require_once __DIR__ . '/../models/superAdminDashboardModel.php';

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        mostrarDatosDashboard();
        break;

}

function mostrarDatosDashboard()
{
    // INSTANCIAMOS LA CLASE 
    $ObjDashboard = new SuperAdminDashboard();

    // OBTENEMOS LOS DATOS DE LOS MÉTODOS
    $totalConsultorios = $ObjDashboard->contarConsultorios();
    $totalUsuarios = $ObjDashboard->contarUsuarios();
    $totalEspecialidades = $ObjDashboard->contarEspecialidades();
    $nuevosConsultoriosPorMes = $ObjDashboard->contarNuevosConsultoriosPorMes();
    
    // variable para el foreach
    $ultimosConsultorios = $ObjDashboard->mostrarUltimosConsultorios();

    // CARGAMOS LA VISTA
    require_once __DIR__ . '/../views/dashboard/superadministrador/dashboard_superadmin.php';
}