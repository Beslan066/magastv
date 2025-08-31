@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/news-page.css')}}">
@endpush

@section('content')
    <main class="news-page" data-main>
        <section class="news-content">
            <div class="container">
                <div class="news-content__inner">
                    <div class="news-content__top">
                        <h1 class="page-title">Новости</h1>
                        <div class="news-content__tabs_wrapper">
                            <button class="tab-arrow tab-arrow-prev" aria-label="Предыдущие категории" style="display: none;">
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>
                            </button>

                            <div class="tabs">
                                <ul class="list-reset tabs__list" id="categories-list">
                                    <li class="tab active" data-category-id="all">
                                        <span>Все</span>
                                    </li>
                                    @foreach($categories as $category)
                                        <li class="tab" data-category-id="{{ $category->id }}">
                                            <span>{{$category->name}}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <button class="tab-arrow tab-arrow-next" aria-label="Следующие категории">
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <button class="btn-reset news-content__filters_btn">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 6L13 6" stroke="#1A1A1A" stroke-width="1.5" />
                                    <path d="M17 14L7 14" stroke="#1A1A1A" stroke-width="1.5" />
                                    <circle cx="5" cy="14" r="2.25" stroke="#1A1A1A" stroke-width="1.5" />
                                    <circle cx="15" cy="6" r="2.25" stroke="#1A1A1A" stroke-width="1.5" />
                                </svg>
                                Фильтры
                            </button>
                        </div>
                        <div class="filters">
                            <div class="filter-item filters--sort">
                                <span class="filter-item__title">Сортировка</span>
                                <div class="dropdown">
                                    <button type="button" class="dropdown__button">По дате</button>
                                    <ul class="dropdown__list">
                                        <li class="dropdown__list-item dropdown__list-item_active" data-value="date">По дате</li>
                                        <li class="dropdown__list-item" data-value="views">По просмотрам</li>
                                    </ul>
                                    <input type="text" name="select-sort" value="date" class="dropdown__input_hidden">
                                </div>
                            </div>
                            <div class="filter-item filters--time">
                                <span class="filter-item__title">Период</span>
                                <div class="dropdown">
                                    <button type="button" class="dropdown__button">Весь период</button>
                                    <ul class="dropdown__list">
                                        <li class="dropdown__list-item dropdown__list-item_active" data-value="all">Весь период</li>
                                        <li class="dropdown__list-item" data-value="week">Последняя неделя</li>
                                        <li class="dropdown__list-item" data-value="month">Последний месяц</li>
                                        <li class="dropdown__list-item" data-value="year">Последний год</li>
                                    </ul>
                                    <input type="text" name="select-period" value="all" class="dropdown__input_hidden">
                                </div>
                            </div>
                            <div class="filter-item filters--time">
                                <span class="filter-item__title">Период</span>
                                <div class="dropdown">
                                    <button type="button" class="dropdown__button">Весь период</button>
                                    <ul class="dropdown__list">
                                        <li class="dropdown__list-item dropdown__list-item_active" data-value="all">Весь период</li>
                                        <li class="dropdown__list-item" data-value="week">Последняя неделя</li>
                                        <li class="dropdown__list-item" data-value="month">Последний месяц</li>
                                        <li class="dropdown__list-item" data-value="year">Последний год</li>
                                    </ul>
                                    <input type="text" name="select-period" value="all" class="dropdown__input_hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="news-content__bottom">
                        <div class="news-content__left">
                            <div class="news-content__news-block">
                                <ul class="list-reset news-block__list news-block__list--second" id="news-list">
                                    @if($mainPost)
                                        <li class="news-item news-item--second main-news-item">
                                            <a href="{{route('home.news.single', $mainPost->slug)}}">
                                                <div class="news-item__media">
                                                    <img src="{{asset('storage/public/' . $mainPost->media)}}"
                                                         alt="С началом весны участились случаи возгорания сухой травы и сжигания мусора.">
                                                    <button class="btn-reset news-item--media__btn">
                                                        <svg width="10" height="12" viewBox="0 0 10 12" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z"
                                                                fill="white" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </a>
                                            <div class="news-item__bottom">
                                                <h6 class="news-item__title">
                                                    <a href="{{route('home.news.single', $mainPost->slug)}}">{{$mainPost->title}}</a>
                                                </h6>
                                                <div class="news-item__descr">
                                                    <p>{{$mainPost->lead}}</p>
                                                </div>
                                                <div class="news-item__info">
                                                    <time datetime="2025-04-1 18:35" class="news-item_time">
                                                        {{$mainPost->formatted_published_at}}
                                                    </time>
{{--                                                    <div class="news-item_views">--}}
{{--                                                        <div class="item-views__icon">--}}
{{--                                                            <svg width="14" height="10" viewBox="0 0 14 10" fill="none"--}}
{{--                                                                 xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                                <path--}}
{{--                                                                    d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z" />--}}
{{--                                                            </svg>--}}
{{--                                                        </div>--}}
{{--                                                        <span>{{$mainPost->views}}</span>--}}
{{--                                                    </div>--}}
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if($items)
                                            @include('frontend.partials.news.news_items', ['items' => $items])
                                    @endif
                                </ul>
                            </div>
                            <div id="loading-indicator" style="display: none; text-align: center; padding: 20px;">
                                <div class="spinner"></div>
                                <p>Загрузка...</p>
                            </div>
                        </div>
                        <div class="news-content__right">
                            <div class="ads-block">
                                <img src="{{asset('assets/add.jpg')}}" alt="add">
                            </div>
                            <div class="content__popular popular-sidebar popular-sidebar--news">
                                <h3 class="popular-sidebar__title">Популярное</h3>
                                <ul class="list-reset popular-sidebar__list">
                                    @if($popularItems)
                                        @foreach($popularItems as $news)
                                            <li class="popular-sidebar__item">
                                                <a href="{{route('home.news.single', $news->slug)}}" class="popular-sidebar__item_text">
                                                    {{$news->title}}
                                                </a>
                                                <div class="popular-sidebar__item_info">
                                                    <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                        {{$news->formatted_published_at}}
                                                    </time>
{{--                                                    <div class="popular-sidebar__item_views">--}}
{{--                                                        <div class="item-views__icon">--}}
{{--                                                            <img src="{{asset('assets/img/views1.svg')}}" alt="Eye icon">--}}
{{--                                                        </div>--}}
{{--                                                        <span>{{$news->views}}</span>--}}
{{--                                                    </div>--}}
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let isLoading = false;
            let currentPage = 1;
            let initialScrollPosition = 0;
            let hasMorePages = true;
            let currentFilters = {
                category: null,
                sort: 'date',
                period: null,
                content: null
            };
            let isInitialLoad = true;
            let scrollTimeout = null;

            // Сохраняем начальное состояние
            const saveInitialState = () => {
                initialScrollPosition = window.scrollY;
                const newsList = document.getElementById('news-list');
                const mainNewsItem = newsList.querySelector('.main-news-item');
                const initialHtml = mainNewsItem ? mainNewsItem.outerHTML : '';
                newsList.setAttribute('data-initial-html', initialHtml);
            };

            saveInitialState();

            // Функция для сброса к начальному состоянию
            const resetToInitialState = () => {
                const newsList = document.getElementById('news-list');
                const initialHtml = newsList.getAttribute('data-initial-html');
                newsList.innerHTML = initialHtml || '';
                currentPage = 1;
                hasMorePages = true;
                isLoading = false;
                isInitialLoad = true;
            };

            // Функция для проверки, были ли изменены фильтры
            const haveFiltersChanged = (newFilters) => {
                return JSON.stringify(newFilters) !== JSON.stringify(currentFilters);
            };

            // Функция для листания категорий
            const initCategoryTabsScroll = () => {
                const tabsList = document.getElementById('categories-list');
                const prevBtn = document.querySelector('.tab-arrow-prev');
                const nextBtn = document.querySelector('.tab-arrow-next');
                const tabs = tabsList.querySelectorAll('.tab');

                let scrollPosition = 0;
                const scrollStep = 150;

                // Проверяем видимость стрелок
                const checkArrowsVisibility = () => {
                    if (window.innerWidth <= 768) {
                        prevBtn.style.display = 'none';
                        nextBtn.style.display = 'none';
                        tabsList.style.overflowX = 'auto';
                        tabsList.style.WebkitOverflowScrolling = 'touch';
                        return;
                    }

                    const maxScroll = tabsList.scrollWidth - tabsList.clientWidth;

                    prevBtn.style.display = scrollPosition > 0 ? 'flex' : 'none';
                    nextBtn.style.display = scrollPosition < maxScroll ? 'flex' : 'none';
                };

                // Листание вперед
                nextBtn.addEventListener('click', () => {
                    scrollPosition += scrollStep;
                    const maxScroll = tabsList.scrollWidth - tabsList.clientWidth;

                    if (scrollPosition > maxScroll) {
                        scrollPosition = maxScroll;
                    }

                    tabsList.scrollTo({
                        left: scrollPosition,
                        behavior: 'smooth'
                    });

                    setTimeout(checkArrowsVisibility, 300);
                });

                // Листание назад
                prevBtn.addEventListener('click', () => {
                    scrollPosition -= scrollStep;

                    if (scrollPosition < 0) {
                        scrollPosition = 0;
                    }

                    tabsList.scrollTo({
                        left: scrollPosition,
                        behavior: 'smooth'
                    });

                    setTimeout(checkArrowsVisibility, 300);
                });

                // Обновляем позицию при ручном скролле
                tabsList.addEventListener('scroll', () => {
                    scrollPosition = tabsList.scrollLeft;
                    checkArrowsVisibility();
                });

                // Проверяем при загрузке и ресайзе
                setTimeout(checkArrowsVisibility, 100);
                window.addEventListener('resize', checkArrowsVisibility);
            };

            // Инициализируем листание категорий
            initCategoryTabsScroll();

            // Обработчики для табов категорий
            document.querySelectorAll('.tabs__list .tab').forEach((tab) => {
                tab.addEventListener('click', function() {
                    // Удаляем active у всех табов
                    document.querySelectorAll('.tabs__list .tab').forEach(t => t.classList.remove('active'));
                    // Добавляем active текущему табу
                    this.classList.add('active');

                    // Устанавливаем фильтр категории
                    const newCategory = this.dataset.categoryId === 'all' ? null : this.dataset.categoryId;

                    // Проверяем, изменились ли фильтры
                    const newFilters = {
                        ...currentFilters,
                        category: newCategory
                    };

                    if (haveFiltersChanged(newFilters)) {
                        currentFilters = newFilters;
                        // Сбрасываем и загружаем заново только если фильтры изменились
                        resetToInitialState();
                        loadMoreNews();
                    }
                });
            });

            // Обработчики для dropdown фильтров
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                const button = dropdown.querySelector('.dropdown__button');
                const items = dropdown.querySelectorAll('.dropdown__list-item');
                const input = dropdown.querySelector('.dropdown__input_hidden');

                items.forEach(item => {
                    item.addEventListener('click', function() {
                        // Удаляем active у всех items
                        items.forEach(i => i.classList.remove('dropdown__list-item_active'));
                        // Добавляем active текущему item
                        this.classList.add('dropdown__list-item_active');
                        // Обновляем текст кнопки
                        button.textContent = this.textContent;
                        // Обновляем скрытое поле
                        if (input) {
                            input.value = this.dataset.value;
                        }

                        // Определяем тип фильтра
                        const filterType = dropdown.closest('.filter-item').classList[1].split('--')[1];

                        let newFilters = { ...currentFilters };

                        // Устанавливаем значение фильтра
                        switch(filterType) {
                            case 'sort':
                                newFilters.sort = this.dataset.value;
                                break;
                            case 'time':
                                newFilters.period = this.dataset.value === 'all' ? null : this.dataset.value;
                                break;
                            case 'content':
                                newFilters.content = this.dataset.value === 'all' ? null : this.dataset.value;
                                break;
                        }

                        // Проверяем, изменились ли фильтры
                        if (haveFiltersChanged(newFilters)) {
                            currentFilters = newFilters;
                            // Сбрасываем и загружаем заново только если фильтры изменились
                            resetToInitialState();
                            loadMoreNews();
                        }
                    });
                });
            });

            // Улучшенная проверка скролла для мобильных устройств
            const checkScroll = () => {
                if (isLoading || !hasMorePages) return;

                if (scrollTimeout) {
                    window.cancelAnimationFrame(scrollTimeout);
                }

                scrollTimeout = window.requestAnimationFrame(() => {
                    const scrollPosition = window.scrollY || window.pageYOffset;
                    const windowHeight = window.innerHeight;
                    const documentHeight = getDocumentHeight();

                    // Для мобильных устройств используем другой подход
                    if (window.innerWidth <= 768) {
                        // Проверяем, достигли ли мы последнего элемента в списке новостей
                        const newsItems = document.querySelectorAll('#news-list .news-item');
                        if (newsItems.length > 0) {
                            const lastNewsItem = newsItems[newsItems.length - 1];
                            const lastItemRect = lastNewsItem.getBoundingClientRect();

                            // Если последний элемент виден или почти виден - подгружаем
                            if (lastItemRect.top <= windowHeight + 300) { // 300px запас
                                loadMoreNews();
                            }
                        }
                    } else {
                        // Для десктопа используем старую логику
                        const threshold = 200;
                        if (scrollPosition + windowHeight >= documentHeight - threshold) {
                            loadMoreNews();
                        }
                    }
                });
            };

            // Функция для получения точной высоты документа на мобильных устройствах
            const getDocumentHeight = () => {
                return Math.max(
                    document.body.scrollHeight,
                    document.body.offsetHeight,
                    document.documentElement.clientHeight,
                    document.documentElement.scrollHeight,
                    document.documentElement.offsetHeight
                );
            };

            // Загрузка новостей
            const loadMoreNews = () => {
                if (isLoading || !hasMorePages) return;

                isLoading = true;
                const loadingIndicator = document.getElementById('loading-indicator');
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'block';
                }

                // Формируем параметры запроса
                const params = new URLSearchParams({
                    page: currentPage,
                    ...currentFilters
                });

                // Убираем пустые параметры
                Object.keys(currentFilters).forEach(key => {
                    if (currentFilters[key] === null || currentFilters[key] === '') {
                        params.delete(key);
                    }
                });

                fetch(`/news?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        if (data.html) {
                            const newsList = document.getElementById('news-list');

                            if (isInitialLoad && currentPage === 1) {
                                // Сохраняем main-news-item если он есть
                                const mainNewsItem = newsList.querySelector('.main-news-item');
                                newsList.innerHTML = mainNewsItem ? mainNewsItem.outerHTML : '';
                                newsList.insertAdjacentHTML('beforeend', data.html);
                                isInitialLoad = false;
                            } else {
                                newsList.insertAdjacentHTML('beforeend', data.html);
                            }
                        }

                        hasMorePages = data.hasMore;
                        if (currentPage === 1) saveInitialState();
                        currentPage++;
                    })
                    .catch(error => {
                        console.error('Error loading more news:', error);
                        if (currentPage > 1) currentPage--;
                    })
                    .finally(() => {
                        isLoading = false;
                        const loadingIndicator = document.getElementById('loading-indicator');
                        if (loadingIndicator) {
                            loadingIndicator.style.display = 'none';
                        }
                    });
            };

            // Добавляем обработчик скролла с throttle для производительности
            let isScrolling = false;
            window.addEventListener('scroll', () => {
                if (!isScrolling) {
                    window.requestAnimationFrame(() => {
                        checkScroll();
                        isScrolling = false;
                    });
                    isScrolling = true;
                }
            });

            // Также обрабатываем touch события для мобильных устройств
            window.addEventListener('touchmove', checkScroll);

            // Инициализация активных dropdown items
            document.querySelectorAll('.dropdown__list-item').forEach(item => {
                if (item.classList.contains('dropdown__list-item_active')) {
                    item.closest('.dropdown').querySelector('.dropdown__button').textContent = item.textContent;
                }
            });

            // Загружаем первую порцию контента при загрузке страницы
            setTimeout(checkScroll, 1000);
        });
    </script>
@endpush
