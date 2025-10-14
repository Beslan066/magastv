import './bootstrap';
import Alpine from 'alpinejs';

// Импортируем все JS библиотеки
import '../../public/js/swiper.min.js';
import '../../public/js/nouislider.js';
import '../../public/js/video.min.js';
import '../../public/js/headerLive.js';
import '../../public/js/script.js';

window.Alpine = Alpine;

// Ваш поисковый скрипт
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.menu__input input');
    const searchResults = document.querySelector('.menu-list');
    const tabs = document.querySelectorAll('.menu-tab');
    let currentCategory = 'all';
    let searchTimeout;

    // Обработчик ввода в поле поиска
    searchInput?.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const searchTerm = this.value.trim();
            if (searchTerm.length >= 2) {
                fetchSearchResults(searchTerm, currentCategory);
            } else if (searchTerm.length === 0) {
                clearSearchResults();
            }
        }, 300);
    });

    // Обработчики для табов категорий
    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentCategory = this.textContent.trim().toLowerCase();

            const searchTerm = searchInput?.value.trim();
            if (searchTerm && searchTerm.length >= 2) {
                fetchSearchResults(searchTerm, currentCategory);
            }
        });
    });

    // Функция для получения результатов поиска
    function fetchSearchResults(term, category) {
        const categoryId = category === 'все' ? 'all' : category;

        fetch(`/search?q=${encodeURIComponent(term)}&category=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data.items, data.total, term);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Функция для отображения результатов
    function displaySearchResults(items, total, term) {
        if (!searchResults) return;

        if (items.length === 0) {
            searchResults.innerHTML = '<div class="no-results" style="color: #fff; font-family: Golos Text, sans-serif; font-weight: 600">Ничего не найдено</div>';
            return;
        }

        let html = '';
        items.forEach(item => {
            const isVideo = item.type === 'video';

            // Формируем медиа-контент
            let mediaContent = '';
            if (isVideo) {
                mediaContent = `
                    <video src="${item.video_url || ''}" poster="${item.media || '/assets/default-video.jpg'}"></video>
                    <button class="btn-reset menu-news__play-btn">
                        <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z" fill="white"/>
                        </svg>
                    </button>
                `;
            } else {
                mediaContent = `<img src="${item.media || '/assets/default-news.jpg'}" alt="${item.title}">`;
            }

            // Формируем HTML для элемента
            html += `
                <div class="menu-news menu-news--media" data-menu-category="${item.category_slug}">
                    <div class="menu-news__media">
                        ${mediaContent}
                    </div>
                    <div class="menu-news__info">
                        <h6 class="menu-news__title">
                            <a href="/${isVideo ? 'video' : 'news'}/${item.slug}">${highlightTerm(item.title, term)}</a>
                        </h6>
                        <div class="menu-news__text">
                            <p>${highlightTerm(item.lead, term)}</p>
                        </div>
                        <div class="menu-news__meta">
                            <time>${formatDate(item.published_at)}</time>
                            <div class="menu-news__views">
                                <div class="menu-news__icon">
                                    <svg width="18" height="12" viewBox="0 0 18 12" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.99998 0C14.0312 0 16.9533 4.44092 17.7656 5.875C17.921 6.14927 17.9148 6.47693 17.7461 6.74316C16.907 8.0657 13.9914 12 8.99998 12C4.00872 11.9999 1.0939 8.06568 0.254863 6.74316C0.086031 6.47689 0.078957 6.14935 0.234355 5.875C1.04653 4.44117 3.96865 0.000143146 8.99998 0ZM8.99998 3C7.34324 3.00013 5.99998 4.34323 5.99998 6C5.99998 7.65677 7.34324 8.99987 8.99998 9C10.6568 9 12 7.65685 12 6C12 4.34315 10.6568 3 8.99998 3Z"/>
                                    </svg>
                                </div>
                                <span>${item.views}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        if (total > 10) {
            html += `
                <div class="all-results-link">
                    <a href="/search?q=${encodeURIComponent(term)}&category=${currentCategory}">Показать все результаты (${total})</a>
                </div>
            `;
        }

        searchResults.innerHTML = html;
    }

    // Функция для очистки результатов
    function clearSearchResults() {
        if (searchResults) {
            searchResults.innerHTML = '';
        }
    }

    // Функция для подсветки искомого термина
    function highlightTerm(text, term) {
        if (!term) return text;
        const regex = new RegExp(`(${term})`, 'gi');
        return text.replace(regex, '<span class="highlight">$1</span>');
    }

    // Функция для форматирования даты
    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = {day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit'};
        return date.toLocaleDateString('ru-RU', options);
    }
});

// Инициализация слайдеров телепрограммы
document.addEventListener('DOMContentLoaded', function() {
    const scheduleSliders = document.querySelectorAll('[data-schedule]');
    scheduleSliders.forEach(slider => {
        initScheduleSlider(slider);
    });
});

function initScheduleSlider(slider) {
    const list = slider.querySelector('.schedule-list');
    const items = slider.querySelectorAll('.schedule-list__item');
    const prevBtn = slider.closest('.header__schedule')?.querySelector('.schedule-navigation__btn--prev');
    const nextBtn = slider.closest('.header__schedule')?.querySelector('.schedule-navigation__btn--next');

    if (!list || !prevBtn || !nextBtn) return;

    let currentPosition = 0;
    const itemWidth = items[0]?.offsetWidth + parseInt(getComputedStyle(items[0]).marginRight) || 215;
    const visibleItems = Math.floor(slider.offsetWidth / itemWidth);
    const maxPosition = Math.max(0, items.length - visibleItems) * itemWidth;

    function updateButtons() {
        prevBtn.classList.toggle('schedule-navigation__btn--disabled', currentPosition === 0);
        nextBtn.classList.toggle('schedule-navigation__btn--disabled', currentPosition >= maxPosition);
    }

    function scrollTo(position) {
        currentPosition = Math.max(0, Math.min(position, maxPosition));
        list.style.transform = `translateX(-${currentPosition}px)`;
        updateButtons();
    }

    prevBtn.addEventListener('click', function () {
        if (currentPosition > 0) {
            scrollTo(currentPosition - itemWidth * visibleItems);
        }
    });

    nextBtn.addEventListener('click', function () {
        if (currentPosition < maxPosition) {
            scrollTo(currentPosition + itemWidth * visibleItems);
        }
    });

    let resizeTimeout;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function () {
            const newVisibleItems = Math.floor(slider.offsetWidth / itemWidth);
            const newMaxPosition = Math.max(0, items.length - newVisibleItems) * itemWidth;

            if (newMaxPosition < currentPosition) {
                scrollTo(newMaxPosition);
            } else {
                updateButtons();
            }
        }, 250);
    });

    updateButtons();

    const activeItem = slider.querySelector('.schedule-list__item.active');
    if (activeItem) {
        const activeIndex = Array.from(items).indexOf(activeItem);
        if (activeIndex >= visibleItems) {
            setTimeout(() => {
                scrollTo(Math.min(activeIndex * itemWidth, maxPosition));
            }, 100);
        }
    }
}

Alpine.start();
