<?php
require_once __DIR__ . '/../../config/database.php';

class Paciente
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }
    public function registrar($data)
    {
        try {
            // Se inicia el registro con beginTransaction que es el inicio de una serie de inserciones sql donde si falla una se rompe todo para conservar la consistencia de los datos
            $this->conexion->beginTransaction();
            // 1. Insertar Usuario
            $insertarUsuario = "INSERT INTO usuarios(email, contrasena, id_rol) VALUES (:email, :contrasena, :id_rol)";
            $resultadoUsuario = $this->conexion->prepare($insertarUsuario);
            $resultadoUsuario->bindParam(':email', $data['email']);
            $resultadoUsuario->bindParam(':contrasena', $data['contrasena']);
            $resultadoUsuario->bindParam(':contrasena', $data['contrasena']);

            $resultadoUsuario->execute();
            // en este punto ya se hizo la insercion a la tabla usuarios

            // obtener el id del usuario recien creado
            $id_usuario = $this->conexion->lastInsertId();
            // 2. Insertar paciente
            $insertarPaciente = "INSERT INTO pacientes(id_usuario, nombres, apellidos, id_tipo_documento, numero_documento, fecha_nacimiento,genero, telefono, direccion, foto, eps, rh, historial_medico, nombre_contacto_emergencia, telefono_contacto_emergencia, direccion_contacto_emergencia, id_aseguradora) VALUES (:id_usuario, :nombres, :apellidos, :id_tipo_documento,:numero_documento, :fecha_nacimiento, :genero, :telefono, :direccion, :foto, :eps,:rh,:historial_medico, :nombre_contacto_emergencia, :telefono_contacto_emergencia, :direccion_contacto_emergencia, :id_aseguradora)";


            $resultadoPaciente = $this->conexion->prepare($insertarPaciente);
            $resultadoPaciente->bindParam(':id_usuario', $id_usuario);
            $resultadoPaciente->bindParam(':nombres', $data['nombres']);
            $resultadoPaciente->bindParam(':apellidos', $data['apellidos']);
            $resultadoPaciente->bindParam(':id_tipo_documento', $data['id_tipo_documento']);
            $resultadoPaciente->bindParam(':numero_documento', $data['numero_documento']);
            $resultadoPaciente->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
            $resultadoPaciente->bindParam(':genero', $data['genero']);
            $resultadoPaciente->bindParam(':telefono', $data['telefono']);
            $resultadoPaciente->bindParam(':direccion', $data['direccion']);
            $resultadoPaciente->bindParam(':foto', $data['foto']);
            $resultadoPaciente->bindParam(':eps', $data['eps']);
            $resultadoPaciente->bindParam(':rh', $data['rh']);
            $resultadoPaciente->bindParam(':historial_medico', $data['historial_medico']);
            $resultadoPaciente->bindParam(':nombre_contacto_emergencia', $data['nombre_contacto_emergencia']);
            $resultadoPaciente->bindParam(':telefono_contacto_emergencia', $data['telefono_contacto_emergencia']);
            $resultadoPaciente->bindParam(':direccion_contacto_emergencia', $data['direccion_contacto_emergencia']);
            $resultadoPaciente->bindParam(':id_aseguradora', $data['id_aseguradora']);

            $resultadoPaciente->execute();

            // se confirman las inserciones en las tablas exitosamente, en caso de que se rompa o algo salga mal entra el catch a servirnos, en este caso se finaliza con el metodo commit();
            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            // se revierte el proceso en caso de que algo salga mal, se rompe todo y se inicia el proceso de 0, con esto se evita que se creen solo usuarios vacios y no pacientes
            $this->conexion->rollBack();
            error_log("Error en paciente::registrar->" . $e->getMessage());
            return false;
        }
    }
    public function consultar()
    {
        try {
            $consultar = "SELECT p.id, p.nombres, p.apellidos, p.numero_documento, p.fecha_nacimiento, p.genero, p.telefono, p.direccion, p.foto, p.eps, p.rh, td.nombre as tipo_documento, u.email, u.estado, a.nombre as aseguradora FROM pacientes p INNER JOIN usuarios u ON p.id_tipo_documento LEFT JOIN aseguradoras a ON p.id_aseguradora = a.id ORDER BY p.apellidos ASC, p.nombres ASC";

            $resultado = $this->conexion->prepare($consultar);
            $resultado->execute();
            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log('Error en paciente::consultar->' . $e->getMessage());
            return [];
        }
    }
    public function listarPacientePorId($id)
    {
        try {
            $consulta = "SELECT p.*, u.email, u.estado, u.id AS id_usuario_tabla FROM pacientes p INNER JOIN usuarios u ON p.id_usuario = u.id WHERE p.id = :id LIMIT 1";

            $resultado = $this->conexion->prepare($consulta);
            $resultado->bindParam(':id', $id);
            $resultado->excute();

            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error en paciente::listarPacientePorId->" . $e->getMessage());
            return [];
        }
    }
    public function actualizar($data)
    {
        try {
            $this->conexion->beginTransaction();

            // 1. Actualizar usuario 
            $actualizarUsuario = "UPDATE usuarios SET email = :email, estado =:estado WHERE id = :id_usuario";

            $resultadoUsuario = $this->conexion->prepare($actualizarUsuario);
            $resultadoUsuario->bindParam(':email', $data['email']);
            $resultadoUsuario->bindParam(':estado', $data['estado']);
            $resultadoUsuario->bindParam(':id_usuario', $data['id_usuario']);
            $resultadoUsuario->execute();

            //2. Actualizar paciente
            $actualizarPaciente = "UPDATE pacientes SET nombres = :nombres, apellidos =:apellidos, id_tipo_documento =:id_tipo_documento, numero_documento=:numero_documento, fecha_nacimiento=:fecha_nacimiento, genero=:genero, telefono=:telefono, direccion=:direccion, eps=:eps, rh=:rh, historial_medico=:historial_medico, nombre_contacto_emergencia=:nombre_contacto_emergencia, telefono_contacto_emergencia=:telefono_contacto_emergencia, direccion_contacto_emergencia =:direccion_contacto_emergencia, id_aseguradora=:id_aseguradora WHERE id = :id";

            $resultadoPaciente = $this->conexion->prepare($actualizarPaciente);
            $resultadoPaciente->bindParam(':id', $data['id']);
            $resultadoPaciente->bindParam(':nombres', $data['nombres']);
            $resultadoPaciente->bindParam(':apellidos', $data['apellidos']);
            $resultadoPaciente->bindParam(':id_tipo_documento', $data['id_tipo_documento']);
            $resultadoPaciente->bindParam(':numero_documento', $data['numero_documento']);
            $resultadoPaciente->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
            $resultadoPaciente->bindParam(':genero', $data['genero']);
            $resultadoPaciente->bindParam(':telefono', $data['telefono']);
            $resultadoPaciente->bindParam(':direccion', $data['direccion']);
            $resultadoPaciente->bindParam(':eps', $data['eps']);
            $resultadoPaciente->bindParam(':rh', $data['rh']);
            $resultadoPaciente->bindParam(':historial_medico', $data['historial_medico']);
            $resultadoPaciente->bindParam(':nombre_contacto_emergencia', $data['nombre_contacto_emergencia']);
            $resultadoPaciente->bindParam(':telefono_contacto_emergencia', $data['telefono_contacto_emergencia']);
            $resultadoPaciente->bindParam(':direccion_contacto_emergencia', $data['direccion_contacto_emergencia']);
            $resultadoPaciente->bindParam(':id_aseguradora', $data['id_aseguradora']);

            $resultadoPaciente->execute();
            // confirmar la ejecucion exitosa del sql
            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            // Revertir la ejecucion de las consultas y la funcion porque algo salio mal 
            $this->conexion->rollBack();
            error_log('Error en paciente::actualizar->' . $e->getMessage());
            return false;
        }
    }
    public function eliminar($id)
    {
        try {
            // se inician las sentencias sql y con ello el inicio de una 'transaccion', es decir todo el proceso de eliminar en este caso
            $this->conexion->beginTransaction();

            // 1. se obtiene el id del usuario antes de eliminar un paciente
            $consultaIdUsuario = "SELECT id_usuario FROM pacientes WHERE id = :id";
            $resultadoConsulta = $this->conexion->prepare($consultaIdUsuario);
            $resultadoConsulta->bindParam(':id', $id);
            $resultadoConsulta->execute();
            $paciente = $resultadoConsulta->fetch();

            if (!$paciente) {
                throw new Exception("Paciente no encontrado");
            }
            $id_usuario = $paciente['id_usuario'];

            // 2. Eliminar 
        } catch (PDOException $e) {
        }
    }
}
