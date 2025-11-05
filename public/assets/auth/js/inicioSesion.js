document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const recordarme = document.getElementById('recordarme').checked;
            
            // Validación básica
            if (!email || !password) {
                alert('Por favor, complete todos los campos');
                return;
            }
            
            // Validación de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Por favor, ingrese un email válido');
                return;
            }
            
            // Aquí iría la lógica de autenticación
            console.log('Datos de inicio de sesión:', {
                email: email,
                password: password,
                recordarme: recordarme
            });
            
            // Simular inicio de sesión exitoso
            alert('Iniciando sesión...');
            
            // Aquí redirigirías al usuario al dashboard
            // window.location.href = 'dashboard.html';
        });
        
        // Agregar animación al input cuando tiene foco
        const inputs = document.querySelectorAll('.campos-formulario');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'scale(1.02)';
                this.style.transition = 'all 0.3s ease';
            });
            
            input.addEventListener('blur', function() {
                this.style.transform = 'scale(1)';
            });
        });

        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: false,
            mirror: true
        });
