/* =========================================================
   AOS — inicialización
   CAMBIO CLAVE: esperamos a que TODO cargue (window.load),
   no solo el HTML (DOMContentLoaded). AOS calcula la posición
   de cada elemento en el momento del init; si las imágenes
   aún no cargaron, el documento no tiene su altura final y
   los triggers de scroll quedan desincronizados. Por eso el
   contenido "aparecía tarde" o se sentía vacío un instante.
   ========================================================= */

window.addEventListener('load', () => {
    AOS.init({
        once: true,
        duration: 600,        // antes 750 — animación más corta, menos sensación de "vacío"
        easing: 'ease-out-cubic',
        offset: 60,            // antes 80 — dispara un poco antes, da más margen
        disable: function () {
            // Desactiva AOS en pantallas pequeñas si prefieres rendimiento sobre efecto.
            // Déjalo en "false" para mantenerlo activo en móvil; cámbialo a una condición
            // como window.innerWidth < 768 si quieres quitarlo del todo en celular.
            return false;
        }
    });

    // Recalcula posiciones una vez que todas las imágenes y fuentes ya están listas.
    // Esto corrige cualquier desfase que haya quedado del cálculo inicial.
    setTimeout(() => AOS.refresh(), 200);
});

/* ===== NAVBAR — cambia de fondo al hacer scroll =====
   CAMBIO: usamos requestAnimationFrame para no recalcular
   estilos en cada pixel de scroll (esto causaba jank/tirones
   que se sentían como interferencia con las animaciones). */
const navbar = document.querySelector('header nav');
let navbarTicking = false;

window.addEventListener('scroll', () => {
    if (!navbarTicking) {
        requestAnimationFrame(() => {
            if (window.scrollY > 50) {
                navbar.style.backdropFilter = 'blur(10px)';
                navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.3)';
                navbar.style.transition = 'all 0.3s ease';
            } else {
                navbar.style.backdropFilter = 'none';
                navbar.style.boxShadow = 'none';
            }
            navbarTicking = false;
        });
        navbarTicking = true;
    }
});

/* ===== CONTADOR ANIMADO — el 100% en #convencer ===== */
const contadorEl = document.querySelector('.titulo-convencer');

if (contadorEl) {
    const contadorObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                let inicio = 0;
                const fin = 100;
                const duracion = 1800;
                const paso = Math.ceil(duracion / fin);

                const intervalo = setInterval(() => {
                    inicio++;
                    contadorEl.textContent = inicio + '%';
                    if (inicio >= fin) clearInterval(intervalo);
                }, paso);

                contadorObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    contadorObserver.observe(contadorEl);
}

/* ===== SMOOTH SCROLL — enlaces del nav ===== */
document.querySelectorAll('a[href^="#"]').forEach(enlace => {
    enlace.addEventListener('click', (e) => {
        const href = enlace.getAttribute('href');
        if (href === '#') return;

        const destino = document.querySelector(href);
        if (destino) {
            e.preventDefault();
            destino.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

/* ===== CURSOR PERSONALIZADO =====
   CAMBIO: solo se activa en dispositivos con mouse real
   (pointer: fine). En táctil no tiene sentido y solo consume
   recursos / puede interferir con el scroll en móvil. */
const tieneMouse = window.matchMedia('(pointer: fine)').matches;

if (tieneMouse) {
    const cursor = document.createElement('div');
    const cursorPunto = document.createElement('div');

    cursor.style.cssText = `
        width: 36px;
        height: 36px;
        border: 2px solid #007bff;
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 9999;
        transition: transform 0.15s ease, opacity 0.3s ease;
        transform: translate(-50%, -50%);
    `;

    cursorPunto.style.cssText = `
        width: 6px;
        height: 6px;
        background: #007bff;
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 9999;
        transform: translate(-50%, -50%);
        transition: transform 0.05s ease;
    `;

    document.body.appendChild(cursor);
    document.body.appendChild(cursorPunto);

    window.addEventListener('mousemove', (e) => {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
        cursorPunto.style.left = e.clientX + 'px';
        cursorPunto.style.top = e.clientY + 'px';
    });

    document.querySelectorAll('a, button, .plan, .cont-fun-1, .cont-fun-2, .cont-fun-3').forEach(el => {
        el.addEventListener('mouseenter', () => {
            cursor.style.transform = 'translate(-50%, -50%) scale(1.6)';
            cursor.style.background = 'rgba(0, 123, 255, 0.1)';
        });
        el.addEventListener('mouseleave', () => {
            cursor.style.transform = 'translate(-50%, -50%) scale(1)';
            cursor.style.background = 'transparent';
        });
    });
}

/* ===== PARALLAX SUAVE EN EL HERO =====
   CAMBIO: requestAnimationFrame en vez de ejecutar en cada
   evento de scroll. Mismo efecto visual, sin el jank. */
const heroInfo = document.querySelector('#hero .cont-info');
const heroFoto = document.querySelector('#hero .cont-foto');
let parallaxTicking = false;

window.addEventListener('scroll', () => {
    if (!parallaxTicking) {
        requestAnimationFrame(() => {
            const scrollY = window.scrollY;
            if (heroInfo) heroInfo.style.transform = `translateY(${scrollY * 0.08}px)`;
            if (heroFoto) heroFoto.style.transform = `translateY(${scrollY * 0.12}px)`;
            parallaxTicking = false;
        });
        parallaxTicking = true;
    }
});

/* ===== HOVER 3D EN TARJETAS DE PRECIOS ===== */
document.querySelectorAll('.cont-plan .plan').forEach(plan => {
    plan.addEventListener('mousemove', (e) => {
        const rect = plan.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centroX = rect.width / 2;
        const centroY = rect.height / 2;
        const rotarX = ((y - centroY) / centroY) * -6;
        const rotarY = ((x - centroX) / centroX) * 6;

        plan.style.transform = `perspective(800px) rotateX(${rotarX}deg) rotateY(${rotarY}deg) translateY(-8px)`;
        plan.style.transition = 'transform 0.1s ease';
    });

    plan.addEventListener('mouseleave', () => {
        plan.style.transform = 'perspective(800px) rotateX(0) rotateY(0) translateY(0)';
        plan.style.transition = 'transform 0.4s ease';
    });
});

/* ===== RIPPLE EN BOTONES ===== */
document.querySelectorAll('.boton1, .boton2').forEach(boton => {
    boton.style.position = 'relative';
    boton.style.overflow = 'hidden';

    boton.addEventListener('click', (e) => {
        const ripple = document.createElement('span');
        const rect = boton.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;

        ripple.style.cssText = `
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out forwards;
            pointer-events: none;
        `;

        boton.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);
    });
});

/* ===== KEYFRAME DEL RIPPLE (se inyecta en el <head>) ===== */
const estiloRipple = document.createElement('style');
estiloRipple.textContent = `
    @keyframes rippleAnim {
        to {
            transform: scale(2.5);
            opacity: 0;
        }
    }
`;
document.head.appendChild(estiloRipple);