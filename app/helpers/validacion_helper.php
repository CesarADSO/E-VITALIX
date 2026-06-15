<?php

/**
 * HELPER DE VALIDACIONES
 * Contiene todas las funciones de validación para formularios
 * Validaciones para Backend y Frontend
 */

class Validaciones {

    /**
     * Validar email
     */
    public static function validarEmail($email) {
        // Remover espacios en blanco
        $email = trim($email);
        
        // Validar formato de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'valido' => false,
                'mensaje' => 'El email no tiene un formato válido'
            ];
        }

        // Validar longitud máxima
        if (strlen($email) > 255) {
            return [
                'valido' => false,
                'mensaje' => 'El email es demasiado largo (máximo 255 caracteres)'
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar contraseña
     */
    public static function validarContrasena($contrasena) {
        if (empty($contrasena)) {
            return [
                'valido' => false,
                'mensaje' => 'La contraseña es obligatoria'
            ];
        }

        if (strlen($contrasena) < 8) {
            return [
                'valido' => false,
                'mensaje' => 'La contraseña debe tener al menos 8 caracteres'
            ];
        }

        if (strlen($contrasena) > 100) {
            return [
                'valido' => false,
                'mensaje' => 'La contraseña es demasiado larga'
            ];
        }

        // Validar que contenga al menos una mayúscula
        if (!preg_match('/[A-Z]/', $contrasena)) {
            return [
                'valido' => false,
                'mensaje' => 'La contraseña debe contener al menos una letra mayúscula'
            ];
        }

        // Validar que contenga al menos una minúscula
        if (!preg_match('/[a-z]/', $contrasena)) {
            return [
                'valido' => false,
                'mensaje' => 'La contraseña debe contener al menos una letra minúscula'
            ];
        }

        // Validar que contenga al menos un número
        if (!preg_match('/[0-9]/', $contrasena)) {
            return [
                'valido' => false,
                'mensaje' => 'La contraseña debe contener al menos un número'
            ];
        }

        // Validar que contenga al menos un carácter especial
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $contrasena)) {
            return [
                'valido' => false,
                'mensaje' => 'La contraseña debe contener al menos un carácter especial (!@#$%^&*)'
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar contraseña simple (para cambios de contraseña)
     */
    public static function validarContrasenasimple($contrasena) {
        if (empty($contrasena)) {
            return [
                'valido' => false,
                'mensaje' => 'La contraseña es obligatoria'
            ];
        }

        if (strlen($contrasena) < 8) {
            return [
                'valido' => false,
                'mensaje' => 'La contraseña debe tener al menos 8 caracteres'
            ];
        }

        if (strlen($contrasena) > 100) {
            return [
                'valido' => false,
                'mensaje' => 'La contraseña es demasiado larga'
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar nombres
     */
    public static function validarNombres($nombres) {
        $nombres = trim($nombres);

        if (empty($nombres)) {
            return [
                'valido' => false,
                'mensaje' => 'Los nombres son obligatorios'
            ];
        }

        if (strlen($nombres) < 2) {
            return [
                'valido' => false,
                'mensaje' => 'Los nombres deben tener al menos 2 caracteres'
            ];
        }

        if (strlen($nombres) > 100) {
            return [
                'valido' => false,
                'mensaje' => 'Los nombres son demasiado largos (máximo 100 caracteres)'
            ];
        }

        // No permitir números al inicio
        if (preg_match('/^[0-9]/', $nombres)) {
            return [
                'valido' => false,
                'mensaje' => 'Los nombres no pueden comenzar con números'
            ];
        }

        // Solo permitir letras, espacios y algunos caracteres especiales
        if (!preg_match('/^[a-záéíóúñ\s\-\'áéíóúÁÉÍÓÚÑ]+$/i', $nombres)) {
            return [
                'valido' => false,
                'mensaje' => 'Los nombres contienen caracteres no válidos'
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar apellidos
     */
    public static function validarApellidos($apellidos) {
        return self::validarNombres($apellidos);
    }

    /**
     * Validar teléfono colombiano
     */
    public static function validarTelefono($telefono) {
        $telefono = trim($telefono);

        if (empty($telefono)) {
            return [
                'valido' => false,
                'mensaje' => 'El teléfono es obligatorio'
            ];
        }

        // Remover espacios, guiones y el signo +
        $telefono_limpio = preg_replace('/[\s\-\+]/', '', $telefono);

        // Validar que sea solo números
        if (!preg_match('/^[0-9]+$/', $telefono_limpio)) {
            return [
                'valido' => false,
                'mensaje' => 'El teléfono debe contener solo números'
            ];
        }

        // Validar longitud (números de Colombia)
        if (strlen($telefono_limpio) < 7 || strlen($telefono_limpio) > 15) {
            return [
                'valido' => false,
                'mensaje' => 'El teléfono debe tener entre 7 y 15 dígitos'
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar número de documento
     */
    public static function validarDocumento($numero_documento, $tipo_documento = null) {
        $numero_documento = trim($numero_documento);

        if (empty($numero_documento)) {
            return [
                'valido' => false,
                'mensaje' => 'El número de documento es obligatorio'
            ];
        }

        // Validar que sea solo números
        if (!preg_match('/^[0-9]+$/', $numero_documento)) {
            return [
                'valido' => false,
                'mensaje' => 'El número de documento debe contener solo números'
            ];
        }

        // Validar longitud según tipo de documento
        if ($tipo_documento) {
            $longitudes = [
                '1' => [7, 10], // Cédula de Ciudadanía
                '2' => [5, 10], // Cédula de Extranjería
                '3' => [7, 8]   // Tarjeta de Identidad
            ];

            if (isset($longitudes[$tipo_documento])) {
                list($min, $max) = $longitudes[$tipo_documento];
                if (strlen($numero_documento) < $min || strlen($numero_documento) > $max) {
                    return [
                        'valido' => false,
                        'mensaje' => "El documento debe tener entre {$min} y {$max} dígitos"
                    ];
                }
            }
        }

        return ['valido' => true];
    }

    /**
     * Validar fecha de nacimiento
     */
    public static function validarFechaNacimiento($fecha) {
        if (empty($fecha)) {
            return [
                'valido' => false,
                'mensaje' => 'La fecha de nacimiento es obligatoria'
            ];
        }

        // Validar formato de fecha
        $fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha);
        if (!$fecha_obj || $fecha_obj->format('Y-m-d') !== $fecha) {
            return [
                'valido' => false,
                'mensaje' => 'El formato de la fecha debe ser YYYY-MM-DD'
            ];
        }

        // Calcular edad
        $hoy = new DateTime();
        $edad = $hoy->diff($fecha_obj)->y;

        // Validar que sea mayor a 18 años (ajustar según requerimientos)
        if ($edad < 18) {
            return [
                'valido' => false,
                'mensaje' => 'Debes ser mayor de 18 años'
            ];
        }

        // Validar que no sea una fecha futura
        if ($fecha_obj > $hoy) {
            return [
                'valido' => false,
                'mensaje' => 'La fecha de nacimiento no puede ser futura'
            ];
        }

        // Validar que no sea demasiado antigua (máximo 120 años)
        if ($edad > 120) {
            return [
                'valido' => false,
                'mensaje' => 'La fecha de nacimiento parece inválida'
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar dirección
     */
    public static function validarDireccion($direccion) {
        $direccion = trim($direccion);

        if (empty($direccion)) {
            return [
                'valido' => false,
                'mensaje' => 'La dirección es obligatoria'
            ];
        }

        if (strlen($direccion) < 5) {
            return [
                'valido' => false,
                'mensaje' => 'La dirección debe tener al menos 5 caracteres'
            ];
        }

        if (strlen($direccion) > 255) {
            return [
                'valido' => false,
                'mensaje' => 'La dirección es demasiado larga (máximo 255 caracteres)'
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar ciudad
     */
    public static function validarCiudad($ciudad) {
        $ciudad = trim($ciudad);

        if (empty($ciudad)) {
            return [
                'valido' => false,
                'mensaje' => 'La ciudad es obligatoria'
            ];
        }

        if (strlen($ciudad) < 2) {
            return [
                'valido' => false,
                'mensaje' => 'La ciudad debe tener al menos 2 caracteres'
            ];
        }

        if (strlen($ciudad) > 100) {
            return [
                'valido' => false,
                'mensaje' => 'La ciudad es demasiado larga'
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar campo de selección (no vacío)
     */
    public static function validarSelect($valor, $nombre_campo = 'campo') {
        if (empty($valor) || $valor === '0') {
            return [
                'valido' => false,
                'mensaje' => "Por favor selecciona un {$nombre_campo}"
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar texto de área
     */
    public static function validarTextArea($texto, $minimo = 10, $maximo = 1000) {
        $texto = trim($texto);

        if (empty($texto)) {
            return [
                'valido' => false,
                'mensaje' => 'Este campo es obligatorio'
            ];
        }

        if (strlen($texto) < $minimo) {
            return [
                'valido' => false,
                'mensaje' => "El texto debe tener al menos {$minimo} caracteres"
            ];
        }

        if (strlen($texto) > $maximo) {
            return [
                'valido' => false,
                'mensaje' => "El texto no debe exceder {$maximo} caracteres"
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar número entero
     */
    public static function validarNumero($numero, $minimo = null, $maximo = null) {
        $numero = trim($numero);

        if (empty($numero)) {
            return [
                'valido' => false,
                'mensaje' => 'Este campo es obligatorio'
            ];
        }

        if (!is_numeric($numero) || intval($numero) != $numero) {
            return [
                'valido' => false,
                'mensaje' => 'Debe ser un número entero'
            ];
        }

        $numero = intval($numero);

        if ($minimo !== null && $numero < $minimo) {
            return [
                'valido' => false,
                'mensaje' => "El número no puede ser menor a {$minimo}"
            ];
        }

        if ($maximo !== null && $numero > $maximo) {
            return [
                'valido' => false,
                'mensaje' => "El número no puede ser mayor a {$maximo}"
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar decimal
     */
    public static function validarDecimal($numero, $minimo = null, $maximo = null, $decimales = 2) {
        $numero = trim($numero);

        if (empty($numero)) {
            return [
                'valido' => false,
                'mensaje' => 'Este campo es obligatorio'
            ];
        }

        if (!is_numeric($numero)) {
            return [
                'valido' => false,
                'mensaje' => 'Debe ser un número válido'
            ];
        }

        $numero = floatval($numero);

        if ($minimo !== null && $numero < $minimo) {
            return [
                'valido' => false,
                'mensaje' => "El número no puede ser menor a {$minimo}"
            ];
        }

        if ($maximo !== null && $numero > $maximo) {
            return [
                'valido' => false,
                'mensaje' => "El número no puede ser mayor a {$maximo}"
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar hora (formato HH:MM)
     */
    public static function validarHora($hora) {
        if (empty($hora)) {
            return [
                'valido' => false,
                'mensaje' => 'La hora es obligatoria'
            ];
        }

        if (!preg_match('/^([0-1][0-9]|2[0-3]):([0-5][0-9])$/', $hora)) {
            return [
                'valido' => false,
                'mensaje' => 'El formato de la hora debe ser HH:MM'
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar fecha (formato YYYY-MM-DD)
     */
    public static function validarFecha($fecha) {
        if (empty($fecha)) {
            return [
                'valido' => false,
                'mensaje' => 'La fecha es obligatoria'
            ];
        }

        $fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha);
        if (!$fecha_obj || $fecha_obj->format('Y-m-d') !== $fecha) {
            return [
                'valido' => false,
                'mensaje' => 'El formato de la fecha debe ser YYYY-MM-DD'
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar que la fecha sea futura
     */
    public static function validarFechaFutura($fecha) {
        $validacion = self::validarFecha($fecha);
        if (!$validacion['valido']) {
            return $validacion;
        }

        $fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha);
        $hoy = new DateTime();

        if ($fecha_obj <= $hoy) {
            return [
                'valido' => false,
                'mensaje' => 'La fecha debe ser futura'
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar hora futura
     */
    public static function validarHoraFutura($fecha, $hora) {
        $validacion_fecha = self::validarFecha($fecha);
        $validacion_hora = self::validarHora($hora);

        if (!$validacion_fecha['valido']) {
            return $validacion_fecha;
        }

        if (!$validacion_hora['valido']) {
            return $validacion_hora;
        }

        $fecha_hora = DateTime::createFromFormat('Y-m-d H:i', $fecha . ' ' . $hora);
        $ahora = new DateTime();

        if ($fecha_hora <= $ahora) {
            return [
                'valido' => false,
                'mensaje' => 'La fecha y hora deben ser futuras'
            ];
        }

        return ['valido' => true];
    }

    /**
     * Validar archivo de imagen
     */
    public static function validarImagenUpload($archivo, $tam_maximo_mb = 5) {
        if (!isset($archivo) || $archivo['error'] !== UPLOAD_ERR_OK) {
            return [
                'valido' => false,
                'mensaje' => 'Error al subir el archivo'
            ];
        }

        $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($archivo['type'], $tipos_permitidos)) {
            return [
                'valido' => false,
                'mensaje' => 'Solo se permiten imágenes (JPG, PNG, GIF, WEBP)'
            ];
        }

        $tam_maximo = $tam_maximo_mb * 1024 * 1024;
        if ($archivo['size'] > $tam_maximo) {
            return [
                'valido' => false,
                'mensaje' => "El archivo no debe exceder {$tam_maximo_mb}MB"
            ];
        }

        // Validar extensión del archivo
        $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($ext), $extensiones_permitidas)) {
            return [
                'valido' => false,
                'mensaje' => 'Extensión de archivo no permitida'
            ];
        }

        return ['valido' => true];
    }

    /**
     * Sanitizar string
     */
    public static function sanitizarString($texto) {
        return htmlspecialchars(trim($texto), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitizar email
     */
    public static function sanitizarEmail($email) {
        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitizar número
     */
    public static function sanitizarNumero($numero) {
        return filter_var($numero, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Validar especialidad
     */
    public static function validarEspecialidad($especialidad) {
        return self::validarSelect($especialidad, 'especialidad');
    }

    /**
     * Validar EPS
     */
    public static function validarEPS($eps) {
        return self::validarSelect($eps, 'EPS');
    }

    /**
     * Validar RH
     */
    public static function validarRH($rh) {
        $rh_validos = ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];
        if (!in_array($rh, $rh_validos)) {
            return [
                'valido' => false,
                'mensaje' => 'RH no válido'
            ];
        }
        return ['valido' => true];
    }

    /**
     * Validar género
     */
    public static function validarGenero($genero) {
        $generos_validos = ['Masculino', 'Femenino', 'Otro'];
        if (!in_array($genero, $generos_validos)) {
            return [
                'valido' => false,
                'mensaje' => 'Género no válido'
            ];
        }
        return ['valido' => true];
    }

    /**
     * Validar URL
     */
    public static function validarURL($url) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'valido' => false,
                'mensaje' => 'La URL no es válida'
            ];
        }
        return ['valido' => true];
    }

    /**
     * Validar un array de campos obligatorios
     */
    public static function validarCamposObligatorios($datos, $campos_requeridos) {
        foreach ($campos_requeridos as $campo) {
            if (!isset($datos[$campo]) || empty($datos[$campo])) {
                return [
                    'valido' => false,
                    'mensaje' => "El campo '{$campo}' es obligatorio"
                ];
            }
        }
        return ['valido' => true];
    }
}

?>
