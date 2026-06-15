# SISTEMA DE VALIDACIONES - E-VITALIX

## 📋 Descripción General
Este documento detalla todas las validaciones agregadas al proyecto E-VITALIX tanto en el backend como en el frontend para mejorar la seguridad, calidad de datos y experiencia del usuario.

---

## 🔐 VALIDACIONES BACKEND

### 1. Helper de Validaciones (`app/helpers/validacion_helper.php`)

Archivo centralizado con la clase `Validaciones` que contiene métodos estáticos para validar todos los tipos de datos comunes en la aplicación.

#### Métodos Disponibles:

**Validación de Email:**
- `validarEmail($email)` - Valida formato, longitud máxima (255 caracteres)

**Validación de Contraseñas:**
- `validarContrasena($contrasena)` - Valida: mínimo 8 caracteres, mayúscula, minúscula, número, carácter especial
- `validarContrasenasimple($contrasena)` - Validación simple: mínimo 8 caracteres

**Validación de Nombres/Apellidos:**
- `validarNombres($nombres)` - Valida: 2-100 caracteres, solo letras, no números al inicio
- `validarApellidos($apellidos)` - Igual que nombres

**Validación de Contacto:**
- `validarTelefono($telefono)` - Valida: 7-15 dígitos, formato telefónico colombiano
- `validarDocumento($numero_documento, $tipo_documento)` - Valida según tipo de documento
- `validarEmail($email)` - Ya descrito arriba

**Validación de Fechas:**
- `validarFechaNacimiento($fecha)` - Valida: formato YYYY-MM-DD, mayor de 18 años, menor de 120 años
- `validarFecha($fecha)` - Validación básica de formato
- `validarFechaFutura($fecha)` - Valida que la fecha sea futura
- `validarHora($hora)` - Valida formato HH:MM
- `validarHoraFutura($fecha, $hora)` - Valida que fecha y hora sean futuras

**Validación de Ubicación:**
- `validarDireccion($direccion)` - Valida: 5-255 caracteres
- `validarCiudad($ciudad)` - Valida: 2-100 caracteres

**Validación de Campos:**
- `validarSelect($valor, $nombre_campo)` - Valida que no esté vacío
- `validarTextArea($texto, $minimo, $maximo)` - Valida longitud de texto
- `validarNumero($numero, $minimo, $maximo)` - Valida números enteros y rango
- `validarDecimal($numero, $minimo, $maximo)` - Valida números decimales

**Validación de Datos Médicos:**
- `validarEPS($eps)` - Valida que sea un EPS válido
- `validarRH($rh)` - Valida: O+, O-, A+, A-, B+, B-, AB+, AB-
- `validarGenero($genero)` - Valida: Masculino, Femenino, Otro
- `validarEspecialidad($especialidad)` - Valida especialidad no vacía

**Validación de Archivos:**
- `validarImagenUpload($archivo, $tam_maximo_mb)` - Valida tipos JPG, PNG, GIF, WEBP y tamaño

**Utilidades:**
- `sanitizarString($texto)` - Limpia caracteres especiales con htmlspecialchars
- `sanitizarEmail($email)` - Limpia el email
- `sanitizarNumero($numero)` - Extrae solo números
- `validarCamposObligatorios($datos, $campos_requeridos)` - Valida múltiples campos

---

## 🎨 VALIDACIONES FRONTEND

### 1. Script de Validaciones (`public/assets/js/validaciones.js`)

Archivo JavaScript con la clase `ValidadorFormulario` que proporciona validaciones en tiempo real.

#### Características:

**Validaciones en Tiempo Real:**
- Los campos se validan al perder el foco (blur event)
- Se limpian los errores automáticamente al corregir
- Mensajes de error dinámicos y contextuales

**Métodos de Validación:**
- `validarEmail(valor)` - Email válido
- `validarTelefono(valor)` - Teléfono 7-15 dígitos
- `validarDocumento(valor)` - Documento válido
- `validarNombres(valor)` - Nombres válidos
- `validarPassword(valor, tipo)` - Contraseña fuerte o simple
- `validarFecha(valor)` - Formato YYYY-MM-DD
- `validarFechaNacimiento(valor)` - Mayor de 18 años
- `validarTextArea(valor, minimo, maximo)` - Longitud de texto
- `validarNumero(valor, minimo, maximo)` - Números
- `validarSelect(valor, nombre)` - Select no vacío
- `validarDireccion(valor)` - Dirección válida
- `validarHora(valor)` - Formato HH:MM

**Funciones Helpers:**
- `configurarValidacionCampo(id_campo, tipo, opciones)` - Configurar validación de un campo
- `configurarValidacionesFormulario(id_formulario, configuracion)` - Configurar validación de formulario completo
- `mostrarFortalezaPassword(id_campo, id_indicador)` - Mostrar fortaleza de contraseña en tiempo real
- `validarCoincidenciaPassword(id_password, id_confirmar)` - Validar que coincidan dos contraseñas
- `sanitizarTexto(texto)` - Sanitizar texto para prevenir XSS

---

## 🔧 CONTROLADORES ACTUALIZADOS

