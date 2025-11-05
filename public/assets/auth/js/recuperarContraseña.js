  // Inicializar AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: false,
            mirror: true
        });

        // Elementos del DOM
        const formRecuperar = document.getElementById('formRecuperar');
        const emailInput = document.getElementById('email');
        const recuperarFormDiv = document.getElementById('recuperarForm');
        const successMessage = document.getElementById('successMessage');
        const btnEnviar = document.getElementById('btnEnviar');

        // Manejar click del botón de enviar
        btnEnviar.addEventListener('click', function(e) {
            e.preventDefault();
            
            const email = emailInput.value.trim();
            
            // Validación de email vacío
            if (!email) {
                alert('Por favor, ingrese su correo electrónico');
                emailInput.focus();
                return;
            }
            
            // Validación de formato de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Por favor, ingrese un correo electrónico válido');
                emailInput.focus();
                return;
            }
            
            // Simular envío del correo
            console.log('Enviando correo de recuperación a:', email);
            
            // Mostrar animación de carga
            btnEnviar.textContent = 'Enviando...';
            btnEnviar.style.pointerEvents = 'none';
            
            // Simular delay de envío
            setTimeout(() => {
                // Ocultar formulario y mostrar mensaje de éxito
                recuperarFormDiv.style.display = 'none';
                successMessage.classList.add('active');
                
                // Refrescar animaciones AOS para el mensaje de éxito
                setTimeout(() => {
                    AOS.refresh();
                }, 100);
                
                // Aquí iría la lógica real de envío al backend
                // fetch('/api/recuperar-password', {
                //     method: 'POST',
                //     body: JSON.stringify({ email: email }),
                //     headers: { 'Content-Type': 'application/json' }
                // })
                
                // Reset del botón
                btnEnviar.textContent = 'Enviar enlace de recuperación';
                btnEnviar.style.pointerEvents = 'auto';
                
                // Redirigir al login después de 2 segundos
                setTimeout(() => {
                    window.open('inicioSesion.html', '_blank');
                }, 2000);
            }, 1500);
        });



        // Animación en input
        emailInput.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
            this.style.transition = 'all 0.3s ease';
        });
        
        emailInput.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
        });

        // Prevenir envío múltiple con Enter
        emailInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                btnEnviar.click();
            }
        });

        // Auto-focus en el campo de email al cargar la página
        window.addEventListener('load', function() {
            emailInput.focus();
        });

        