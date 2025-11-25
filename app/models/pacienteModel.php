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
            // Iniciar transacción
            $this->conexion->beginTransaction();

            // 1. Insertar usuario
            $insertarUsuario = "INSERT INTO usuarios(email, contrasena, id_rol, estado) 
                               VALUES(:email, :contrasena, :id_rol, 'Activo')";

            $resultadoUsuario = $this->conexion->prepare($insertarUsuario);
            $resultadoUsuario->bindParam(':email', $data['email']);
            $resultadoUsuario->bindParam(':contrasena', $data['contrasena']);
            $resultadoUsuario->bindParam(':id_rol', $data['id_rol']);

            $resultadoUsuario->execute();

            // Obtener el ID del usuario recién creado
            $id_usuario = $this->conexion->lastInsertId();

            // 2. Insertar paciente
            $insertarPaciente = "INSERT INTO pacientes(
                id_usuario, 
                nombres, 
                apellidos, 
                id_tipo_documento, 
                numero_documento, 
                fecha_nacimiento, 
                genero, 
                telefono, 
                direccion, 
                foto, 
                eps, 
                rh, 
                historial_medico, 
                nombre_contacto_emergencia, 
                telefono_contacto_emergencia, 
                direccion_contacto_emergencia, 
                id_aseguradora
            ) VALUES(
                :id_usuario, 
                :nombres, 
                :apellidos, 
                :id_tipo_documento, 
                :numero_documento, 
                :fecha_nacimiento, 
                :genero, 
                :telefono, 
                :direccion, 
                :foto, 
                :eps, 
                :rh, 
                :historial_medico, 
                :nombre_contacto_emergencia, 
                :telefono_contacto_emergencia, 
                :direccion_contacto_emergencia, 
                :id_aseguradora
            )";

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

            // Manejo especial para id_aseguradora (puede ser NULL)
            if (empty($data['id_aseguradora'])) {
                $resultadoPaciente->bindValue(':id_aseguradora', null, PDO::PARAM_NULL);
            } else {
                $resultadoPaciente->bindParam(':id_aseguradora', $data['id_aseguradora']);
            }

            $resultadoPaciente->execute();

            // Confirmar transacción
            $this->conexion->commit();

            return true;
        } catch (PDOException $e) {
            // Revertir transacción en caso de error
            $this->conexion->rollBack();
            error_log("Error en paciente::registrar->" . $e->getMessage());
            return false;
        }
    }

    public function consultar()
    {
        try {
            $consultar = "SELECT 
                            p.id,
                            p.nombres,
                            p.apellidos,
                            p.numero_documento,
                            p.fecha_nacimiento,
                            p.genero,
                            p.telefono,
                            p.direccion,
                            p.foto,
                            p.eps,
                            p.rh,
                            td.nombre as tipo_documento,
                            u.email,
                            u.estado,
                            a.nombre as aseguradora
                          FROM pacientes p
                          INNER JOIN usuarios u ON p.id_usuario = u.id
                          INNER JOIN tipo_documento td ON p.id_tipo_documento = td.id
                          LEFT JOIN aseguradoras a ON p.id_aseguradora = a.id
                          ORDER BY p.apellidos ASC, p.nombres ASC";

            $resultado = $this->conexion->prepare($consultar);
            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en paciente::consultar->" . $e->getMessage());
            return [];
        }
    }

    public function listarPacientePorId($id)
    {
        try {
            $consulta = "SELECT 
                            p.*,
                            u.email,
                            u.estado,
                            u.id as id_usuario_tabla
                          FROM pacientes p
                          INNER JOIN usuarios u ON p.id_usuario = u.id
                          WHERE p.id = :id 
                          LIMIT 1";

            $resultado = $this->conexion->prepare($consulta);
            $resultado->bindParam(':id', $id);
            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error en paciente::listarPacientePorId->" . $e->getMessage());
            return [];
        }
    }

    public function actualizar($data)
    {
        try {
            // Iniciar transacción
            $this->conexion->beginTransaction();

            // 1. Actualizar usuario
            $actualizarUsuario = "UPDATE usuarios 
                                 SET email = :email, 
                                     estado = :estado 
                                 WHERE id = :id_usuario";

            $resultadoUsuario = $this->conexion->prepare($actualizarUsuario);
            $resultadoUsuario->bindParam(':email', $data['email']);
            $resultadoUsuario->bindParam(':estado', $data['estado']);
            $resultadoUsuario->bindParam(':id_usuario', $data['id_usuario']);
            $resultadoUsuario->execute();

            // 2. Actualizar paciente
            $actualizarPaciente = "UPDATE pacientes 
                                  SET nombres = :nombres,
                                      apellidos = :apellidos,
                                      id_tipo_documento = :id_tipo_documento,
                                      numero_documento = :numero_documento,
                                      fecha_nacimiento = :fecha_nacimiento,
                                      genero = :genero,
                                      telefono = :telefono,
                                      direccion = :direccion,
                                      eps = :eps,
                                      rh = :rh,
                                      historial_medico = :historial_medico,
                                      nombre_contacto_emergencia = :nombre_contacto_emergencia,
                                      telefono_contacto_emergencia = :telefono_contacto_emergencia,
                                      direccion_contacto_emergencia = :direccion_contacto_emergencia,
                                      id_aseguradora = :id_aseguradora
                                  WHERE id = :id";

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

            // Manejo especial para id_aseguradora (puede ser NULL)
            if (empty($data['id_aseguradora'])) {
                $resultadoPaciente->bindValue(':id_aseguradora', null, PDO::PARAM_NULL);
            } else {
                $resultadoPaciente->bindParam(':id_aseguradora', $data['id_aseguradora']);
            }

            $resultadoPaciente->execute();

            // Confirmar transacción
            $this->conexion->commit();

            return true;
        } catch (PDOException $e) {
            // Revertir transacción en caso de error
            $this->conexion->rollBack();
            error_log("Error en paciente::actualizar->" . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id)
    {
        try {
            // Iniciar transacción
            $this->conexion->beginTransaction();

            // 1. Obtener id_usuario antes de eliminar el paciente
            $consultaIdUsuario = "SELECT id_usuario FROM pacientes WHERE id = :id";
            $resultadoConsulta = $this->conexion->prepare($consultaIdUsuario);
            $resultadoConsulta->bindParam(':id', $id);
            $resultadoConsulta->execute();
            $paciente = $resultadoConsulta->fetch();

            if (!$paciente) {
                throw new Exception("Paciente no encontrado");
            }

            $id_usuario = $paciente['id_usuario'];

            // 2. Eliminar paciente
            $eliminarPaciente = "DELETE FROM pacientes WHERE id = :id";
            $resultadoPaciente = $this->conexion->prepare($eliminarPaciente);
            $resultadoPaciente->bindParam(':id', $id);
            $resultadoPaciente->execute();

            // 3. Eliminar usuario
            $eliminarUsuario = "DELETE FROM usuarios WHERE id = :id_usuario";
            $resultadoUsuario = $this->conexion->prepare($eliminarUsuario);
            $resultadoUsuario->bindParam(':id_usuario', $id_usuario);
            $resultadoUsuario->execute();

            // Confirmar transacción
            $this->conexion->commit();

            return true;
        } catch (PDOException $e) {
            // Revertir transacción en caso de error
            $this->conexion->rollBack();
            error_log("Error en paciente::eliminar->" . $e->getMessage());
            return false;
        }
    }
}
