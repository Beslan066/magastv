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
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 6L13 6" stroke="#1A1A1A" stroke-width="1.5" />
                                        <path d="M17 14L7 14" stroke="#1A1A1A" stroke-width="1.5" />
                                        <circle cx="5" cy="14" r="2.25" stroke="#1A1A1A" stroke-width="1.5" />
                                        <circle cx="15" cy="6" r="2.25" stroke="#1A1A1A" stroke-width="1.5" />
                                    </svg>
                                </button>
                            </div>
                            <button class="btn-reset news-content__filters_btn" id="filtersToggle">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 6L13 6" stroke="#1A1A1A" stroke-width="1.5" />
                                    <path d="M17 14L7 14" stroke="#1A1A1A" stroke-width="1.5" />
                                    <circle cx="5" cy="14" r="2.25" stroke="#1A1A1A" stroke-width="1.5" />
                                    <circle cx="15" cy="6" r="2.25" stroke="#1A1A1A" stroke-width="1.5" />
                                </svg>
                                Фильтры
                            </button>
                        </div>
                        <div class="filters" id="filtersPanel" style="display: none;">
                            <form id="newsFilterForm">
                                <div class="filter-item filters--sort">
                                    <span class="filter-item__title">Сортировка</span>
                                    <div class="dropdown">
                                        <button type="button" class="dropdown__button" data-name="sort">
                                            @if($currentSort == 'published_at_desc') По дате (новые)
                                            @elseif($currentSort == 'published_at_asc') По дате (старые)
                                            @elseif($currentSort == 'views_desc') По просмотрам (убыв.)
                                            @elseif($currentSort == 'views_asc') По просмотрам (возр.)
                                            @endif
                                        </button>
                                        <ul class="dropdown__list">
                                            <li class="dropdown__list-item" data-value="published_at_desc">По дате (новые)</li>
                                            <li class="dropdown__list-item" data-value="published_at_asc">По дате (старые)</li>
                                            <li class="dropdown__list-item" data-value="views_desc">По просмотрам (убыв.)</li>
                                            <li class="dropdown__list-item" data-value="views_asc">По просмотрам (возр.)</li>
                                        </ul>
                                        <input type="hidden" name="sort" value="{{ $currentSort }}" class="dropdown__input_hidden">
                                    </div>
                                </div>
                                <div class="filter-item filters--time">
                                    <span class="filter-item__title">Период</span>
                                    <div class="dropdown">
                                        <button type="button" class="dropdown__button" data-name="period">
                                            @if($currentPeriod == 'all') Весь период
                                            @elseif($currentPeriod == 'week') Последняя неделя
                                            @elseif($currentPeriod == 'month') Последний месяц
                                            @elseif($currentPeriod == 'year') Последний год
                                            @endif
                                        </button>
                                        <ul class="dropdown__list">
                                            <li class="dropdown__list-item" data-value="all">Весь период</li>
                                            <li class="dropdown__list-item" data-value="week">Последняя неделя</li>
                                            <li class="dropdown__list-item" data-value="month">Последний месяц</li>
                                            <li class="dropdown__list-item" data-value="year">Последний год</li>
                                        </ul>
                                        <input type="hidden" name="period" value="{{ $currentPeriod }}" class="dropdown__input_hidden">
                                    </div>
                                </div>
                                <div class="filter-item filters--content">
                                    <span class="filter-item__title">Контент</span>
                                    <div class="dropdown">
                                        <button type="button" class="dropdown__button" data-name="content">
                                            @if($currentContent == 'all') Весь контент
                                            @else {{ $currentContent }}
                                            @endif
                                        </button>
                                        <ul class="dropdown__list">
                                            <li class="dropdown__list-item" data-value="all">Весь контент</li>
                                            <li class="dropdown__list-item" data-value="article">Статьи</li>
                                            <li class="dropdown__list-item" data-value="video">Видео</li>
                                            <li class="dropdown__list-item" data-value="news">Новости</li>
                                        </ul>
                                        <input type="hidden" name="content" value="{{ $currentContent }}" class="dropdown__input_hidden">
                                    </div>
                                </div>
                                <button type="submit" class="btn-reset filters__apply-btn">Применить</button>
                            </form>
                        </div>
                    </div>
                    <div class="news-content__bottom">
                        <div class="news-content__left">
                            <div class="news-content__news-block">
                                <ul class="list-reset news-block__list news-block__list--second" id="newsList">
                                    @if(isset($mainPost))
                                        <li class="news-item news-item--second main-news-item" data-category="society">
                                            <a href="{{ route('news.show', $mainPost->id) }}">
                                                <div class="news-item__media">
                                                    <img src="{{ asset('storage/public/' . $mainPost->preview) }}" alt="{{ $mainPost->title }}">
                                                    @if($mainPost->type === 'video')
                                                        <button class="btn-reset news-item--media__btn">
                                                            <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z" fill="white" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                            </a>
                                            <div class="news-item__bottom">
                                                <h6 class="news-item__title">
                                                    <a href="{{ route('news.show', $mainPost->id) }}">{{ $mainPost->title }}</a>
                                                </h6>
                                                <div class="news-item__descr">
                                                    <p>{{ $mainPost->lead }}</p>
                                                </div>
                                                <div class="news-item__info">
                                                    <time datetime="{{ $mainPost->formated_published_at }}" class="news-item_time">
                                                        {{ $mainPost->formated_published_at }}
                                                    </time>
                                                    <div class="news-item_views">
                                                        <div class="item-views__icon">
                                                            <svg width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z" />
                                                            </svg>
                                                        </div>
                                                        <span>{{ $mainPost->views ?? 0 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                    @foreach($news as $post)
                                        <li class="news-item news-item--second @if($post->type === 'video') news-item--media @endif" data-category="{{ $post->category ?? 'general' }}">
                                            <a href="{{ route('news.show', $post->id) }}">
                                                <div class="news-item__media">
                                                    <img src="{{ asset('storage/public/' . $post->preview) }}" alt="{{ $post->title }}">
                                                    @if($post->type === 'video')
                                                        <button class="btn-reset news-item--media__btn">
                                                            <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z" fill="white" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                            </a>
                                            <div class="news-item__bottom">
                                                <h6 class="news-item__title">
                                                    <a href="{{ route('news.show', $post->id) }}">{{ $post->title }}</a>
                                                </h6>
                                                <div class="news-item__descr">
                                                    <p>{{ $post->lead }}</p>
                                                </div>
                                                <div class="news-item__info">
                                                    <time datetime="{{ $post->formated_published_at }}" class="news-item_time">
                                                        {{ $post->pformated_published_at }}
                                                    </time>
                                                    <div class="news-item_views">
                                                        <div class="item-views__icon">
                                                            <svg width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z" />
                                                            </svg>
                                                        </div>
                                                        <span>{{ $post->views ?? 0 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div id="loadingIndicator" style="display: none; text-align: center; padding: 20px;">
                                Загрузка...
                            </div>
                        </div>
                        <div class="news-content__right">
                            <!-- Правая колонка (реклама и популярное) -->
                            <div class="ads-block">
                                <img src="{{ asset('assets/add.jpg') }}" alt="add">
                            </div>
                            <div class="content__popular popular-sidebar popular-sidebar--news">
                                <h3 class="popular-sidebar__title">Популярное</h3>
                                <ul class="list-reset popular-sidebar__list">
                                    <!-- Популярные новости -->
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
            let currentPage = 1;
            let isLoading = false;
            let hasMore = true;
            let currentFilters = {
                sort: '{{ $currentSort }}',
                period: '{{ $currentPeriod }}',
                content: '{{ $currentContent }}'
            };

            // Вечная подгрузка при скролле
            window.addEventListener('scroll', function() {
                if (isLoading || !hasMore) return;

                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                // Сброс при поднятии наверх
                if (scrollTop < 100) {
                    resetToFirstPage();
                    return;
                }

                // Проверка достижения низа страницы
                if (window.innerHeight + scrollTop >= document.documentElement.scrollHeight - 100) {
                    loadMoreNews();
                }
            });

            // Загрузка дополнительных новостей
            function loadMoreNews() {
                if (isLoading || !hasMore) return;

                isLoading = true;
                currentPage++;

                document.getElementById('loadingIndicator').style.display = 'block';

                fetch(`/news?page=${currentPage}&${new URLSearchParams(currentFilters)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.html) {
                            document.getElementById('newsList').insertAdjacentHTML('beforeend', data.html);
                        }
                        hasMore = data.hasMore;
                        isLoading = false;
                        document.getElementById('loadingIndicator').style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Error loading news:', error);
                        isLoading = false;
                        document.getElementById('loadingIndicator').style.display = 'none';
                        currentPage--;
                    });
            }

            // Сброс к первой странице
            function resetToFirstPage() {
                currentPage = 1;
                hasMore = true;

                // Обновляем список новостей
                fetch(`/news?page=1&${new URLSearchParams(currentFilters)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.html) {
                            document.getElementById('newsList').innerHTML = data.html;
                        }
                        hasMore = data.hasMore;
                    })
                    .catch(error => {
                        console.error('Error resetting news:', error);
                    });
            }

            // Переключение фильтров
            document.getElementById('filtersToggle').addEventListener('click', function() {
                const filtersPanel = document.getElementById('filtersPanel');
                filtersPanel.style.display = filtersPanel.style.display === 'none' ? 'block' : 'none';
            });

            // Обработка формы фильтров
            document.getElementById('newsFilterForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                currentFilters = {
                    sort: formData.get('sort'),
                    period: formData.get('period'),
                    content: formData.get('content')
                };

                // Сбрасываем пагинацию и загружаем с новыми фильтрами
                currentPage = 0;
                hasMore = true;
                loadMoreNews();

                // Скрываем панель фильтров
                document.getElementById('filtersPanel').style.display = 'none';
            });

            // Инициализация dropdown
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                const button = dropdown.querySelector('.dropdown__button');
                const list = dropdown.querySelector('.dropdown__list');
                const input = dropdown.querySelector('.dropdown__input_hidden');
                const items = dropdown.querySelectorAll('.dropdown__list-item');

                button.addEventListener('click', function() {
                    list.style.display = list.style.display === 'block' ? 'none' : 'block';
                });

                items.forEach(item => {
                    item.addEventListener('click', function() {
                        input.value = this.getAttribute('data-value');
                        button.textContent = this.textContent;
                        list.style.display = 'none';
                    });
                });

                document.addEventListener('click', function(e) {
                    if (!dropdown.contains(e.target)) {
                        list.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush
