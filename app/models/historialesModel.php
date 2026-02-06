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

    public function ConsultarPacienteConConsulta ($id_especialista) {
        try {

            // PRIMERO OBTENEMOS EL ID DE LA CONSULTA MÉDICA 
            $obtenerIdConsulta = "SELECT id FROM consulta_medica";

            $resultadoIdConsulta = $this->conexion->prepare($obtenerIdConsulta);
            $resultadoIdConsulta->execute();

            $id_consulta = $resultadoIdConsulta->fetchColumn();


            $consultar = "SELECT consulta_medica.id AS id_consulta, pacientes.id AS id_paciente, pacientes.nombres, pacientes.apellidos, tipo_documento.nombre as tipo_documento, pacientes.numero_documento, MAX(consulta_medica.created_at) AS ultima_consulta FROM consulta_medica INNER JOIN pacientes ON consulta_medica.id_paciente = pacientes.id INNER JOIN tipo_documento ON pacientes.id_tipo_documento = tipo_documento.id WHERE consulta_medica.id = :id_consulta AND consulta_medica.id_especialista = :id_especialista GROUP BY pacientes.nombres";

            $resultado = $this->conexion->prepare($consultar);
            $resultado->bindParam(':id_consulta', $id_consulta);
            $resultado->bindParam(':id_especialista', $id_especialista);
            $resultado->execute();

            return $resultado->fetchAll();

            
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            error_log("Error en Historiales::ConsultarPacienteConConsulta->" . $e->getMessage());
            return false;
        }
    }
}