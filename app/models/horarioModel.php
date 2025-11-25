<?php
    require_once __DIR__ . '/../../config/database.php';

    // CREAMOS NUESTRA CLASE
    class Horario {
        // CREAMOS EL METODO QUE VAMOS A UTILIZAR
        public function registrar() {
            // CREAMOS EL TRY-CATCH PARA MANEJAR ERRORES
            try {
                
                // GUARDAMOS EN UNA VARIABLE LA SENTENCIA SQL A EJECUTAR
                $registrar = "INSERT INTO disponibilidad_medico"





            } catch (PDOException $e) {
                error_log('Error en Horario::registrar->' . $e->getMessage());
                return false;
            }
        }
    }

?>