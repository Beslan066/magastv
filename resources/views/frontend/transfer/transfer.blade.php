@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/transfer.page.css')}}">
@endpush

@section('content')
    <main class="transfer__page" data-main>
        <section class="programs">
            <div class="programs__inner">
                <!-- Slider main container -->
                <div
                    class="swiper programs__slider swiper-initialized swiper-horizontal swiper-ios swiper-backface-hidden">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper" id="swiper-wrapper-5ff3ee537489f80b" aria-live="polite">
                        <!-- Slides -->
                        @if(isset($transfer))
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
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
            </div>

        </section>
        <section class="transfer-releases releases">
            <div class="container">
                <div class="releases__inner">
                    <h2 class="releases__title">
                        Выпуски передач
                    </h2>
                    <div class="releases__content">
                        @if($transferVideos)
                            <div class="releases__items">
                                @foreach($transferVideos as $video)
                                    <div class="popular-item releases-item" data-video-id="{{ $video->id }}">
                                        <div class="popular-item__media">
                                            <video src="{{asset('storage/public/' . $video->video)}}" poster="{{asset('storage/public/' . $video->preview)}}"
                                                   class="popular-item__media_video-tag"></video>
                                            <button class="btn-reset play-btn popular-item__media_btn play-btn--small">
                                                <svg width="15" height="16" viewBox="0 0 15 16" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg" class="popular-item__media_svg">
                                                    <path
                                                        d="M13.92 6.1398C15.2533 6.9096 15.2533 8.8341 13.92 9.6039L3.92999 15.3716C2.59666 16.1414 0.929998 15.1792 0.929998 13.6396L0.929998 2.10411C0.929998 0.564513 2.59667 -0.397735 3.93 0.372065L13.92 6.1398Z"
                                                        fill="#70E780" />
                                                </svg>
                                            </button>
                                            <div class="popular-item__media_timeline">

                                            </div>
                                            <div class="video-navigation hidden popular-item__video-navigation">
                                                <div class="video-navigation__progress"></div>
                                                <div class="video-navigation__controls">
                                                    <div class="video-navigation__controls_left">

                                                        <button class="btn-reset video-navigation__btn">
                                                            <svg class="video-navigation__btn_svg--play" width="12" height="14"
                                                                 viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M11.3648 6.11953L1.4741 0.793746C0.807869 0.435006 0 0.917542 0 1.67422V12.3258C0 13.0825 0.807868 13.565 1.4741 13.2063L11.3648 7.88047C12.066 7.5029 12.066 6.4971 11.3648 6.11953Z" />
                                                            </svg>
                                                            <svg class="video-navigation__btn_svg--pause" width="24" height="24"
                                                                 viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect x="6" y="4" width="4" height="16" rx="1" />
                                                                <rect x="14" y="4" width="4" height="16" rx="1" />
                                                            </svg>
                                                        </button>
                                                        <div class="video-navigation__volume">
                                                            <button class="btn-reset video-navigation__sound_btn">
                                                                <svg class="video-navigation__sound_btn-unmute_svg" width="18"
                                                                     height="16" viewBox="0 0 18 16" fill="none"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                          d="M7.32429 0.536043L3 4.4998V4.49994H1C0.447715 4.49994 0 4.94765 0 5.49994V10.4999C0 11.0522 0.447715 11.4999 1 11.4999H3V11.4998L7.32426 15.4639C7.96566 16.0519 9 15.5969 9 14.7267V1.27321C9 0.403119 7.9657 -0.0518867 7.32429 0.536043ZM11 5C12.6569 5 14 6.34315 14 8C14 9.65685 12.6569 11 11 11V5ZM11 3C13.7614 3 16 5.23858 16 8C16 10.7614 13.7614 13 11 13V15C14.866 15 18 11.866 18 8C18 4.13401 14.866 1 11 1V3Z" />
                                                                </svg>
                                                                <svg class="video-navigation__sound_btn-mute_svg" width="19"
                                                                     height="16" viewBox="0 0 19 16" fill="none"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                          d="M7.32429 0.536043L3 4.4998V4.49994H1C0.447715 4.49994 0 4.94765 0 5.49994V10.4999C0 11.0522 0.447715 11.4999 1 11.4999H3V11.4998L7.32426 15.4639C7.96566 16.0519 9 15.5969 9 14.7267V1.27321C9 0.403119 7.9657 -0.0518867 7.32429 0.536043ZM17.293 4.29297C17.6835 3.90244 18.3165 3.90244 18.707 4.29297C19.0976 4.68349 19.0976 5.31651 18.707 5.70703L16.4141 8L18.707 10.293C19.0976 10.6835 19.0976 11.3165 18.707 11.707C18.3165 12.0976 17.6835 12.0976 17.293 11.707L15 9.41406L12.707 11.707C12.3165 12.0976 11.6835 12.0976 11.293 11.707C10.9024 11.3165 10.9024 10.6835 11.293 10.293L13.5859 8L11.293 5.70703C10.9024 5.31651 10.9024 4.68349 11.293 4.29297C11.6835 3.90244 12.3165 3.90244 12.707 4.29297L15 6.58594L17.293 4.29297Z" />
                                                                </svg>
                                                            </button>
                                                            <input type="range" class="video-navigation__range-input">
                                                            <div class="video-navigation__slider-styled"
                                                                 data-id="video-navigation__slider-round"></div>
                                                        </div>
                                                        <div class="video-navigation__timeline">
                                                            <div class="video-navigation__timeline_current">
                                                                <!-- <span>01</span>
                                                                :
                                                                <span>46</span> -->
                                                            </div>
                                                            /
                                                            <div class="video-navigation__timeline_duration">
                                                                <!-- <span>04</span>
                                                                :
                                                                <span>35</span> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn-reset video-navigation__fullscreen">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M12 1H15C16.1046 1 17 1.89543 17 3V6M6 1H3C1.89543 1 1 1.89543 1 3V6M1 12V15C1 16.1046 1.89543 17 3 17H6M12 17H15C16.1046 17 17 16.1046 17 15V12"
                                                                stroke="#F2F2F2" stroke-width="2" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="popular-item__info">
                                            <h6 class="popular-item__title"><a href="#">{{$video->title}}</a></h6>
                                            <time datetime="2025-03-21 21:34" class="popular-item__time">21 мар, 21:34</time>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const videos = document.querySelectorAll('.popular-item__media_video-tag');

            videos.forEach(video => {
                // Проверяем, был ли уже учтён просмотр
                const videoId = video.closest('.popular-item').dataset.videoId;
                const storageKey = `video_view_${videoId}`;

                video.addEventListener('play', function() {
                    if (!localStorage.getItem(storageKey)) {
                        fetch(`/videos/${videoId}/view`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                        })
                            .then(response => response.json())
                            .then(data => {
                                localStorage.setItem(storageKey, 'viewed');
                                console.log('Просмотр учтён!', data);
                            });
                    }
                });
            });
        });
    </script>
@endpush
