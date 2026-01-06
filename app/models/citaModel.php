<?php
require_once __DIR__ . '/../../config/database.php';

class Cita
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function agendar($data) {
        try {
            $agendar = "INSERT INTO citas(id_agenda_slot, id_paciente, id_servicio, motivo_consulta, estado_cita) VALUES (:id_agenda_slot, :id_paciente, :id_servicio, :motivo_consulta, 'Pendiente')";

            $resultado = $this->conexion->prepare($agendar);

            $resultado->bindParam(':id_agenda_slot', $data['horario']);
            $resultado->bindParam(':id_paciente', $data['id_paciente']);
            $resultado->bindParam(':id_servicio', $data['servicio']);
            $resultado->bindParam(':motivo_consulta', $data['motivo']);

            $resultado->execute();

            return true;

        } catch (PDOException $e) {
            error_log("Error en Cita::agendar->" . $e->getMessage());
            return false;
        }
    }

}