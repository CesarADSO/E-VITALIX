<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
require_once __DIR__ . '/../models/planesModel.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id_plan'])) {
            consultarPlanPorId($_GET['id_plan']);
        }

        traerId();
        break;

    default:
        # code...
        break;
}

function traerId()
{
    // INSTANCIAMOS LA CLASE DEL MODELO
    $objPlan = new Plan();

    // ACCEDEMOS AL MÉTODO DE LA CLASE PLAN
    $resultado = $objPlan->traerId();

    // RETORNAMOS RESULTADO
    return $resultado;
}

function consultarPlanPorId($id) {
    // INSTANCIAMOS LA CLASE DEL MODELO
    $objPlan = new Plan();

    // ACCEDEMOS AL MÉTODO DE LA CLASE PLAN
    $resultado = $objPlan->consultarPlanPorId($id);

    // RETORNAMOS A LA VISTA
    return $resultado;
}