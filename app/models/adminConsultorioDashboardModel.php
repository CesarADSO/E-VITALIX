<?php
require_once __DIR__ . '/../../config/database.php';

class AdminConsultorioDashboard
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    // 1. Contar el número total de pacientes atendidos en un consultorio específico
    public function contarPacientesAtendidos($id_consultorio)
    {
        try {
            $contar = "SELECT COUNT(DISTINCT citas.id_paciente) AS total_pacientes  FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id WHERE agenda_slot.id_consultorio = :id_consultorio AND citas.estado_cita = 'COMPLETADA'";

            $resultado = $this->conexion->prepare($contar);
            $resultado->bindParam(':id_consultorio', $id_consultorio);
            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (\Throwable $e) {
            error_log("Error en AdminConsultorioDashboard::contarPacientesAtendidos-> " . $e->getMessage());
        }
    }

    // 2. Contar el número total de citas programadas para un consultorio específico
    public function contarCitasProgramadas($id_consultorio)
    {
        try {
            $contar = "SELECT COUNT(*) AS total_citas FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id WHERE agenda_slot.id_consultorio = :id_consultorio";

            $resultado = $this->conexion->prepare($contar);
            $resultado->bindParam(':id_consultorio', $id_consultorio);
            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (\Throwable $e) {
            error_log("Error en AdminConsultorioDashboard::contarCitasProgramadas-> " . $e->getMessage());
        }
    }

    // 3. Contar el número total de citas programadas para hoy en un consultorio específico
    public function contarCitasProgramadasHoy($id_consultorio) {
        try {
            $contar = "SELECT COUNT(*) AS total_citas FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id WHERE agenda_slot.id_consultorio = :id_consultorio AND DATE(agenda_slot.fecha) = CURDATE()";

            $resultado = $this->conexion->prepare($contar);
            $resultado->bindParam(':id_consultorio', $id_consultorio);
            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (\Throwable $e) {
            error_log("Error en AdminConsultorioDashboard::contarCitasProgramadasHoy-> " . $e->getMessage());
        }
    }
}
