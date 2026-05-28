<?php

// IMPORTAMOS EL MODELO QUE NECESITAMOS
require_once __DIR__ . '/../models/ciudadesModel.php';

function listarCiudades () {
    // INSTANCIAMOS LA CLASE DEL MODELO
    $objCiudad = new Ciudad;

    // ACCEDEMOS AL MÉTODO QUE NECESITAMOS DE ESA CLASE
    $resultado = $objCiudad->listarCiudades();

    // RETORNAMOS A LAS VISTAS QUE NECESITAMOS
    return $resultado;
}

?>