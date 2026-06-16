/**
 * SISTEMA DE VALIDACIONES FRONTEND
 * Validaciones en tiempo real para formularios
 */

class ValidadorFormulario {
    constructor() {
        this.errores = {};
        this.validadores = {
            email: this.validarEmail.bind(this),
            telefono: this.validarTelefono.bind(this),
            documento: this.validarDocumento.bind(this),
            nombres: this.validarNombres.bind(this),
            password: this.validarPassword.bind(this),
            fecha: this.validarFecha.bind(this),
            textarea: this.validarTextArea.bind(this),
            numero: this.validarNumero.bind(this),
            select: this.validarSelect.bind(this),
            direccion: this.validarDireccion.bind(this),
            hora: this.validarHora.bind(this)
        };
    }

    /**
     * Validar email
     */
    validarEmail(valor) {
        if (!valor) {
            return 'El email es requerido';
        }
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regex.test(valor)) {
            return 'Email inválido';
        }
        if (valor.length > 255) {
            return 'El email es muy largo';
        }
        return null;
    }

    /**
     * Validar teléfono
     */
    validarTelefono(valor) {
        if (!valor) {
            return 'El teléfono es requerido';
        }
        const telefono_limpio = valor.replace(/[\s\-\+]/g, '');
        if (!/^[0-9]+$/.test(telefono_limpio)) {
            return 'El teléfono debe contener solo números';
        }
        if (telefono_limpio.length < 7 || telefono_limpio.length > 15) {
            return 'El teléfono debe tener entre 7 y 15 dígitos';
        }
        return null;
    }

    /**
     * Validar número de documento
     */
    validarDocumento(valor) {
        if (!valor) {
            return 'El documento es requerido';
        }
        if (!/^[0-9]+$/.test(valor)) {
            return 'El documento debe contener solo números';
        }
        if (valor.length < 5 || valor.length > 10) {
            return 'El documento debe tener entre 5 y 10 dígitos';
        }
        return null;
    }

    /**
     * Validar nombres y apellidos
     */
    validarNombres(valor) {
        if (!valor) {
            return 'Este campo es requerido';
        }
        if (valor.trim().length < 2) {
            return 'Debe tener al menos 2 caracteres';
        }
        if (valor.length > 100) {
            return 'No puede exceder 100 caracteres';
        }
        if (/^[0-9]/.test(valor)) {
            return 'No puede comenzar con números';
        }
        // Permitir letras, espacios, guiones y apóstrofos
        if (!/^[a-záéíóúñ\s\-'áéíóúÁÉÍÓÚÑ]+$/i.test(valor)) {
            return 'Solo se permiten letras, espacios y caracteres especiales';
        }
        return null;
    }

    /**
     * Validar contraseña
     */
    validarPassword(valor, tipo = 'fuerte') {
        if (!valor) {
            return 'La contraseña es requerida';
        }

        if (tipo === 'fuerte') {
            if (valor.length < 8) {
                return 'La contraseña debe tener al menos 8 caracteres';
            }
            if (!/[A-Z]/.test(valor)) {
                return 'Debe contener al menos una letra mayúscula';
            }
            if (!/[a-z]/.test(valor)) {
                return 'Debe contener al menos una letra minúscula';
            }
            if (!/[0-9]/.test(valor)) {
                return 'Debe contener al menos un número';
            }
            if (!/[!@#$%^&*(),.?":{}|<>]/.test(valor)) {
                return 'Debe contener al menos un carácter especial';
            }
        } else {
            if (valor.length < 8) {
                return 'La contraseña debe tener al menos 8 caracteres';
            }
        }

        return null;
    }

    /**
     * Validar fecha (YYYY-MM-DD)
     */
    validarFecha(valor) {
        if (!valor) {
            return 'La fecha es requerida';
        }
        const regex = /^\d{4}-\d{2}-\d{2}$/;
        if (!regex.test(valor)) {
            return 'Formato de fecha inválido (YYYY-MM-DD)';
        }
        const fecha = new Date(valor);
        if (isNaN(fecha.getTime())) {
            return 'Fecha inválida';
        }
        return null;
    }

    /**
     * Validar fecha de nacimiento
     */
    validarFechaNacimiento(valor) {
        const validacion = this.validarFecha(valor);
        if (validacion) return validacion;

        const fecha = new Date(valor);
        const hoy = new Date();
        const edad = hoy.getFullYear() - fecha.getFullYear();
        const mes = hoy.getMonth() - fecha.getMonth();

        if (mes < 0 || (mes === 0 && hoy.getDate() < fecha.getDate())) {
            edad--;
        }

        if (edad < 18) {
            return 'Debes ser mayor de 18 años';
        }

        if (edad > 120) {
            return 'La fecha de nacimiento parece inválida';
        }

        return null;
    }

    /**
     * Validar textarea
     */
    validarTextArea(valor, minimo = 10, maximo = 1000) {
        if (!valor || !valor.trim()) {
            return 'Este campo es requerido';
        }
        if (valor.trim().length < minimo) {
            return `Debe tener al menos ${minimo} caracteres`;
        }
        if (valor.length > maximo) {
            return `No puede exceder ${maximo} caracteres`;
        }
        return null;
    }

    /**
     * Validar número
     */
    validarNumero(valor, minimo = null, maximo = null) {
        if (!valor) {
            return 'Este campo es requerido';
        }
        if (isNaN(valor) || !Number.isInteger(Number(valor))) {
            return 'Debe ser un número entero';
        }
        const num = parseInt(valor);
        if (minimo !== null && num < minimo) {
            return `No puede ser menor a ${minimo}`;
        }
        if (maximo !== null && num > maximo) {
            return `No puede ser mayor a ${maximo}`;
        }
        return null;
    }

    /**
     * Validar select
     */
    validarSelect(valor, nombre = 'campo') {
        if (!valor || valor === '0' || valor === '') {
            return `Por favor selecciona un ${nombre}`;
        }
        return null;
    }

    /**
     * Validar dirección
     */
    validarDireccion(valor) {
        if (!valor || !valor.trim()) {
            return 'La dirección es requerida';
        }
        if (valor.trim().length < 5) {
            return 'La dirección debe tener al menos 5 caracteres';
        }
        if (valor.length > 255) {
            return 'La dirección es muy larga';
        }
        return null;
    }

    /**
     * Validar hora (HH:MM)
     */
    validarHora(valor) {
        if (!valor) {
            return 'La hora es requerida';
        }
        const regex = /^([0-1][0-9]|2[0-3]):([0-5][0-9])$/;
        if (!regex.test(valor)) {
            return 'Formato de hora inválido (HH:MM)';
        }
        return null;
    }

    /**
     * Validar un campo según su tipo
     */
    validar(id_campo, tipo, valor = null, opciones = {}) {
        const campo = document.getElementById(id_campo);
        if (!campo && !valor) return null;

        const valor_actual = valor || campo.value;
        let error = null;

        if (this.validadores[tipo]) {
            if (tipo === 'textarea' && opciones.minimo) {
                error = this.validadores[tipo](valor_actual, opciones.minimo, opciones.maximo);
            } else if (tipo === 'numero' && (opciones.minimo || opciones.maximo)) {
                error = this.validadores[tipo](valor_actual, opciones.minimo, opciones.maximo);
            } else if (tipo === 'select' && opciones.nombre) {
                error = this.validadores[tipo](valor_actual, opciones.nombre);
            } else if (tipo === 'password' && opciones.tipo) {
                error = this.validadores[tipo](valor_actual, opciones.tipo);
            } else {
                error = this.validadores[tipo](valor_actual);
            }
        }

        // Guardar estado del error
        if (error) {
            this.errores[id_campo] = error;
        } else {
            delete this.errores[id_campo];
        }

        // Actualizar visualización si el elemento existe
        if (campo) {
            this.mostrarError(campo, error);
        }

        return error;
    }

    /**
     * Mostrar error en el campo
     */
    mostrarError(campo, error) {
        // Remover clase de error anterior
        campo.classList.remove('is-invalid');
        let msg_error = campo.parentElement.querySelector('.invalid-feedback');
        if (msg_error) {
            msg_error.remove();
        }

        if (error) {
            campo.classList.add('is-invalid');
            const div_error = document.createElement('div');
            div_error.className = 'invalid-feedback d-block';
            div_error.textContent = error;
            campo.parentElement.appendChild(div_error);
            return false;
        } else {
            campo.classList.remove('is-invalid');
            campo.classList.add('is-valid');
        }
        return true;
    }

    /**
     * Validar formulario completo
     */
    validarFormulario(id_formulario, configuracion) {
        const formulario = document.getElementById(id_formulario);
        if (!formulario) return false;

        this.errores = {};
        let es_valido = true;

        for (const [id_campo, config] of Object.entries(configuracion)) {
            const error = this.validar(id_campo, config.tipo, null, config.opciones || {});
            if (error) {
                es_valido = false;
            }
        }

        return es_valido;
    }

    /**
     * Limpiar errores
     */
    limpiarErrores() {
        const campos_invalidos = document.querySelectorAll('.is-invalid');
        campos_invalidos.forEach(campo => {
            campo.classList.remove('is-invalid', 'is-valid');
            const msg_error = campo.parentElement.querySelector('.invalid-feedback');
            if (msg_error) {
                msg_error.remove();
            }
        });
        this.errores = {};
    }

    /**
     * Obtener todos los errores
     */
    obtenerErrores() {
        return this.errores;
    }

    /**
     * Verificar si hay errores
     */
    hayErrores() {
        return Object.keys(this.errores).length > 0;
    }
}

// Crear instancia global
const validador = new ValidadorFormulario();

// Configurar validaciones en tiempo real para un campo específico
function configurarValidacionCampo(id_campo, tipo, opciones = {}) {
    const campo = document.getElementById(id_campo);
    if (!campo) return;

    // Validar al perder el foco
    campo.addEventListener('blur', function () {
        validador.validar(id_campo, tipo, null, opciones);
    });

    // Limpiar error si comienza a escribir correctamente
    campo.addEventListener('input', function () {
        const error = validador.validar(id_campo, tipo, null, opciones);
        if (!error && campo.classList.contains('is-invalid')) {
            campo.classList.remove('is-invalid');
            const msg = campo.parentElement.querySelector('.invalid-feedback');
            if (msg) msg.remove();
        }
    });
}

// Configurar validaciones para múltiples campos
function configurarValidacionesFormulario(id_formulario, configuracion) {
    for (const [id_campo, config] of Object.entries(configuracion)) {
        configurarValidacionCampo(id_campo, config.tipo, config.opciones || {});
    }

    // Validar al enviar el formulario
    const formulario = document.getElementById(id_formulario);
    if (formulario) {
        formulario.addEventListener('submit', function (e) {
            if (!validador.validarFormulario(id_formulario, configuracion)) {
                e.preventDefault();
                console.error('El formulario contiene errores');
                return false;
            }
        });
    }
}

// Mostrar fortaleza de contraseña
function mostrarFortalezaPassword(id_campo_password, id_indicador) {
    const campo = document.getElementById(id_campo_password);
    const indicador = document.getElementById(id_indicador);

    if (!campo || !indicador) return;

    campo.addEventListener('input', function () {
        const password = this.value;
        let fortaleza = 0;
        let texto = '';
        let color = '';

        if (password.length >= 8) fortaleza++;
        if (/[a-z]/.test(password)) fortaleza++;
        if (/[A-Z]/.test(password)) fortaleza++;
        if (/[0-9]/.test(password)) fortaleza++;
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) fortaleza++;

        switch (fortaleza) {
            case 0:
            case 1:
                texto = 'Muy débil';
                color = 'danger';
                break;
            case 2:
                texto = 'Débil';
                color = 'warning';
                break;
            case 3:
                texto = 'Regular';
                color = 'info';
                break;
            case 4:
                texto = 'Fuerte';
                color = 'success';
                break;
            case 5:
                texto = 'Muy fuerte';
                color = 'success';
                break;
        }

        indicador.innerHTML = `<span class="badge bg-${color}">${texto}</span>`;
    });
}

// Comparar contraseñas (para confirmación)
function validarCoincidenciaPassword(id_password, id_confirmar_password) {
    const campo_confirmar = document.getElementById(id_confirmar_password);
    const campo_password = document.getElementById(id_password);

    if (!campo_confirmar || !campo_password) return;

    campo_confirmar.addEventListener('blur', function () {
        if (campo_password.value !== this.value) {
            validador.mostrarError(this, 'Las contraseñas no coinciden');
        } else {
            validador.mostrarError(this, null);
        }
    });

    campo_confirmar.addEventListener('input', function () {
        if (campo_password.value === this.value) {
            const error_msg = this.parentElement.querySelector('.invalid-feedback');
            if (error_msg) error_msg.remove();
            this.classList.remove('is-invalid');
        }
    });
}

// Sanitizar entrada de texto
function sanitizarTexto(texto) {
    const div = document.createElement('div');
    div.textContent = texto;
    return div.innerHTML;
}
