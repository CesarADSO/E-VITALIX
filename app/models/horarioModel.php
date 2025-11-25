<?php
    require_once __DIR__ . '/../../config/database.php';

    // CREAMOS NUESTRA CLASE
    class Horario {
        private $conexion;
        public function __construct()
        {
            $db = new Conexion();
            $this->conexion = $db->getConexion();
        }


        // CREAMOS EL METODO QUE VAMOS A UTILIZAR
        public function registrar($data) {
            // CREAMOS EL TRY-CATCH PARA MANEJAR ERRORES
            try {
                
                // GUARDAMOS EN UNA VARIABLE LA SENTENCIA SQL A EJECUTAR
                $registrar = "INSERT INTO disponibilidad_medico(id_especialista, id_consultorio, dia_semana, hora_inicio, hora_fin, pausa_inicio, pausa_fin, capacidad_maxima, estado_disponibilidad) VALUES (:idEspecialista, :idConsultorio, :diaSemana, :horaInicio, :horaFin, :pausaInicio, :pausaFin, :capacidadMaxima, 'Activo')";

                $resultado = $this->conexion->prepare($registrar);

                $resultado->bindParam(':idEspecialista', $data['idEspecialista']);
                $resultado->bindParam(':idConsultorio', $data['idConsultorio']);
                $resultado->bindParam(':diaSemana', $data['diaSemana']);
                $resultado->bindParam(':horaInicio', $data['horaInicio']);
                $resultado->bindParam(':horaFin', $data['horaFin']);
                $resultado->bindParam(':pausaInicio', $data['inicioDescanso']);
                $resultado->bindParam(':pausaFin', $data['finDescanso']);
                $resultado->bindParam(':capacidadMaxima', $data['capacidadMaxima']);

                $resultado->execute();

                return true;
            } catch (PDOException $e) {
                error_log('Error en Horario::registrar->' . $e->getMessage());
                return false;
            }
        }

        public function mostrar() {
            try {
                
                // GUARDAMOS EN UNA VARIABLE LA CONSULTA SQL A EJECUTAR
                $mostrar = "SELECT disponibilidad_medico.*, especialistas.nombres, especialistas.apellidos FROM disponibilidad_medico INNER JOIN especialistas ON disponibilidad_medico.id_especialista = especialistas.id";

                $resultado = $this->conexion->prepare($mostrar);

                $resultado->execute();



                return $resultado->fetchAll();

            } catch (PDOException $e) {
                error_log('Error en Horario::registrar->' . $e->getMessage());
                return [];
            }
        }
    }

?>