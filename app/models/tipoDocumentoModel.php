<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
// QUE ES LA CONEXIÓN A LA BASE DE DATOS
require_once __DIR__ . '/../../config/database.php';

// CREAMOS LA CLASE
class TipoDocumento {

    //PONEMOS LA CONEXIÓN PRIVADA
    private $conexion;

    // CREAMOS LA FUNCIÓN CONSTRUCTORA
    function __construct()
        {
            $db = new Conexion();
            $this->conexion = $db->getConexion();
        }

    // CREAMOS LA FUNCIÓN QUE VAMOS A UTILIZAR
    public function traer() {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            $traer = "SELECT * FROM tipo_documento ORDER BY nombre ASC";

            // CREAMOS LA VARIABLE RESULTADO PARA ACCEDER A LA FUNCIÓN PREPARE
            $resultado = $this->conexion->prepare($traer);

            // EJECUTAMOS LA FUNCIÓN
            $resultado->execute();

            // RETORNAMOS EL RESULTADO EN UN FETCHALL PARA ENVIARSELO AL CONTROLADOR    
            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en tipo de documento::traer->" . $e->getMessage());
            return [];
        }
    }





}



?>