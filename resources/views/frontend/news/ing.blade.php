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
                        <h1 class="page-title">Хоамаш</h1>
                        <div class="news-content__tabs_wrapper">
                            <div class="tabs">
                                <button class="btn-reset news-content__filters_btn news-content__filters_btn--mobile">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 6L13 6" stroke="#1A1A1A" stroke-width="1.5" />
                                        <path d="M17 14L7 14" stroke="#1A1A1A" stroke-width="1.5" />
                                        <circle cx="5" cy="14" r="2.25" stroke="#1A1A1A" stroke-width="1.5" />
                                        <circle cx="15" cy="6" r="2.25" stroke="#1A1A1A" stroke-width="1.5" />
                                    </svg>
                                </button>
                                <ul class="list-reset tabs__list">
                                    <li class="tab active" data-category-id="">
                                        <span>Все</span>
                                    </li>
                                    @foreach($categories as $category)
                                        <li class="tab" data-category-id="{{ $category->id }}">
                                            <span>{{ $category->name }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
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
                                        <li class="dropdown__list-item dropdown__list-item_active" data-value="published_at">По дате</li>
                                        <li class="dropdown__list-item" data-value="views">По просмотрам</li>
                                    </ul>
                                    <input type="text" name="select-sort" value="published_at" class="dropdown__input_hidden">
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
                                    @if($news->count() > 0)
                                        @include('frontend.partials.news.news_items', ['items' => $news])
                                    @else
                                        <li class="no-items">Нет видеорепортажей</li>
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
                                    @if($popularItems->count() > 0)
                                        @foreach($popularItems as $item)
                                            <li class="popular-sidebar__item">
                                                <a href="{{ route('home.news.single', $item->slug) }}" class="popular-sidebar__item_text">
                                                    {{ $item->title }}
                                                </a>
                                                <div class="popular-sidebar__item_info">
                                                    <time datetime="{{ $item->published_at->format('Y-m-d H:i') }}" class="popular-sidebar__item_time">
                                                        {{ $item->formatted_published_at }}
                                                    </time>
                                                    <div class="popular-sidebar__item_views">
                                                        <div class="item-views__icon">
                                                            <img src="{{ asset('assets/img/views1.svg') }}" alt="Eye icon">
                                                        </div>
                                                        <span>{{ $item->views }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="no-items">Нет популярных видео</li>
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
            let hasMorePages = true;
            let currentFilters = {
                category: null,
                sort: 'published_at',
                period: null
            };
            let isInitialLoad = true;
            let scrollTimeout = null;

            // Сохраняем начальное состояние
            const saveInitialState = () => {
                const newsList = document.getElementById('news-list');
                newsList.setAttribute('data-initial-html', newsList.innerHTML);
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

            // Обработчики для табов категорий
            document.querySelectorAll('.tabs__list .tab').forEach((tab) => {
                tab.addEventListener('click', function() {
                    // Удаляем active у всех табов
                    document.querySelectorAll('.tabs__list .tab').forEach(t => t.classList.remove('active'));
                    // Добавляем active текущему табу
                    this.classList.add('active');

                    // Устанавливаем фильтр категории
                    const newCategory = this.dataset.categoryId || '';

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
                        input.value = this.dataset.value;

                        // Определяем тип фильтра по имени input
                        const inputName = input.getAttribute('name');
                        let filterType = '';

                        if (inputName === 'select-sort') {
                            filterType = 'sort';
                        } else if (inputName === 'select-period') {
                            filterType = 'period';
                        }

                        let newFilters = { ...currentFilters };

                        // Устанавливаем значение фильтра
                        if (filterType === 'sort') {
                            newFilters.sort = this.dataset.value;
                        } else if (filterType === 'period') {
                            newFilters.period = this.dataset.value === 'all' ? null : this.dataset.value;
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

            // Улучшенная проверка скролла
            const checkScroll = () => {
                if (isLoading || !hasMorePages) return;

                if (scrollTimeout) {
                    clearTimeout(scrollTimeout);
                }

                scrollTimeout = setTimeout(() => {
                    const scrollPosition = window.scrollY || window.pageYOffset;
                    const windowHeight = window.innerHeight;
                    const documentHeight = Math.max(
                        document.body.scrollHeight,
                        document.body.offsetHeight,
                        document.documentElement.clientHeight,
                        document.documentElement.scrollHeight,
                        document.documentElement.offsetHeight
                    );
                    const threshold = 200;

                    // Проверяем, достигли ли мы нижней части страницы
                    if (scrollPosition + windowHeight >= documentHeight - threshold) {
                        loadMoreNews();
                    }
                }, 100);
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
                    page: currentPage
                });

                // Добавляем фильтры
                if (currentFilters.category) {
                    params.append('category', currentFilters.category);
                }
                if (currentFilters.sort) {
                    params.append('sort', currentFilters.sort);
                }
                if (currentFilters.period) {
                    params.append('period', currentFilters.period);
                }

                fetch(`/news-ing?${params.toString()}`, {
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
                                newsList.innerHTML = data.html;
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

            // Добавляем обработчик скролла
            window.addEventListener('scroll', checkScroll);
            window.addEventListener('touchmove', checkScroll);

            // Инициализация
            document.querySelectorAll('.tabs__list .tab').forEach((tab, index) => {
                if (index === 0) {
                    tab.classList.add('active');
                }
            });

            // Загружаем первую порцию контента
            setTimeout(checkScroll, 500);
        });
    </script>
@endpush
