<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="{{asset('assets/favicon.ico')}}" type="image/x-icon">

    @vite(['resources/css/app.css'])

    <!-- Шрифты -->
    <link
        href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">


    <link rel="icon" type="image/x-icon" href="{{asset('assets/favicon.ico')}}">

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){
            m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
        })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=104109555', 'ym');

        ym(104109555, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/104109555" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->






    @stack('styles')

    <style>
        @media (max-width: 404px) {
            #tidings iframe {
                height: 219px !important;
            }
        }

        @media (max-width: 429px) {
            #tidings iframe {
                height: 230px !important;
            }
        }

        @media (max-width: 768px) {
            #tidings iframe {
                height: 250px !important;
                overflow: hidden;
            }
        }

        @media (max-width: 1080px) {
            #tidings iframe {
                width: 100%;
            }
        }

        /* Стили для cookie-уведомления */
        .cookie-notice {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 20px 24px;
            z-index: 1000;
            max-width: 1200px;
            margin: 0 auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.5s ease;
        }

        @media (min-width: 768px) {
            .cookie-notice {
                left: 30px;
                right: 30px;
                bottom: 30px;
            }
        }

        @media (min-width: 1260px) {
            .cookie-notice {
                left: 50%;
                right: auto;
                transform: translateX(-50%);
                width: 1200px;
            }
        }

        .cookie-notice__content {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        @media (min-width: 768px) {
            .cookie-notice__content {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .cookie-notice__text {
            color: #fff;
            font-family: 'Golos Text', sans-serif;
            font-size: 14px;
            line-height: 1.5;
            flex: 1;
        }

        .cookie-notice__text a {
            color: #70E780;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .cookie-notice__text a:hover {
            opacity: 0.8;
        }

        .cookie-notice__buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .cookie-notice__btn {
            padding: 10px 24px;
            border-radius: 8px;
            font-family: 'Golos Text', sans-serif;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            white-space: nowrap;
        }

        .cookie-notice__btn--accept {
            background: #70E780;
            color: #000;
        }

        .cookie-notice__btn--accept:hover {
            background: #5bc96b;
        }

        .cookie-notice__btn--settings {
            background: transparent;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .cookie-notice__btn--settings:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Стили для модального окна настроек */
        .cookie-settings {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 1001;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .cookie-settings.active {
            display: flex;
        }

        .cookie-settings__modal {
            background: #1a1a1a;
            border-radius: 16px;
            padding: 30px;
            max-width: 500px;
            width: 100%;
            max-height: 80vh;
            overflow-y: auto;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .cookie-settings__title {
            color: #fff;
            font-family: 'Golos Text', sans-serif;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .cookie-settings__option {
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
        }

        .cookie-settings__option-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .cookie-settings__option-title {
            color: #fff;
            font-family: 'Golos Text', sans-serif;
            font-size: 16px;
            font-weight: 500;
        }

        .cookie-settings__option-description {
            color: rgba(255, 255, 255, 0.7);
            font-family: 'Golos Text', sans-serif;
            font-size: 14px;
            line-height: 1.4;
        }

        .cookie-settings__toggle {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .cookie-settings__toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .cookie-settings__toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #444;
            transition: .3s;
            border-radius: 24px;
        }

        .cookie-settings__toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked + .cookie-settings__toggle-slider {
            background-color: #70E780;
        }

        input:checked + .cookie-settings__toggle-slider:before {
            transform: translateX(26px);
        }

        input:disabled + .cookie-settings__toggle-slider {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .cookie-settings__save {
            background: #70E780;
            color: #000;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-family: 'Golos Text', sans-serif;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: background 0.3s;
        }

        .cookie-settings__save:hover {
            background: #5bc96b;
        }

        .cookie-settings__close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s;
        }

        .cookie-settings__close:hover {
            opacity: 1;
        }
    </style>

    <link rel="stylesheet" href="{{asset('css/media/media.css')}}">


    @stack('meta')
</head>

<!-- header menu,footer -->

<body class="body">
@if(auth()->user())
    @if(auth()->user()->role->name !== 'Обычный пользователь')
        <div class="admin-row">
            <div class="container">
                <ul>
                    <li>
                        <a href="{{route('admin.index')}}">
                            Админ-панель
                        </a>
                    </li>
                    <li>
                        <a href="{{route('categories.index')}}">
                            Категории
                        </a>
                    </li>
                    <li><a href="{{route('news.index')}}"></a></li>
                    <li>
                        <a href="{{route('video-reportages.index')}}">
                            Видеорепортажи
                        </a>
                    </li>
                    <li>Пользователи</li>
                    <li>Роли</li>
                </ul>
            </div>
        </div>
    @endif
@endif
<header class="header">

    <div class="header__top">
        <div class="container">
            <div class="header__top_inner">
                <div class="header__media">
                    <div class="header__media_tabs">
                        <button class="btn-reset header__media_tab header-tab active" data-media-tab="tv">
                            <div class="header-tab__main_content">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect x="4" y="8" width="12" height="8" rx="2" stroke-width="1.5"></rect>
                                    <path d="M5.38892 3L9.88895 7.50003L14.3889 3" stroke-width="1.5"
                                          stroke-linejoin="bevel"></path>
                                </svg>
                                ТВ
                            </div>
                            <div class="header__media_info--mobile">
                                <svg width="8" height="8" viewBox="0 0 8 8" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="4" cy="4" r="4" fill="#70E780"></circle>
                                </svg>
                                <h6 class="video__title">
                                    @if($currentTvProgram && $currentTvProgram->title)
                                        {{ $currentTvProgram->title }}
                                    @else
                                        Нет текущей передачи
                                    @endif
                                </h6>
                            </div>
                        </button>
                        <button class="btn-reset header__media_tab header-tab" data-media-tab="radio">
                            <div class="header-tab__main_content">

                                <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.5 13C15.1568 11.3431 15.1568 8.65684 13.5 6.99999M7.50001 13C5.84316 11.3431 5.84316 8.65684 7.50001 6.99999"
                                        stroke-width="1.5"></path>
                                    <path
                                        d="M15.5 15C18.2614 12.2385 18.2614 7.76141 15.5 4.99999M5.50001 15C2.73859 12.2385 2.73859 7.76141 5.50001 4.99999"
                                        stroke-width="1.5"></path>
                                    <circle cx="10.5" cy="10" r="2"></circle>
                                </svg>
                                Радио
                            </div>
                            <div class="header__media_info--mobile">
                                <svg width="8" height="8" viewBox="0 0 8 8" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="4" cy="4" r="4" fill="#70E780"></circle>
                                </svg>
                                <h6 class="video__title">
                                    @if($currentRadioProgram && $currentRadioProgram->title)
                                        {{ $currentRadioProgram->title }}
                                    @else
                                        Нет текущей передачи
                                    @endif
                                </h6>
                            </div>
                        </button>
                    </div>

                    <div class="header__media_content  header__media_content--video active" id="tv">
                        <video id="header__media--video" class="header__media--video" preload="true"></video>
                        <div class="overlay">
                            <div class="overlay__inner">
                                <div class="video-custom-controls">
                                    <button
                                        class="btn-reset video-custom-controls__btn video-custom-controls__btn--mute"
                                        data-id="muteVideo">
                                        <svg width="19" height="16" viewBox="0 0 19 16" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M7.32429 0.536043L3 4.4998V4.49994H1C0.447715 4.49994 0 4.94765 0 5.49994V10.4999C0 11.0522 0.447715 11.4999 1 11.4999H3V11.4998L7.32426 15.4639C7.96566 16.0519 9 15.5969 9 14.7267V1.27321C9 0.403119 7.9657 -0.0518867 7.32429 0.536043ZM17.293 4.29297C17.6835 3.90244 18.3165 3.90244 18.707 4.29297C19.0976 4.68349 19.0976 5.31651 18.707 5.70703L16.4141 8L18.707 10.293C19.0976 10.6835 19.0976 11.3165 18.707 11.707C18.3165 12.0976 17.6835 12.0976 17.293 11.707L15 9.41406L12.707 11.707C12.3165 12.0976 11.6835 12.0976 11.293 11.707C10.9024 11.3165 10.9024 10.6835 11.293 10.293L13.5859 8L11.293 5.70703C10.9024 5.31651 10.9024 4.68349 11.293 4.29297C11.6835 3.90244 12.3165 3.90244 12.707 4.29297L15 6.58594L17.293 4.29297Z"/>
                                        </svg>

                                    </button>
                                    <button
                                        class="btn-reset video-custom-controls__btn video-custom-controls__btn--unmute hidden"
                                        data-id="unmuteVideo">

                                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M7.32429 0.536043L3 4.4998V4.49994H1C0.447715 4.49994 0 4.94765 0 5.49994V10.4999C0 11.0522 0.447715 11.4999 1 11.4999H3V11.4998L7.32426 15.4639C7.96566 16.0519 9 15.5969 9 14.7267V1.27321C9 0.403119 7.9657 -0.0518867 7.32429 0.536043ZM11 5C12.6569 5 14 6.34315 14 8C14 9.65685 12.6569 11 11 11V5ZM11 3C13.7614 3 16 5.23858 16 8C16 10.7614 13.7614 13 11 13V15C14.866 15 18 11.866 18 8C18 4.13401 14.866 1 11 1V3Z"/>
                                        </svg>
                                    </button>
                                    <button
                                        class="btn-reset video-custom-controls__btn video-custom-controls__btn--play hidden"
                                        data-id="play">
                                        <svg width="12" height="14" viewBox="0 0 12 14" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.3648 6.11953L1.4741 0.793746C0.807869 0.435006 0 0.917542 0 1.67422V12.3258C0 13.0825 0.807868 13.565 1.4741 13.2063L11.3648 7.88047C12.066 7.5029 12.066 6.4971 11.3648 6.11953Z"/>
                                        </svg>

                                    </button>
                                    <button
                                        class="btn-reset video-custom-controls__btn video-custom-controls__btn--pause"
                                        data-id="pause">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="6" y="4" width="4" height="16" rx="1"/>
                                            <rect x="14" y="4" width="4" height="16" rx="1"/>
                                        </svg>
                                    </button>
                                    <button class="btn-reset video-custom-controls__btn" data-id="fullScreenVideo">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 1H15C16.1046 1 17 1.89543 17 3V6M6 1H3C1.89543 1 1 1.89543 1 3V6M1 12V15C1 16.1046 1.89543 17 3 17H6M12 17H15C16.1046 17 17 16.1046 17 15V12"
                                                stroke-width="2"/>
                                        </svg>
                                    </button>
                                </div>

                            </div>
                        </div>
                        <div class="overlay__info">
                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <circle cx="4" cy="4" r="4" fill="#70E780"/>
                            </svg>
                            <h6 class="video__title">
                                @if($currentTvProgram && $currentTvProgram->title)
                                    {{ $currentTvProgram->title }}
                                @else
                                    Нет текущей передачи
                                @endif
                            </h6>
                        </div>
                    </div>
                    <div class="header__media_content header__media_content--radio" id="radio">
                        <div class="radio__inner">
                            <div class="radio-content">
                                <span>88.8 FM</span>
                                <audio src="https://magas.tv/ingradio" id="radio-stream-header" preload="none"></audio>
                                <svg width="29" height="28" viewBox="0 0 29 28" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M22.9674 4.74665C22.2538 4.74665 21.6733 5.32847 21.6733 6.04367V21.9646C21.7386 23.6858 24.2015 23.6796 24.2664 21.9646V6.04367C24.2664 5.32853 23.6837 4.74665 22.9674 4.74665ZM14.5 4.74665C13.7837 4.74665 13.201 5.32847 13.201 6.04367V21.9646C13.2665 23.6834 15.7342 23.682 15.799 21.9646V6.04367C15.799 5.32853 15.2163 4.74665 14.5 4.74665ZM18.7336 9.48915C18.0201 9.48915 17.4397 10.071 17.4397 10.7862V17.2222C17.505 18.9435 19.9678 18.9371 20.0327 17.2222V10.7862C20.0327 10.071 19.4499 9.48915 18.7336 9.48915ZM27.201 11.8605C26.4875 11.8605 25.907 12.4423 25.907 13.1575V14.8509C25.9723 16.5722 28.4351 16.5659 28.5 14.8509V13.1575C28.5 12.4423 27.9173 11.8605 27.201 11.8605ZM1.79905 11.8605C1.08275 11.8605 0.5 12.4423 0.5 13.1574V14.8509C0.565516 16.5671 3.02837 16.5709 3.09301 14.8509V13.1574C3.09301 12.4423 2.51255 11.8605 1.79905 11.8605ZM6.03268 7.1179C5.31638 7.1179 4.73363 7.69972 4.73363 8.41492V19.5934C4.79915 21.3097 7.26205 21.3133 7.32675 19.5934V8.41492C7.32675 7.69972 6.74624 7.1179 6.03268 7.1179ZM10.2664 0.00415039C9.55007 0.00415039 8.96737 0.585971 8.96737 1.30117V26.7071C9.03284 28.4234 11.4957 28.427 11.5604 26.7071V1.30117C11.5604 0.585971 10.9799 0.00415039 10.2664 0.00415039Z"
                                        fill="white"></path>
                                </svg>
                            </div>
                            <div class="overlay">
                                <div class="overlay__inner">
                                    <div class="radio-custom-controls">
                                        <button
                                            class="btn-reset radio-custom-controls__btn radio-custom-controls__btn--mute"
                                            data-id="muteRadio">
                                            <svg width="19" height="16" viewBox="0 0 19 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M7.32429 0.536043L3 4.4998V4.49994H1C0.447715 4.49994 0 4.94765 0 5.49994V10.4999C0 11.0522 0.447715 11.4999 1 11.4999H3V11.4998L7.32426 15.4639C7.96566 16.0519 9 15.5969 9 14.7267V1.27321C9 0.403119 7.9657 -0.0518867 7.32429 0.536043ZM17.293 4.29297C17.6835 3.90244 18.3165 3.90244 18.707 4.29297C19.0976 4.68349 19.0976 5.31651 18.707 5.70703L16.4141 8L18.707 10.293C19.0976 10.6835 19.0976 11.3165 18.707 11.707C18.3165 12.0976 17.6835 12.0976 17.293 11.707L15 9.41406L12.707 11.707C12.3165 12.0976 11.6835 12.0976 11.293 11.707C10.9024 11.3165 10.9024 10.6835 11.293 10.293L13.5859 8L11.293 5.70703C10.9024 5.31651 10.9024 4.68349 11.293 4.29297C11.6835 3.90244 12.3165 3.90244 12.707 4.29297L15 6.58594L17.293 4.29297Z"/>
                                            </svg>

                                        </button>
                                        <button
                                            class="btn-reset radio-custom-controls__btn radio-custom-controls__btn--unmute hidden"
                                            data-id="unmuteRadio">

                                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M7.32429 0.536043L3 4.4998V4.49994H1C0.447715 4.49994 0 4.94765 0 5.49994V10.4999C0 11.0522 0.447715 11.4999 1 11.4999H3V11.4998L7.32426 15.4639C7.96566 16.0519 9 15.5969 9 14.7267V1.27321C9 0.403119 7.9657 -0.0518867 7.32429 0.536043ZM11 5C12.6569 5 14 6.34315 14 8C14 9.65685 12.6569 11 11 11V5ZM11 3C13.7614 3 16 5.23858 16 8C16 10.7614 13.7614 13 11 13V15C14.866 15 18 11.866 18 8C18 4.13401 14.866 1 11 1V3Z"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn-reset radio-custom-controls__btn radio-custom-controls__btn--play hidden"
                                            data-id="playRadio">
                                            <svg width="12" height="14" viewBox="0 0 12 14" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.3648 6.11953L1.4741 0.793746C0.807869 0.435006 0 0.917542 0 1.67422V12.3258C0 13.0825 0.807868 13.565 1.4741 13.2063L11.3648 7.88047C12.066 7.5029 12.066 6.4971 11.3648 6.11953Z"/>
                                            </svg>

                                        </button>
                                        <button
                                            class="btn-reset radio-custom-controls__btn radio-custom-controls__btn--pause"
                                            data-id="pauseRadio">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <rect x="6" y="4" width="4" height="16" rx="1"/>
                                                <rect x="14" y="4" width="4" height="16" rx="1"/>
                                            </svg>
                                        </button>
                                        <button class="btn-reset fullScreenRadio" data-id="fullScreenRadio">
                                            <svg width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 1H15C16.1046 1 17 1.89543 17 3V6M6 1H3C1.89543 1 1 1.89543 1 3V6M1 12V15C1 16.1046 1.89543 17 3 17H6M12 17H15C16.1046 17 17 16.1046 17 15V12"
                                                    stroke-width="2"/>
                                            </svg>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <div class="radio-overlay">
                                <svg width="6" height="6" viewBox="0 0 6 6" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="3" cy="3" r="3" fill="#70E780"></circle>
                                </svg>
                                <h6 class="radio-overlay__title">
                                    Радио-трансляция
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header__schedule">
                    <div class="header__schedule_inner">
                        <div class="header__schedule_slider" data-schedule="tv">
                            <div class="header__schedule_top">
                    <span class="header__schedule_title">
                        Телепрограмма
                    </span>
                                <div class="schedule-navigation">
                                    <button class="btn-reset schedule-navigation__btn schedule-navigation__btn--prev">
                                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 15L2 8L9 1" stroke-width="1.5"/>
                                        </svg>
                                    </button>
                                    <button class="btn-reset schedule-navigation__btn schedule-navigation__btn--next">
                                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L8 8L1 15" stroke-width="1.5"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <ul class="list-reset header__schedule_list schedule-list schedule-wrapper">
                                @foreach($tvProgramsToday as $program)
                                    @php
                                        $now = \Carbon\Carbon::now('Europe/Moscow');
                                        $isActive = $currentTvProgram && $currentTvProgram->id === $program->id;
                                    @endphp
                                    <li class="schedule-list__item schedule-slide {{ $isActive ? 'active' : '' }}">
                                        <time>{{ $program->start_time->format('H:i') }}
                                            - {{ $program->end_time->format('H:i') }}</time>
                                        <a>
                                            {{ $program->title ?? 'Без названия' }}
                                            @if($program->age_restriction)
                                                <span>{{ $program->age_restriction->title }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="header__schedule_slider" data-schedule="radio">
                            <div class="header__schedule_top">
                    <span class="header__schedule_title radio-header__schedule_title">
                        Радиопрограмма
                    </span>
                                <div class="schedule-navigation">
                                    <button class="btn-reset schedule-navigation__btn schedule-navigation__btn--prev">
                                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 15L2 8L9 1" stroke-width="1.5"/>
                                        </svg>
                                    </button>
                                    <button class="btn-reset schedule-navigation__btn schedule-navigation__btn--next">
                                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L8 8L1 15" stroke-width="1.5"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <ul class="list-reset header__schedule_list schedule-list schedule-wrapper">
                                @foreach($radioProgramsToday as $program)
                                    @php
                                        $timeParts = explode('-', $program->time_range);
                                        $startTime = trim($timeParts[0]);
                                        $endTime = trim($timeParts[1] ?? $startTime);

                                        $start = \Carbon\Carbon::createFromFormat(
                                            'Y-m-d H:i',
                                            $program->program_date->format('Y-m-d') . ' ' . $startTime,
                                            'Europe/Moscow'
                                        );

                                        $end = \Carbon\Carbon::createFromFormat(
                                            'Y-m-d H:i',
                                            $program->program_date->format('Y-m-d') . ' ' . $endTime,
                                            'Europe/Moscow'
                                        );

                                        $now = \Carbon\Carbon::now('Europe/Moscow');
                                        $isActive = $now->between($start, $end);
                                    @endphp
                                    <li class="schedule-list__item schedule-slide {{ $isActive ? 'active' : '' }}">
                                        <time>{{ $program->time_range }}</time>
                                        <a>
                                            {{ $program->title ?? 'Без названия' }}
                                            @if($program->age_restriction)
                                                <span>{{ $program->age_restriction->title }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header__bottom">
        <div class="container">
            <div class="header__bottom_inner">
                <div class="header__logo">
                    <a href="{{route('home')}}">
                        <img src="{{asset('assets/img/logo.svg')}}" alt="Логотип Магас ТВ">
                    </a>
                </div>
                <nav class="header__nav">
                    <ul class="list-reset header__list">
                        <li class="header__item">
                            <a href="{{route('onAir')}}">
                                Эфир
                            </a>
                        </li>
                        <li class="header__item">
                            <a href="{{route('home.news.index')}}">
                                Новости
                            </a>
                        </li>
                        <li class="header__item">
                            <a href="{{route('newsIng')}}">
                                Хоамаш
                            </a>
                        </li>
                        <li class="header__item">
                            <a href="{{route('tvProgram')}}">
                                Телепрограмма
                            </a>
                        </li>
                        <li class="header__item">
                            <a href="{{route('transfers')}}">
                                Телепроекты
                            </a>
                        </li>
                        <li class="header__item">
                            <a href="{{route('radio')}}">
                                Радио
                            </a>
                        </li>

                        <li class="header__item">
                            <a href="{{route('musicalCard')}}">
                                Музыкальная открытка
                            </a>
                        </li>

                        <li class="header__item">
                            <a href="{{route('ads')}}">
                                Реклама
                            </a>
                        </li>
                        <li class="header__item">
                            <a href="{{route('contacts')}}">
                                Контакты
                            </a>
                        </li>
                    </ul>
                    <button class="btn-reset header__search_btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <circle cx="7.5" cy="7.5" r="6.5" transform="matrix(-1 0 0 1 19 3)" stroke-width="2"/>
                            <path d="M16 15.5L21 20.5" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <button class="btn-reset header__burger_btn">
                        <span></span>
                    </button>
                </nav>
            </div>
        </div>
    </div>
    <div class="menu" data-menu="search">
        <div class="container menu__container">
            <div class="menu__inner">
                <div class="menu__top">
                    <button class="btn-reset menu__close">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4L21 20" stroke="white" stroke-width="2"/>
                            <path d="M21 4L4 20" stroke="white" stroke-width="2"/>
                        </svg>
                    </button>
                    <label class="menu__input">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="7.5" cy="7.5" r="6.5" transform="matrix(-1 0 0 1 19 3)" stroke="white"
                                    stroke-width="2"/>
                            <path d="M16 15.5L21 20.5" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <input type="text" class="input-reset search-input" placeholder="Поиск по сайту">
                    </label>
                </div>
                <div class="menu__results">
                    <span>Результаты поиска</span>
                    <div class="menu-list search-results-container">
                        <!-- Динамически загружаемые здесь -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="menu burger__menu" data-menu="burger" tabindex="-1">
        <div class="container menu__container">
            <div class="menu__inner">
                <div class="burger__menu_top">

                    <button class="btn-reset burger__menu_close">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">


                            <path d="M4 4L21 20" stroke="white" stroke-width="2"/>


                            <path d="M21 4L4 20" stroke="white" stroke-width="2"/>


                        </svg>
                    </button>

                </div>
                <div class="burger__menu_bottom">
                    <nav class="header__nav">
                        <ul class="list-reset header__list">
                            <li class="header__item">
                                <a href="{{route('onAir')}}">
                                    Эфир
                                </a>
                            </li>
                            <li class="header__item">
                                <a href="{{route('home.news.index')}}">
                                    Новости
                                </a>
                            </li>

                            <li class="header__item">
                                <a href="{{route('newsIng')}}">
                                    Хоамаш
                                </a>
                            </li>
                            <li class="header__item">
                                <a href="{{route('tvProgram')}}">
                                    Телепрограмма
                                </a>
                            </li>
                            <li class="header__item">
                                <a href="{{route('transfers')}}">
                                    Телепроекты
                                </a>
                            </li>
                            <li class="header__item">
                                <a href="{{route('radio')}}">
                                    Радио
                                </a>
                            </li>
                            <li class="header__item">
                                <a href="{{route('musicalCard')}}">
                                    Музыкальная открытка
                                </a>
                            </li>
                            <li class="header__item">
                                <a href="{{route('watching')}}">
                                    Где смотреть
                                </a>
                            </li>
                            <li class="header__item">
                                <a href="{{route('about')}}">
                                    О нас
                                </a>
                            </li>
                            <li class="header__item">
                                <a href="{{route('ads')}}">
                                    Реклама
                                </a>
                            </li>
                            <li class="header__item">
                                <a href="{{route('contacts')}}">
                                    Контакты
                                </a>
                            </li>
                        </ul>

                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
@yield('content')
<footer class="footer">
    <div class="footer__top">
        <div class="container">
            <div class="footer__top_inner">

                <nav class="footer__nav">
                    <ul class="list-reset footer__nav_list">
                        <li class="footer__nav_item">
                            <a href="{{route('onAir')}}">Эфир</a>
                        </li>
                        <li class="footer__nav_item">
                            <a href="{{route('home.news.index')}}">Новости</a>
                        </li>
                        <li class="footer__nav_item">
                            <a href="{{route('newsIng')}}">Хоамаш</a>
                        </li>
                        <li class="footer__nav_item">
                            <a href="{{route('tvProgram')}}">Телепрограмма</a>
                        </li>
                        <li class="footer__nav_item">
                            <a href="{{route('transfers')}}">Телепроекты</a>
                        </li>
                        <li class="footer__nav_item">
                            <a href="{{route('radio')}}">Радио</a>
                        </li>

                        <li class="footer__nav_item">
                            <a href="{{route('watching')}}">Где смотреть</a>
                        </li>
                        <li class="footer__nav_item">
                            <a href="{{route('about')}}">О нас</a>
                        </li>
                        <li class="footer__nav_item">
                            <a href="{{route('ads')}}">Реклама</a>
                        </li>
                        <li class="footer__nav_item">
                            <a href="{{route('contacts')}}">Контакты</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="footer__mid">
        <div class="container">
            <div class="footer__mid_inner">
                <address class="footer__info">
                    <span> ГАУ РИ НТРК “Магас”</span>
                    <a> 386001 Республика Ингушетия, г. Магас, пр-т И. Зязикова, 15</a>
                    <a href="tel:787325702222">Тел.: 8 (8734) 55-40-55 </a>
                    <a href="mailto:ntrkmagas@mail.ru"> E-mail: magas.tv@magas.tv</a>
                </address>
                <div class="footer__socials">
                    <span class="footer__socials_title">Подписывайтесь на нас:</span>
                    <ul class="list-reset footer__socials_list">
                        <li class="footer__socials_item">
                            <a href="https://max.ru/id608017209_gos" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 720 720">
                                    <path fill="#BDBDBD"
                                          d="M350.4,9.6C141.8,20.5,4.1,184.1,12.8,390.4c3.8,90.3,40.1,168,48.7,253.7,2.2,22.2-4.2,49.6,21.4,59.3,31.5,11.9,79.8-8.1,106.2-26.4,9-6.1,17.6-13.2,24.2-22,27.3,18.1,53.2,35.6,85.7,43.4,143.1,34.3,299.9-44.2,369.6-170.3C799.6,291.2,622.5-4.6,350.4,9.6h0ZM269.4,504c-11.3,8.8-22.2,20.8-34.7,27.7-18.1,9.7-23.7-.4-30.5-16.4-21.4-50.9-24-137.6-11.5-190.9,16.8-72.5,72.9-136.3,150-143.1,78-6.9,150.4,32.7,183.1,104.2,72.4,159.1-112.9,316.2-256.4,218.6h0Z"/>
                                </svg>
                            </a>
                        </li>
                        <li class="footer__socials_item">
                            <a href="https://vk.com/public220873017" target="_blank">
                                <svg width="26" height="16" viewBox="0 0 26 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M0.400024 0.299988C0.604647 9.91921 5.51557 15.7 14.1254 15.7H14.6135V10.1967C17.7772 10.505 20.1696 12.7711 21.1297 15.7H25.6C24.3723 11.322 21.1454 8.90179 19.1307 7.97686C21.1454 6.83612 23.9786 4.06135 24.6555 0.299988H20.5944C19.713 3.35224 17.1004 6.12701 14.6135 6.38908V0.299988H10.5523V10.9675C8.03391 10.3508 4.85448 7.36025 4.71282 0.299988H0.400024Z"
                                          fill="#BDBDBD"/>
                                </svg>
                            </a>
                        </li>
                        <li class="footer__socials_item">
                            <a href="https://t.me/magas_tv" target="_blank">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M16.3686 7.76115C14.3624 8.61073 10.3529 10.3691 4.33993 13.0364C3.36352 13.4317 2.85204 13.8184 2.80548 14.1966C2.72678 14.8357 3.51285 15.0873 4.58328 15.43C4.72889 15.4766 4.87975 15.5249 5.03442 15.5761C6.08756 15.9246 7.50421 16.3324 8.24067 16.3486C8.90871 16.3633 9.65432 16.0829 10.4775 15.5074C16.0956 11.6463 18.9957 9.6947 19.1777 9.65263C19.3062 9.62294 19.4842 9.58562 19.6048 9.69476C19.7254 9.8039 19.7135 10.0106 19.7008 10.066C19.6229 10.404 16.5373 13.3247 14.9404 14.8362C14.4426 15.3073 14.0895 15.6416 14.0174 15.7179C13.8557 15.8889 13.6909 16.0506 13.5325 16.2061C12.5541 17.1664 11.8204 17.8865 13.5731 19.0624C14.4154 19.6275 15.0894 20.0948 15.7618 20.5611C16.4961 21.0702 17.2285 21.578 18.1762 22.2105C18.4176 22.3716 18.6482 22.539 18.8728 22.702C19.7274 23.3223 20.4951 23.8795 21.4436 23.7907C21.9948 23.739 22.5641 23.2114 22.8532 21.6377C23.5366 17.9185 24.8797 9.86033 25.1901 6.53973C25.2173 6.24881 25.1831 5.87648 25.1556 5.71303C25.1281 5.54959 25.0707 5.31671 24.862 5.14433C24.6149 4.94017 24.2334 4.89711 24.0628 4.90017C23.287 4.91409 22.0967 5.33546 16.3686 7.76115Z"
                                          fill="#BDBDBD"/>
                                </svg>
                            </a>
                        </li>
                        <li class="footer__socials_item">
                            <a href="https://rutube.ru/u/magastv/" target="_blank">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M23.8 8.39995C24.9598 8.39995 25.9 7.45973 25.9 6.29993C25.9 5.14015 24.9598 4.19995 23.8 4.19995C22.6402 4.19995 21.7 5.14015 21.7 6.29993C21.7 7.45973 22.6402 8.39995 23.8 8.39995Z"
                                        fill="#BDBDBD"/>
                                    <path
                                        d="M17.8415 7.69995H3.5V23.8H7.4917V18.562H15.1405L18.6303 23.8H23.1L19.2517 18.5379C20.4468 18.3448 21.3073 17.8862 21.8332 17.162C22.359 16.4379 22.6219 15.2792 22.6219 13.7345V12.5275C22.6219 11.6103 22.5263 10.8862 22.359 10.331C22.1917 9.77581 21.9049 9.29309 21.4986 8.85858C21.0683 8.44824 20.5903 8.15858 20.0166 7.96548C19.443 7.7965 18.7259 7.69995 17.8415 7.69995ZM17.1961 15.0137H7.4917V11.2482H17.1961C17.7459 11.2482 18.1283 11.3448 18.3195 11.5138C18.5108 11.6827 18.6303 11.9965 18.6303 12.4551V13.8069C18.6303 14.2896 18.5108 14.6034 18.3195 14.7723C18.1283 14.9413 17.7459 15.0137 17.1961 15.0137Z"
                                        fill="#BDBDBD"/>
                                </svg>
                            </a>
                        </li>
                        <li class="footer__socials_item">
                            <a href="https://dzen.ru/ntrkmagas" target="_blank">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14 25C14.1509 20.0758 14.278 17.8282 16.0253 16.0253C17.8282 14.278 20.0758 14.1589 25 14C25 18.4397 24.9841 21.7596 23.3957 23.3957C21.7596 24.9841 18.5906 25 14 25Z"
                                        fill="#BDBDBD"/>
                                    <path
                                        d="M4.60433 23.3957C3.01588 21.7596 3 18.4397 3 14C7.92417 14.1509 10.1718 14.278 11.9747 16.0253C13.722 17.8282 13.8411 20.0758 14 25C9.40938 25 6.24043 24.9841 4.60433 23.3957Z"
                                        fill="#BDBDBD"/>
                                    <path
                                        d="M4.60433 4.60433C6.24043 3.01588 9.41733 3 14 3C13.8491 7.92417 13.722 10.1718 11.9747 11.9747C10.1718 13.722 7.92417 13.8411 3 14C3 9.56029 3.01588 6.24043 4.60433 4.60433Z"
                                        fill="#BDBDBD"/>
                                    <path
                                        d="M14 3C14.1509 7.92417 14.278 10.1718 16.0253 11.9747C17.8282 13.722 20.0758 13.8411 25 14C25 9.56029 24.9841 6.24043 23.3957 4.60433C21.7596 3.01588 18.5906 3 14 3Z"
                                        fill="#BDBDBD"/>
                                </svg>
                            </a>
                        </li>

                        <img src="{{asset('assets/16.png')}}" alt="16+" class="ageIcon" style="margin-left: 20px;">
                    </ul>

                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container">
            <div class="footer__inner--bottom">
                <p>Сетевое издание «Телеканал «Магас». Реестровая запись СМИ ЭЛ № ФС77-88796, выдано Федеральной
                    службой по надзору в сфере связи, информационных технологий и массовых коммуникаций
                    «Роскомнадзор» от 24 декабря 2024 года.</p>
                <span>
                        Учредитель: Государственное автономное учреждение Республики Ингушетия «Национальная
                        телерадиокомпания «Магас».
                    </span>
                <span>
                        Главный редактор сетевого издания: Котиева М.Б.
                    </span>
                <address><a href="#">Адрес: 386001 Республика Ингушетия, г. Магас, пр-т И. Зязикова, 15.</a> <a
                        href="#">Тел.: 8 (8734) 55-40-55.</a> <a href="#">E-mail: magas.tv@magas.tv</a></address>
                <span>
                        При использовании материалов сайта в интернете обязательна активная гиперссылка на www.magas.tv.
                        При использовании необходимо письменное разрешение.
                    </span>
                <span> Используя настоящий сайт, вы обязуетесь выполнять условия <a href="{{route('pravila')}}">Правила использования материалов</a>
                    </span>
                <span><a href="{{route('privacyPolicy')}}">Политика конфиденциальности</a></span>

                <span><a href="{{route('soglasie')}}">Согласие на обработку персональных данных</a></span>
            </div>


            <div style="display: flex; align-items: center;">
                <!-- Yandex.Metrika informer -->
                <a href="https://metrika.yandex.ru/stat/?id=104109555&amp;from=informer" target="_blank" rel="nofollow" style="margin-right: 10px;">
                    <img src="https://informer.yandex.ru/informer/104109555/3_1_FFFFFFFF_FFFFFFFF_0_pageviews"
                         style="width:88px; height:31px; border:0;"
                         alt="Яндекс.Метрика"
                         title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)"
                         class="ym-advanced-informer" data-cid="104109555" data-lang="ru"/>
                </a>
                <!-- /Yandex.Metrika informer -->

                <!-- ИКС Вебмастер -->
                <a href="https://webmaster.yandex.ru/siteinfo/?site=https://magas.tv"><img width="88" height="31" alt="" border="0" border-radius="8" src="https://yandex.ru/cycounter?https://magas.tv&theme=light&lang=ru"/></a>

            </div>
            </div>


    </div>
</footer>



<!-- Cookie Notice -->
<div class="cookie-notice" id="cookieNotice">
    <div class="cookie-notice__content">
        <div class="cookie-notice__text">
            Мы используем файлы cookie и сервисы для отслеживания метрики(в том числе Яндекс Метрика) с целью повышения удобства пользования сайтом.
            Продолжая использовать наш сайт, вы соглашаетесь с <a href="{{route('soglasie')}}">обработкой персональных
                данных</a> и принимаете <a href="{{route('pravila')}}">условия использования</a>.
        </div>
        <div class="cookie-notice__buttons">
            <button class="cookie-notice__btn cookie-notice__btn--settings" onclick="openCookieSettings()">Настройки
            </button>
            <button class="cookie-notice__btn cookie-notice__btn--accept" onclick="acceptCookies()">Принять</button>
        </div>
    </div>
</div>

<!-- Cookie Settings Modal -->
<div class="cookie-settings" id="cookieSettings">
    <div class="cookie-settings__modal">
        <button class="cookie-settings__close" onclick="closeCookieSettings()">&times;</button>
        <h3 class="cookie-settings__title">Настройки cookie</h3>

        <div class="cookie-settings__option">
            <div class="cookie-settings__option-header">
                <span class="cookie-settings__option-title">Необходимые cookie</span>
                <label class="cookie-settings__toggle">
                    <input type="checkbox" checked disabled>
                    <span class="cookie-settings__toggle-slider"></span>
                </label>
            </div>
            <div class="cookie-settings__option-description">
                Эти файлы cookie необходимы для работы сайта и не могут быть отключены.
            </div>
        </div>

        <div class="cookie-settings__option">
            <div class="cookie-settings__option-header">
                <span class="cookie-settings__option-title">Аналитические cookie (Яндекс.Метрика)</span>
                <label class="cookie-settings__toggle">
                    <input type="checkbox" id="analyticsCookies" checked>
                    <span class="cookie-settings__toggle-slider"></span>
                </label>
            </div>
            <div class="cookie-settings__option-description">
                Позволяют нам собирать анонимную статистику посещений для улучшения работы сайта.
            </div>
        </div>

        <div class="cookie-settings__option">
            <div class="cookie-settings__option-header">
                <span class="cookie-settings__option-title">Функциональные cookie</span>
                <label class="cookie-settings__toggle">
                    <input type="checkbox" id="functionalCookies" checked>
                    <span class="cookie-settings__toggle-slider"></span>
                </label>
            </div>
            <div class="cookie-settings__option-description">
                Запоминают ваши предпочтения и настройки для улучшения взаимодействия с сайтом.
            </div>
        </div>

        <button class="cookie-settings__save" onclick="saveCookieSettings()">Сохранить настройки</button>
    </div>
</div>

<script src="{{asset('js/swiper.min.js')}}"></script>
<script src="{{asset('js/nouislider.js')}}"></script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('.menu__input input');
        const searchResults = document.querySelector('.menu-list');
        const tabs = document.querySelectorAll('.menu-tab');
        let currentCategory = 'all';
        let searchTimeout;

        // Cookie notice logic
        checkCookieConsent();

        if (e.key === 'Enter') {
            e.preventDefault(); // Предотвращаем отправку формы
            const searchTerm = this.value.trim();
            const category = document.querySelector('.menu-tab.active')?.textContent?.trim().toLowerCase() || 'all';
            const categoryId = category === 'все' ? 'all' : category;

            if (searchTerm.length >= 2) {
                // Переходим на страницу всех результатов
                window.location.href = `/search/all?q=${encodeURIComponent(searchTerm)}&category=${categoryId}`;
            } else if (searchTerm.length === 0) {
                // Если поле пустое - ничего не делаем
                return;
            } else {
                // Если меньше 2 символов - показываем сообщение
                if (searchResults) {
                    searchResults.innerHTML = '<div class="no-results" style="color: #fff; padding: 20px; text-align: center;">Введите минимум 2 символа для поиска</div>';
                }
            }
        }
    });


    // Обработчик ввода в поле поиска
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchTerm = this.value.trim();
                if (searchTerm.length >= 2) {
                    fetchSearchResults(searchTerm, currentCategory);
                } else if (searchTerm.length === 0) {
                    clearSearchResults();
                }
            }, 300);
        });

        // Обработчики для табов категорий
        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                currentCategory = this.textContent.trim().toLowerCase();

                const searchTerm = searchInput.value.trim();
                if (searchTerm.length >= 2) {
                    fetchSearchResults(searchTerm, currentCategory);
                }
            });
        });

        function fetchSearchResults(term, category) {
            const categoryId = category === 'все' ? 'all' : category;

            fetch(`/search?q=${encodeURIComponent(term)}&category=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    // Вставляем готовый HTML из партиала
                    const searchResults = document.querySelector('.search-results-container');
                    if (searchResults) {
                        searchResults.innerHTML = data.html || '<div class="no-results">Ничего не найдено</div>';
                    }

                    // Добавляем обработчик для ссылки "Все результаты"
                    if (data.search_url) {
                        const moreLink = document.querySelector('.menu-list__more a');
                        if (moreLink) {
                            moreLink.href = data.search_url;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Функция для отображения результатов
    function displaySearchResults(items, total, term, searchUrl) {
        const searchResults = document.querySelector('.search-results-container');

        if (!searchResults) return;

            if (items.length === 0) {
                searchResults.innerHTML = `<div class="no-results" style="color: #fff; font-family: 'Golos Text', sans-serif; font-weight: 600; padding: 20px; text-align: center;">
                 Ничего не найдено по запросу "${term}"
             </div>`;
                return;
            }

            let html = '';
            items.forEach(item => {
                const isVideo = item.type === 'video';
                const mediaPath = item.media || (isVideo ? '/assets/default-video.jpg' : '/assets/default-news.jpg');

                let mediaContent = '';
                if (isVideo) {
                    mediaContent = `
                <div class="menu-news__video-wrapper" style="position: relative; width: 100%; height: 100%;">
                    <video src="${item.video_url || ''}" poster="${mediaPath}" style="width: 100%; height: 100%; object-fit: cover;"></video>
                    <button class="btn-reset menu-news__play-btn" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                        <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z" fill="white"/>
                        </svg>
                    </button>
                </div>
            `;
                } else {
                    mediaContent = `<img src="${mediaPath}" alt="${item.title}" style="width: 100%; height: 100%; object-fit: cover;">`;
                }

                html += `
            <div class="menu-news menu-news--media" data-menu-category="${item.category_slug || 'uncategorized'}">
                <div class="menu-news__media">
                    ${mediaContent}
                </div>
                <div class="menu-news__info">
                    <h6 class="menu-news__title">
                        <a href="${item.url || `/${isVideo ? 'videos' : 'news'}/${item.slug}`}">${highlightTerm(item.title, term)}</a>
                    </h6>
                    <div class="menu-news__text">
                        <p>${item.lead ? highlightTerm(item.lead, term) : ''}</p>
                    </div>
                    <div class="menu-news__meta">
                        <time>${formatDate(item.published_at)}</time>
                        <div class="menu-news__views">
                            <div class="menu-news__icon">
                                <svg width="18" height="12" viewBox="0 0 18 12" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.99998 0C14.0312 0 16.9533 4.44092 17.7656 5.875C17.921 6.14927 17.9148 6.47693 17.7461 6.74316C16.907 8.0657 13.9914 12 8.99998 12C4.00872 11.9999 1.0939 8.06568 0.254863 6.74316C0.086031 6.47689 0.078957 6.14935 0.234355 5.875C1.04653 4.44117 3.96865 0.000143146 8.99998 0ZM8.99998 3C7.34324 3.00013 5.99998 4.34323 5.99998 6C5.99998 7.65677 7.34324 8.99987 8.99998 9C10.6568 9 12 7.65685 12 6C12 4.34315 10.6568 3 8.99998 3Z"/>
                                </svg>
                            </div>
                            <span>${item.views || 0}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
            });

        // Добавляем ссылку "Показать все" только если есть результаты
        if (total > 10 && searchUrl) {
                html += `
            <div class="all-results-link" style="padding: 20px; text-align: center;">
                <a href="${searchUrl}" style="color: #70E780; text-decoration: none; font-family: 'Golos Text', sans-serif; font-weight: 500; display: inline-block; padding: 10px 20px; border: 1px solid #70E780; border-radius: 8px; transition: all 0.3s;">
                    Показать все результаты (${total})
                </a>
            </div>
        `;
            }

            searchResults.innerHTML = html;
        }

    // Функция для подсветки искомого термина
    function highlightTerm(text, term) {
        if (!text || !term) return text || '';
        const regex = new RegExp(`(${term})`, 'gi');
        return text.replace(regex, '<span class="highlight" style="color: #70E780; font-weight: 600;">$1</span>');
    }

    // Функция для форматирования даты
    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        const options = {day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit'};
        return date.toLocaleDateString('ru-RU', options);
    }


    // Функция для очистки результатов
    function clearSearchResults() {
            searchResults.innerHTML = '';
        }

    // Функция для подсветки искомого термина
    function highlightTerm(text, term) {
            if (!term) return text;
            const regex = new RegExp(`(${term})`, 'gi');
            return text.replace(regex, '<span class="highlight">$1</span>');
        }

    // Функция для форматирования даты
    function formatDate(dateString) {
            const date = new Date(dateString);
            const options = {day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit'};
            return date.toLocaleDateString('ru-RU', options);
    }


    document.addEventListener('DOMContentLoaded', function () {
        // Инициализация для всех слайдеров телепрограммы
        const scheduleSliders = document.querySelectorAll('[data-schedule]');

        scheduleSliders.forEach(slider => {
            initScheduleSlider(slider);
        });
    });

    function initScheduleSlider(slider) {
        const list = slider.querySelector('.schedule-list');
        const items = slider.querySelectorAll('.schedule-list__item');
        const prevBtn = slider.closest('.header__schedule').querySelector('.schedule-navigation__btn--prev');
        const nextBtn = slider.closest('.header__schedule').querySelector('.schedule-navigation__btn--next');

        if (!list || !prevBtn || !nextBtn) return;

        let currentPosition = 0;
        const itemWidth = items[0]?.offsetWidth + parseInt(getComputedStyle(items[0]).marginRight) || 215; // ширина элемента + отступ
        const visibleItems = Math.floor(slider.offsetWidth / itemWidth);
        const maxPosition = Math.max(0, items.length - visibleItems) * itemWidth;

        // Функция для обновления состояния кнопок
        function updateButtons() {
            prevBtn.classList.toggle('schedule-navigation__btn--disabled', currentPosition === 0);
            nextBtn.classList.toggle('schedule-navigation__btn--disabled', currentPosition >= maxPosition);
        }

        // Функция для прокрутки
        function scrollTo(position) {
            currentPosition = Math.max(0, Math.min(position, maxPosition));
            list.style.transform = `translateX(-${currentPosition}px)`;
            updateButtons();
        }

        // Обработчики кликов
        prevBtn.addEventListener('click', function () {
            if (currentPosition > 0) {
                scrollTo(currentPosition - itemWidth * visibleItems);
            }
        });

        nextBtn.addEventListener('click', function () {
            if (currentPosition < maxPosition) {
                scrollTo(currentPosition + itemWidth * visibleItems);
            }
        });

        // Обработчик ресайза окна
        let resizeTimeout;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function () {
                const newVisibleItems = Math.floor(slider.offsetWidth / itemWidth);
                const newMaxPosition = Math.max(0, items.length - newVisibleItems) * itemWidth;

                if (newMaxPosition < currentPosition) {
                    scrollTo(newMaxPosition);
                } else {
                    updateButtons();
                }
            }, 250);
        });

        // Инициализация
        updateButtons();

        // Автоматическая прокрутка к активному элементу
        const activeItem = slider.querySelector('.schedule-list__item.active');
        if (activeItem) {
            const activeIndex = Array.from(items).indexOf(activeItem);
            if (activeIndex >= visibleItems) {
                setTimeout(() => {
                    scrollTo(Math.min(activeIndex * itemWidth, maxPosition));
                }, 100);
            }
        }
    }

    // Cookie functions
    function checkCookieConsent() {
        const consent = localStorage.getItem('cookieConsent');
        if (consent) {
            document.getElementById('cookieNotice').style.display = 'none';
            applyCookieSettings(JSON.parse(consent));
        }
    }

    function acceptCookies() {
        const settings = {
            necessary: true,
            analytics: true,
            functional: true
        };
        localStorage.setItem('cookieConsent', JSON.stringify(settings));
        document.getElementById('cookieNotice').style.display = 'none';
        applyCookieSettings(settings);
    }

    function openCookieSettings() {
        const settings = JSON.parse(localStorage.getItem('cookieConsent')) || {
            necessary: true,
            analytics: true,
            functional: true
        };
        document.getElementById('analyticsCookies').checked = settings.analytics;
        document.getElementById('functionalCookies').checked = settings.functional;
        document.getElementById('cookieSettings').classList.add('active');
    }

    function closeCookieSettings() {
        document.getElementById('cookieSettings').classList.remove('active');
    }

    function saveCookieSettings() {
        const settings = {
            necessary: true,
            analytics: document.getElementById('analyticsCookies').checked,
            functional: document.getElementById('functionalCookies').checked
        };
        localStorage.setItem('cookieConsent', JSON.stringify(settings));
        document.getElementById('cookieSettings').classList.remove('active');
        document.getElementById('cookieNotice').style.display = 'none';
        applyCookieSettings(settings);
    }

    function applyCookieSettings(settings) {
        // Здесь можно добавить логику для включения/отключения счетчиков
        if (!settings.analytics) {
            // Отключить Яндекс.Метрику
            const metrikaScript = document.querySelector('script[src*="mc.yandex.ru"]');
            if (metrikaScript) {
                metrikaScript.remove();
            }
        }
    }

    // Закрытие модального окна по клику вне его
    document.getElementById('cookieSettings').addEventListener('click', function (e) {
        if (e.target === this) {
            closeCookieSettings();
        }
    });
</script>
<script defer src="{{asset('js/script.js')}}" type="module"></script>
<script src="{{asset('js/video.min.js')}}"></script>
<script src="{{asset('js/headerLive.js')}}" type="module"></script>


@stack('scripts')

<script>
    setTimeout(function() {

        // Проверяем, есть ли скрипт метрики на странице
        const metrikaScript = document.querySelector('script[src*="mc.yandex.ru"]');

        // Проверяем отправку хита
        if (typeof ym !== 'undefined') {
            ym(104109555, 'getClientID', function(id) {
                console.log('7. Client ID получен:', id);
                if (!id) {
                    console.error('❌ Client ID не получен - метрика НЕ РАБОТАЕТ!');
                } else {
                    console.log('✅ Метрика работает!');
                }
            });
        } else {
            console.error('❌ ym функция не определена!');
        }
    }, 2000);
</script>

</body>

</html>
