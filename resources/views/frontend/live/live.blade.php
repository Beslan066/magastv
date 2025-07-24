@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/live.page.css')}}">
@endpush

@section('content')
    <main class="live-main" data-main>
        <section class="live">
            <div class="container">
                <div class="live__inner">
                    <h1 class="page-title">
                        Прямой эфир
                    </h1>
                    <div class="live-content">
                        <div class="live-content__left">
                            <div class="live__main-media">
                                <video class="live-video-tag" poster="./assets/img/liveimg.jpg" controls>
                                    <!-- Use an actual video file (MP4, HLS, etc.) -->
                                    <source src="https://public.mediacdn.ru/magas/" type="video/mp4">
                                    <!-- Fallback for older browsers -->
                                    Your browser does not support HTML5 video.
                                </video>
                                <div class="main-media__navigation-bar">
                                    <div class="navigation-bar__left">
                                        <button class="btn-reset main-media__play">
                                            <svg class="play-svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <rect x="6" y="4" width="4" height="16" rx="1" />
                                                <rect x="14" y="4" width="4" height="16" rx="1" />
                                            </svg>
                                            <svg class="pause-svg" width="12" height="14" viewBox="0 0 12 14"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.3648 6.11953L1.4741 0.793746C0.807869 0.435006 0 0.917542 0 1.67422V12.3258C0 13.0825 0.807868 13.565 1.4741 13.2063L11.3648 7.88047C12.066 7.5029 12.066 6.4971 11.3648 6.11953Z" />
                                            </svg>
                                        </button>
                                        <button class="btn-reset main-media__mute">
                                            <svg class="main-media__mute-svg" width="18" height="16" viewBox="0 0 18 16"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M7.32429 0.536043L3 4.4998V4.49994H1C0.447715 4.49994 0 4.94765 0 5.49994V10.4999C0 11.0522 0.447715 11.4999 1 11.4999H3V11.4998L7.32426 15.4639C7.96566 16.0519 9 15.5969 9 14.7267V1.27321C9 0.403119 7.9657 -0.0518867 7.32429 0.536043ZM11 5C12.6569 5 14 6.34315 14 8C14 9.65685 12.6569 11 11 11V5ZM11 3C13.7614 3 16 5.23858 16 8C16 10.7614 13.7614 13 11 13V15C14.866 15 18 11.866 18 8C18 4.13401 14.866 1 11 1V3Z">
                                                </path>
                                            </svg>
                                            <svg class="main-media__unmute-svg" width="19" height="16"
                                                 viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M7.32429 0.536043L3 4.4998V4.49994H1C0.447715 4.49994 0 4.94765 0 5.49994V10.4999C0 11.0522 0.447715 11.4999 1 11.4999H3V11.4998L7.32426 15.4639C7.96566 16.0519 9 15.5969 9 14.7267V1.27321C9 0.403119 7.9657 -0.0518867 7.32429 0.536043ZM17.293 4.29297C17.6835 3.90244 18.3165 3.90244 18.707 4.29297C19.0976 4.68349 19.0976 5.31651 18.707 5.70703L16.4141 8L18.707 10.293C19.0976 10.6835 19.0976 11.3165 18.707 11.707C18.3165 12.0976 17.6835 12.0976 17.293 11.707L15 9.41406L12.707 11.707C12.3165 12.0976 11.6835 12.0976 11.293 11.707C10.9024 11.3165 10.9024 10.6835 11.293 10.293L13.5859 8L11.293 5.70703C10.9024 5.31651 10.9024 4.68349 11.293 4.29297C11.6835 3.90244 12.3165 3.90244 12.707 4.29297L15 6.58594L17.293 4.29297Z" />
                                            </svg>
                                        </button>
                                        <span class="main-media__status" data-status="online">
                                            В ЭФИРЕ
                                        </span>
                                    </div>
                                    <button class="btn-reset navigation-bar__fullscreen">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 1H15C16.1046 1 17 1.89543 17 3V6M6 1H3C1.89543 1 1 1.89543 1 3V6M1 12V15C1 16.1046 1.89543 17 3 17H6M12 17H15C16.1046 17 17 16.1046 17 15V12"
                                                stroke="#F2F2F2" stroke-width="2" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="live-programs">
                                <h2 class="live-programs__title">Смотрите дальше</h2>
                                <div class="live-programs__items">
                                    @if($tvProgramsToday)
                                        @foreach($tvProgramsToday as $program)
                                            <div class="programListItem @if($program->top_show === 1) programListItem--third @endif">
                                                <time datetime="2025-04-1 15:30">15:30</time>
                                                <div class="programListItem__info">
                                                    <h6 class="programListItem__title">
                                                        {{$program->title}}
                                                        <span class="programListItem__age"></span>
                                                    </h6>
                                                    <span class="programListItem__type">
                                                        Новости
                                                    </span>
                                                    <div class="programListItem__media programListItem__media--mobile">
                                                        <img src="./assets/poster.jpg" alt="Program item image">
                                                    </div>
                                                    <p class="programListItem__text">{{$program->description}}</p>
                                            </div>
                                            <div class="programListItem__media">
                                                <img src="./assets/poster.jpg" alt="Program item image">
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="live-content__right">
                            <div class="ads-block">
                                <img src="./assets/add.jpg" alt="add">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
<script src="{{asset('js/live.js')}}"></script>
@endpush
