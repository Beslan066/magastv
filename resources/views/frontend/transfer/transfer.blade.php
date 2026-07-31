@extends('layouts.frontend')

@push('meta')
    <title>{{$transfer->title}}</title>
@endpush


@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/transfer.page.css')}}">
    <style>
        .programs-slide {
            position: relative;
            overflow: hidden;
            height: 100%;
            min-height: 500px; /* Минимальная высота баннера */
        }

        /* Стили для десктопного фона */
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
            background: rgba(0,0,0,0.3);
        }

        .programs-slide__inner {
            position: relative;
            z-index: 3;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .programs-slide__container {
            flex: 1;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .programs-slide__info {
            width: 100%;
            max-width: 600px;
            text-align: left;
            margin-right: auto;
        }

        /* Стили для мобильного изображения */
        .programs-slide__mobile-image {
            display: none;
            width: 100%;
        }

        .programs-slide__mobile-image video,
        .programs-slide__mobile-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Скрываем десктопный фон на мобильных */
        @media (max-width: 768px) {
            .programs-slide__video,
            .programs-slide__image-background,
            .programs-slide__video-overlay {
                display: none;
            }

            .programs-slide__mobile-image {
                display: block;
            }

            .programs-slide__inner {
                flex-direction: column;
            }

            .programs-slide__info {
                max-width: 100%;
                text-align: center;
                margin: 0 auto;
            }
        }

        /* Скрываем мобильное изображение на десктопе */
        @media (min-width: 769px) {
            .programs-slide__mobile-image {
                display: none;
            }

            .programs-slide__info {
                padding: 40px 0;
            }
        }

        /* Дополнительные стили для текста */
        .programs-slide__text {
            text-align: left;
            margin-bottom: 20px;
        }

        .programs-slide__title {
            text-align: left;
            margin-bottom: 15px;
            color: white;
        }

        .programs-slide__paragraph {
            text-align: left;
            line-height: 1.6;
            color: white;
        }

        .programs-slide__schedule span {
            color: white;
        }
    </style>
@endpush

@section('content')
    <main class="transfer__page" data-main>
        <section class="programs">
            <div class="programs__inner">
                <div class="swiper programs__slider">
                    <div class="swiper-wrapper">
                        @if(isset($transfer))
                            <div class="swiper-slide programs-slide swiper-slide-active">
                                <!-- Десктопная версия -->
                                @if(!empty($transfer->slider_video))
                                    <video class="programs-slide__video" autoplay muted loop playsinline>
                                        <source src="{{asset('storage/public/' . $transfer->slider_video)}}" type="video/mp4">
                                    </video>
                                    <div class="programs-slide__video-overlay"></div>
                                @elseif(!empty($transfer->slider_image))
                                    <div class="programs-slide__image-background" style="background: url('{{asset('storage/public/' . $transfer->slider_image)}}') no-repeat center; background-size: cover;"></div>
                                @else
                                    <div class="programs-slide__image-background" style="background: url('{{asset('storage/public/' . $transfer->image)}}') no-repeat center; background-size: cover;"></div>
                                @endif

                                <div class="programs-slide__inner">
                                    <!-- Мобильная версия -->
                                    <div class="programs-slide__mobile-image">
                                        @if(!empty($transfer->slider_video))
                                            <video autoplay muted loop playsinline>
                                                <source src="{{asset('storage/public/' . $transfer->slider_video)}}" type="video/mp4">
                                            </video>
                                        @elseif(!empty($transfer->slider_image))
                                            <img src="{{asset('storage/public/' . $transfer->slider_image)}}" alt="{{$transfer->title}}">
                                        @else
                                            <img src="{{asset('storage/public/' . $transfer->image)}}" alt="{{$transfer->title}}">
                                        @endif
                                    </div>

                                    <div class="container programs-slide__container">
                                        <div class="programs-slide__info">
                                            @if($transfer->published)
                                                <div class="programs-slide__schedule">
                                                    <span>{{$transfer->published}}</span>
                                                </div>
                                            @endif
                                            <div class="programs-slide__text">
                                                <h2 class="programs-slide__title">
                                                    {{$transfer->title}}
                                                </h2>
                                                @if($transfer->lead)
                                                    <p class="programs-slide__paragraph">
                                                        {{$transfer->lead}}
                                                    </p>
                                                @endif
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
                        @if($transferVideos && count($transferVideos) > 0)
                            <div class="releases__items">
                                @foreach($transferVideos as $video)
                                    <div class="popular-item releases-item">
                                        <div class="popular-item__media">
                                            {!! $video->video !!}
                                        </div>
                                        <div class="popular-item__info">
                                            <h6 class="popular-item__title">
                                                <a>
                                                    {{$video->title}}
                                                </a>
                                            </h6>
                                            <time datetime="{{$video->formatted_created_at}}" class="popular-item__time">{{$video->formatted_created_at}}</time>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>Нет доступных выпусков</p>
                        @endif

                        <div>
                            {{$transferVideos->links('vendor.pagination.simple')}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
