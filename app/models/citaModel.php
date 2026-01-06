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

            $cambiarEstadoSlot = "UPDATE agenda_slot SET estado_slot = 'Reservado' WHERE id = :id_agenda_slot";

            $resultado2 = $this->conexion->prepare($cambiarEstadoSlot);

            $resultado2->bindParam(':id_agenda_slot', $data['horario']);

            $resultado2->execute();

            return true;

        } catch (PDOException $e) {
            error_log("Error en Cita::agendar->" . $e->getMessage());
            return false;
        }
    }

    public function mostrar($id_paciente) {
        try {
            $consultar = "SELECT especialistas.nombres, especialistas.apellidos, consultorios.nombre AS nombre_consultorio, servicios.nombre AS nombre_servicio, agenda_slot.fecha, agenda_slot.hora_inicio, agenda_slot.hora_fin, citas.estado_cita FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id INNER JOIN servicios ON citas.id_servicio = servicios.id INNER JOIN especialistas ON agenda_slot.id_especialista = especialistas.id INNER JOIN consultorios ON agenda_slot.id_consultorio = consultorios.id WHERE citas.id_paciente = :id_paciente";

            $resultado = $this->conexion->prepare($consultar);

            $resultado->bindParam(':id_paciente', $id_paciente);

            $resultado->execute();

           return $resultado->fetchAll();

        } catch (PDOException $e) {
            error_log("Error en Cita::mostrar->" . $e->getMessage());
            return [];
        }
    }

}