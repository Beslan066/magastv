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
                            <video id="liveStream" controls autoplay muted></video>

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
{{--<script src="{{asset('js/live.js')}}"></script>--}}

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    const video = document.getElementById('liveStream');

    if (Hls.isSupported()) {
        const hls = new Hls({
            pLoader: (context) => {
                // Переписываем URL для загрузки через прокси
                context.url = '/proxy-live/' + context.url.split('/').pop();
                return context;
            }
        });

        hls.loadSource('/proxy-live/playlist.m3u8');
        hls.attachMedia(video);

        hls.on(Hls.Events.MANIFEST_PARSED, () => {
            video.play().catch(e => console.error("Autoplay error:", e));
        });

        hls.on(Hls.Events.ERROR, (event, data) => {
            console.error("HLS Error:", data);
            if (data.fatal) {
                switch (data.type) {
                    case Hls.ErrorTypes.NETWORK_ERROR:
                        console.error("Network error, trying to recover...");
                        hls.startLoad();
                        break;
                    case Hls.ErrorTypes.MEDIA_ERROR:
                        console.error("Media error, recovering...");
                        hls.recoverMediaError();
                        break;
                    default:
                        console.error("Fatal error, cannot recover");
                }
            }
        });
    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
        // Для Safari (который поддерживает HLS без HLS.js)
        video.src = '/proxy-live';
        video.addEventListener('loadedmetadata', () => {
            video.play().catch(e => console.error("Autoplay error:", e));
        });
    } else {
        alert("Ваш браузер не поддерживает HLS!");
    }
</script>
@endpush
