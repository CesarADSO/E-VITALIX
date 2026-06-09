<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
// QUE ES LA CONEXIÓN A LA BASE DE DATOS
require_once __DIR__ . '/../../config/database.php';

// CREAMOS LA CLASE
class Ciudad
{

    //PONEMOS LA CONEXIÓN PRIVADA
    private $conexion;

    // CREAMOS LA FUNCIÓN CONSTRUCTORA
    function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function listarCiudades()
    {
        try {
        
            $listar = "SELECT * FROM ciudades ORDER BY nombre ASC";
            $resultado = $this->conexion->prepare($listar);
            $resultado->execute();

            return $resultado;
        
        } catch (PDOException $e) {
            error_log("Error en Ciudad::listarCiudades->" . $e->getMessage());
            return [];
        }
    }
}
