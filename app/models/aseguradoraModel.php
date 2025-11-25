<?php
require_once __DIR__ . '/../../config/database.php';

class Aseguradora
{
    private $conexion;

    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function consultar()
    {
        try {
            $consulta = "SELECT * FROM aseguradoras ORDER BY nombre ASC";
            $resultado = $this->conexion->prepare($consulta);
            $resultado->execute();
            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en aseguradora::consultar->" . $e->getMessage());
            return [];
        }
    }
}
