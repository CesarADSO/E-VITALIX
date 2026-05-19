<?php
require_once __DIR__ . '/../../config/database.php';

class EspecialistaDashboard
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    // 1. Contar el número total de citas programadas de un especialista en específico (histórico)
    public function contarCitasProgramadas($id_especialista) {
        try {
            $contar = "SELECT COUNT(*) AS total_citas FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id WHERE agenda_slot.id_especialista = :id_especialista AND citas.estado_cita != 'CANCELADA'";

            $resultado = $this->conexion->prepare($contar);
            $resultado->bindParam(':id_especialista', $id_especialista);
            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en EspecialistaDashboard::contarCitasProgramadas-> " . $e->getMessage());
        }
    }

    // 2. Contar citas programadas pendientes por atender para un especialista específico
    public function contarCitasPendientes($id_especialista) {
        try {
            $contar = "SELECT COUNT(*) AS total_citas_pendientes FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id WHERE agenda_slot.id_especialista = :id_especialista AND citas.estado_cita IN ('PENDIENTE', 'CONFIRMADA')";

            $resultado = $this->conexion->prepare($contar);
            $resultado->bindParam(':id_especialista', $id_especialista);
            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en EspecialistaDashboard::contarCitasPendientes-> " . $e->getMessage());
        }
    }

    // 3. Contar el número total de pacientes atendidos por un especialista específico (histórico)
    public function contarPacientesAtendidos($id_especialista) {
        try {
            $contar = "SELECT COUNT(DISTINCT citas.id_paciente) AS total_pacientes FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id WHERE agenda_slot.id_especialista = :id_especialista AND citas.estado_cita = 'COMPLETADA'";

            $resultado = $this->conexion->prepare($contar);
            $resultado->bindParam(':id_especialista', $id_especialista);
            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en EspecialistaDashboard::contarPacientesAtendidos-> " . $e->getMessage());
        }
    }

    // 4. Contar el número total de citas programadas para hoy para un especialista específico
    public function contarCitasProgramadasHoy($id_especialista) {
        try {
            $contar = "SELECT COUNT(*) AS total_citas_hoy FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id WHERE agenda_slot.id_especialista = :id_especialista AND DATE(agenda_slot.fecha) = CURDATE() AND citas.estado_cita != 'CANCELADA'";

            $resultado = $this->conexion->prepare($contar);
            $resultado->bindParam(':id_especialista', $id_especialista);
            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en EspecialistaDashboard::contarCitasProgramadasHoy-> " . $e->getMessage());
        }
    }

    // 5. Mostrar en el dashboard del especialista las últimas 5 citas pendientes por atender
    public function obtenerUltimasCitasPendientes($id_especialista) {
        try {
            $consulta = "SELECT citas.id AS id_cita, servicios.id AS id_servicio, pacientes.id AS id_paciente, pacientes.nombres AS nombre_paciente, pacientes.apellidos AS apellido_paciente, agenda_slot.fecha, servicios.nombre AS nombre_servicio, citas.estado_cita FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id INNER JOIN pacientes ON citas.id_paciente = pacientes.id INNER JOIN servicios ON citas.id_servicio = servicios.id WHERE agenda_slot.id_especialista = :id_especialista AND citas.estado_cita IN ('PENDIENTE', 'CONFIRMADA') ORDER BY agenda_slot.fecha ASC LIMIT 5";

            $resultado = $this->conexion->prepare($consulta);

            $resultado->bindParam(':id_especialista', $id_especialista);

            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en EspecialistaDashboard::obtenerUltimasCitasPendientes-> " . $e->getMessage());
            return [];
        }
    }
}