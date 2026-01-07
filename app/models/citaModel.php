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

    public function agendar($data)
    {
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

    public function mostrar($id_paciente)
    {
        try {
            $consultar = "SELECT citas.id, especialistas.nombres, especialistas.apellidos, consultorios.nombre AS nombre_consultorio, servicios.nombre AS nombre_servicio, agenda_slot.fecha, agenda_slot.hora_inicio, agenda_slot.hora_fin, citas.estado_cita FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id INNER JOIN servicios ON citas.id_servicio = servicios.id INNER JOIN especialistas ON agenda_slot.id_especialista = especialistas.id INNER JOIN consultorios ON agenda_slot.id_consultorio = consultorios.id WHERE citas.id_paciente = :id_paciente";

            $resultado = $this->conexion->prepare($consultar);

            $resultado->bindParam(':id_paciente', $id_paciente);

            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en Cita::mostrar->" . $e->getMessage());
            return [];
        }
    }

    public function listarCita($id)
    {
        try {

            $listar = "SELECT citas.id AS id_cita, agenda_slot.id AS id_horario, agenda_slot.fecha, agenda_slot.hora_inicio, agenda_slot.hora_fin, especialistas.nombres, especialistas.apellidos, consultorios.nombre AS nombre_consultorio, servicios.id AS id_servicio, servicios.nombre AS nombre_servicio, citas.motivo_consulta FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id INNER JOIN servicios ON citas.id_servicio = servicios.id INNER JOIN especialistas ON agenda_slot.id_especialista = especialistas.id INNER JOIN consultorios ON agenda_slot.id_consultorio = consultorios.id WHERE citas.id = :id_cita";

            $resultado = $this->conexion->prepare($listar);

            $resultado->bindParam(':id_cita', $id);

            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error en Cita::mostrar->" . $e->getMessage());
            return [];
        }
    }

    public function reagendar($data)
    {
        try {

            // 1. OBTENER EL SLOT ANTERIOR DE LA CITA
            // ANTES DE CAMBIAR LA CITA, NECESITAMOS SABER QUE SLOT ESTABA RESERVADO
            $obtenerSlotAnterior = "SELECT id_agenda_slot FROM citas WHERE id = :id_cita";

            $resultadoSlotAnterior = $this->conexion->prepare($obtenerSlotAnterior);
            $resultadoSlotAnterior->bindParam(':id_cita', $data['id_cita']);
            $resultadoSlotAnterior->execute();


            // Guardamos el ID del slot anterior
            // fetchColumn devuelve SOLO el valor del id del slot anterior
            $slotAnterior = $resultadoSlotAnterior->fetchColumn();


            // ACTUALIZAR LA CITA CON EL NUEVO HORARIO


            $reagendar = "UPDATE citas SET id_agenda_slot = :id_agenda_slot, id_servicio = :id_servicio, motivo_consulta = :motivo_consulta WHERE id = :id_cita";

            $resultado = $this->conexion->prepare($reagendar);

            $resultado->bindParam(':id_agenda_slot', $data['horario']);
            $resultado->bindParam(':id_servicio', $data['servicio']);
            $resultado->bindParam(':motivo_consulta', $data['motivo']);
            $resultado->bindParam(':id_cita', $data['id_cita']);

            $resultado->execute();


            // LIBERAMOS EL SLOT ANTERIOR
            $liberarSlot = "UPDATE agenda_slot SET estado_slot = 'Disponible' WHERE id = :id_agenda_slot";

            $resultadoLiberar = $this->conexion->prepare($liberarSlot);
            $resultadoLiberar->bindParam(':id_agenda_slot', $slotAnterior);
            $resultadoLiberar->execute();


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

    public function cancelar($id)
    {
        try {

            $obtenerIdSlot = "SELECT id_agenda_slot FROM citas WHERE id = :id_cita";

            $resultado = $this->conexion->prepare($obtenerIdSlot);
            $resultado->bindParam(':id_cita', $id);
            $resultado->execute();

            // fetchColumn devuelve SOLO el valor del id del slot anterior
            $id_agenda_slot = $resultado->fetchColumn();

            if ($id_agenda_slot === false) {
                return false;
            }

            $cancelar = "UPDATE citas SET estado_cita = 'Cancelada' WHERE id = :id_cita";

            $resultado = $this->conexion->prepare($cancelar);

            $resultado->bindParam(':id_cita', $id);

            $resultado->execute();

            $cambiarEstadoSlot = "UPDATE agenda_slot SET estado_slot = 'Bloqueado' WHERE id = :id_agenda_slot";

            $resultado2 = $this->conexion->prepare($cambiarEstadoSlot);
            $resultado2->bindParam(':id_agenda_slot', $id_agenda_slot);
            $resultado2->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Cita::cancelar->" . $e->getMessage());
            return false;
        }
    }
}
