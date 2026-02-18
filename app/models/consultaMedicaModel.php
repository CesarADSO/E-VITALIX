<?php
require_once __DIR__ . '/../../config/database.php';

// CREAMOS LA CLASE
class ConsultaMedica
{
    // CREAMOS LA FUNCIÓN CONSTRUCTORA PARA LA CONEXIÓN A LA BASE DE DATOS
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    

    public function registrarConsultaMedica($data)
    {
        try {
            $registrarConsulta = "INSERT INTO consulta_medica(id_paciente, id_especialista, id_cita, diagnostico, motivo_consulta, sintomas, tratamiento, observaciones, presion_sistolica, presion_diastolica, temperatura, frecuencia_cardiaca, frecuencia_respiratoria, estado) VALUES (:id_paciente, :id_especialista, :id_cita, :diagnostico, :motivo_consulta, :sintomas, :tratamiento, :observaciones, :presion_sistolica, :presion_diastolica, :temperatura, :frecuencia_cardiaca, :frecuencia_respiratoria, 'COMPLETADA')";

            $resultado = $this->conexion->prepare($registrarConsulta);
            $resultado->bindParam(':id_paciente', $data['id_paciente']);
            $resultado->bindParam(':id_especialista', $data['id_especialista']);
            $resultado->bindParam(':id_cita', $data['id_cita']);
            $resultado->bindParam(':diagnostico', $data['diagnostico']);
            $resultado->bindParam(':motivo_consulta', $data['motivo_consulta']);
            $resultado->bindParam(':sintomas', $data['sintomas']);
            $resultado->bindParam(':tratamiento', $data['tratamiento']);
            $resultado->bindParam(':observaciones', $data['observaciones']);
            $resultado->bindParam(':presion_sistolica', $data['presion_sistolica']);
            $resultado->bindParam(':presion_diastolica', $data['presion_diastolica']);
            $resultado->bindParam(':temperatura', $data['temperatura']);
            $resultado->bindParam(':frecuencia_cardiaca', $data['frecuencia_cardiaca']);
            $resultado->bindParam(':frecuencia_respiratoria', $data['frecuencia_respiratoria']);
            $resultado->execute();

            // AHORA MODIFICAMOS EL ESTADO DE LA CITA A 'COMPLETADA'
            $actualizarCita = "UPDATE citas SET estado_cita = 'COMPLETADA' WHERE id = :id_cita";

            $resultadoActualizar = $this->conexion->prepare($actualizarCita);
            $resultadoActualizar->bindParam(':id_cita', $data['id_cita']);
            $resultadoActualizar->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en ConsultaMedica::registrar->" . $e->getMessage());
            return false;
        }
    }
}
