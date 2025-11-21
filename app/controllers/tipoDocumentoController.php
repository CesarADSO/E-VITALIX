<?php

// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS QUE EN ESTE CASO ES EL MODELO
require_once __DIR__ . '/../models/tipoDocumentoModel.php';

function traerTipoDocumento()
{
    try {
        // Instanciamos el modelo
        $tipoDocumento = new TipoDocumento();

        // Obtenemos los resultados
        $resultado = $tipoDocumento->traer();

        // Retornamos el resultado
        return $resultado;
    } catch (Exception $e) {
        error_log("Error en traerTipoDocumento: " . $e->getMessage());
        return [];
    }
}
