/**
 * password-toggle.js
 *
 * Este archivo se encarga de agregar automáticamente un botón de "ojito" a TODOS
 * los campos de contraseña de la aplicación (login, perfiles, registros).
 *
 * ¿Por qué un archivo separado?
 * Porque los dashboards usan dashboards.js y el login usa validaciones.js.
 * Si pusiéramos esta lógica en cualquiera de esos dos archivos, tendríamos que
 * DUPLICARLA en el otro. Un archivo nuevo = una sola fuente de verdad.
 *
 * Se incluye en: los 5 footers de los dashboards + inicioSesion.php
 */

// ═══════════════════════════════════════════════════════════════════════════════
// EVENTO PRINCIPAL: DOMContentLoaded
// ═══════════════════════════════════════════════════════════════════════════════
//
// 'DOMContentLoaded' se dispara cuando el navegador terminó de parsear todo el HTML
// y construyó el árbol del DOM (los elementos ya existen en memoria).
//
// ¿Por qué no poner el código directamente sin addEventListener?
// Si el código se ejecuta ANTES de que el HTML esté listo, document.querySelectorAll
// no encontrará ningún input (todavía no existen en el DOM) y el script no hará nada.
// Con DOMContentLoaded garantizamos que los elementos SÍ existen cuando los buscamos.
//
// Nota: esto es distinto al evento 'load', que espera TAMBIÉN a que se carguen
// imágenes, CSS externos, etc. DOMContentLoaded es más rápido porque solo espera el HTML.
//
document.addEventListener('DOMContentLoaded', function () {

    // ─── PASO 1: Encontrar todos los campos de contraseña ──────────────────────
    //
    // document.querySelectorAll(selector) recorre todo el documento y devuelve
    // una NodeList con TODOS los elementos que coincidan con el selector CSS.
    //
    // El selector 'input[type="password"]' significa:
    //   → input     = elementos <input>
    //   → [type="password"] = que tengan exactamente ese valor en el atributo type
    //
    // NodeList es parecida a un Array pero no es exactamente un Array:
    // tiene .length y se puede recorrer con forEach, pero NO tiene .map, .filter, etc.
    //
    const camposContrasena = document.querySelectorAll('input[type="password"]');

    // Si la página actual no tiene campos de contraseña, terminamos aquí.
    // Esto es importante porque este script se carga en TODAS las páginas del dashboard.
    // La mayoría no tienen campos de contraseña, así que salimos sin hacer nada.
    if (camposContrasena.length === 0) return;

    // ─── PASO 2: Procesar cada campo encontrado ─────────────────────────────────
    //
    // forEach es un método de NodeList (y de Array) que ejecuta una función
    // por cada elemento de la colección.
    //
    // Parámetros de la función callback:
    //   → campo: el elemento <input type="password"> actual de esta iteración
    //   → indice: (no lo usamos) la posición del elemento en la NodeList (0, 1, 2…)
    //
    camposContrasena.forEach(function (campo) {

        // ─── PASO 2.1: Crear el contenedor con position:relative ─────────────
        //
        // El botón del ojito se posicionará de forma ABSOLUTA (position: absolute).
        // Un elemento con position:absolute se posiciona respecto a su ANCESTRO
        // más cercano que tenga position distinto a 'static'.
        //
        // Problema: los padres actuales del input (col-md-6, mb-3, etc.) son
        // position:static por defecto → el botón se posicionaría mal.
        //
        // Solución: creamos un <div> intermedio con position:relative y metemos
        // el input dentro. Así el botón se posiciona exactamente dentro de ese div.
        //
        const contenedor = document.createElement('div');
        // position:relative convierte este div en el punto de referencia para
        // cualquier hijo con position:absolute
        contenedor.style.position = 'relative';
        contenedor.style.display  = 'block';
        contenedor.style.width    = '100%'; // hereda el ancho del padre original

        // ─── PASO 2.2: Insertar el contenedor en el lugar que ocupaba el input ─
        //
        // campo.parentNode → el padre actual del input (ej: <div class="col-md-6">)
        //
        // parentNode.insertBefore(nuevoNodo, nodoReferencia):
        //   Inserta 'nuevoNodo' ANTES de 'nodoReferencia' dentro de 'parentNode'.
        //   Resultado: el contenedor queda exactamente donde estaba el input.
        //
        campo.parentNode.insertBefore(contenedor, campo);

        // ─── PASO 2.3: Mover el input DENTRO del nuevo contenedor ─────────────
        //
        // appendChild(nodo) mueve el nodo al FINAL de los hijos del elemento.
        //
        // Importante: en el DOM, un nodo solo puede tener UN padre a la vez.
        // Al hacer contenedor.appendChild(campo), el input se MUEVE automáticamente
        // (se elimina de su posición anterior y se inserta dentro de 'contenedor').
        // No se crea una copia — es el mismo elemento, solo cambia de lugar.
        //
        contenedor.appendChild(campo);

        // ─── PASO 2.4: Dar espacio en el input para que el botón no tape el texto ─
        //
        // El botón se superpone sobre el borde derecho del input.
        // Si no hacemos nada, cuando el usuario escriba una contraseña larga,
        // el texto podría quedar oculto BAJO el botón.
        //
        // Solución: aumentar el padding-right del input para que el texto
        // se detenga antes de llegar al borde donde vive el botón.
        //
        // El valor '2.8rem' es suficiente para el ícono (~1.1rem) + espaciado.
        //
        campo.style.paddingRight = '2.8rem';

        // ─── PASO 2.5: Crear el botón del ojito ──────────────────────────────
        //
        const boton = document.createElement('button');

        // MUY IMPORTANTE: type="button"
        // Dentro de un <form>, los botones sin type explícito actúan como type="submit".
        // Eso significa que al hacer clic en el ojito, ¡se enviaría el formulario!
        // type="button" previene ese comportamiento: el botón solo ejecuta su evento click.
        boton.setAttribute('type', 'button');

        // aria-label es para accesibilidad (lectores de pantalla para personas con
        // discapacidad visual). Como el botón solo tiene un ícono (sin texto visible),
        // el lector de pantalla no sabría qué hace. aria-label le da contexto.
        boton.setAttribute('aria-label', 'Mostrar contraseña');

        // ─── Posicionamiento del botón ────────────────────────────────────────
        //
        // position:absolute → el botón se posiciona respecto al contenedor (position:relative)
        // right:0.6rem      → a 0.6rem del borde DERECHO del contenedor
        // top:50%           → el borde superior del botón queda en el centro vertical
        //                     del contenedor (pero el botón no está centrado todavía)
        // transform:translateY(-50%) → desplaza el botón hacia ARRIBA la mitad de su propia
        //                     altura. Combinado con top:50%, esto centra el botón
        //                     verticalmente sin importar su altura exacta.
        //
        // ¿Por qué no usar top:calc(50% - Xpx)?
        // Porque no sabemos la altura exacta del botón en px. translateY(-50%) es
        // dinámico: calcula la mitad de la altura real del elemento en tiempo de ejecución.
        //
        boton.style.position  = 'absolute';
        boton.style.right     = '0.6rem';
        boton.style.top       = '40%';
        boton.style.transform = 'translateY(-50%)';

        // ─── Estilos visuales del botón ───────────────────────────────────────
        boton.style.background = 'none';    // sin fondo (transparente)
        boton.style.border     = 'none';    // sin borde
        boton.style.padding    = '0';       // sin espaciado interno
        boton.style.cursor     = 'pointer'; // ícono de manita al pasar el mouse
        boton.style.color      = '#6c757d'; // gris neutro → se ve bien sobre fondos claros y oscuros
        boton.style.fontSize   = '1.1rem';  // tamaño del ícono en rem (escala con el texto base)
        boton.style.lineHeight = '1';       // sin altura extra causada por el line-height heredado
        boton.style.zIndex     = '5';       // encima del input para recibir los clics del usuario

        // ─── PASO 2.6: Crear el ícono ─────────────────────────────────────────
        //
        // Bootstrap Icons funciona así:
        //   <i class="bi bi-eye"></i>
        //
        // La librería CSS de Bootstrap Icons detecta la clase "bi-eye" y muestra
        // el ícono correspondiente usando un pseudo-elemento ::before con un carácter
        // unicode de la fuente de íconos.
        //
        // bi-eye      = ojo abierto   → estado inicial: la contraseña está oculta
        // bi-eye-slash = ojo tachado  → estado alternativo: la contraseña está visible
        //
        const icono = document.createElement('i');
        icono.classList.add('bi', 'bi-eye'); // estado inicial: ojo abierto

        // Ensamblar la estructura: ícono → botón → contenedor
        boton.appendChild(icono);
        contenedor.appendChild(boton);

        // ═══════════════════════════════════════════════════════════════════════
        // PASO 3: El evento de clic — aquí ocurre la magia
        // ═══════════════════════════════════════════════════════════════════════
        //
        // addEventListener('click', callback) registra una función que se ejecutará
        // CADA VEZ que el usuario haga clic en el botón.
        //
        // La función callback NO recibe parámetros porque no necesitamos información
        // sobre el evento en sí (posición del clic, tecla presionada, etc.).
        //
        boton.addEventListener('click', function () {

            if (campo.type === 'password') {
                // ── CASO A: La contraseña está oculta → la mostramos ─────────
                //
                // campo.type = 'text' cambia el input de tipo password a texto plano.
                // El navegador deja de mostrar bullets (•••) y muestra los caracteres reales.
                // Esta propiedad es dinámica: el DOM actualiza la vista inmediatamente.
                //
                campo.type = 'text';

                // Cambiamos el ícono de "ojo abierto" a "ojo tachado"
                // para indicar visualmente que "la contraseña está siendo mostrada"
                // y que el próximo clic la ocultará.
                //
                // classList.remove(clase) → elimina esa clase CSS del elemento
                // classList.add(clase)    → agrega esa clase CSS al elemento
                //
                icono.classList.remove('bi-eye');
                icono.classList.add('bi-eye-slash');

                // Actualizamos aria-label para describir la NUEVA acción disponible
                boton.setAttribute('aria-label', 'Ocultar contraseña');

            } else {
                // ── CASO B: La contraseña está visible → la ocultamos ─────────
                //
                // Volvemos al tipo 'password': el navegador vuelve a mostrar bullets.
                //
                campo.type = 'password';

                // Volvemos al ícono de ojo abierto
                icono.classList.remove('bi-eye-slash');
                icono.classList.add('bi-eye');

                boton.setAttribute('aria-label', 'Mostrar contraseña');
            }

            // ─── Devolver el foco al campo ─────────────────────────────────────
            //
            // Al hacer clic en el botón, el foco del teclado se desplaza AL BOTÓN.
            // Eso significa que si el usuario quiere seguir escribiendo, tendría que
            // hacer clic de nuevo en el campo. Malo para la usabilidad.
            //
            // campo.focus() devuelve el foco al input inmediatamente después del clic,
            // así el usuario puede seguir escribiendo su contraseña sin interrupciones.
            //
            campo.focus();
        });

    }); // fin del forEach — cuando llega aquí, ya procesó TODOS los campos de contraseña

}); // fin del DOMContentLoaded
