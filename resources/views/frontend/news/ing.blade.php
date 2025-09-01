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
                                <img src="{{ asset('assets/add.jpg') }}" alt="add">
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
                    loadMoreTidings();
                }
            });

            // Загрузка дополнительных tidings
            function loadMoreTidings() {
                if (isLoading || !hasMore) return;

                isLoading = true;
                currentPage++;

                document.getElementById('loadingIndicator').style.display = 'block';

                // ИСПРАВЛЕННЫЙ URL - используем правильный роут news-inh
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

            // Сброс к первой странице
            function resetToFirstPage() {
                currentPage = 1;
                hasMore = true;

                // Обновляем список tidings
                fetch(`/news-inh?page=1&${new URLSearchParams(currentFilters)}`, {
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
                        console.error('Error resetting tidings:', error);
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
                loadMoreTidings();

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
