<?php
require_once __DIR__ . '/../../config/database.php';

class Historiales
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function ConsultarPacienteConConsulta ($id_consulta) {
        try {
            $consultar = "SELECT pacientes.nombres, pacientes.apellidos, tipo_documento.nombre as tipo_documento, pacientes.numero_documento FROM consulta_medica INNER JOIN pacientes ON consulta_medica.id_paciente = pacientes.id INNER JOIN tipo_documento ON pacientes.id_tipo_documento = tipo_documento.id WHERE consulta_medica.id = :id_consulta";

            $resultado = $this->conexion->prepare($consultar);
            $resultado->bindParam(':id_consulta', $id_consulta);
            $resultado->execute();

            return $resultado->fetchAll();

            
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            error_log("Error en Historiales::ConsultarPacienteConConsulta->" . $e->getMessage());
            return false;
        }
    }
}