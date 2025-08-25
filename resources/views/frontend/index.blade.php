@extends('layouts.frontend')

@push('styles')
    <style>
        .programs-slide {
            position: relative;
            overflow: hidden;
        }

        .programs-slide__video,
        .programs-slide__image-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }

        .programs-slide__video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
        }

        .programs-slide__inner {
            position: relative;
            z-index: 3;
        }

        /* Для мобильного изображения */
        .programs-slide__mobile-image video,
        .programs-slide__mobile-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        transferItem_media {
            position: relative;
            overflow: hidden;
        }

        .transferItem__video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .transferItem__image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s ease;
        }

        /* При наведении скрываем изображение и показываем видео */
        .transferItem:hover .transferItem__video {
            opacity: 1;
        }

        .transferItem:hover .transferItem__image {
            opacity: 0;
        }
    </style>
@endpush

@section('content')
    <main class="main" data-main>
        <section class="news">
            <div class="container">
                <div class="news__inner">
                    <div class="tabs-container">
                        <button class="tab-arrow tab-arrow-prev" aria-label="Предыдущие категории">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <div class="tabs">
                            <ul class="list-reset tabs__list">
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
                    </div>
                    <div class="news__main">
                        <div class="news__grid">
                            <div class="news-block">
                                <ul class="list-reset news-block__list" id="news-items-container">
                                    @if(isset($mainPost))
                                        <li class="news-item main-news-item" data-static="true">
                                            <a href="{{ $mainPost->type === 'news' ? route('home.news.single', $mainPost->slug) : route('home.news.single', $mainPost->slug) }}">
                                                <div class="news-item__media">
                                                    <img src="{{ asset('storage/public/' . ($mainPost->type === 'news' ? $mainPost->media : $mainPost->media)) }}"
                                                         alt="{{ $mainPost->title }}">
                                                    @if($mainPost->type === 'video')
                                                        <button class="btn-reset news-item--media__btn">
                                                            <svg width="10" height="12" viewBox="0 0 10 12" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z"
                                                                    fill="white"></path>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                            </a>
                                            <div class="news-item__bottom">
                                                <h6 class="news-item__title">
                                                    <a href="{{ $mainPost->type === 'news' ? route('home.news.single', $mainPost->slug) : route('home.news.single', $mainPost->slug) }}">
                                                        {{ $mainPost->title }}
                                                    </a>
                                                </h6>

                                                <div class="news-item__descr">
                                                    <p>{{ $mainPost->lead }}</p>
                                                </div>
                                                <div class="news-item__info">
                                                    <time datetime="{{ $mainPost->published_at }}" class="news-item_time">
                                                        {{ $mainPost->formatted_published_at ?? $mainPost->published_at->format('d.m.Y H:i') }}
                                                    </time>
                                                    <div class="news-item_views">
                                                        <div class="item-views__icon">
                                                            <svg width="14" height="10" viewBox="0 0 14 10" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z"></path>
                                                            </svg>
                                                        </div>
                                                        <span>{{ $mainPost->views }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if(isset($items))
                                        @foreach($items as $item)
                                            <li class="news-item @if($item->type === 'video') news-item--media @endif">
                                                <a href="{{route('home.news.single', $item->slug)}}">
                                                    <div class="news-item__media">
                                                        <img src="{{asset('storage/public/' . $item->media)}}"
                                                             alt="{{$item->title}}">
                                                        <button class="btn-reset news-item--media__btn">
                                                            <svg width="10" height="12" viewBox="0 0 10 12" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z"
                                                                    fill="white"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </a>
                                                <div class="news-item__bottom">
                                                    <h6 class="news-item__title">
                                                        <a href="{{route('home.news.single', $item->slug)}}">{{$item->title}}</a>
                                                    </h6>
                                                    <div class="news-item__descr">
                                                        <p>{{$item->lead}}</p>
                                                    </div>
                                                    <div class="news-item__info">
                                                        <time datetime="2025-04-1 18:35" class="news-item_time">
                                                            {{$item->formatted_published_at}}
                                                        </time>
                                                        <div class="news-item_views">
                                                            <div class="item-views__icon">

                                                                <svg width="14" height="10" viewBox="0 0 14 10"
                                                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z"></path>
                                                                </svg>
                                                            </div>
                                                            <span>{{$item->views}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>

                                <div class="all-news-link">
                                    <a href="{{route('home.news.index')}}" class="main-transfers__all">Все
                                        новости</a>
                                </div>
                            </div>

                            <div class="content__popular popular-sidebar">
                                <h3 class="popular-sidebar__title">Популярное</h3>
                                <ul class="list-reset popular-sidebar__list">
                                    @if(isset($popularItems))
                                        @foreach($popularItems as $item)
                                            <li class="popular-sidebar__item">
                                                <a href="{{route('home.news.single', $item->slug)}}"
                                                   class="popular-sidebar__item_text">
                                                    {{$item->title}}
                                                </a>
                                                <div class="popular-sidebar__item_info">
                                                    <time datetime="2024-09-19 21:34"
                                                          class="popular-sidebar__item_time">
                                                        {{$item->formatted_published_at}}
                                                    </time>
                                                    <div class="popular-sidebar__item_views">
                                                        <div class="item-views__icon">
                                                            <img src="{{asset('assets/img/views1.svg')}}"
                                                                 alt="Eye icon">
                                                        </div>
                                                        <span>{{$item->views}}</span>
                                                    </div>
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
        <section class="programs">
            <div class="programs__inner">
                <div
                    class="swiper programs__slider swiper-initialized swiper-horizontal swiper-ios swiper-backface-hidden">
                    <div class="swiper-wrapper" id="swiper-wrapper-5ff3ee537489f80b" aria-live="polite">
                        @if(isset($transfers))
                            @foreach($transfers as $transfer)
                                <div class="swiper-slide programs-slide swiper-slide-active"
                                     style="width: 430px;"
                                     role="group" aria-label="1 / 3" data-swiper-slide-index="0">

                                    <!-- Видео вместо фонового изображения -->
                                    @if(!empty($transfer->slider_video))
                                        <video class="programs-slide__video" autoplay muted loop playsinline>
                                            <source src="{{asset('storage/public/' . $transfer->slider_video)}}"
                                                    type="video/mp4">
                                        </video>
                                        <div class="programs-slide__video-overlay"
                                             style="background: rgba(0,0,0,0.3);"></div>
                                    @else
                                        <div class="programs-slide__image-background"
                                             style="background:  url({{asset('storage/public/' . $transfer->slider_image) }}) no-repeat center;"></div>
                                    @endif

                                    <div class="programs-slide__inner">

                                        <div class="container programs-slide__container">
                                            <div class="programs-slide__info">
                                                <div class="programs-slide__schedule">
                                                    <span>{{$transfer->published}}</span>
                                                </div>
                                                <div class="programs-slide__text">
                                                    <h2 class="programs-slide__title">
                                                        {{$transfer->title}}
                                                    </h2>
                                                    <p class="programs-slide__paragraph">
                                                        {{$transfer->lead}}
                                                    </p>
                                                </div>
                                                <div class="programs-slide__btns">
                                                    <a href="{{route('transfer', $transfer->id)}}"
                                                       class="btn-reset programs-slide__btn programs-slide__btn--primary">
                                                        Подробнее
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="slider-nav-wrapper">
                        <div class="container">
                            <div class="slider-navigation">
                                <button class="btn-reset slider-btn slider-btn--prev" tabindex="0"
                                        aria-label="Previous slide" aria-controls="swiper-wrapper-5ff3ee537489f80b">
                                    <svg width="12" height="20" viewBox="0 0 12 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.25 1L2.25 10L11.25 19" stroke="#BDBDBD" stroke-width="2"></path>
                                    </svg>
                                </button>
                                <div class="swiper-pagination swiper-pagination-fraction swiper-pagination-horizontal">
                                    <span class="swiper-pagination-current">1</span> / <span
                                        class="swiper-pagination-total">3</span></div>
                                <button class="btn-reset slider-btn slider-btn--next" tabindex="0"
                                        aria-label="Next slide" aria-controls="swiper-wrapper-5ff3ee537489f80b">
                                    <svg width="12" height="20" viewBox="0 0 12 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.25 1L10.25 10L1.25 19" stroke="#BDBDBD" stroke-width="2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                </div>
            </div>
        </section>
        <section class="main-transfers">
            <div class="container">
                <div class="main-transfers__inner">
                    <div class="main-transfers__header">
                        <h2 class="main-transfers__title">Телепроекты</h2>
                        <a href="{{route('transfers')}}" class="main-transfers__all">Все телепроекты</a>
                    </div>
                    <div class="main-transfers__body">
                        <ul class="list-reset main-transfers__list">
                            @foreach($allTransfers as $transfer)
                                <li class="transferItem transferItem--index">
                                    <div class="transferItem_media">
                                        @if(isset($transfer->slider_video))
                                            <!-- Видео элемент (скрыт по умолчанию) -->
                                            <video class="transferItem__video" muted loop preload="metadata">
                                                <source src="{{asset('storage/public/' . $transfer->slider_video)}}"
                                                        type="video/mp4">
                                            </video>
                                            <!-- Изображение (показывается по умолчанию) -->
                                            <img class="transferItem__image"
                                                 src="{{asset('storage/public/' . $transfer->image)}}"
                                                 alt="{{$transfer->title}}">
                                        @else
                                            <img src="{{asset('storage/public/' . $transfer->image)}}"
                                                 alt="{{$transfer->title}}">
                                        @endif
                                    </div>
                                    <div class="transferItem__info">
                                        <h6 class="transferItem_title">
                                            <a href="{{route('transfer', $transfer->id)}}">{{$transfer->title}}
                                                @if(isset($transfer->age_restriction))
                                                    <span>{{$transfer->age_restriction->title}}</span>
                                                @endif
                                            </a>
                                        </h6>
                                        <span
                                            class="transferItem_count">Выпусков: {{$transfer->getVideosCountAttribute()}}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="{{route('transfers')}}" class="main-transfers__all main-transfers__all--mobile">Все
                        телепроекты</a>
                </div>
            </div>
        </section>

        <section class="popular">
            <div class="container">
                <div class="popular__inner">
                    <h2 class="popular__title">
                        Часто смотрят
                    </h2>
                    <div class="releases__content">
                        <div class="releases__items home-release-item">
                            @if(isset($popularVideos))
                                @foreach($popularVideos as $video)
                                    <div class="releases__items">
                                        {!! $video->video !!}
                                        {{--                                        <div class="popular-item__info">--}}
                                        {{--                                            <h6 class="popular-item__title">--}}
                                        {{--                                                <a href="{{route('transfer', $video->transfer_id)}}">--}}
                                        {{--                                                    {{$video->title}}--}}
                                        {{--                                                </a>--}}
                                        {{--                                            </h6>--}}
                                        {{--                                            <time datetime="{{$video->formated_created_at}}" class="popular-item__time">--}}
                                        {{--                                                {{$video->formated_created_at}}--}}
                                        {{--                                            </time>--}}
                                        {{--                                        </div>--}}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.tab');
            const newsContainer = document.getElementById('news-container');
            // Получаем все видео элементы на странице
            const videoElements = document.querySelectorAll('.popular-item__media_video-tag');
            const playButtons = document.querySelectorAll('.popular-item__media_btn');
            const videoNavigations = document.querySelectorAll('.video-navigation');

            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    // Удаляем активный класс у всех вкладок
                    tabs.forEach(t => t.classList.remove('active'));

                    // Добавляем активный класс текущей вкладке
                    this.classList.add('active');

                    // Получаем выбранную категорию
                    const categoryId = this.getAttribute('data-category');


                });
            });

            let currentPlayingVideo = null;

            function pauseOtherVideos(currentVideo) {
                videoElements.forEach(video => {
                    if (video !== currentVideo && !video.paused) {
                        video.pause();
                        const parentItem = video.closest('.popular-item');
                        const playBtn = parentItem.querySelector('.popular-item__media_btn');
                        const videoNav = parentItem.querySelector('.video-navigation');

                        // Показываем кнопку воспроизведения и скрываем контролы
                        playBtn.style.display = 'block'; // или '' чтобы вернуть исходное значение
                        videoNav.classList.add('hidden');
                    }
                });
            }

            playButtons.forEach((button, index) => {
                button.addEventListener('click', function () {
                    const video = videoElements[index];
                    const videoNav = videoNavigations[index];

                    if (video.paused) {
                        pauseOtherVideos(video);
                        video.play();
                        currentPlayingVideo = video;

                        // Скрываем кнопку воспроизведения и показываем контролы
                        this.style.display = 'none';
                        videoNav.classList.remove('hidden');
                    } else {
                        video.pause();
                        currentPlayingVideo = null;

                        // Показываем кнопку воспроизведения и скрываем контролы
                        this.style.display = 'block';
                        videoNav.classList.add('hidden');
                    }
                });
            });

            videoElements.forEach((video, index) => {
                const playBtn = playButtons[index];
                const videoNav = videoNavigations[index];

                video.addEventListener('click', function () {
                    if (this.paused) {
                        pauseOtherVideos(this);
                        this.play();
                        currentPlayingVideo = this;

                        playBtn.style.display = 'none';
                        videoNav.classList.remove('hidden');
                    } else {
                        this.pause();
                        currentPlayingVideo = null;

                        playBtn.style.display = 'block';
                        videoNav.classList.add('hidden');
                    }
                });

                video.addEventListener('ended', function () {
                    currentPlayingVideo = null;
                    playBtn.style.display = 'block';
                    videoNav.classList.add('hidden');
                });
            });
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.tab');
            const container = document.querySelector('#news-items-container');

            if (!container) {
                console.error('news-items-container not found');
                return;
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', async () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    const categoryId = tab.dataset.categoryId ?? 'all';

                    const mainPostElement = container.querySelector('[data-static="true"]');
                    const mainPostHTML = mainPostElement?.outerHTML || '';

                    try {
                        const response = await fetch(`/filter-news?category_id=${categoryId}`);
                        const data = await response.json();

                        if (data && data.html) {
                            // Если есть HTML с новостями - вставляем его
                            container.innerHTML = mainPostHTML + data.html;
                        } else {
                            // Если новостей нет - показываем сообщение
                            container.innerHTML = mainPostHTML +
                                `<li class="no-news-message" style="font-family: Golos Text, sans-serif; font-size: 16px;">Нет новостей по этой категории</li>`;
                        }
                    } catch (e) {
                        console.error('Ошибка при загрузке новостей:', e);
                        // В случае ошибки тоже показываем сообщение
                        container.innerHTML = mainPostHTML +
                            `<li class="no-news-message">Ошибка при загрузке новостей</li>`;
                    }
                });
            });


        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabsContainer = document.querySelector('.tabs');
            const tabsList = document.querySelector('.tabs__list');
            const prevBtn = document.querySelector('.tab-arrow-prev');
            const nextBtn = document.querySelector('.tab-arrow-next');

            // Скрываем стрелку "назад" по умолчанию
            prevBtn.style.display = 'none';

            function updateArrows() {
                // Проверяем, есть ли скролл
                const canScroll = tabsList.scrollWidth > tabsContainer.offsetWidth;

                if (!canScroll) {
                    prevBtn.style.display = 'none';
                    nextBtn.style.display = 'none';
                    return;
                }

                // Показываем обе стрелки, если контент не помещается
                nextBtn.style.display = 'flex';

                // Проверяем позицию скролла
                const isAtStart = tabsList.scrollLeft <= 0;
                const isAtEnd = tabsList.scrollLeft + tabsContainer.offsetWidth >= tabsList.scrollWidth - 1;

                prevBtn.style.display = isAtStart ? 'none' : 'flex';
                nextBtn.style.display = isAtEnd ? 'none' : 'flex';

                prevBtn.disabled = isAtStart;
                nextBtn.disabled = isAtEnd;
            }

            // Обработчики для стрелок
            prevBtn.addEventListener('click', () => {
                tabsList.scrollBy({left: -200, behavior: 'smooth'});
            });

            nextBtn.addEventListener('click', () => {
                tabsList.scrollBy({left: 200, behavior: 'smooth'});
            });

            // Обновляем стрелки при скролле
            tabsList.addEventListener('scroll', updateArrows);

            // И при изменении размера окна
            window.addEventListener('resize', updateArrows);

            // Инициализация
            updateArrows();
        });


        // Воспроизведение видео при наведении на передачи
        document.addEventListener('DOMContentLoaded', function() {
            // Функция для управления видео при наведении
            const videoItems = document.querySelectorAll('.transferItem');

            videoItems.forEach(item => {
                const video = item.querySelector('.transferItem__video');
                if (!video) return;

                item.addEventListener('mouseenter', function() {
                    video.play().catch(e => {
                        console.log('Автовоспроизведение заблокировано:', e);
                    });
                });

                item.addEventListener('mouseleave', function() {
                    video.pause();
                    video.currentTime = 0; // Сбрасываем видео в начало
                });
            });
        });

    </script>
@endpush
