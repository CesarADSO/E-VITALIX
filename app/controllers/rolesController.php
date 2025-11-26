<?php

// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS QUE EN ESTE CASO ES EL MODELO
require_once __DIR__ . '/../models/rolesModel.php';

function traerRoles()
{
    try {
        // Instanciamos el modelo
        $rol = new Rol();

        // Obtenemos los resultados
        $resultado = $rol->traer();

        // Retornamos el resultado
        return $resultado;
    } catch (Exception $e) {
        error_log("Error en rol: " . $e->getMessage());
        return [];
    }
}
