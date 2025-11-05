const contEspecialidades = document.getElementById('cont-especialidades');
let especialidades = []
AOS.init({
    once: true,
    offset: 100
});

const equipoSwiper = new Swiper('.equipoSwiper', {
    // Configuración de slides por vista
    slidesPerView: 1,
    spaceBetween: 30,
    centeredSlides: true,
    loop: true,

    // Autoplay (opcional - quítalo si no lo quieres)
    

    // Navegación con flechas
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // Paginación (los botones)
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },

    // Responsive
    breakpoints: {
        // Tablet
        768: {
            slidesPerView: 2,
            spaceBetween: 30,
            centeredSlides: false,
        },
        // Desktop
        1024: {
            slidesPerView: 3,
            spaceBetween: 30,
            centeredSlides: false,
        },
    },
});

document.addEventListener('DOMContentLoaded', () => {
    fetch("../assets/data/especialidades.json")

        .then(response => response.json())

        .then(data => {
            especialidades = data;
            mostrarEspecialidades();
        })

        .catch(error => {
            console.error("No se encontró el archivo especialidades.json", error);
        })
})

function mostrarEspecialidades() {
    especialidades.forEach((especialidad) => {
        const contInfo = document.createElement('div');
        contInfo.classList.add('col-md-3', 'cont-info');
        contInfo.setAttribute('data-aos', 'fade-up');
        contInfo.setAttribute('data-aos-duration', '1000');

        if (especialidad.icono) {
            const icono = document.createElement('i');
            icono.className = especialidad.icono;
            contInfo.appendChild(icono);
        } else if (especialidad.imagen) {
            const img = document.createElement('img');
            img.src = especialidad.imagen;
            img.alt = especialidad.alt;
            contInfo.appendChild(img);
        }
        const nombre = document.createElement('p');
        nombre.textContent = especialidad.nombre;
        contInfo.appendChild(nombre);

        contEspecialidades.appendChild(contInfo);
        
    })
}