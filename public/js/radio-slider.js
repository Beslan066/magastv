// radio-slider-fixed.js
document.addEventListener('DOMContentLoaded', function() {
    const radioSlider = document.querySelector('.radio-slider');

    if (!radioSlider) return;

    const wrapper = radioSlider.querySelector('.radio-slider__wrapper');
    const slides = radioSlider.querySelectorAll('.radio-slide');
    const prevBtn = radioSlider.querySelector('.radio-slider-btn--prev');
    const nextBtn = radioSlider.querySelector('.radio-slider-btn--next');
    const pagination = radioSlider.querySelector('.radio-slider-pagination');

    if (!slides.length) return;

    let currentSlide = 0;

    function updateSlider() {
        wrapper.style.transform = `translateX(-${currentSlide * 100}%)`;

        // Обновляем пагинацию
        if (pagination) {
            pagination.textContent = `${currentSlide + 1}/${slides.length}`;
        }

        // Обновляем состояние кнопок
        if (prevBtn) {
            prevBtn.disabled = currentSlide === 0;
        }
        if (nextBtn) {
            nextBtn.disabled = currentSlide === slides.length - 1;
        }
    }

    // Инициализация
    wrapper.style.display = 'flex';
    wrapper.style.transition = 'transform 0.3s ease';

    slides.forEach(slide => {
        slide.style.flex = '0 0 100%';
        slide.style.width = '100%';
    });

    // Обработчики событий
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (currentSlide < slides.length - 1) {
                currentSlide++;
                updateSlider();
            }
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            if (currentSlide > 0) {
                currentSlide--;
                updateSlider();
            }
        });
    }

    // Инициализируем пагинацию
    if (pagination) {
        pagination.textContent = `1/${slides.length}`;
    }

    // Обновляем состояние кнопок при инициализации
    updateSlider();
});
