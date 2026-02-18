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

    public function ConsultarPacienteConConsulta($id_especialista)
    {
        try {

            // // PRIMERO OBTENEMOS EL ID DE LA CONSULTA MÉDICA 
            // $obtenerIdConsulta = "SELECT id FROM consulta_medica";

            // $resultadoIdConsulta = $this->conexion->prepare($obtenerIdConsulta);
            // $resultadoIdConsulta->execute();

            // $id_consulta = $resultadoIdConsulta->fetchColumn();


            $consultar = "SELECT pacientes.id AS id_paciente, consulta_medica.id AS id_consulta, pacientes.nombres, pacientes.apellidos, tipo_documento.nombre AS tipo_documento, pacientes.numero_documento, MAX(consulta_medica.created_at) AS ultima_consulta FROM consulta_medica INNER JOIN pacientes ON consulta_medica.id_paciente = pacientes.id INNER JOIN tipo_documento ON pacientes.id_tipo_documento = tipo_documento.id WHERE consulta_medica.id_especialista = :id_especialista GROUP BY pacientes.id ORDER BY consulta_medica.created_at DESC";

            $resultado = $this->conexion->prepare($consultar);
            // $resultado->bindParam(':id_consulta', $id_consulta);
            $resultado->bindParam(':id_especialista', $id_especialista);
            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            error_log("Error en Historiales::ConsultarPacienteConConsulta->" . $e->getMessage());
            return [];
        }
    }

    public function consultarInfoPaciente($id_paciente)
    {
        try {
            $consultarInfo = "SELECT pacientes.foto, pacientes.nombres AS nombre_paciente, pacientes.apellidos AS apellido_paciente, tipo_documento.nombre AS tipo_documento, pacientes.numero_documento, pacientes.edad, pacientes.rh, pacientes.genero FROM pacientes INNER JOIN tipo_documento ON pacientes.id_tipo_documento = tipo_documento.id WHERE pacientes.id = :id_paciente";
            $resultado = $this->conexion->prepare($consultarInfo);
            $resultado->bindParam(':id_paciente', $id_paciente);
            $resultado->execute();

            return $resultado->fetch();

        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            error_log("Error en Historiales::consultarInfoPaciente->" . $e->getMessage());
            return [];
        }
    }


    public function consultarHistorialClinicoPaciente($id_paciente)
    {
        try {
            $consultarHistorial = "SELECT consulta_medica.id AS id_consulta, consulta_medica.created_at AS fecha_consulta, consulta_medica.motivo_consulta, consulta_medica.diagnostico, especialistas.nombres AS nombre_especialista, especialistas.apellidos AS apellido_especialista, especialistas.id_especialidad, especialidades.nombre AS especialidad, consulta_medica.presion_sistolica, consulta_medica.presion_diastolica, consulta_medica.temperatura, consulta_medica.frecuencia_cardiaca, consulta_medica.frecuencia_respiratoria, consulta_medica.tratamiento, consulta_medica.observaciones FROM consulta_medica INNER JOIN pacientes ON consulta_medica.id_paciente = pacientes.id INNER JOIN especialistas ON consulta_medica.id_especialista = especialistas.id INNER JOIN especialidades ON especialistas.id_especialidad = especialidades.id WHERE pacientes.id = :id_paciente ORDER BY consulta_medica.created_at DESC";

            $resultado = $this->conexion->prepare($consultarHistorial);
            $resultado->bindParam(':id_paciente', $id_paciente);

            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            error_log("Error en Historiales::consultarHistorialClinicoPaciente->" . $e->getMessage());
            return [];
        }
    }
}
