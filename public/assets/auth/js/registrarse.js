document.addEventListener('DOMContentLoaded', function () {
    let currentStep = 1;
    const totalSteps = 3; // Arreglado a 2 pasos

    // Elementos del DOM
    const btnSiguiente = document.getElementById('btnSiguiente');
    const btnAnterior = document.getElementById('btnAnterior');
    const btnRegistrar = document.getElementById('btnRegistrar');
    const progressLine = document.getElementById('progressLine');

    function updateWizard() {
        // Ocultar todos los pasos
        document.querySelectorAll('.wizard-form-step').forEach(step => {
            step.classList.remove('active');
        });

        // Mostrar paso actual (Busca el data-step exacto)
        document.querySelector(`.wizard-form-step[data-step="${currentStep}"]`).classList.add('active');

        // Actualizar círculos/textos de progreso (Se cambió '.wizard-step' por '.step' que es la clase que tú usas)
        document.querySelectorAll('.step').forEach(step => {
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
        if (progressLine) {
            progressLine.style.width = `${progressPercent}%`;
        }

        // Mostrar/ocultar botones dependiendo de dónde estés
        if (currentStep === 1) {
            // Primer paso: solo "Siguiente", ocupando todo el ancho
            btnAnterior.style.display = 'none';
            btnSiguiente.style.display = 'block';
            btnSiguiente.style.width = '100%';
            btnRegistrar.style.display = 'none';
        } else if (currentStep === totalSteps) {
            // Último paso: "Anterior" + "Registrar"
            btnAnterior.style.display = 'block';
            btnSiguiente.style.display = 'none';
            btnRegistrar.style.display = 'block';
        } else {
            // Pasos intermedios: "Anterior" + "Siguiente"
            btnAnterior.style.display = 'block';
            btnSiguiente.style.display = 'block';
            btnSiguiente.style.width = '48%';
            btnRegistrar.style.display = 'none';
        }
    }

    // Validar paso actual
    function validateCurrentStep() {
        const currentStepElement = document.querySelector(`.wizard-form-step[data-step="${currentStep}"]`);
        const inputs = currentStepElement.querySelectorAll('input[required], select[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
            }
        });

        if (!isValid) {
            alert('Por favor, llena todos los campos obligatorios.');
        }

        return isValid;
    }

    // Botón Siguiente
    if (btnSiguiente) {
        btnSiguiente.addEventListener('click', function () {
            if (validateCurrentStep() && currentStep < totalSteps) {
                currentStep++;
                updateWizard();
            }
        });
    }

    // Botón Anterior
    if (btnAnterior) {
        btnAnterior.addEventListener('click', function () {
            if (currentStep > 1) {
                currentStep--;
                updateWizard();
            }
        });
    }

    // Inicializar
    updateWizard();

    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: false,
        mirror: true
    });
});