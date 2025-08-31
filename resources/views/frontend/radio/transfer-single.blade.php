@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/single-news.page.css')}}">
    <link rel="stylesheet" href="{{asset('css/pages/radio.page.css')}}">
    <link rel="stylesheet" href="{{asset('css/components/radio-item.css')}}">

    <style>
        .radio-item__play_btn.playing .radio-item__play_btn--play-svg {
            display: none;
        }

        .radio-item__play_btn.playing .radio-item__play_btn--stop-svg {
            display: block;
        }

        .radio-item__play_btn--stop-svg {
            display: none;
        }
    </style>
@endpush

@section('content')
    <section class="single-news-content book-single">
        <div class="container">
            <div class="single-news-content__inner">
                <div class="single-news__top">
                    <h2 class="single-news__title">
                        {{$transfer->title}}
                    </h2>

                    <div class="single-news__image single-news__image--main" style="max-width: 300px;">
                        <div class="single-news__image_content">
                            <img src="{{asset('storage/public/' . $transfer->image)}}" alt="{{$transfer->title}}"
                                 style="border-radius: 15px">
                        </div>
                    </div>
                </div>
                <div class="single-news__bottom">
                    <div class="single-news__content" style="flex-basis: unset">
                        <div class="single-news__content--main">


                            @if(isset($transfer->lead))
                                <p class="single-news__paragraph single-news__paragraph--first" style="margin-bottom: 20px; width: 100%">
                                    {{$transfer->lead}}
                                </p>
                            @endif

                                @foreach($transfer->programs as $item)
                                    <div class="radio-item">
                                        <div class="radio-item__bottom">

                                            <div class="radio-item__info">
                                                <h6 class="radio-item__title">
                                                    <a>{{$item->title}}</a>
                                                </h6>
                                            </div>
                                            <div class="radio-item__nav">
                                                <audio class="audio" preload="metadata" src="{{asset('storage/public/' . $item->audio)}}"></audio>
                                                <button class="btn-reset radio-item__play_btn">
                                                    <svg class="radio-item__play_btn--play-svg" width="20" height="20"
                                                         viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.3648 6.11953L1.4741 0.793746C0.807869 0.435006 0 0.917542 0 1.67422V12.3258C0 13.0825 0.807868 13.565 1.4741 13.2063L11.3648 7.88047C12.066 7.5029 12.066 6.4971 11.3648 6.11953Z"
                                                            fill="#545454" />
                                                    </svg>
                                                    <svg class="radio-item__play_btn--stop-svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="6" y="4" width="4" height="16" rx="1" fill="#14AB28" />
                                                        <rect x="14" y="4" width="4" height="16" rx="1" fill="#14AB28" />
                                                    </svg>
                                                </button>
                                                <div class="radio-item__progress">
                                                    <div class="radio-item__timer">
                                                        <span class="current-time">00:00</span>
                                                        <span> / </span>
                                                        <span class="duration">00:00</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script defer src="{{asset('js/radio-slider.js')}}"></script>
    <script defer src="{{asset('js/radio.js')}}"></script>
@endpush
