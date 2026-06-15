# GUÍA DE USO - SISTEMA DE VALIDACIONES E-VITALIX

## 📚 Tabla de Contenidos

1. [Importar Validaciones](#importar-validaciones)
2. [Validaciones Backend](#validaciones-backend)
3. [Validaciones Frontend](#validaciones-frontend)
4. [Ejemplos Prácticos](#ejemplos-prácticos)
5. [Mejores Prácticas](#mejores-prácticas)

---

## Importar Validaciones

### Backend

En tu controlador PHP, importa el helper de validaciones:

```php
<?php
require_once __DIR__ . '/../helpers/validacion_helper.php';

// Ahora puedes usar la clase Validaciones
$validacion = Validaciones::validarEmail($email);
```

### Frontend

En tu vista HTML, incluye los archivos CSS y JavaScript:

```html
<!-- CSS -->
<link rel="stylesheet" href="public/assets/css/validaciones.css">

<!-- JavaScript -->
<script src="public/assets/js/validaciones.js"></script>
```

---

## Validaciones Backend

### Uso Básico

```php
// Validar un email
$resultado = Validaciones::validarEmail($email);

if (!$resultado['valido']) {
    mostrarSweetAlert('error', 'Error', $resultado['mensaje']);
    exit();
}

// Validar múltiples campos
$validacion = Validaciones::validarCamposObligatorios(
    ['campo1' => $valor1, 'campo2' => $valor2],
    ['campo1', 'campo2']
);

if (!$validacion['valido']) {
    // Manejar error
}
```

### Patrones Comunes

#### Validar Formulario de Registro

```php
// Sanitizar entrada
$email = Validaciones::sanitizarEmail($_POST['email']);
$nombres = Validaciones::sanitizarString($_POST['nombres']);

// Validar email
$val_email = Validaciones::validarEmail($email);
if (!$val_email['valido']) {
    mostrarSweetAlert('error', 'Error de email', $val_email['mensaje']);
    exit();
}

// Validar nombres
$val_nombres = Validaciones::validarNombres($nombres);
if (!$val_nombres['valido']) {
    mostrarSweetAlert('error', 'Error de nombres', $val_nombres['mensaje']);
    exit();
}

// Verificar duplicados
if ($modelo->emailExiste($email)) {
    mostrarSweetAlert('error', 'Duplicado', 'Este email ya existe');
    exit();
}
```

#### Validar Fecha de Cita

```php
$fecha = $_POST['fecha_cita'];
$hora = $_POST['hora_cita'];

// Validar que sean futuras
$validacion = Validaciones::validarHoraFutura($fecha, $hora);
if (!$validacion['valido']) {
    mostrarSweetAlert('error', 'Error de fecha', $validacion['mensaje']);
    exit();
}
```

#### Validar Archivo de Imagen

```php
// Validar imagen (máximo 2MB)
$validacion = Validaciones::validarImagenUpload($_FILES['foto'], 2);
if (!$validacion['valido']) {
    mostrarSweetAlert('error', 'Error en imagen', $validacion['mensaje']);
    exit();
}

// Si es válida, procesar la carga
// ...
```

---

## Validaciones Frontend

### Validación en Tiempo Real de un Campo

```javascript
// Cuando el usuario sale del campo (blur)
// Se valida automáticamente si has configurado:
configurarValidacionCampo('id_email', 'email', {});

// El campo debe tener un id="id_email"
// <input type="email" id="id_email" name="email" required>
```

### Validación Completa del Formulario

```javascript
// Al cargar la página, configura validaciones
configurarValidacionesFormulario('miFormulario', {
    'email': {
        tipo: 'email',
        opciones: {}
    },
    'telefono': {
        tipo: 'telefono',
        opciones: {}
    },
    'nombres': {
        tipo: 'nombres',
        opciones: {}
    }
});

// Al enviar, se validan todos los campos automáticamente
// Si hay errores, el formulario no se envía
```

### Mostrar Fortaleza de Contraseña

```javascript
// En HTML:
// <input type="password" id="password" name="password">
// <div id="fortaleza"></div>

// En JavaScript:
mostrarFortalezaPassword('password', 'fortaleza');
```

### Validar Coincidencia de Contraseñas

```javascript
// En HTML:
// <input type="password" id="password" name="password">
// <input type="password" id="password_confirm" name="password_confirm">

// En JavaScript:
validarCoincidenciaPassword('password', 'password_confirm');
```

---

## Ejemplos Prácticos

### Ejemplo 1: Formulario de Login

**HTML (vista):**
```html
<form id="loginForm" action="login" method="POST" novalidate>
    <div class="mb-3">
        <input 
            type="email" 
            id="email" 
            name="email" 
            class="form-control" 
            required
            placeholder="Email">
    </div>
    
    <div class="mb-3">
        <input 
            type="password" 
            id="password" 
            name="password" 
            class="form-control" 
            required
            minlength="8"
            placeholder="Contraseña">
    </div>
    
    <button type="submit" class="btn btn-primary">Ingresar</button>
</form>

<script>
    configurarValidacionesFormulario('loginForm', {
        'email': { tipo: 'email', opciones: {} },
        'password': { tipo: 'password', opciones: { tipo: 'simple' } }
    });
</script>
```

**PHP (controlador):**
```php
<?php
require_once __DIR__ . '/../helpers/validacion_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = Validaciones::sanitizarEmail($_POST['email']);
    $password = $_POST['password'];
    
    // Validar email
    $val_email = Validaciones::validarEmail($email);
    if (!$val_email['valido']) {
        mostrarSweetAlert('error', 'Error', $val_email['mensaje']);
        exit();
    }
    
    // Procesar login
    // ...
}
```

### Ejemplo 2: Formulario de Registro con Validaciones Complejas

**HTML (vista):**
```html
<form id="registroForm" action="registrar" method="POST" novalidate>
    <div class="mb-3">
        <label class="form-label">Nombre:</label>
        <input 
            type="text" 
            id="nombres" 
            name="nombres" 
            class="form-control" 
            required
            minlength="2"
            maxlength="100"
            pattern="[a-záéíóúñ\s\-'áéíóúÁÉÍÓÚÑ]+"
            placeholder="Tu nombre">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Email:</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            class="form-control" 
            required
            placeholder="tu@email.com">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Teléfono:</label>
        <input 
            type="tel" 
            id="telefono" 
            name="telefono" 
            class="form-control" 
            required
            minlength="7"
            maxlength="15"
            pattern="[0-9\s\-\+]+"
            placeholder="+57 300 123 4567">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Contraseña:</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            class="form-control" 
            required
            minlength="8">
        <div id="fortaleza" class="mt-2"></div>
    </div>
    
    <button type="submit" class="btn btn-primary">Registrar</button>
</form>

<script>
    configurarValidacionesFormulario('registroForm', {
        'nombres': { tipo: 'nombres', opciones: {} },
        'email': { tipo: 'email', opciones: {} },
        'telefono': { tipo: 'telefono', opciones: {} },
        'password': { tipo: 'password', opciones: { tipo: 'fuerte' } }
    });
    
    mostrarFortalezaPassword('password', 'fortaleza');
</script>
```

**PHP (controlador):**
```php
<?php
require_once __DIR__ . '/../helpers/validacion_helper.php';
require_once __DIR__ . '/../models/usuarioModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar
    $nombres = Validaciones::sanitizarString($_POST['nombres']);
    $email = Validaciones::sanitizarEmail($_POST['email']);
    $telefono = Validaciones::sanitizarString($_POST['telefono']);
    $password = $_POST['password'];
    
    // Validar nombres
    $val = Validaciones::validarNombres($nombres);
    if (!$val['valido']) exit();
    
    // Validar email
    $val = Validaciones::validarEmail($email);
    if (!$val['valido']) exit();
    
    // Validar teléfono
    $val = Validaciones::validarTelefono($telefono);
    if (!$val['valido']) exit();
    
    // Validar contraseña
    $val = Validaciones::validarContrasena($password);
    if (!$val['valido']) exit();
    
    // Verificar duplicados
    $modelo = new Usuario();
    if ($modelo->emailExiste($email)) {
        mostrarSweetAlert('error', 'Error', 'Email ya existe');
        exit();
    }
    
    // Guardar en base de datos
    // ...
}
```

### Ejemplo 3: Validación de Cita Médica

**HTML (vista):**
```html
<form id="citaForm" method="POST" novalidate>
    <div class="mb-3">
        <label class="form-label">Fecha:</label>
        <input 
            type="date" 
            id="fecha" 
            name="fecha" 
            class="form-control" 
            required
            min="">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Hora:</label>
        <input 
            type="time" 
            id="hora" 
            name="hora" 
            class="form-control" 
            required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Motivo de la cita:</label>
        <textarea 
            id="motivo" 
            name="motivo" 
            class="form-control" 
            required
            minlength="10"
            maxlength="500"
            rows="4"
            placeholder="Describe el motivo de tu cita"></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Agendar Cita</button>
</form>

<script>
    // Establecer fecha mínima como hoy
    document.getElementById('fecha').min = new Date().toISOString().split('T')[0];
    
    configurarValidacionesFormulario('citaForm', {
        'fecha': { tipo: 'fecha', opciones: {} },
        'hora': { tipo: 'hora', opciones: {} },
        'motivo': { tipo: 'textarea', opciones: { minimo: 10, maximo: 500 } }
    });
</script>
```

---

## Mejores Prácticas

### 1. Validar Siempre en Backend
```php
// ❌ NO hacer esto solo en frontend
// ✅ Hacer esto siempre, incluso si validas en frontend

require_once __DIR__ . '/../helpers/validacion_helper.php';

$email = Validaciones::sanitizarEmail($_POST['email']);
$val = Validaciones::validarEmail($email);
if (!$val['valido']) {
    // Rechazar
}
```

### 2. Sanitizar Antes de Validar
```php
// ❌ INCORRECTO
$email = $_POST['email'];
$val = Validaciones::validarEmail($email);

// ✅ CORRECTO
$email = Validaciones::sanitizarEmail($_POST['email']);
$val = Validaciones::validarEmail($email);
```

### 3. Usar Mensajes Claros
```php
// ❌ MALO
if (!$val['valido']) {
    echo "Error";
}

// ✅ BUENO
if (!$val['valido']) {
    mostrarSweetAlert('error', 'Error de validación', $val['mensaje']);
}
```

### 4. Validar Rangos Apropiados
```php
// Siempre validar con rangos si aplica

// Email
Validaciones::validarEmail($email); // Validación de formato

// Números
Validaciones::validarNumero($edad, 0, 120); // Con rangos

// Texto
Validaciones::validarTextArea($comentario, 10, 500); // Con min/max
```

### 5. Ofrecer Retroalimentación
```javascript
// Mostrar fortaleza de contraseña
mostrarFortalezaPassword('password', 'fortaleza');

// Validar coincidencia
validarCoincidenciaPassword('password', 'password_confirm');

// Mensajes de ayuda
// <small class="form-text text-muted">Mínimo 8 caracteres</small>
```

### 6. Verificar Duplicados en BD
```php
// Siempre verificar uniqueness en la BD

$modelo = new Usuario();

if ($modelo->emailExiste($email)) {
    mostrarSweetAlert('error', 'Duplicado', 'Este email ya existe');
    exit();
}
```

### 7. Usar atributos HTML5
```html
<!-- ❌ INCORRECTO -->
<input type="text" name="email">

<!-- ✅ CORRECTO -->
<input 
    type="email" 
    name="email" 
    required
    maxlength="255"
    pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$">
```

---

## 📞 Referencia Rápida

### Métodos Disponibles

| Método | Uso |
|--------|-----|
| `validarEmail()` | Validar formato de email |
| `validarContrasena()` | Validar contraseña fuerte |
| `validarNombres()` | Validar nombres |
| `validarTelefono()` | Validar teléfono |
| `validarDocumento()` | Validar número de documento |
| `validarFechaNacimiento()` | Validar fecha nacimiento |
| `validarDireccion()` | Validar dirección |
| `validarCiudad()` | Validar ciudad |
| `sanitizarString()` | Limpiar texto |
| `sanitizarEmail()` | Limpiar email |
| `validarCamposObligatorios()` | Validar múltiples campos |

---

**Última Actualización:** 2026-06-15
