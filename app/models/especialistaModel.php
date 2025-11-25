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

            return true;
        } catch (PDOException $e) {
            error_log("Error en Especialista::registrar->" . $e->getMessage());
            return false;
        }
    }

    // CREAMOS LA FUNCIÓN PARA MOSTRAR LOS ESPECIALISTAS
    public function mostrar()
    {
        // CREAMOS EL TRY-CATCH PARA MANEJAR ERRORES
        try {
            // EN UNA VARIABLE DECLARAMOS LA CONSULTA SQL A UTILIZAR
            $mostrar = "SELECT especialistas.*, usuarios.id AS id_usuario, usuarios.estado FROM especialistas INNER JOIN usuarios ON especialistas.id_usuario = usuarios.id ORDER BY especialistas.nombres ASC";

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

    // CREAMOS LA FUNCIÓN PARA LISTAR UN ESPECIALISTA
    public function listarEspecialistaPorId($id)
    {
        // CREAMOS EL TRY-CATCH PARA MANEJAR ERRORES
        try {
            // EN UNA VARIABLE DECLARAMOS LA CONSULTA SQL A UTILIZAR
            $consultar = "SELECT 
                            especialistas.id AS id_especialista,
                            especialistas.nombres,
                            especialistas.apellidos,
                            especialistas.id_tipo_documento,
                            especialistas.numero_documento,
                            especialistas.fecha_nacimiento,
                            especialistas.genero,
                            especialistas.telefono,
                            especialistas.direccion,
                            especialistas.foto,
                            especialistas.especialidad,
                            especialistas.registro_profesional,
                            usuarios.id AS id_usuario,
                            usuarios.estado,
                            tipo_documento.nombre AS documento
                            FROM especialistas INNER JOIN tipo_documento
                            ON especialistas.id_tipo_documento = tipo_documento.id
                            INNER JOIN usuarios ON especialistas.id_usuario = usuarios.id
                            WHERE especialistas.id = :id
                            LIMIT 1;";

            // PREPARAMOS LA ACCIÓN A EJECUTAR
            $resultado = $this->conexion->prepare($consultar);

            // HACEMOS EL BINDPARAM
            $resultado->bindParam(':id', $id);

            // EJECUTAMOS LA ACCIÓN
            $resultado->execute();

            // RETORNAMOS LA CADENA DE DATOS CON UN FETCH
            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error en Especialista::listarEspecialistaPorId->" . $e->getMessage());
            // RETORNAMOS UN ARREGLO VACIO SI NO LLEGAS NADA
            return [];
        }
    }

    public function actualizar($data) {
        // CREAMOS EL TRY-CATCH PARA MANEJAR ERRORES
        try {
            // EN UNA VARIABLE DECLARAMOS LA CONSULTA SQL A UTILIZAR
            $actualizar = "UPDATE usuarios SET estado = :estadoEspecialista WHERE id = :idUsuario";

             // PREPARAMOS LA ACCIÓN A EJECUTAR
             $resultado = $this->conexion->prepare($actualizar);

             $resultado->bindParam(':idUsuario', $data['idUsuario']);
             $resultado->bindParam(':estadoEspecialista', $data['estadoEspecialista']);

             $resultado->execute();

            $actualizar2 = "UPDATE especialistas SET nombres = :nombres, apellidos = :apellidos, id_tipo_documento = :idTipoDocumento, numero_documento = :numeroDocumento, fecha_nacimiento = :fechaNacimiento, genero = :genero, telefono = :telefono, direccion = :direccion, foto = :foto, especialidad = :especialidad, registro_profesional = :registroProfesional WHERE id = :idEspecialista";

            $resultado2 = $this->conexion->prepare($actualizar2);
            $resultado2->bindParam(':idEspecialista', $data['idEspecialista']);
            $resultado2->bindParam(':nombres', $data['nombres']);
            $resultado2->bindParam(':apellidos', $data['apellidos']);
            $resultado2->bindParam(':idTipoDocumento', $data['tipoDocumento']);
            $resultado2->bindParam(':numeroDocumento', $data['numeroDocumento']);
            $resultado2->bindParam(':fechaNacimiento', $data['fechaNacimiento']);
            $resultado2->bindParam(':genero', $data['genero']);
            $resultado2->bindParam(':telefono', $data['telefono']);
            $resultado2->bindParam(':direccion', $data['direccion']);
            $resultado2->bindParam(':foto', $data['foto']);
            $resultado2->bindParam(':especialidad', $data['especialidad']);
            $resultado2->bindParam(':registroProfesional', $data['registroProfesional']);

            $resultado2->execute();

            return true;
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            error_log("Error en Especialista::actualizar->" . $e->getMessage());
            return false;
        }
    }

    public function eliminar($idUsuario, $id , $idDisponibilidad) {
        // CREAMOS EL TRY - CATCH PARA MANEJAR ERRORES
        try {
            
            // EN UNA VARIABLE DEFINIMOS NUESTRA CONSULTA SQL

            $eliminarDisponibilidad = "DELETE FROM disponibilidad_medico WHERE id = :idDisponibilidad";

            $resultado3 = $this->conexion->prepare($eliminarDisponibilidad);

            $resultado3->bindParam(':idDisponibilidad', $idDisponibilidad);

            $resultado3->execute();

            $eliminarEspecialista = "DELETE FROM especialistas WHERE id = :idEspecialista";

            $resultado2 = $this->conexion->prepare($eliminarEspecialista);

            $resultado2->bindParam(':idEspecialista', $id);

            $resultado2->execute();

            $eliminarUsuario = "DELETE FROM usuarios WHERE id = :idUsuario";

            $resultado = $this->conexion->prepare($eliminarUsuario);

            $resultado->bindParam(':idUsuario', $idUsuario);

            $resultado->execute();

            return true;

        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            error_log("Error en Especialista::actualizar->" . $e->getMessage());
            return false;
        }
    }
}
