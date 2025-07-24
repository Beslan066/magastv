@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/radio.page.css')}}">
    <link rel="stylesheet" href="{{asset('css/components/radio-item.css')}}">
@endpush

@section('content')
    <main class="radio" data-main>

        <section class="radio__content">
            <div class="container">
                <h1 class="page-title">Радио</h1>
                <div class="radio__content_inner">
                    <div class="radio__content_left">

                        <div class="radio-slider">
                            <div class="swiper-wrapper radio-slider__wrapper">
                                @if(isset($events))
                                    @foreach($events as $event)
                                        <div class="radio-slide"
                                             style="background-image: url({{asset('storage/public/' . $event->image)}})">
                                            <div class="radio-slide__wrapper">

                                                <div class="radio-slide__mobile-image">
                                                    <img src="{{asset('storage/public/' . $event->image)}}"
                                                         alt="{{$event->title}}">
                                                </div>
                                                <div
                                                    style="display: flex; flex-direction: column; justify-content: space-between; height: 100%">
                                                    <div class="radio-slide__inner">
                                                        <div class="radio-slide__schedule">
                                                            <span>{{$event->formatted_published_at}}</span>
                                                        </div>
                                                        <div class="radio-slide__text">
                                                            <h2 class="radio-slide__title">
                                                                {{$event->title}}
                                                            </h2>
                                                            <p class="radio-slide__paragraph">
                                                                {{$event->lead}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="radio-slide__btns" style="padding-left: 52px">
                                                        <a  href="{{route('event.single', $event->id)}}"
                                                            class="btn-reset radio-slide__btn radio-slide__btn--primary">
                                                            Подробнее
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="radio-slider-navigation">
                                <button class="btn-reset radio-slider-btn radio-slider-btn--prev">
                                    <svg width="12"
                                         height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.25 1L2.25 10L11.25 19" stroke="#BDBDBD" stroke-width="2"/>
                                    </svg>
                                </button>
                                <div class="radio-slider-pagination"></div>
                                <button class="btn-reset radio-slider-btn radio-slider-btn--next">
                                    <svg width="12" height="20" viewBox="0 0 12 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.25 1L10.25 10L1.25 19" stroke="#BDBDBD" stroke-width="2"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="radio-events">
                            <h2 class="radio-events__title">
                                Наши события
                            </h2>

                            <div class="radio__items">
                                @if(isset($news))
                                    @foreach($news as $item)
                                        <div class="radio-item">
                                            <div class="radio-item__image">
                                                <img src="{{asset('storage/public/' . $item->image)}}" alt="{{$item->title}}">
                                            </div>
                                            <div class="radio-item__bottom">
                                                <div class="radio-item__nav">
                                                    <audio class="audio" preload="auto"
                                                           src="{{asset('storage/public/' . $item->audio)}}"></audio>
                                                    <button class="btn-reset radio-item__play_btn">
                                                        <svg class="radio-item__play_btn--play-svg" width="12" height="14"
                                                             viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M11.3648 6.11953L1.4741 0.793746C0.807869 0.435006 0 0.917542 0 1.67422V12.3258C0 13.0825 0.807868 13.565 1.4741 13.2063L11.3648 7.88047C12.066 7.5029 12.066 6.4971 11.3648 6.11953Z"
                                                                fill="#545454"/>
                                                        </svg>
                                                        <svg class="radio-item__play_btn--stop-svg" width="24" height="24"
                                                             viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="6" y="4" width="4" height="16" rx="1" fill="#14AB28"/>
                                                            <rect x="14" y="4" width="4" height="16" rx="1" fill="#14AB28"/>
                                                        </svg>
                                                    </button>
                                                    <div class="radio-item__progress">
                                                        <div class="audio-slider">

                                                        </div>
                                                        <div class="radio-item__timer">
                                                            <span class="duration">00:00</span>
                                                        </div>
                                                    </div>
                                                    <a href="{{asset('storage/public/' . $item->audio)}}" download class="btn-reset radio-item__download">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M5 14V17C5 18.1046 5.89543 19 7 19H17C18.1046 19 19 18.1046 19 17V14"
                                                                stroke="#545454" stroke-width="2"/>
                                                            <path d="M12 3V15" stroke="#545454" stroke-width="2"/>
                                                            <path d="M17 10L12 15L7 10" stroke="#545454" stroke-width="2"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                                <div class="radio-item__info">
                                                    <h6 class="radio-item__title">
                                                        <a>{{$item->title}}</a>
                                                    </h6>
                                                    <div class="radio-item__meta">
                                                        <time datetime="2025-04-1 18:35">{{$item->formatted_published_at}}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="radio__content_right">
                        <div class="radio__player player">
                            <div class="player__inner">
                                <div class="player__main">
                                    <div class="player__main_top">
                                        <div class="player__info_wrapper">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_2330_9777)">
                                                    <path
                                                        d="M15.6 15.5998C17.5882 13.6116 17.5882 10.388 15.6 8.3998M8.40001 15.5998C6.41178 13.6116 6.41178 10.388 8.40001 8.3998"
                                                        stroke="white" stroke-width="2"/>
                                                    <path
                                                        d="M18.412 18.4117C21.9532 14.8704 21.9532 9.12896 18.412 5.58774M5.58804 18.4117C2.04682 14.8704 2.04682 9.12896 5.58804 5.58774"
                                                        stroke="white" stroke-width="2"/>
                                                    <circle cx="12" cy="12" r="2" fill="white"/>
                                                </g>
                                                <defs>
                                                    <clippath id="clip0_2330_9777">
                                                        <rect width="24" height="24" fill="white"/>
                                                    </clippath>
                                                </defs>
                                            </svg>
                                            <div class="player__info">
                                                <span class="player__frequency">88.8 FM</span>
                                                <span class="player__title">Радио Ингушетия</span>
                                            </div>
                                        </div>
                                        <div class="player__controls">
                                            <audio src="http://77.87.97.62:8086/ingradio"></audio>
                                            <div class="player__controls_controls">
                                                <button class="btn-reset player__controls_btn">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="2" height="14" rx="1"
                                                              transform="matrix(-1 0 0 1 6 5)" fill="white"/>
                                                        <path
                                                            d="M9.63516 11.1195L19.5259 5.79375C20.1921 5.43501 21 5.91754 21 6.67422V17.3258C21 18.0825 20.1921 18.565 19.5259 18.2063L9.63516 12.8805C8.93396 12.5029 8.93396 11.4971 9.63516 11.1195Z"
                                                            fill="white"/>
                                                    </svg>
                                                </button>
                                                <button
                                                    class="btn-reset player__controls_btn player__controls_btn--play">
                                                    <svg class="play-svg" width="24" height="24" viewBox="0 0 24 24"
                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="6" y="4" width="4" height="16" rx="1" fill="white"/>
                                                        <rect x="14" y="4" width="4" height="16" rx="1" fill="white"/>
                                                    </svg>
                                                    <svg class="pause-svg" width="12" height="14" viewBox="0 0 12 14"
                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.3648 6.11953L1.4741 0.793746C0.807869 0.435006 0 0.917542 0 1.67422V12.3258C0 13.0825 0.807868 13.565 1.4741 13.2063L11.3648 7.88047C12.066 7.5029 12.066 6.4971 11.3648 6.11953Z"
                                                            fill="white"/>
                                                    </svg>
                                                </button>
                                                <button class="btn-reset player__controls_btn">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="18" y="5" width="2" height="14" rx="1" fill="white"/>
                                                        <path
                                                            d="M14.3648 11.1195L4.4741 5.79375C3.80787 5.43501 3 5.91754 3 6.67422V17.3258C3 18.0825 3.80787 18.565 4.4741 18.2063L14.3648 12.8805C15.066 12.5029 15.066 11.4971 14.3648 11.1195Z"
                                                            fill="white"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="player__volume">
                                                <button class="btn-reset player__mute">
                                                    <svg width="18" height="16" viewBox="0 0 18 16" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M7.32429 0.536043L3 4.4998V4.49994H1C0.447715 4.49994 0 4.94765 0 5.49994V10.4999C0 11.0522 0.447715 11.4999 1 11.4999H3V11.4998L7.32426 15.4639C7.96566 16.0519 9 15.5969 9 14.7267V1.27321C9 0.403119 7.9657 -0.0518867 7.32429 0.536043ZM11 5C12.6569 5 14 6.34315 14 8C14 9.65685 12.6569 11 11 11V5ZM11 3C13.7614 3 16 5.23858 16 8C16 10.7614 13.7614 13 11 13V15C14.866 15 18 11.866 18 8C18 4.13401 14.866 1 11 1V3Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <input type="range" class="range-input">
                                                <div class="slider-styled" id="slider-round"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="player__main_bottom">
                                        <ul class="list-reset player__list">
                                            <li class="player__item">
                                                <div class="player__item_meta">
                                                    <span class="player__item_title">Радио Г1алг1айче</span>
                                                    <span class="player__item_frequency">87.6 FM</span>
                                                </div>
                                                <button class="btn-reset player__item_btn">
                                                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.3648 6.11953L1.4741 0.793746C0.807869 0.435006 0 0.917542 0 1.67422V12.3258C0 13.0825 0.807868 13.565 1.4741 13.2063L11.3648 7.88047C12.066 7.5029 12.066 6.4971 11.3648 6.11953Z"
                                                            fill="#BDBDBD"/>
                                                    </svg>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="radio__next">
                            <h3 class="radio__next_title">Слушайте дальше</h3>
                            <div class="radio__programs">
                                @if(isset($radioShows))
                                    @foreach($radioShows as $item)
                                        @php
                                            [$start, $end] = explode('-', $item->time_range);
                                            $now = \Carbon\Carbon::now('Europe/Moscow');
                                            $startTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $item->program_date->format('Y-m-d') . ' ' . trim($start));
                                            $endTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $item->program_date->format('Y-m-d') . ' ' . trim($end));
                                            $isActive = $now->between($startTime, $endTime);
                                        @endphp
                                        <div class="programListItem {{ $isActive ? 'active' : '' }}">
                                            <time datetime="2025-04-1 14:00">{{mb_substr($item->time_range, 0, 5)}}</time>
                                            <div class="programListItem__info">
                                                <h6 class="programListItem__title">
                                                    {{$item->title}}
                                                    <span class="programListItem__age"></span>
                                                </h6>
                                                <span class="programListItem__type">
                                            {{$item->radioShowType->title}}
                                        </span>
                                                <p class="programListItem__text">
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script defer src="{{asset('js/radio-slider.js')}}"></script>
    <script defer src="{{asset('js/radio.js')}}"></script>
@endpush
