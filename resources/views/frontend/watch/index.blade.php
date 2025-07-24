@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/watch.page.css')}}">
@endpush

@section('content')
    <main class="watch" data-main>
        <section class="watch__content">
            <div class="container">
                <div class="watch__content_inner">
                    <h1 class="watch__title">
                        Где смотреть
                    </h1>

                    <div class="watch__list-wrapper">
                        <ul class="list-reset watch__list">
                            <li class="watch__item">
                                <div class="watch__item_top">
                                    <div class="watch__item_image">
                                        <img src="{{asset('assets/img/watch/magastv.png')}}" alt="Magas">
                                    </div>
                                    <h6 class="watch__item_title">Телерадио<br>компания НТРК МАГАС</h6>
                                </div>
                                <div class="watch__item_bottom">
                                    <a href="/">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="20" y="4" width="16" height="16" rx="2" transform="rotate(90 20 4)"
                                                  stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M15.2111 11.1056L10.4472 8.72361C9.78231 8.39116 9 8.87465 9 9.61803V14.382C9 15.1253 9.78231 15.6088 10.4472 15.2764L15.2111 12.8944C15.9482 12.5259 15.9482 11.4741 15.2111 11.1056Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        Смотреть онлайн</a>

                                </div>
                            </li>
                            <li class="watch__item">
                                <div class="watch__item_top">
                                    <div class="watch__item_image">
                                        <img src="{{asset('assets/img/watch/tricolor.png')}}" alt="Триколор">
                                    </div>
                                    <h6 class="watch__item_title">Оператор цифрового<br> телевидения Триколор</h6>
                                </div>
                                <div class="watch__item_bottom">
                                    <a href="https://kino.tricolor.ru/channels/watch/magas/">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="18.6567" y="12.4141" width="13" height="10" rx="2"
                                                  transform="rotate(135 18.6567 12.4141)" stroke="#1A1A1A"
                                                  stroke-width="1.5" />
                                            <rect x="11.5859" y="8.17188" width="2" height="2" rx="0.5"
                                                  transform="rotate(45 11.5859 8.17188)" fill="#1A1A1A" />
                                            <rect x="9.46436" y="11.3536" width="4.5" height="4.5" rx="2.25"
                                                  transform="rotate(45 9.46436 11.3536)" stroke="#1A1A1A"
                                                  stroke-width="1.5" />
                                            <rect x="14.4141" y="11" width="2" height="2" rx="0.5"
                                                  transform="rotate(45 14.4141 11)" fill="#1A1A1A" />
                                            <path
                                                d="M17.8979 6.10263C18.0153 6.21998 18.0916 6.36262 18.1286 6.51281L17.4878 5.872C17.638 5.90891 17.7805 5.98528 17.8979 6.10263Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M20.0711 9.58489C21.6332 8.02279 21.6332 5.49013 20.0711 3.92804C18.509 2.36594 15.9763 2.36594 14.4142 3.92804"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        813 канал</a>
                                    <a href="#">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="20" y="4" width="16" height="16" rx="2" transform="rotate(90 20 4)"
                                                  stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M15.2111 11.1056L10.4472 8.72361C9.78231 8.39116 9 8.87465 9 9.61803V14.382C9 15.1253 9.78231 15.6088 10.4472 15.2764L15.2111 12.8944C15.9482 12.5259 15.9482 11.4741 15.2111 11.1056Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        Смотреть онлайн</a>

                                </div>
                            </li>
                            <li class="watch__item">
                                <div class="watch__item_top">
                                    <div class="watch__item_image">
                                        <img src="{{asset('assets/img/watch/rostelekom.png')}}" alt="Ростелеком">
                                    </div>
                                    <h6 class="watch__item_title">Телеком<br>муникационная компания Ростелеком</h6>
                                </div>
                                <div class="watch__item_bottom">
                                    <a href="#">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="18.6567" y="12.4141" width="13" height="10" rx="2"
                                                  transform="rotate(135 18.6567 12.4141)" stroke="#1A1A1A"
                                                  stroke-width="1.5" />
                                            <rect x="11.5859" y="8.17188" width="2" height="2" rx="0.5"
                                                  transform="rotate(45 11.5859 8.17188)" fill="#1A1A1A" />
                                            <rect x="9.46436" y="11.3536" width="4.5" height="4.5" rx="2.25"
                                                  transform="rotate(45 9.46436 11.3536)" stroke="#1A1A1A"
                                                  stroke-width="1.5" />
                                            <rect x="14.4141" y="11" width="2" height="2" rx="0.5"
                                                  transform="rotate(45 14.4141 11)" fill="#1A1A1A" />
                                            <path
                                                d="M17.8979 6.10263C18.0153 6.21998 18.0916 6.36262 18.1286 6.51281L17.4878 5.872C17.638 5.90891 17.7805 5.98528 17.8979 6.10263Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M20.0711 9.58489C21.6332 8.02279 21.6332 5.49013 20.0711 3.92804C18.509 2.36594 15.9763 2.36594 14.4142 3.92804"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        21 канал</a>

                                </div>
                            </li>
                            <li class="watch__item">
                                <div class="watch__item_top">
                                    <div class="watch__item_image">
                                        <img src="{{asset('assets/img/watch/wink.png')}}" alt="Цифровой видеосервис Wink">
                                    </div>
                                    <h6 class="watch__item_title">Цифровой видеосервис Wink</h6>
                                </div>
                                <div class="watch__item_bottom">
                                    <a href="#">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="20" y="4" width="16" height="16" rx="2" transform="rotate(90 20 4)"
                                                  stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M15.2111 11.1056L10.4472 8.72361C9.78231 8.39116 9 8.87465 9 9.61803V14.382C9 15.1253 9.78231 15.6088 10.4472 15.2764L15.2111 12.8944C15.9482 12.5259 15.9482 11.4741 15.2111 11.1056Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        Смотреть онлайн</a>

                                </div>
                            </li>
                            <li class="watch__item">
                                <div class="watch__item_top">
                                    <div class="watch__item_image">
                                        <img src="{{asset('assets/img/watch/rutube.png')}}" alt="Онлайн видео-хостинг RUTUBE')">
                                    </div>
                                    <h6 class="watch__item_title">Онлайн видео-хостинг RUTUBE</h6>
                                </div>
                                <div class="watch__item_bottom">
                                    <a href="https://rutube.ru/video/15bb032337c7425983757d211713eb7d/?r=plwd">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="20" y="4" width="16" height="16" rx="2" transform="rotate(90 20 4)"
                                                  stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M15.2111 11.1056L10.4472 8.72361C9.78231 8.39116 9 8.87465 9 9.61803V14.382C9 15.1253 9.78231 15.6088 10.4472 15.2764L15.2111 12.8944C15.9482 12.5259 15.9482 11.4741 15.2111 11.1056Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        Смотреть онлайн</a>

                                </div>
                            </li>
                            <li class="watch__item">
                                <div class="watch__item_top">
                                    <div class="watch__item_image">
                                        <img src="{{asset('assets/img/watch/russia.png')}}" alt="Онлайн ТВ-платформа Цифоровое ТВ">
                                    </div>
                                    <h6 class="watch__item_title">Онлайн ТВ-платформа Цифровое ТВ</h6>
                                </div>
                                <div class="watch__item_bottom">

                                    <a href="https://russia-tv.online/ingushetia?region=6">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="20" y="4" width="16" height="16" rx="2" transform="rotate(90 20 4)"
                                                  stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M15.2111 11.1056L10.4472 8.72361C9.78231 8.39116 9 8.87465 9 9.61803V14.382C9 15.1253 9.78231 15.6088 10.4472 15.2764L15.2111 12.8944C15.9482 12.5259 15.9482 11.4741 15.2111 11.1056Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        Смотреть онлайн</a>

                                </div>
                            </li>
                            <li class="watch__item">
                                <div class="watch__item_top">
                                    <div class="watch__item_image">
                                        <img src="{{asset('assets/img/watch/red.png')}}" alt="Онлайн ТВ-платформа Online Red">
                                    </div>
                                    <h6 class="watch__item_title">Онлайн ТВ-платформа Online Red</h6>
                                </div>
                                <div class="watch__item_bottom">

                                    <a href="https://online-red.com/tv/ingushetiya.html">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="20" y="4" width="16" height="16" rx="2" transform="rotate(90 20 4)"
                                                  stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M15.2111 11.1056L10.4472 8.72361C9.78231 8.39116 9 8.87465 9 9.61803V14.382C9 15.1253 9.78231 15.6088 10.4472 15.2764L15.2111 12.8944C15.9482 12.5259 15.9482 11.4741 15.2111 11.1056Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        Смотреть онлайн</a>

                                </div>
                            </li>
                            <li class="watch__item">
                                <div class="watch__item_top">
                                    <div class="watch__item_image">
                                        <img src="{{'assets/img/watch/watch.png'}}" alt="Онлайн ТВ-платформа СмотретьTV">
                                    </div>
                                    <h6 class="watch__item_title">Онлайн ТВ-платформа СмотретьTV</h6>
                                </div>
                                <div class="watch__item_bottom">

                                    <a href="https://smotret.tv/region/ingushetiya">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="20" y="4" width="16" height="16" rx="2" transform="rotate(90 20 4)"
                                                  stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M15.2111 11.1056L10.4472 8.72361C9.78231 8.39116 9 8.87465 9 9.61803V14.382C9 15.1253 9.78231 15.6088 10.4472 15.2764L15.2111 12.8944C15.9482 12.5259 15.9482 11.4741 15.2111 11.1056Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        Смотреть онлайн</a>

                                </div>
                            </li>
                            <li class="watch__item">
                                <div class="watch__item_top">
                                    <div class="watch__item_image">
                                        <img src="{{asset('assets/img/watch/lime.png')}}" alt="Онлайн ТВ-платформа ЛаймТВ">
                                    </div>
                                    <h6 class="watch__item_title">Онлайн ТВ-платформа ЛаймТВ</h6>
                                </div>
                                <div class="watch__item_bottom">

                                    <a href="https://limehd.tv/channel/ingushetia">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="20" y="4" width="16" height="16" rx="2" transform="rotate(90 20 4)"
                                                  stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M15.2111 11.1056L10.4472 8.72361C9.78231 8.39116 9 8.87465 9 9.61803V14.382C9 15.1253 9.78231 15.6088 10.4472 15.2764L15.2111 12.8944C15.9482 12.5259 15.9482 11.4741 15.2111 11.1056Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        Смотреть онлайн</a>

                                </div>
                            </li>
                            <li class="watch__item">
                                <div class="watch__item_top">
                                    <div class="watch__item_image">
                                        <img src="{{asset('assets/img/watch/tv2free.png')}}" alt="Онлайн видеотранслятор tv2free">
                                    </div>
                                    <h6 class="watch__item_title">Онлайн видеотранслятор tv2free</h6>
                                </div>
                                <div class="watch__item_bottom">

                                    <a href="https://tv2free.ru/tv/ingushetiya-magas">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="20" y="4" width="16" height="16" rx="2" transform="rotate(90 20 4)"
                                                  stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M15.2111 11.1056L10.4472 8.72361C9.78231 8.39116 9 8.87465 9 9.61803V14.382C9 15.1253 9.78231 15.6088 10.4472 15.2764L15.2111 12.8944C15.9482 12.5259 15.9482 11.4741 15.2111 11.1056Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        Смотреть онлайн</a>

                                </div>
                            </li>
                            <li class="watch__item">
                                <div class="watch__item_top">
                                    <div class="watch__item_image">
                                        <img src="{{'assets/img/watch/lite.png'}}" alt="Онлайн ТВ-платформа Лайт TV">
                                    </div>
                                    <h6 class="watch__item_title">Онлайн ТВ-платформа Лайт TV</h6>
                                </div>
                                <div class="watch__item_bottom">

                                    <a href="https://litehd.tv/channel/ingushetia">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="20" y="4" width="16" height="16" rx="2" transform="rotate(90 20 4)"
                                                  stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M15.2111 11.1056L10.4472 8.72361C9.78231 8.39116 9 8.87465 9 9.61803V14.382C9 15.1253 9.78231 15.6088 10.4472 15.2764L15.2111 12.8944C15.9482 12.5259 15.9482 11.4741 15.2111 11.1056Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        Смотреть онлайн</a>

                                </div>
                            </li>
                            <li class="watch__item">
                                <div class="watch__item_top">
                                    <div class="watch__item_image">
                                        <img src="{{'assets/img/watch/live.png'}}" alt="Онлайн ТВ-платформа Эфир ТВ">
                                    </div>
                                    <h6 class="watch__item_title">Онлайн ТВ-платформа Эфир ТВ</h6>
                                </div>
                                <div class="watch__item_bottom">

                                    <a>
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="20" y="4" width="16" height="16" rx="2" transform="rotate(90 20 4)"
                                                  stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M15.2111 11.1056L10.4472 8.72361C9.78231 8.39116 9 8.87465 9 9.61803V14.382C9 15.1253 9.78231 15.6088 10.4472 15.2764L15.2111 12.8944C15.9482 12.5259 15.9482 11.4741 15.2111 11.1056Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        Смотреть онлайн</a>

                                </div>
                            </li>
                            <li class="watch__item">
                                <div class="watch__item_top">
                                    <div class="watch__item_image">
                                        <img src="{{asset('assets/img/watch/vits.png')}}" alt="Онлайн видеотранслятор VitsTV">
                                    </div>
                                    <h6 class="watch__item_title">Онлайн видеотранслятор VitsTV</h6>
                                </div>
                                <div class="watch__item_bottom">

                                    <a href="https://vits.tv/ru/tv-online/ntrk-ingushetiya/">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="20" y="4" width="16" height="16" rx="2" transform="rotate(90 20 4)"
                                                  stroke="#1A1A1A" stroke-width="1.5" />
                                            <path
                                                d="M15.2111 11.1056L10.4472 8.72361C9.78231 8.39116 9 8.87465 9 9.61803V14.382C9 15.1253 9.78231 15.6088 10.4472 15.2764L15.2111 12.8944C15.9482 12.5259 15.9482 11.4741 15.2111 11.1056Z"
                                                stroke="#1A1A1A" stroke-width="1.5" />
                                        </svg>
                                        Смотреть онлайн</a>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
