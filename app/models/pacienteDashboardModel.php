<?php
require_once __DIR__ . '/../../config/database.php';

class PacienteDashboard
{
    private $conexion;

    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    // Función para obtener el número total de citas del paciente
    public function obtenerHistorialDeCitas($id_paciente)
    {
        try {
            $contar = "SELECT COUNT(*) AS total_citas FROM citas WHERE id_paciente = :id_paciente";
            $resultado = $this->conexion->prepare($contar);
            $resultado->bindParam(':id_paciente', $id_paciente);

            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en PacienteDashboard::obtenerHistorialDeCitas  " . $e->getMessage());
            return [];
        }
    }

    // Función para obtener el número de citas programadas para hoy
    public function obtenerCitasParaHoy($id_paciente)
    {
        try {
            $contar = "SELECT COUNT(*) AS citas_hoy FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id WHERE citas.id_paciente = :id_paciente AND DATE(agenda_slot.fecha) = CURDATE() AND citas.estado_cita IN ('CONFIRMADA', 'PENDIENTE')";
            $resultado = $this->conexion->prepare($contar);
            $resultado->bindParam(':id_paciente', $id_paciente);

            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en PacienteDashboard::obtenerCitasParaHoy  " . $e->getMessage());
            return [];
        }
    }

    // Función para obtener el número de citas Completadas
    public function obtenerCitasCompletadas($id_paciente) {
        try {
            $contar = "SELECT COUNT(*) AS citas_completadas FROM citas WHERE id_paciente = :id_paciente AND estado_cita = 'COMPLETADA'";

            $resultado = $this->conexion->prepare($contar);
            $resultado->bindParam(':id_paciente', $id_paciente);
            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en PacienteDashboard::obtenerCitasCompletadas  " . $e->getMessage());
            return [];
        }
    }

    // Función para obtener el número de citas canceladas
    public function obtenerCitasCanceladas($id_paciente) {
        try {
            $contar = "SELECT COUNT(*) AS citas_canceladas FROM citas WHERE id_paciente = :id_paciente AND estado_cita IN ('CANCELADA', 'RECHAZADA')";

            $resultado = $this->conexion->prepare($contar);
            $resultado->bindParam(':id_paciente', $id_paciente);
            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en PacienteDashboard::obtenerCitasCanceladas  " . $e->getMessage());
            return [];
        }
    }

    // Función para obtener las últimas 5 citas del paciente
    public function obtenerUltimasCitas($id_paciente) {
        try {
            $mostrar = "SELECT citas.id AS id_cita, agenda_slot.id_especialista AS id_especialista, agenda_slot.id_consultorio AS id_consultorio, citas.id_servicio AS id_servicio, especialidades.id AS id_especialidad, especialistas.nombres AS nombre_especialista, especialistas.apellidos AS apellido_especialista, agenda_slot.fecha, agenda_slot.hora_inicio, citas.estado_cita FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id INNER JOIN especialistas ON agenda_slot.id_especialista = especialistas.id INNER JOIN especialidades ON especialistas.id_especialidad = especialidades.id WHERE citas.id_paciente = :id_paciente ORDER BY agenda_slot.fecha DESC, agenda_slot.hora_inicio DESC LIMIT 5";
            $resultado = $this->conexion->prepare($mostrar);
            $resultado->bindParam(':id_paciente', $id_paciente);
            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en PacienteDashboard::obtenerUltimasCitas  " . $e->getMessage());
            return [];
        }
    }
}
