function toggleMenu() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('active');
        }

        // Cerrar menú al hacer clic en un enlace (mobile)
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 992) {
                    document.getElementById('navLinks').classList.remove('active');
                }
            });
        });

        // Cerrar menú al cambiar tamaño de ventana
        window.addEventListener('resize', () => {
            if (window.innerWidth > 992) {
                document.getElementById('navLinks').classList.remove('active');
            }
});
AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: false,
            mirror: true
        });