AOS.init({
    once: true, // La animación ocurre solo la primera vez
    duration: 750, // Duración por defecto
    easing: 'ease-out-cubic',
    offset: 80 // Cuántos px antes del elemento empieza
});

/* ===== NAVBAR — cambia de fondo al hacer scroll ===== */
const navbar = document.querySelector('header nav');

window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        navbar.style.backdropFilter = 'blur(10px)';
        navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.3)';
        navbar.style.transition = 'all 0.3s ease';
    } else {
        navbar.style.backdropFilter = 'none';
        navbar.style.boxShadow = 'none';
    }
});

/* ===== FIX OFFCANVAS — elimina el padding-right que Bootstrap inyecta ===== */
const menuMobile = document.getElementById('menuMobile');

if (menuMobile) {
    menuMobile.addEventListener('show.bs.offcanvas', () => {
        document.body.style.paddingRight = '0px';
        document.body.style.overflow = 'hidden';
    });

    menuMobile.addEventListener('hidden.bs.offcanvas', () => {
        document.body.style.paddingRight = '';
        document.body.style.overflow = '';
    });
}

/* ===== CONTADOR ANIMADO — el 100% en #convencer ===== */
// Selecciona el elemento HTML que contiene el porcentaje (ej: <h2 class="titulo-convencer">0%</h2>)
const contadorEl = document.querySelector('.titulo-convencer');

// Verificamos que el elemento exista en la página
if (contadorEl) {
    // Crea un Intersection Observer: API que detecta cuando un elemento entra en el viewport (pantalla visible)
    const contadorObserver = new IntersectionObserver((entries) => {
        // entries es un array con los elementos observados que cambian de visibilidad
        entries.forEach(entry => {
            // isIntersecting = true significa que el usuario scrolleó hasta ver el elemento
            if (entry.isIntersecting) {
                // ===== CONFIGURACIÓN DEL CONTADOR =====
                let inicio = 0;           // Valor inicial del contador (comienza en 0)
                const fin = 100;          // Valor final (hasta 100%)
                const duracion = 1800;    // Duración total en milisegundos (1.8 segundos)
                const paso = Math.ceil(duracion / fin);  // Calcula el intervalo entre cada incremento
                // Ej: 1800ms ÷ 100 = 18ms entre cada número

                // Ejecuta una función repetidamente cada 'paso' milisegundos
                const intervalo = setInterval(() => {
                    inicio++;  // Incrementa el contador en 1
                    contadorEl.textContent = inicio + '%';  // Actualiza el texto del elemento a mostrar "1%", "2%", etc.

                    // Cuando llega a 100, detiene el intervalo
                    if (inicio >= fin) clearInterval(intervalo);
                }, paso);

                // Detiene la observación del elemento después de que se ejecute la animación
                // Esto evita que la animación se repita si el usuario vuelve a scrollear
                contadorObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });  // threshold: 0.5 = se activa cuando el 50% del elemento es visible

    // Comienza a observar el elemento (lo vigila para detectar cuando entra en pantalla)
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

/* ===== CURSOR PERSONALIZADO ===== */
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

/* Se agranda al pasar sobre elementos clicables */
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

/* ===== PARALLAX SUAVE EN EL HERO ===== */
const heroInfo = document.querySelector('#hero .cont-info');
const heroFoto = document.querySelector('#hero .cont-foto');

window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;
    if (heroInfo) heroInfo.style.transform = `translateY(${scrollY * 0.08}px)`;
    if (heroFoto) heroFoto.style.transform = `translateY(${scrollY * 0.12}px)`;
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