<?php
// IMPORTAMOS LA CONEXIÓN A LA BASE DE DATOS
require_once __DIR__ . '/../../config/database.php';

class Registro
{
    private $conexion;

    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function registrar($data)
    {
        // CREAMOS EL TRY CATCH PARA MANEJAR ERRORES
        try {

            // HASEAMOS LA CONTRASEÑA QUE VA A SER EL NÚMERO DE DOCUMENTO
            $clave_encriptada = password_hash($data['numero_documento'], PASSWORD_DEFAULT);
            
            // EN UNA VARIABLE GUARDAMOS LA SENTENCIA SQL QUE VAMOS A EJECUTAR
            $registrarUsuario = "INSERT INTO usuarios(email, contrasena, id_rol, estado) VALUES (:email, :contrasena, 1, 'Activo')";

            $resultadoUsuario = $this->conexion->prepare($registrarUsuario);

            $resultadoUsuario->bindParam(':email', $data['email']);
            $resultadoUsuario->bindParam(':contrasena', $clave_encriptada);
            $resultadoUsuario->execute();

            // OBTENEMOS EL ID DEL USUARIO RECIEN CREADO
            $id_usuario = $this->conexion->lastInsertId();

            // HACEMOS EL INSERT EN LA TABLA PACIENTES
            $registrarPaciente = "INSERT INTO pacientes(id_usuario, nombres, apellidos, id_tipo_documento, numero_documento, fecha_nacimiento, genero, telefono, ciudad, direccion, foto, eps, rh, historial_medico, nombre_contacto_emergencia, telefono_contacto_emergencia, direccion_contacto_emergencia, id_aseguradora) VALUES (:id_usuario, :nombres, :apellidos, :id_tipo_documento, :numero_documento, NULL, NULL, :telefono, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";

            $resultadoPaciente = $this->conexion->prepare($registrarPaciente);
            $resultadoPaciente->bindParam(':id_usuario', $id_usuario);
            $resultadoPaciente->bindParam(':nombres', $data['nombres']);
            $resultadoPaciente->bindParam(':apellidos', $data['apellidos']);
            $resultadoPaciente->bindParam(':id_tipo_documento', $data['tipo_documento']);
            $resultadoPaciente->bindParam(':numero_documento', $data['numero_documento']);
            $resultadoPaciente->bindParam(':telefono', $data['telefono']);

            $resultadoPaciente->execute();

            return true;



        } catch (PDOException $e) {
            error_log("Error en Registro::registrar->" . $e->getMessage());
            return false;
        }
    }
}
