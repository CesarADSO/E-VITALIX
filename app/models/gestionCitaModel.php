<?php
require_once __DIR__ . '/../../config/database.php';

class AgendarCita
{
    private $conexion;

    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    /* ============================
        REGISTRAR CITA
    ============================= */
    public function registrar($data)
    {
        try {
            $sql = "INSERT INTO citas(
                id_paciente,
                id_especialista,
                fecha_cita,
                hora_inicio,
                hora_fin,
                id_servicio,
                id_consultorio,
                motivo_consulta,
                tipo_cita,
                prioridad,
                sintomas_reportados
            ) VALUES (
                :id_paciente,
                :id_especialista,
                :fecha_cita,
                :hora_inicio,
                :hora_fin,
                :id_servicio,
                :id_consultorio,
                :motivo_consulta,
                :tipo_cita,
                :prioridad,
                :sintomas_reportados
            )";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($data);

            return true;

        } catch (PDOException $e) {
            error_log("Error en AgendarCita::registrar -> " . $e->getMessage());
            return false;
        }
    }

    /* ============================
        MOSTRAR TODAS LAS CITAS
    ============================= */
    public function mostrar()
    {
        try {
            $sql = "SELECT c.*, 
                        CONCAT(p.nombres, ' ', p.apellidos) AS nombre_paciente,
                        CONCAT(e.nombres, ' ', e.apellidos) AS nombre_especialista
                    FROM citas c
                    INNER JOIN pacientes p ON c.id_paciente = p.id
                    INNER JOIN especialistas e ON c.id_especialista = e.id_especialista";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en AgendarCita::mostrar -> " . $e->getMessage());
            return [];
        }
    }




    /* ============================
        LISTAR CITA POR ID
    ============================= */
    public function listarPorId($id)
    {
        try {
            $sql = "SELECT * FROM citas WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en AgendarCita::listarPorId -> " . $e->getMessage());
            return [];
        }
    }


    /* ============================
        ACTUALIZAR CITA
    ============================= */
    public function actualizar($data)
    {
        try {
            $sql = "UPDATE citas SET
                        fecha_cita = :fecha_cita,
                        hora_inicio = :hora_inicio,
                        hora_fin = :hora_fin,
                        motivo_consulta = :motivo_consulta,
                        tipo_cita = :tipo_cita,
                        prioridad = :prioridad,
                        sintomas_reportados = :sintomas_reportados,
                        id_estado_cita = :id_estado_cita
                    WHERE id = :id";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute($data);

            return true;
        } catch (PDOException $e) {
            error_log("Error en AgendarCita::actualizar -> " . $e->getMessage());
            return false;
        }
    }


    /* ============================
        ELIMINAR CITA
    ============================= */
    public function eliminar($id)
    {
        try {
            $sql = "DELETE FROM citas WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en AgendarCita::eliminar -> " . $e->getMessage());
            return false;
        }
    }
}
