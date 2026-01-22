<?php
require_once __DIR__ . '/../../config/database.php';


class MetodoPago
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function obtenerMetodosPago()
    {
        try {
            $consultar = "SELECT * FROM metodos_pago";
            $resultado = $this->conexion->prepare($consultar);
            $resultado->execute();
            return $resultado->fetchAll();
        } catch (PDOException $e) {
            echo "Error al obtener los métodos de pago: " . $e->getMessage();
            return [];
        }
    }
}
