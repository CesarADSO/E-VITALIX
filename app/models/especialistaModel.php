<?php
// IMPORTAMOS LA CONEXIÓN A LA BASE DE DATOS
require_once __DIR__ . '/../../config/database.php';

// CREAMOS LA CLASE ANTERIORMENTE INSTANCIADA EN EL CONTROLADOR
class Especialista
{

    // CREAMOS LA FUNCIÓN CONSTRUCTORA
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }


    // CREAMOS EL MÉTODO AL QUE ANTERIORMENTE ACCEDIMOS EN EL CONTROLADOR
    public function registrar($data)
    {
        // CREAMOS EL TRY-CATCH PARA MANEJAR ERRORES
        try {

            // ENCRIPTAMOS LA CLAVE 
            $claveEncriptada = password_hash($data['clave'], PASSWORD_DEFAULT);

            // DEFINIMOS EN UNA VARIABLE LA CONSULTA SQL
            $registrarUsuario = "INSERT INTO usuarios(email, contrasena, id_rol, estado) VALUES (:email, :clave, 3, 'Activo')";

            // PREPARAMOS LA ACCIÓN A EJECUTAR
            $resultado = $this->conexion->prepare($registrarUsuario);

            // CREAMOS LA PARAMETROS
            $resultado->bindParam(':email', $data['email']);
            $resultado->bindParam(':clave', $claveEncriptada);

            // EJECUTAMOS LA ACCIÓN
            $resultado->execute();

            // OBTENEMOS EL ID DEL USUARIO CREADO
            $idUsuario = $this->conexion->lastInsertId();


            // DEFINIMOS EN OTRA VARIABLE LA SIGUIENTE CONSULTA DE SQL
            $registrarEspecialista = "INSERT INTO especialistas(id_usuario, 
            nombres,
            apellidos,
            id_tipo_documento,
            numero_documento, 
            fecha_nacimiento,
            genero,
            telefono,
            direccion,
            foto,
            especialidad,
            registro_profesional)
            VALUES 
            (:id_usuario,
            :nombres,
            :apellidos,
            :id_tipo_documento,
            :numero_documento,
            :fecha_nacimiento,
            :genero,
            :telefono,
            :direccion,
            :foto,
            :especialidad,
            :registro_profesional)";

            // PREPARAMOS LA ACCIÓN A EJECUTAR
            $resultado2 = $this->conexion->prepare($registrarEspecialista);

            $resultado2->bindParam(':id_usuario', $idUsuario);
            $resultado2->bindParam(':nombres', $data['nombres']);
            $resultado2->bindParam(':apellidos', $data['apellidos']);
            $resultado2->bindParam(':id_tipo_documento', $data['tipoDocumento']);
            $resultado2->bindParam(':numero_documento', $data['numeroDocumento']);
            $resultado2->bindParam(':fecha_nacimiento', $data['fechaNacimiento']);
            $resultado2->bindParam(':genero', $data['genero']);
            $resultado2->bindParam(':telefono', $data['telefono']);
            $resultado2->bindParam(':direccion', $data['direccion']);
            $resultado2->bindParam(':foto', $data['foto']);
            $resultado2->bindParam(':especialidad', $data['especialidad']);
            $resultado2->bindParam(':registro_profesional', $data['registroProfesional']);


            $resultado2->execute();

            // OBTENEMOS EL ID DEL ESPECIALISTA PARA LA DISPONIBILIDAD
            $idEspecialista = $this->conexion->lastInsertId();

            $registrarDisponibilidad = "INSERT INTO disponibilidad_medico(id_especialista,
            id_consultorio,
            dia_semana,
            hora_inicio,
            hora_fin,
            pausa_inicio,
            pausa_fin,
            capacidad_maxima,
            estado_disponibilidad)
            VALUES 
            (:id_especialista,
            :consultorio,
            :dia_semana,
            :hora_inicio,
            :hora_fin,
            :pausa_inicio,
            :pausa_fin,
            :capacidad_maxima,
            'Activo')";

            $resultado3 = $this->conexion->prepare($registrarDisponibilidad);

            $resultado3->bindParam(':id_especialista', $idEspecialista);
            $resultado3->bindParam(':consultorio', $data['consultorio']);
            $resultado3->bindParam(':dia_semana', $data['diaSemana']);
            $resultado3->bindParam(':hora_inicio', $data['horaInicio']);
            $resultado3->bindParam(':hora_fin', $data['horaFin']);
            $resultado3->bindParam(':pausa_inicio', $data['descansoInicio']);
            $resultado3->bindParam(':pausa_fin', $data['descansoFinal']);
            $resultado3->bindParam(':capacidad_maxima', $data['capacidad']);

            $resultado3->execute();


            return true;
        } catch (PDOException $e) {
            error_log("Error en Especialista::registrar->" . $e->getMessage());
            return false;
        }
    }

    // CREAMOS LA FUNCIÓN PARA MOSTRAR LOS ESPECIALISTAS
    public function mostrar() {
        // CREAMOS EL TRY-CATCH PARA MANEJAR ERRORES
        try {
            // EN UNA VARIABLE DECLARAMOS LA CONSULTA SQL A UTILIZAR
            $mostrar = "SELECT especialistas.*, usuarios.email, usuarios.estado, disponibilidad_medico.id_consultorio FROM disponibilidad_medico INNER JOIN especialistas ON disponibilidad_medico.id_especialista = especialistas.id INNER JOIN usuarios ON especialistas.id_usuario = usuarios.id WHERE usuarios.estado = 'Activo' ORDER BY especialistas.nombres ASC";

            // PREPARAMOS LA ACCIÓN A EJECUTAR Y LA EJECUTAMOS
            $resultado = $this->conexion->prepare($mostrar);

            // EJECUTAMOS LA ACCIÓN
            $resultado->execute();

            // RETORNAMOS EN UN FETCHALL LA CADENA DE DATOS QUE NOS DA LA VARIABLE RESULTADO PARA ENVIARLO COMO UN ARREGLO
            return $resultado->fetchAll();


        } catch (PDOException $e) {
            error_log("Error en Especialista::mostrar->" . $e->getMessage());
            // RETORNAMOS UN ARREGLO VACIO SI NO LLEGAS NADA
            return [];
        }
    }
}
