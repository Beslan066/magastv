@extends('layouts.frontend')

@push('meta')
    <title>Прямой эфир Национальная телерадиокомпания "Магас"</title>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/live.page.css')}}">

    <style>
        @media (max-width: 768px) {
            .live__main-media iframe {
                height: 250px !important;
                overflow: hidden; /* Убирает скролл на мобильных */
            }
        }

        @media (max-width: 429px) {
            .live__main-media iframe {
                height: 230px !important;
            }
        }

        @media (max-width: 404px) {
            .live__main-media iframe {
                height: 219px !important;
            }
        }

        @media (max-width: 381px) {
            .live__main-media iframe {
                height: 204px !important;
            }
        }
    </style>
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
                            <div class="live__main-media" style="height: auto">
                                <iframe src="https://public.mediacdn.ru/magas/"
                                        frameborder="0"
                                        allowfullscreen
                                        allow="autoplay"
                                        style="height: 500px">
                                </iframe>
                            </div>

                            <div class="live-programs">
                                <h2 class="live-programs__title">Смотрите дальше</h2>
                                <div class="live-programs__items">
                                    @if($tvProgramsToday)
                                        @foreach($tvProgramsToday as $program)
                                            <div class="programListItem @if($program->top_show === 1) programListItem--third @endif @if($currentTvProgram && $currentTvProgram->id === $program->id) active @endif">
                                                <time datetime="{{ $program->program_date->format('Y-m-d') }} {{ $program->time_range }}">{{ Carbon\Carbon::parse($program->time_range)->format('H:i') }}</time>
                                                <div class="programListItem__info">
                                                    <h6 class="programListItem__title">
                                                        {{$program->title}}
                                                        <span class="programListItem__age"></span>
                                                    </h6>
                                                    <span class="programListItem__type">
                                                        @if(isset($program->tvShowType))
                                                            {{$program->tvShowType->title}}
                                                        @endif
                                                    </span>
                                                    <div class="programListItem__media programListItem__media--mobile">
                                                        <img src="{{asset('assets/poster.jpg')}}" alt="Program item image">
                                                    </div>
                                                    <p class="programListItem__text">
                                                        @if(isset($program->description))
                                                            {{$program->description}}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="programListItem__media">
                                                    <img src="{{asset('assets/poster.jpg')}}" alt="Program item image">
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="live-content__right">
                            <div class="ads-block">
                                {{--                                <img src="{{asset('assets/add.jpg')}}" alt="add">--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.querySelector('.live-video-tag');

            if (Hls.isSupported()) {
                const hls = new Hls();
                hls.loadSource('https://public.mediacdn.ru/magas/');
                hls.attachMedia(video);
                hls.on(Hls.Events.MANIFEST_PARSED, function() {
                    video.play();
                });
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                // Для Safari, который поддерживает HLS нативно
                video.src = 'https://public.mediacdn.ru/magas/';
                video.addEventListener('loadedmetadata', function() {
                    video.play();
                });
            }

            // Остальной код вашего live.js
        });
    </script>
<script src="{{asset('js/live.js')}}"></script>
@endpush
