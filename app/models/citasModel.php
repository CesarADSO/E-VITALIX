<?php
require_once __DIR__ . '/../../config/database.php';

class CitasModel
{
    private $conexion;

    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    /**
     * Obtener todas las citas de un especialista específico
     * @param int $id_especialista ID del especialista logueado
     * @return array Lista de citas con información completa
     */
    public function obtenerCitasPorEspecialista($id_especialista)
    {
        try {
            $consulta = "
                SELECT 
                    c.id,
                    a.fecha,
                    a.hora_inicio,
                    a.hora_fin,
                    c.estado_cita,
                    c.motivo_consulta,
                    CONCAT(p.nombres, ' ', p.apellidos) AS nombre_paciente,
                    p.telefono AS telefono_paciente,
                    u.email AS email_paciente,
                    s.nombre AS servicio_nombre,
                    s.duracion_minutos AS servicio_duracion,
                    s.precio AS servicio_precio
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id
                INNER JOIN usuarios u ON p.id_usuario = u.id
                INNER JOIN servicios s ON c.id_servicio = s.id
                INNER JOIN agenda_slot a ON c.id_agenda_slot = a.id
                WHERE a.id_especialista = :id_especialista
                ORDER BY 
                    CASE 
                        WHEN c.estado_cita = 'PENDIENTE' THEN 1
                        WHEN c.estado_cita = 'CONFIRMADA' THEN 2
                        WHEN c.estado_cita = 'CANCELADA' THEN 3
                        ELSE 4
                    END,
                    a.fecha DESC, 
                    a.hora_inicio DESC
            ";

            $resultado = $this->conexion->prepare($consulta);
            $resultado->bindParam(':id_especialista', $id_especialista, PDO::PARAM_INT);
            $resultado->execute();

            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener citas: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Actualizar el estado de una cita
     * @param int $id_cita ID de la cita
     * @param string $nuevo_estado Nuevo estado (CONFIRMADA, CANCELADA)
     * @param int $id_especialista ID del especialista (validación de seguridad)
     * @return array Resultado de la operación
     */
    public function actualizarEstadoCita($id_cita, $nuevo_estado, $id_especialista)
    {
        try {
            // Primero verificamos que la cita pertenece al especialista
            $verificar = "SELECT id FROM citas WHERE id = :id_cita AND id_especialista = :id_especialista";
            $stmt = $this->conexion->prepare($verificar);
            $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
            $stmt->bindParam(':id_especialista', $id_especialista, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                return [
                    'success' => false,
                    'message' => 'No tienes permisos para modificar esta cita'
                ];
            }

            // Actualizamos el estado
            $actualizar = "UPDATE citas SET estado = :estado WHERE id = :id_cita";
            $resultado = $this->conexion->prepare($actualizar);
            $resultado->bindParam(':estado', $nuevo_estado, PDO::PARAM_STR);
            $resultado->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
            $resultado->execute();

            return [
                'success' => true,
                'message' => 'Estado de la cita actualizado correctamente'
            ];
        } catch (PDOException $e) {
            error_log("Error al actualizar estado de cita: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al actualizar el estado de la cita'
            ];
        }
    }

    /**
     * Obtener detalles completos de una cita específica
     * @param int $id_cita ID de la cita
     * @param int $id_especialista ID del especialista (validación)
     * @return array|null Datos de la cita o null si no existe
     */
    public function obtenerDetalleCita($id_cita, $id_especialista)
    {
        try {
            $consulta = "
                SELECT 
                    c.*,
                    CONCAT(p.nombres, ' ', p.apellidos) AS nombre_paciente,
                    p.telefono AS telefono_paciente,
                    p.email AS email_paciente,
                    p.fecha_nacimiento,
                    s.nombre AS servicio_nombre,
                    s.duracion AS servicio_duracion,
                    s.precio AS servicio_precio
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id
                INNER JOIN servicios s ON c.id_servicio = s.id
                WHERE c.id = :id_cita AND c.id_especialista = :id_especialista
            ";

            $resultado = $this->conexion->prepare($consulta);
            $resultado->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
            $resultado->bindParam(':id_especialista', $id_especialista, PDO::PARAM_INT);
            $resultado->execute();

            return $resultado->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener detalle de cita: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Contar citas por estado para un especialista
     * @param int $id_especialista ID del especialista
     * @return array Conteo de citas por estado
     */
    public function contarCitasPorEstado($id_especialista)
    {
        $consulta = "
        SELECT 
            estado_cita,
            COUNT(*) AS total
        FROM citas
        INNER JOIN agenda_slot 
            ON citas.id_agenda_slot = agenda_slot.id
        WHERE agenda_slot.id_especialista = :id_especialista
        GROUP BY estado_cita
    ";

        $stmt = $this->conexion->prepare($consulta);
        $stmt->bindParam(':id_especialista', $id_especialista, PDO::PARAM_INT);
        $stmt->execute();

        $conteo = [
            'Pendiente' => 0,
            'Aceptada' => 0,
            'Cancelada' => 0,
            'Rechazada' => 0
        ];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $conteo[$fila['estado_cita']] = (int)$fila['total'];
        }

        return $conteo;
    }
}
