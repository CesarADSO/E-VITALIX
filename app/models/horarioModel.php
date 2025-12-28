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
                $registrar = "INSERT INTO disponibilidad_medico(id_especialista, id_consultorio, dia_semana, hora_inicio, hora_fin, pausa_inicio, pausa_fin, capacidad_maxima, estado_disponibilidad) VALUES (:id_especialista, :id_consultorio, :dias, :horaInicio, :horaFin, :pausaInicio, :pausaFin, :capacidadMaxima, 'Activo')";

                $resultado = $this->conexion->prepare($registrar);

                $resultado->bindParam(':id_especialista', $data['id_especialista']);
                $resultado->bindParam(':id_consultorio', $data['id_consultorio']);
                $resultado->bindParam(':dias', $data['dias']);
                $resultado->bindParam(':horaInicio', $data['horaInicio']);
                $resultado->bindParam(':horaFin', $data['horaFin']);
                $resultado->bindParam(':pausaInicio', $data['inicioDescanso']);
                $resultado->bindParam(':pausaFin', $data['finDescanso']);
                $resultado->bindParam(':capacidadMaxima', $data['capacidadMaxima']);

                $resultado->execute();

                return true;
            } catch (PDOException $e) {
                echo $e->getMessage();
                // error_log('Error en Horario::registrar->' . $e->getMessage());
                return false;
            }
        }

        public function mostrarParaElEspecialista($id_especialista) {
            try {
                
                // GUARDAMOS EN UNA VARIABLE LA CONSULTA SQL A EJECUTAR
                $mostrar = "SELECT * FROM disponibilidad_medico WHERE id_especialista = :id_especialista";

                $resultado = $this->conexion->prepare($mostrar);
                $resultado->bindParam(':id_especialista', $id_especialista);

                $resultado->execute();



                return $resultado->fetchAll();

            } catch (PDOException $e) {
                error_log('Error en Horario::mostrar->' . $e->getMessage());
                return [];
            }
        }

        public function listarHorarioPorId($id) {
            // CREAMOS EL TRY-CATCH PARA MANEJAR ERRORES
            try {
                
                // GUARDAMOS EN UNA VARIABLE LA CONSULTA SQL QUE VAMOS A UTILIZAR
                $consultar = "SELECT * FROM disponibilidad_medico WHERE disponibilidad_medico.id = :id";

                $resultado = $this->conexion->prepare($consultar);

                $resultado->bindParam(':id', $id);

                $resultado->execute();

                return $resultado->fetch();


            } catch (PDOException $e) {
                error_log('Error en Horario::listarHorariosPorId->' . $e->getMessage());
                return [];
            }
        }

        public function actualizar($data) {
            // CREAMOS EL TRY CATCH PARA MANEJAR ERRORES
            try {
                
                // GUARDAMOS EN UNA VARIABLE LA CONSULTA SQL A UTILIZAR
                $actualizar = "UPDATE disponibilidad_medico SET dia_semana = :dias, hora_inicio = :horaInicio, hora_fin = :horaFin, pausa_inicio = :pausaInicio, pausa_fin = :pausaFin, capacidad_maxima = :capacidadMaxima, estado_disponibilidad = :estado WHERE id = :id";

                $resultado = $this->conexion->prepare($actualizar);
                $resultado->bindParam(':id', $data['id']);
                $resultado->bindParam(':dias', $data['dias']);
                $resultado->bindParam(':horaInicio', $data['horaInicio']);
                $resultado->bindParam(':horaFin', $data['horaFin']);
                $resultado->bindParam(':pausaInicio', $data['inicioDescanso']);
                $resultado->bindParam(':pausaFin', $data['finDescanso']);
                $resultado->bindParam(':capacidadMaxima', $data['capacidadCitas']);
                $resultado->bindParam(':estado', $data['estado']);

                $resultado->execute();

                return true;
            } catch (PDOException $e) {
                error_log('Error en Horario::actualizar->' . $e->getMessage());
                return false;
            }
        }

        public function eliminar($id) {
            try {
                
                $eliminar = "DELETE FROM disponibilidad_medico WHERE id = :id";

                $resultado = $this->conexion->prepare($eliminar);

                $resultado->bindParam(':id', $id);

                $resultado->execute();

                return true;

            } catch (PDOException $e) {
                error_log('Error en Horario::eliminar->' . $e->getMessage());
                return false;
            }
        }
    }

?>