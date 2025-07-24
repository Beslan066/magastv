@extends('layouts.frontend')

@section('content')
    <main class="main" data-main>
        <section class="news">
            <div class="container">
                <div class="news__inner">
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
                    <div class="news__main">
                        <div class="news__grid">
                            <div class="news-block">
                                <ul class="list-reset news-block__list" id="news-items-container">
                                    @if(isset($mainPost))
                                        <li class="news-item main-news-item" data-static="true">
                                            <a href="{{route('home.news.single', $mainPost->slug)}}">
                                                <div class="news-item__media">
                                                    <img src="{{asset('storage/public/' . $mainPost->image)}}"
                                                         alt="{{$mainPost->title}}">
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
                                                        <a href="{{route('home.news.single', $mainPost->slug)}}">{{$mainPost->title}}</a>
                                                    </h6>

                                                <div class="news-item__descr">
                                                    <p>{{$mainPost->lead}}</p>
                                                </div>
                                                <div class="news-item__info">
                                                    <time datetime="2025-04-1 18:35" class="news-item_time">
                                                        {{$mainPost->formatted_published_at}}
                                                    </time>
                                                    <div class="news-item_views">
                                                        <div class="item-views__icon">

                                                            <svg width="14" height="10" viewBox="0 0 14 10" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z"></path>
                                                            </svg>
                                                        </div>
                                                        <span>{{$mainPost->views}}</span>
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
                            </div>


                            <div class="content__popular popular-sidebar">
                                <h3 class="popular-sidebar__title">Популярное</h3>
                                <ul class="list-reset popular-sidebar__list">
                                    @if(isset($popularItems))
                                        @foreach($popularItems as $item)
                                            <li class="popular-sidebar__item">
                                                <a href="#" class="popular-sidebar__item_text">
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
                <!-- Slider main container -->
                <div
                    class="swiper programs__slider swiper-initialized swiper-horizontal swiper-ios swiper-backface-hidden">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper" id="swiper-wrapper-5ff3ee537489f80b" aria-live="polite">
                        <!-- Slides -->
                        @if(isset($transfers))
                            @foreach($transfers as $transfer)
                                <div class="swiper-slide programs-slide swiper-slide-active"
                                     style="background-image: url({{asset('storage/public/' . $transfer->slider_image)}}); width: 430px;"
                                     role="group" aria-label="1 / 3" data-swiper-slide-index="0">
                                    <div class="programs-slide__inner">
                                        <div class="programs-slide__mobile-image">
                                            <img src="{{asset('storage/public/' . $transfer->slider_image)}}"
                                                 alt="Slide image">
                                        </div>
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
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
            </div>

        </section>
        <section class="main-transfers">
            <div class="container">
                <div class="main-transfers__inner">
                    <div class="main-transfers__header">
                        <h2 class="main-transfers__title">Наши передачи</h2>
                        <a href="{{route('transfers')}}" class="main-transfers__all">Все передачи</a>
                    </div>
                    <div class="main-transfers__body">
                        <ul class="list-reset main-transfers__list">
                            @foreach($allTransfers as $transfer)
                                <li class="transferItem transferItem--index">
                                    <div class="transferItem_media">
                                        <img src="{{asset('storage/public/' . $transfer->image)}}"
                                             alt="{{$transfer->title}}">
                                    </div>
                                    <div class="transferItem__info">

                                        <h6 class="transferItem_title">
                                            <a href="{{route('transfer', $transfer->id)}}">{{$transfer->title}}</a>
                                        </h6>
                                        <span class="transferItem_count">24 выпуска</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="{{route('transfers')}}" class="main-transfers__all main-transfers__all--mobile">Все
                        передачи</a>
                </div>
            </div>
        </section>
        <section class="popular">
            <div class="container">
                <div class="popular__inner">
                    <h2 class="popular__title">
                        Часто смотрят
                    </h2>
                    <div class="popular__content">
                        @if(isset($popularVideos))
                            @foreach($popularVideos as $video)
                                <div class="popular-item">
                                    <div class="popular-item__media">
                                        <video src="{{asset('storage/public/' . $video->video)}}"
                                               poster="{{asset('storage/public/' . $video->preview)}}"
                                               class="popular-item__media_video-tag"></video>
                                        <button class="btn-reset play-btn popular-item__media_btn play-btn--small">
                                            <svg width="15" height="16" viewBox="0 0 15 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg" class="popular-item__media_svg">
                                                <path
                                                    d="M13.92 6.1398C15.2533 6.9096 15.2533 8.8341 13.92 9.6039L3.92999 15.3716C2.59666 16.1414 0.929998 15.1792 0.929998 13.6396L0.929998 2.10411C0.929998 0.564513 2.59667 -0.397735 3.93 0.372065L13.92 6.1398Z"
                                                    fill="#70E780"></path>
                                            </svg>
                                        </button>
                                        <div class="popular-item__media_timeline">0:32</div>
                                        <div class="video-navigation hidden popular-item__video-navigation">
                                            <div
                                                class="video-navigation__progress noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr">
                                                <div class="noUi-base">
                                                    <div class="noUi-connects">
                                                        <div class="noUi-connect"
                                                             style="transform: translate(0%, 0px) scale(0, 1);"></div>
                                                    </div>
                                                    <div class="noUi-origin"
                                                         style="transform: translate(-100%, 0px); z-index: 4;">
                                                        <div class="noUi-handle noUi-handle-lower" data-handle="0"
                                                             tabindex="0" role="slider" aria-orientation="horizontal"
                                                             aria-valuemin="0.0" aria-valuemax="100.0"
                                                             aria-valuenow="0.0" aria-valuetext="0">
                                                            <div class="noUi-touch-area"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="video-navigation__controls">
                                                <div class="video-navigation__controls_left">

                                                    <button class="btn-reset video-navigation__btn">
                                                        <svg class="video-navigation__btn_svg--play" width="12"
                                                             height="14" viewBox="0 0 12 14" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M11.3648 6.11953L1.4741 0.793746C0.807869 0.435006 0 0.917542 0 1.67422V12.3258C0 13.0825 0.807868 13.565 1.4741 13.2063L11.3648 7.88047C12.066 7.5029 12.066 6.4971 11.3648 6.11953Z"></path>
                                                        </svg>
                                                        <svg class="video-navigation__btn_svg--pause" width="24"
                                                             height="24" viewBox="0 0 24 24" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="6" y="4" width="4" height="16" rx="1"></rect>
                                                            <rect x="14" y="4" width="4" height="16" rx="1"></rect>
                                                        </svg>
                                                    </button>
                                                    <div class="video-navigation__volume">
                                                        <button class="btn-reset video-navigation__sound_btn muted">
                                                            <svg class="video-navigation__sound_btn-unmute_svg"
                                                                 width="18" height="16" viewBox="0 0 18 16" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                      d="M7.32429 0.536043L3 4.4998V4.49994H1C0.447715 4.49994 0 4.94765 0 5.49994V10.4999C0 11.0522 0.447715 11.4999 1 11.4999H3V11.4998L7.32426 15.4639C7.96566 16.0519 9 15.5969 9 14.7267V1.27321C9 0.403119 7.9657 -0.0518867 7.32429 0.536043ZM11 5C12.6569 5 14 6.34315 14 8C14 9.65685 12.6569 11 11 11V5ZM11 3C13.7614 3 16 5.23858 16 8C16 10.7614 13.7614 13 11 13V15C14.866 15 18 11.866 18 8C18 4.13401 14.866 1 11 1V3Z"></path>
                                                            </svg>
                                                            <svg class="video-navigation__sound_btn-mute_svg" width="19"
                                                                 height="16" viewBox="0 0 19 16" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                      d="M7.32429 0.536043L3 4.4998V4.49994H1C0.447715 4.49994 0 4.94765 0 5.49994V10.4999C0 11.0522 0.447715 11.4999 1 11.4999H3V11.4998L7.32426 15.4639C7.96566 16.0519 9 15.5969 9 14.7267V1.27321C9 0.403119 7.9657 -0.0518867 7.32429 0.536043ZM17.293 4.29297C17.6835 3.90244 18.3165 3.90244 18.707 4.29297C19.0976 4.68349 19.0976 5.31651 18.707 5.70703L16.4141 8L18.707 10.293C19.0976 10.6835 19.0976 11.3165 18.707 11.707C18.3165 12.0976 17.6835 12.0976 17.293 11.707L15 9.41406L12.707 11.707C12.3165 12.0976 11.6835 12.0976 11.293 11.707C10.9024 11.3165 10.9024 10.6835 11.293 10.293L13.5859 8L11.293 5.70703C10.9024 5.31651 10.9024 4.68349 11.293 4.29297C11.6835 3.90244 12.3165 3.90244 12.707 4.29297L15 6.58594L17.293 4.29297Z"></path>
                                                            </svg>
                                                        </button>
                                                        <input type="range" class="video-navigation__range-input">
                                                        <div
                                                            class="video-navigation__slider-styled noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr"
                                                            data-id="video-navigation__slider-round">
                                                            <div class="noUi-base">
                                                                <div class="noUi-connects">
                                                                    <div class="noUi-connect"
                                                                         style="transform: translate(0%, 0px) scale(0, 1);"></div>
                                                                </div>
                                                                <div class="noUi-origin"
                                                                     style="transform: translate(-100%, 0px); z-index: 4;">
                                                                    <div class="noUi-handle noUi-handle-lower"
                                                                         data-handle="0" tabindex="0" role="slider"
                                                                         aria-orientation="horizontal"
                                                                         aria-valuemin="0.0" aria-valuemax="1.0"
                                                                         aria-valuenow="0.0" aria-valuetext="0.00">
                                                                        <div class="noUi-touch-area"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="video-navigation__timeline">
                                                        <div class="video-navigation__timeline_current">
                                                            <!-- <span>01</span>
                                                            :
                                                            <span>46</span> -->
                                                        </div>
                                                        /
                                                        <div class="video-navigation__timeline_duration">0:32</div>
                                                    </div>
                                                </div>
                                                <button class="btn-reset video-navigation__fullscreen">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12 1H15C16.1046 1 17 1.89543 17 3V6M6 1H3C1.89543 1 1 1.89543 1 3V6M1 12V15C1 16.1046 1.89543 17 3 17H6M12 17H15C16.1046 17 17 16.1046 17 15V12"
                                                            stroke="#F2F2F2" stroke-width="2"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="popular-item__info">
                                        <h6 class="popular-item__title">
                                            <a href="{{route('transfer', $video->transfer_id)}}">
                                                {{$video->title}}
                                            </a>
                                        </h6>
                                        <time datetime="2025-03-21 21:34" class="popular-item__time">
                                            {{$video->formated_published_at}}
                                        </time>
                                    </div>
                                </div>
                            @endforeach
                        @endif
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
                button.addEventListener('click', function() {
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

                video.addEventListener('click', function() {
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

                video.addEventListener('ended', function() {
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
@endpush
