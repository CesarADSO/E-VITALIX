<?php
require_once __DIR__ . '/../../config/database.php';

class CalendarioModel
{
    private $conexion;

    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function obtenerEventosEspecialista($id_especialista, $fecha_inicio, $fecha_fin)
    {
        try {
            $consulta = "SELECT s.id, s.fecha, s.hora_inicio, s.hora_fin, s.estado_slot, 
                            c.id AS cita_id, c.estado_cita, c.motivo_consulta, 
                            CONCAT(p.nombres, ' ', p.apellidos) AS nombre_paciente, 
                            srv.nombre AS servicio_nombre 
                    FROM agenda_slot s 
                    LEFT JOIN citas c ON s.id = c.id_agenda_slot 
                    LEFT JOIN pacientes p ON p.id = c.id_paciente 
                    LEFT JOIN servicios srv ON c.id_servicio = srv.id 
                    WHERE s.id_especialista = :id_especialista 
                    AND (s.fecha > CURDATE() OR (s.fecha = CURDATE() AND s.hora_inicio > CURTIME() ))";

            $stmt = $this->conexion->prepare($consulta);
            $stmt->bindParam(':id_especialista', $id_especialista, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);
            $stmt->execute();

            $eventos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $clase = 'fc-event-disponible';
                $titulo = 'Disponible';

                if ($row['estado_slot'] === 'Bloqueado') {
                    $clase = 'fc-event-bloqueado';
                    $titulo = 'Bloqueado';
                } elseif ($row['cita_id']) {
                    switch ($row['estado_cita']) {
                        case 'Pendiente':
                            $clase = 'fc-event-pendiente';
                            $titulo = 'Pendiente: ' . $row['nombre_paciente'];
                            break;
                        case 'Aceptada':
                            $clase = 'fc-event-aceptada';
                            $titulo = 'Cita: ' . $row['nombre_paciente'];
                            break;
                        case 'Cancelada':
                            $clase = 'fc-event-cancelada';
                            $titulo = 'Cancelada';
                            break;
                    }
                }

                $eventos[] = [
                    'id' => $row['cita_id'] ?? $row['id'],
                    'title' => $titulo,
                    'start' => $row['fecha'] . 'T' . $row['hora_inicio'],
                    'end' => $row['fecha'] . 'T' . $row['hora_fin'],
                    'className' => $clase,
                    'extendedProps' => [
                        'tipo' => $row['cita_id'] ? 'cita' : 'slot',
                        'paciente' => $row['nombre_paciente'] ?? 'N/A',
                        'servicio' => $row['servicio_nombre'] ?? 'N/A',
                        'motivo' => $row['motivo_consulta'] ?? '',
                        'estado' => $row['estado_cita'] ?? $row['estado_slot']
                    ]
                ];
            }
            return $eventos;
        } catch (PDOException $e) {
            error_log("Error en CalendarioModel: " . $e->getMessage());
            return [];
        }
    }
}