### 1. LoginController.php

**Validaciones Agregadas:**
```php
- Sanitización de email
- Validación de campos obligatorios
- Validación de formato de email
- Validación de longitud de contraseña
```

### 2. registroController.php - registrarPaciente()

**Validaciones Agregadas:**
```php
- Sanitización de todos los campos
- Validación individual de cada campo:
  • Nombres (formato y longitud)
  • Apellidos (formato y longitud)
  • Tipo de documento (selección)
  • Número de documento (formato y rango)
  • Email (formato y validación de duplicado)
  • Teléfono (formato y rango)
- Verificación de email duplicado en BD
- Verificación de documento duplicado en BD
```

### 3. registroController.php - completarPerfilPaciente()

**Validaciones Agregadas:**
```php
- Validación de fecha de nacimiento (edad mínima 18 años)
- Validación de género
- Validación de ciudad
- Validación de dirección
- Validación de EPS
- Validación de RH
- Validación de nombre de contacto de emergencia
- Validación de teléfono de contacto
- Validación de dirección de contacto
```

---

## 📄 VISTAS ACTUALIZADAS

### 1. app/views/auth/inicioSesion.php

**Atributos HTML5 Agregados:**
```html
- type="email" con pattern
- maxlength="255"
- minlength="8"
- type="password"
- Atributo novalidate en form
- Clases Bootstrap para feedback
```

**Script de Validación:**
```javascript
- Validación de email y contraseña en tiempo real
- Mensajes de error personalizados
```

### 2. app/views/auth/registrarse.php

**Atributos HTML5 Agregados:**
```html
- pattern para nombres y teléfono
- minlength y maxlength
- inputmode="numeric" para documentos
- inputmode="tel" para teléfono
- type="email"
- type="tel"
```

**Script de Validación:**
```javascript
- Validación en tiempo real de todos los campos
- Validación de formato y longitud
- Mensajes de error contextuales
```

---

## 📊 MODELOS ACTUALIZADOS

### registroModel.php

**Métodos Agregados:**

```php
/**
 * Verificar si un email ya está registrado
 */
public function emailExiste($email)

/**
 * Verificar si un documento ya está registrado
 */
public function documentoExiste($numero_documento)
```

---

## 🚀 CÓMO USAR LAS VALIDACIONES

### En un Controlador:

```php
<?php
require_once __DIR__ . '/../helpers/validacion_helper.php';

// Validar un email
$validacion = Validaciones::validarEmail($email);
if (!$validacion['valido']) {
    mostrarSweetAlert('error', 'Error', $validacion['mensaje']);
    exit();
}

// Validar un documento
$validacion = Validaciones::validarDocumento($numero_documento, $tipo_documento);
if (!$validacion['valido']) {
    // Manejar error
}
```

### En una Vista (HTML):

```html
<input 
    type="email" 
    id="email" 
    name="email"
    required
    maxlength="255"
    pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
```

### En JavaScript:

```javascript
// Configurar validación de un campo
configurarValidacionCampo('email', 'email', {});

// Configurar validación de formulario completo
configurarValidacionesFormulario('miFormulario', {
    'campo1': { tipo: 'email', opciones: {} },
    'campo2': { tipo: 'telefono', opciones: {} },
    'campo3': { tipo: 'texto', opciones: { minimo: 10, maximo: 100 } }
});

// Mostrar fortaleza de contraseña
mostrarFortalezaPassword('password', 'fortaleza');

// Validar coincidencia de contraseñas
validarCoincidenciaPassword('password', 'confirmar_password');
```

---

## 🔒 SEGURIDAD

### Medidas Implementadas:

1. **Sanitización**: Todos los inputs se limpian antes de procesar
2. **Validación Doble**: Frontend + Backend
3. **Prevención de XSS**: Uso de htmlspecialchars
4. **Validación de Duplicados**: Email y documento verificados en BD
5. **Validación de Rango**: Números y fechas validados con rangos
6. **Contraseñas Fuertes**: Requisitos de complejidad implementados
7. **Prevención de Inyección SQL**: Uso de prepared statements (ya implementado)

---

## 📱 COMPATIBILIDAD

- ✅ Bootstrap 5.3.0
- ✅ PHP 7.4+
- ✅ Navegadores modernos
- ✅ Dispositivos móviles (con inputmode adecuado)

---

## 🎯 PRÓXIMAS MEJORAS RECOMENDADAS

1. Agregar validaciones a todos los demás controladores
2. Implementar validación de imágenes en uploads
3. Agregar CAPTCHA en formularios públicos
4. Implementar rate limiting en login
5. Agregar logs de intentos fallidos
6. Validación de fecha y hora de citas
7. Validación de horarios disponibles
8. Validar conflictos de horarios

---

## 📞 SOPORTE

Para utilizar las validaciones en nuevos formularios:

1. Incluir el helper en el controlador
2. Validar cada campo con su método correspondiente
3. Incluir el script de validaciones en la vista
4. Configurar los campos con `configurarValidacionCampo()`
5. Agregar atributos HTML5 de validación

---

**Documento Generado:** 2026-06-15
**Versión:** 1.0
