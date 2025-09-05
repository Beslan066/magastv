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
                    </div>
                    <div class="news-content__bottom">
                        <div class="news-content__left">
                            <div class="news-content__news-block">
                                <ul class="list-reset news-block__list news-block__list--second" id="newsList">
                                    @if(isset($mainPost))
                                        <li class="news-item news-item--second main-news-item" data-category="society" id="mainNewsItem">
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
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                        @foreach($tidings as $tiding)
                                            <li class="news-item news-item--second @if($tiding->type === 'video') news-item--media @endif" data-category="{{ $tiding->category ?? 'general' }}">
                                                <a href="{{ route('news.show', $tiding->id) }}">
                                                    <div class="news-item__media">
                                                        <img src="{{ asset('storage/public/' . $tiding->preview) }}" alt="{{ $tiding->title }}">
                                                        @if($tiding->type === 'video')
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
                                                        <a href="{{ route('news.show', $tiding->id) }}">{{ $tiding->title }}</a>
                                                    </h6>
                                                    <div class="news-item__descr">
                                                        <p>{{ $tiding->lead }}</p>
                                                    </div>
                                                    <div class="news-item__info">
                                                        <time datetime="{{ $tiding->formated_published_at }}" class="news-item_time">
                                                            {{ $tiding->formated_published_at }}
                                                        </time>
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
{{--                                <img src="{{ asset('assets/add.jpg') }}" alt="add">--}}
                            </div>
                            <div class="content__popular popular-sidebar popular-sidebar--news">
                                <h3 class="popular-sidebar__title">Популярное</h3>
                                <ul class="list-reset popular-sidebar__list">
                                    @if(isset($popularItems))
                                        @foreach($popularItems as $item)
                                            <li class="popular-sidebar__item">
                                                <a href="{{route('home.news.single', $item->slug)}}" class="popular-sidebar__item_text">
                                                    {{$item->title}}
                                                </a>
                                                <div class="popular-sidebar__item_info">
                                                    <time datetime="{{$item->formated_published_at}}" class="popular-sidebar__item_time">
                                                        {{$item->formated_published_at}}
                                                    </time>
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
            let currentPage = 1;
            let isLoading = false;
            let hasMore = true;
            let currentFilters = {
                sort: '{{ $currentSort }}',
                period: '{{ $currentPeriod }}',
                content: '{{ $currentContent }}'
            };

            // Сохраняем исходный HTML главного поста
            const mainNewsItem = document.querySelector('.main-news-item');
            const mainNewsItemHtml = mainNewsItem ? mainNewsItem.outerHTML : '';

            // Вечная подгрузка при скролле
            window.addEventListener('scroll', function() {
                if (isLoading || !hasMore) return;

                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                // Сброс при поднятии наверх (только если мы действительно вверху)
                if (scrollTop < 100) {
                    // Не сбрасываем полностью, а просто позволяем загрузить с начала
                    if (currentPage > 1) {
                        resetToFirstPage();
                    }
                    return;
                }

                // Проверка достижения низа страницы
                if (window.innerHeight + scrollTop >= document.documentElement.scrollHeight - 100) {
                    loadMoreTidings();
                }
            });

            // Загрузка дополнительных tidings
            function loadMoreTidings() {
                if (isLoading || !hasMore) return;

                isLoading = true;
                currentPage++;

                document.getElementById('loadingIndicator').style.display = 'block';

                fetch(`/news-inh?page=${currentPage}&${new URLSearchParams(currentFilters)}`, {
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
                        console.error('Error loading tidings:', error);
                        isLoading = false;
                        document.getElementById('loadingIndicator').style.display = 'none';
                        currentPage--;
                    });
            }

            // Сброс к первой странице (только обычные новости, главная остается)
            function resetToFirstPage() {
                isLoading = true;
                currentPage = 1;
                hasMore = true;

                // Сохраняем главный пост
                const newsList = document.getElementById('newsList');
                const mainItem = newsList.querySelector('.main-news-item');

                // Обновляем только обычные новости
                fetch(`/news-inh?page=1&${new URLSearchParams(currentFilters)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.html) {
                            // Удаляем все обычные новости, оставляя только главную
                            const regularItems = newsList.querySelectorAll('.news-item:not(.main-news-item)');
                            regularItems.forEach(item => item.remove());

                            // Добавляем первую страницу обычных новостей
                            newsList.insertAdjacentHTML('beforeend', data.html);
                        }
                        hasMore = data.hasMore;
                        isLoading = false;
                    })
                    .catch(error => {
                        console.error('Error resetting tidings:', error);
                        isLoading = false;
                    });
            }

            // Обработка формы фильтров
            document.getElementById('newsFilterForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                currentFilters = {
                    sort: formData.get('sort'),
                    period: formData.get('period'),
                    content: formData.get('content')
                };

                // Полный сброс с фильтрами
                currentPage = 0;
                hasMore = true;

                // Полностью перезагружаем список
                reloadAllTidings();

                // Скрываем панель фильтров
                document.getElementById('filtersPanel').style.display = 'none';
            });

            // Полная перезагрузка всех tidings
            function reloadAllTidings() {
                isLoading = true;
                document.getElementById('loadingIndicator').style.display = 'block';

                const newsList = document.getElementById('newsList');

                fetch(`/news-inh?page=1&${new URLSearchParams(currentFilters)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.html) {
                            // Полностью заменяем содержимое, но сохраняем структуру
                            newsList.innerHTML = mainNewsItemHtml + data.html;
                        }
                        hasMore = data.hasMore;
                        isLoading = false;
                        document.getElementById('loadingIndicator').style.display = 'none';
                        currentPage = 1;
                    })
                    .catch(error => {
                        console.error('Error reloading tidings:', error);
                        isLoading = false;
                        document.getElementById('loadingIndicator').style.display = 'none';
                    });
            }
        });
    </script>
@endpush
