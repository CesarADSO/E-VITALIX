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

            // OBTENEMOS EL ID DE LA CONSULTA RECIÉN REGISTRADA
            $id_consulta = $this->conexion->lastInsertId();

            // HACEMOS LA CONSULTA SQL PARA INSERTAR LOS DATOS EN LA TABLA FORMULACION_MEDICAMENTOS
            $formular = "INSERT INTO formulacion_medicamentos(id_consulta, nombre_medicamento, dosis, frecuencia, duracion) VALUES (:id_consulta, :nombre_medicamento, :dosis, :frecuencia, :duracion)";

            // EN LA VARIABLE RESULTADOFORMULAR ACCEDEMOS A LA FUNCIÓN PREPARE
            $resultadoFormular = $this->conexion->prepare($formular);

            // INSERTAMOS LOS DATOS QUE VIENEN EN DATA EN LOS PARAMETROS DE LA CONSULTA
            $resultadoFormular->bindParam(':id_consulta', $id_consulta);
            $resultadoFormular->bindParam(':nombre_medicamento', $data['medicamento']);
            $resultadoFormular->bindParam(':dosis', $data['dosis']);
            $resultadoFormular->bindParam(':frecuencia', $data['frecuencia']);
            $resultadoFormular->bindParam(':duracion', $data['duracion']);
            $resultadoFormular->execute();

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
