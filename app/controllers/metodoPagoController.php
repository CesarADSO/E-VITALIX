<?php 
    require_once __DIR__ . '/../models/metodoPagoModel.php';

    function mostrarMetodosPago()
    {
        $ObjmetodoPagoModel = new MetodoPago();
        $resultado = $ObjmetodoPagoModel->obtenerMetodosPago();
        return $resultado;
    }
?>