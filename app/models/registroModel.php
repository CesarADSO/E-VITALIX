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
            $registrarPaciente = "INSERT INTO pacientes(id_usuario, nombres, apellidos, id_tipo_documento, numero_documento, fecha_nacimiento, genero, telefono, ciudad, direccion, foto, eps, rh, nombre_contacto_emergencia, telefono_contacto_emergencia, direccion_contacto_emergencia, perfil_completo) VALUES (:id_usuario, :nombres, :apellidos, :id_tipo_documento, :numero_documento, NULL, NULL, :telefono, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0)";

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

    public function completarPerfilPaciente($data) {
        // CREAMOS EL TRY CATCH PARA MANEJAR ERRORES
        try {
            // EN UNA VARIABLE GUARDAMOS LA SENTENCIA SQL QUE VAMOS A EJECUTAR
            $completarPerfil = "UPDATE pacientes SET fecha_nacimiento = :fecha_nacimiento, genero = :genero, ciudad = :ciudad, direccion = :direccion, eps = :eps, rh = :rh, nombre_contacto_emergencia = :nombre_contacto, telefono_contacto_emergencia = :telefono_contacto, direccion_contacto_emergencia = :direccion_contacto, perfil_completo = 1 WHERE id = :id_paciente";

            $resultado = $this->conexion->prepare($completarPerfil);
            $resultado->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
            $resultado->bindParam(':genero', $data['genero']);
            $resultado->bindParam(':ciudad', $data['ciudad']);
            $resultado->bindParam(':direccion', $data['direccion']);
            $resultado->bindParam(':eps', $data['eps']);
            $resultado->bindParam(':rh', $data['rh']);
            $resultado->bindParam(':nombre_contacto', $data['nombre_contacto']);
            $resultado->bindParam(':telefono_contacto', $data['telefono_contacto']);
            $resultado->bindParam(':direccion_contacto', $data['direccion_contacto']);
            $resultado->bindParam(':id_paciente', $data['id_paciente']);

           $resultado->execute();

              return true;
        }  catch (PDOException $e) {
            error_log("Error en Registro::completarPerfilPaciente->" . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si un email ya está registrado
     */
    public function emailExiste($email)
    {
        try {
            $query = "SELECT id FROM usuarios WHERE email = :email LIMIT 1";
            $resultado = $this->conexion->prepare($query);
            $resultado->bindParam(':email', $email);
            $resultado->execute();
            
            return $resultado->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error en Registro::emailExiste->" . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si un documento ya está registrado
     */
    public function documentoExiste($numero_documento)
    {
        try {
            $query = "SELECT id FROM pacientes WHERE numero_documento = :numero_documento LIMIT 1";
            $resultado = $this->conexion->prepare($query);
            $resultado->bindParam(':numero_documento', $numero_documento);
            $resultado->execute();
            
            return $resultado->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error en Registro::documentoExiste->" . $e->getMessage());
            return false;
        }
    }
}
