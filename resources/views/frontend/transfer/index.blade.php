@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/transfers.page.css')}}">

    <style>
        .transferItem_media {
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
    <main class="transfers__page" data-main>
        <section class="transfers-content">
            <div class="container">
                <div class="transfers__inner">
                    <div class="transfers__top">
                        <h1 class="page-title">
                            Телепроекты
                        </h1>
{{--                        <div class="news-content__tabs_wrapper">--}}
{{--                            <div class="tabs">--}}
{{--                                <ul class="list-reset tabs__list">--}}
{{--                                    <li class="tab active" data-tab="all">--}}
{{--                                        <span>Все</span>--}}
{{--                                    </li>--}}
{{--                                    @if(isset($categories))--}}
{{--                                        @foreach($categories as $category)--}}
{{--                                            <li class="tab" >--}}
{{--                                                <span>{{$category->title}}</span>--}}
{{--                                            </li>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="transfers__bottom">
                        <ul class="list-reset transfers__list">
                            @if(isset($transfers))
                                @foreach($transfers as $transfer)
                                    <li class="transferItem active">
                                        <div class="transferItem_media" style="height: 158px !important;">
                                            @if(isset($transfer->slider_video))
                                                <!-- Видео элемент (скрыт по умолчанию) -->
                                                <video class="transferItem__video" muted loop preload="metadata">
                                                    <source src="{{asset('storage/public/' . $transfer->slider_video)}}" type="video/mp4">
                                                </video>
                                                <!-- Изображение (показывается по умолчанию) -->
                                                <img class="transferItem__image"
                                                     src="{{asset('storage/public/' . $transfer->image)}}"
                                                     alt="{{$transfer->title}}">
                                            @else
                                                <img src="{{asset('storage/public/' . $transfer->image)}}" alt="{{$transfer->title}}">
                                            @endif
                                        </div>
                                        <h6 class="transferItem_title">
                                            <a href="{{route('transfer', $transfer->id)}}">{{$transfer->title}}
                                                @if(isset($transfer->age_restriction))
                                                        <span>{{$transfer->age_restriction->title}}</span>
                                                @endif
                                            </a>
                                        </h6>
                                        <span class="transferItem_count">Выпусков: {{$transfer->getVideosCountAttribute()}}</span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Функция для управления видео при наведении
            const videoItems = document.querySelectorAll('.transfers__list .transferItem');

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
