 let currentStep = 1;
        const totalSteps = 4;

        // Elementos del DOM
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnAnterior = document.getElementById('btnAnterior');
        const btnRegistrar = document.getElementById('btnRegistrar');
        const progressLine = document.getElementById('progressLine');

        // Función para actualizar el wizard
        function updateWizard() {
            // Ocultar todos los pasos
            document.querySelectorAll('.wizard-form-step').forEach(step => {
                step.classList.remove('active');
            });

            // Mostrar paso actual
            document.querySelector(`.wizard-form-step[data-step="${currentStep}"]`).classList.add('active');

            // Actualizar círculos de progreso
            document.querySelectorAll('.wizard-step').forEach(step => {
                const stepNum = parseInt(step.dataset.step);
                step.classList.remove('active', 'completed');
                
                if (stepNum === currentStep) {
                    step.classList.add('active');
                } else if (stepNum < currentStep) {
                    step.classList.add('completed');
                }
            });

            // Actualizar línea de progreso
            const progressPercent = ((currentStep - 1) / (totalSteps - 1)) * 100;
            progressLine.style.width = `${progressPercent}%`;

            // Mostrar/ocultar botones
            btnAnterior.style.display = currentStep === 1 ? 'none' : 'block';
            btnSiguiente.style.display = currentStep === totalSteps ? 'none' : 'block';
            btnRegistrar.style.display = currentStep === totalSteps ? 'block' : 'none';
        }

        // Validar paso actual
        function validateCurrentStep() {
            const currentStepElement = document.querySelector(`.wizard-form-step[data-step="${currentStep}"]`);
            const inputs = currentStepElement.querySelectorAll('input, select');
        
            return true;
        }

        // Botón Siguiente
        btnSiguiente.addEventListener('click', function() {
            if (validateCurrentStep() && currentStep < totalSteps) {
                currentStep++;
                updateWizard();
            }
        });

        // Botón Anterior
        btnAnterior.addEventListener('click', function() {
            if (currentStep > 1) {
                currentStep--;
                updateWizard();
            }
        });

        // Botón Registrarse
        btnRegistrar.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (!validateCurrentStep()) {
                return;
            }

            // Recopilar todos los datos
            const formData = {
                nombre: document.getElementById('nombre').value,
                apellidos: document.getElementById('apellidos').value,
                email: document.getElementById('email').value,
                telefono: document.getElementById('telefono').value,
                tipoDocumento: document.getElementById('tipoDocumento').value,
                numeroDocumento: document.getElementById('numeroDocumento').value,
                contrasena: document.getElementById('contrasena').value,
                genero: document.getElementById('genero').value,
                rol: document.getElementById('rol').value
            };
            
            console.log('Datos de registro:', formData);
            alert('Registro exitoso. Redirigiendo...');
            window.open('login', '_blank');
        });

        // Animación en inputs
        const inputs = document.querySelectorAll('.campos-formulario');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'scale(1.01)';
                this.style.transition = 'all 0.3s ease';
            });
            
            input.addEventListener('blur', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Cambiar color del select
        document.querySelectorAll('select.campos-formulario').forEach(select => {
            select.addEventListener('change', function() {
                this.style.color = this.value !== '' ? '#333' : 'var(--tercer-azul)';
            });
        });

        // Permitir Enter para avanzar
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (currentStep < totalSteps) {
                    btnSiguiente.click();
                } else {
                    btnRegistrar.click();
                }
            }
        });

        // Inicializar
        updateWizard();

         AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: false,
            mirror: true
        });