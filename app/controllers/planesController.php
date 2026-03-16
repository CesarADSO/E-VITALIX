<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
require_once __DIR__ . '/../models/planesModel.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
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
