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
                                 style="background-image: url('{{asset($transfer->slider_image
                                        ? 'storage/public/' . $transfer->slider_image
                                        : 'storage/public/' . $transfer->image) }}'); width: 430px;"
                                 role="group" aria-label="1 / 3" data-swiper-slide-index="0">
                                <div class="programs-slide__inner">
                                    <div class="programs-slide__mobile-image">
                                        @if(isset($transfer->slider_image))
                                            <img src="{{asset('storage/public/' . $transfer->slider_image)}}"
                                                 alt="Slide image">
                                        @else
                                            <img src="{{asset('storage/public/' . $transfer->image)}}"
                                                 alt="Slide image">
                                        @endif
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
                                    <div class="releases__items">
                                        <div class="popular-item releases-item">
                                            <div class="popular-item__media">
                                                {!! $video->video !!}
                                            </div>
                                            <div class="popular-item__info">
                                                <h6 class="popular-item__title">
                                                        {{$video->title}}
                                                </h6>
                                                <time datetime="{{$video->formatted_created_at}}" class="popular-item__time">{{$video->formatted_created_at}}</time>
                                            </div>
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
        document.addEventListener('DOMContentLoaded', function () {
            const videos = document.querySelectorAll('.popular-item__media_video-tag');

            videos.forEach(video => {
                // Проверяем, был ли уже учтён просмотр
                const videoId = video.closest('.popular-item').dataset.videoId;
                const storageKey = `video_view_${videoId}`;

                video.addEventListener('play', function () {
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
