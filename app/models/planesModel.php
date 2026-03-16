<?php
require_once __DIR__ . '/../../config/database.php';

class Plan
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }
    
    // CREAMOS LA FUNCIÓN QUE NOS VA A TRAER LA INFORMACIÓN DE CADA PLAN PARA LOS APARTADOS DE PLAN
    public function traerId() {
        try {
            $mostrar = "SELECT id FROM planes_suscripcion";

            $resultado = $this->conexion->prepare($mostrar);
            $resultado->execute();

            return $resultado->fetchAll();

        } catch (PDOException $e) {
            error_log("Error en Plan::mostrar->" . $e->getMessage());
            return [];
        }
    }
}