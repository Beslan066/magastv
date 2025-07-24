@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/single-news.page.css')}}">
    @if($type === 'video')
        <link rel="stylesheet" href="{{asset('css/pages/video-news.page.css')}}">
        <link rel="stylesheet" href="{{asset('css/components/video-player.css')}}">
    @endif
@endpush

@section('content')
    @if($type === 'news')
    <section class="single-news-content">
        <div class="container">
            <div class="single-news-content__inner">
                <div class="single-news__top">
                    <h2 class="single-news__title">
                        {{$news->title}}
                    </h2>
                    <div class="single-news__info">
                        <time>{{$news->formatted_published_at}}</time>
                        ·
                        <span>{{$news->category->name}}</span>
                    </div>
                    <ul class="list-reset socials">
                        <li class="social"><a href="#">
                                <svg width="26" height="16" viewBox="0 0 26 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M0.400391 0.300049C0.605013 9.91927 5.51593 15.7 14.1258 15.7H14.6138V10.1967C17.7776 10.5051 20.17 12.7711 21.1301 15.7H25.6004C24.3727 11.3221 21.1458 8.90185 19.131 7.97693C21.1458 6.83618 23.979 4.06141 24.6558 0.300049H20.5948C19.7133 3.3523 17.1008 6.12707 14.6138 6.38914V0.300049H10.5527V10.9675C8.03428 10.3509 4.85484 7.36031 4.71318 0.300049H0.400391Z" />
                                </svg>
                            </a></li>
                        <li class="social"><a href="#">
                                <svg width="24" height="20" viewBox="0 0 24 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M14.3686 3.76103C12.3624 4.6106 8.35287 6.369 2.33993 9.03623C1.36352 9.43155 0.852038 9.81829 0.805475 10.1964C0.726783 10.8355 1.51285 11.0872 2.58328 11.4299C2.72889 11.4765 2.87975 11.5248 3.03442 11.576C4.08756 11.9245 5.50421 12.3323 6.24067 12.3485C6.90871 12.3632 7.65432 12.0828 8.4775 11.5073C14.0956 7.64616 16.9957 5.69458 17.1777 5.6525C17.3062 5.62282 17.4842 5.5855 17.6048 5.69464C17.7254 5.80378 17.7135 6.01047 17.7008 6.06592C17.6229 6.40391 14.5373 9.32458 12.9404 10.836C12.4426 11.3072 12.0895 11.6414 12.0174 11.7178C11.8557 11.8888 11.6909 12.0505 11.5325 12.206C10.5541 13.1662 9.82038 13.8864 11.5731 15.0623C12.4154 15.6274 13.0894 16.0947 13.7618 16.5609C14.4961 17.0701 15.2285 17.5779 16.1762 18.2103C16.4176 18.3715 16.6482 18.5388 16.8728 18.7019C17.7274 19.3221 18.4951 19.8794 19.4436 19.7905C19.9948 19.7389 20.5641 19.2112 20.8532 17.6375C21.5366 13.9184 22.8797 5.86021 23.1901 2.53961C23.2173 2.24868 23.1831 1.87635 23.1556 1.71291C23.1281 1.54947 23.0707 1.31659 22.862 1.1442C22.6149 0.940043 22.2334 0.896991 22.0628 0.900051C21.287 0.913965 20.0967 1.33533 14.3686 3.76103Z"
                                          fill="#1A1A1A" />
                                </svg>
                            </a></li>
                        <li class="social"><a href="#">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14 25C14.1509 20.0758 14.278 17.8282 16.0253 16.0253C17.8282 14.278 20.0758 14.1589 25 14C25 18.4397 24.9841 21.7596 23.3957 23.3957C21.7596 24.9841 18.5906 25 14 25Z"
                                        fill="#1A1A1A" />
                                    <path
                                        d="M4.60433 23.3957C3.01588 21.7596 3 18.4397 3 14C7.92417 14.1509 10.1718 14.278 11.9747 16.0253C13.722 17.8282 13.8411 20.0758 14 25C9.40938 25 6.24043 24.9841 4.60433 23.3957Z"
                                        fill="#1A1A1A" />
                                    <path
                                        d="M4.60433 4.60433C6.24043 3.01588 9.41733 3 14 3C13.8491 7.92417 13.722 10.1718 11.9747 11.9747C10.1718 13.722 7.92417 13.8411 3 14C3 9.56029 3.01588 6.24043 4.60433 4.60433Z"
                                        fill="#1A1A1A" />
                                    <path
                                        d="M14 3C14.1509 7.92417 14.278 10.1718 16.0253 11.9747C17.8282 13.722 20.0758 13.8411 25 14C25 9.56029 24.9841 6.24043 23.3957 4.60433C21.7596 3.01588 18.5906 3 14 3Z"
                                        fill="#1A1A1A" />
                                </svg>
                            </a></li>
                        <li class="social"><a href="#">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M19.4783 8.47908C19.4783 11.4996 17.0218 13.9565 14 13.9565C10.9788 13.9565 8.52173 11.4996 8.52173 8.47908C8.52173 5.45762 10.9788 3 14 3C17.0218 3 19.4783 5.45762 19.4783 8.47908ZM16.7391 8.47867C16.7391 9.98891 15.5109 11.2174 14 11.2174C12.4894 11.2174 11.2609 9.98891 11.2609 8.47867C11.2609 6.96794 12.4894 5.73913 14 5.73913C15.5109 5.73913 16.7391 6.96794 16.7391 8.47867Z"
                                          fill="#1A1A1A" />
                                    <path
                                        d="M16.1633 18.2463C17.2516 17.9944 18.3012 17.5569 19.268 16.94C19.9996 16.4713 20.22 15.4888 19.7591 14.7454C19.2984 14.0005 18.332 13.7762 17.599 14.2449C15.409 15.6441 12.5893 15.6438 10.4005 14.2449C9.66759 13.7762 8.70084 14.0005 8.24113 14.7454C7.78014 15.4894 7.99992 16.4713 8.73155 16.94C9.6983 17.5563 10.7479 17.9944 11.8362 18.2463L8.84703 21.2834C8.23601 21.9049 8.23601 22.9124 8.84767 23.5339C9.15382 23.8443 9.55435 23.9997 9.95487 23.9997C10.356 23.9997 10.7572 23.8443 11.0633 23.5339L13.9995 20.5495L16.9381 23.5339C17.5491 24.1554 18.5405 24.1554 19.1522 23.5339C19.7645 22.9124 19.7645 21.9042 19.1522 21.2834L16.1633 18.2463Z"
                                        fill="#1A1A1A" />
                                </svg>

                            </a></li>
                        <li class="social"><a href="#">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.411 12.589C14.181 11.3589 12.3615 11.1842 11.3471 12.1986L5.83683 17.7088C4.82241 18.7232 4.99719 20.5427 6.22721 21.7727C7.45722 23.0027 9.27669 23.1775 10.2911 22.1631L13.0462 19.408"
                                        stroke="#1A1A1A" fill="white" stroke-width="3" />
                                    <path
                                        d="M12.6561 15.3444C13.8494 16.5376 15.639 16.6825 16.6534 15.6681L22.1637 10.1579C23.1781 9.14346 23.0331 7.35382 21.8399 6.1606C20.6467 4.96738 18.857 4.82242 17.8426 5.83683L15.0875 8.59196"
                                        stroke="#1A1A1A" fill="white" stroke-width="3" />
                                </svg>
                            </a></li>
                    </ul>
                </div>
                <div class="single-news__bottom">
                    <div class="single-news__content">
                        <div class="single-news__content--main">


                            <p class="single-news__paragraph single-news__paragraph--first">
                                {{$news->lead}}
                            </p>

                            <div class="single-news__image single-news__image--main">
                                <div class="single-news__image_content">
                                    <img src="{{asset('storage/public/' . $news->image)}}" alt="{{$news->title}}">
                                </div>
                                @if(isset($news->image_author))
                                    <h6 class="single-news__image_name">
                                        Фото: <span>Покорение новых верщин, Администрация АРМХИ</span>
                                    </h6>
                                @endif
                            </div>

                            <div class="single-news__subInner" style="margin-top: 10px">
                                <div class="single-news__text" style="font-family: 'Golos Text', sans-serif; font-size: 16px">
                                    {!! $news->content !!}
                                </div>
                            </div>
                        </div>


                        <div class="single-news__right-block">
                            <div class="ads-block">
                                <img src="{{asset('assets/add.jpg')}}" alt="add">
                            </div>
                            <div class="content__popular popular-sidebar popular-sidebar--news">
                                <h3 class="popular-sidebar__title">Популярное</h3>
                                <ul class="list-reset popular-sidebar__list">
                                    @if(isset($popularItems)) @endif
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Учёные создали материал, который восстанавливается
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="{{asset('assets/img/views1.svg')}}" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="single-news-other__inner" style="margin-top: 20px;">
                            <h2 class="single-news-other__title" style=" margin-bottom: 20px">Также смотрите</h2>
                            <ul class="list-reset news-block__list single-news-other__list">
                                @if($similarNews)
                                    @foreach($similarNews as $news)
                                        <li class="news-item @if($news->type === 'video') news-item--media @endif">
                                            <div class="news-item__media">
                                                <img src="{{asset('storage/public/' . $news->image)}}"
                                                     alt="{{$news->title}}">
                                                <button class="btn-reset news-item--media__btn">
                                                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z"
                                                            fill="white" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="news-item__bottom">
                                                <h6 class="news-item__title">
                                                    <a href="{{route('home.news.single', $news->slug)}}">{{$news->title}}</a>
                                                </h6>
                                                <div class="news-item__info">
                                                    <time datetime="2025-04-1 18:35" class="news-item_time">
                                                        {{$news->formatted_published_at}}
                                                    </time>
                                                    <div class="news-item_views">
                                                        <div class="item-views__icon">

                                                            <svg width="14" height="10" viewBox="0 0 14 10" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z" />
                                                            </svg>
                                                        </div>
                                                        <span>{{$news->views}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    @elseif($type === 'video')
        <section class="video-news__main">
            <div class="container">
                <div class="video-news__inner">
                    <div class="single-news__top video-news__top">
                        <h2 class="single-news__title">
                            {{$news->title}}
                        </h2>
                        <div class="single-news__info">
                            <time>1 апреля 2025, 13:45</time>
                            ·
                            <span>{{$news->category->title}}</span>
                        </div>
                        <ul class="list-reset socials">
                            <li class="social"><a href="#">
                                    <svg width="26" height="16" viewBox="0 0 26 16" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M0.400391 0.300049C0.605013 9.91927 5.51593 15.7 14.1258 15.7H14.6138V10.1967C17.7776 10.5051 20.17 12.7711 21.1301 15.7H25.6004C24.3727 11.3221 21.1458 8.90185 19.131 7.97693C21.1458 6.83618 23.979 4.06141 24.6558 0.300049H20.5948C19.7133 3.3523 17.1008 6.12707 14.6138 6.38914V0.300049H10.5527V10.9675C8.03428 10.3509 4.85484 7.36031 4.71318 0.300049H0.400391Z" />
                                    </svg>
                                </a></li>
                            <li class="social"><a href="#">
                                    <svg width="24" height="20" viewBox="0 0 24 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M14.3686 3.76103C12.3624 4.6106 8.35287 6.369 2.33993 9.03623C1.36352 9.43155 0.852038 9.81829 0.805475 10.1964C0.726783 10.8355 1.51285 11.0872 2.58328 11.4299C2.72889 11.4765 2.87975 11.5248 3.03442 11.576C4.08756 11.9245 5.50421 12.3323 6.24067 12.3485C6.90871 12.3632 7.65432 12.0828 8.4775 11.5073C14.0956 7.64616 16.9957 5.69458 17.1777 5.6525C17.3062 5.62282 17.4842 5.5855 17.6048 5.69464C17.7254 5.80378 17.7135 6.01047 17.7008 6.06592C17.6229 6.40391 14.5373 9.32458 12.9404 10.836C12.4426 11.3072 12.0895 11.6414 12.0174 11.7178C11.8557 11.8888 11.6909 12.0505 11.5325 12.206C10.5541 13.1662 9.82038 13.8864 11.5731 15.0623C12.4154 15.6274 13.0894 16.0947 13.7618 16.5609C14.4961 17.0701 15.2285 17.5779 16.1762 18.2103C16.4176 18.3715 16.6482 18.5388 16.8728 18.7019C17.7274 19.3221 18.4951 19.8794 19.4436 19.7905C19.9948 19.7389 20.5641 19.2112 20.8532 17.6375C21.5366 13.9184 22.8797 5.86021 23.1901 2.53961C23.2173 2.24868 23.1831 1.87635 23.1556 1.71291C23.1281 1.54947 23.0707 1.31659 22.862 1.1442C22.6149 0.940043 22.2334 0.896991 22.0628 0.900051C21.287 0.913965 20.0967 1.33533 14.3686 3.76103Z"
                                              fill="#1A1A1A" />
                                    </svg>
                                </a></li>
                            <li class="social"><a href="#">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14 25C14.1509 20.0758 14.278 17.8282 16.0253 16.0253C17.8282 14.278 20.0758 14.1589 25 14C25 18.4397 24.9841 21.7596 23.3957 23.3957C21.7596 24.9841 18.5906 25 14 25Z"
                                            fill="#1A1A1A" />
                                        <path
                                            d="M4.60433 23.3957C3.01588 21.7596 3 18.4397 3 14C7.92417 14.1509 10.1718 14.278 11.9747 16.0253C13.722 17.8282 13.8411 20.0758 14 25C9.40938 25 6.24043 24.9841 4.60433 23.3957Z"
                                            fill="#1A1A1A" />
                                        <path
                                            d="M4.60433 4.60433C6.24043 3.01588 9.41733 3 14 3C13.8491 7.92417 13.722 10.1718 11.9747 11.9747C10.1718 13.722 7.92417 13.8411 3 14C3 9.56029 3.01588 6.24043 4.60433 4.60433Z"
                                            fill="#1A1A1A" />
                                        <path
                                            d="M14 3C14.1509 7.92417 14.278 10.1718 16.0253 11.9747C17.8282 13.722 20.0758 13.8411 25 14C25 9.56029 24.9841 6.24043 23.3957 4.60433C21.7596 3.01588 18.5906 3 14 3Z"
                                            fill="#1A1A1A" />
                                    </svg>
                                </a></li>
                            <li class="social"><a href="#">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M19.4783 8.47908C19.4783 11.4996 17.0218 13.9565 14 13.9565C10.9788 13.9565 8.52173 11.4996 8.52173 8.47908C8.52173 5.45762 10.9788 3 14 3C17.0218 3 19.4783 5.45762 19.4783 8.47908ZM16.7391 8.47867C16.7391 9.98891 15.5109 11.2174 14 11.2174C12.4894 11.2174 11.2609 9.98891 11.2609 8.47867C11.2609 6.96794 12.4894 5.73913 14 5.73913C15.5109 5.73913 16.7391 6.96794 16.7391 8.47867Z"
                                              fill="#1A1A1A" />
                                        <path
                                            d="M16.1633 18.2463C17.2516 17.9944 18.3012 17.5569 19.268 16.94C19.9996 16.4713 20.22 15.4888 19.7591 14.7454C19.2984 14.0005 18.332 13.7762 17.599 14.2449C15.409 15.6441 12.5893 15.6438 10.4005 14.2449C9.66759 13.7762 8.70084 14.0005 8.24113 14.7454C7.78014 15.4894 7.99992 16.4713 8.73155 16.94C9.6983 17.5563 10.7479 17.9944 11.8362 18.2463L8.84703 21.2834C8.23601 21.9049 8.23601 22.9124 8.84767 23.5339C9.15382 23.8443 9.55435 23.9997 9.95487 23.9997C10.356 23.9997 10.7572 23.8443 11.0633 23.5339L13.9995 20.5495L16.9381 23.5339C17.5491 24.1554 18.5405 24.1554 19.1522 23.5339C19.7645 22.9124 19.7645 21.9042 19.1522 21.2834L16.1633 18.2463Z"
                                            fill="#1A1A1A" />
                                    </svg>

                                </a></li>
                            <li class="social"><a href="#">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.411 12.589C14.181 11.3589 12.3615 11.1842 11.3471 12.1986L5.83683 17.7088C4.82241 18.7232 4.99719 20.5427 6.22721 21.7727C7.45722 23.0027 9.27669 23.1775 10.2911 22.1631L13.0462 19.408"
                                            stroke="#1A1A1A" fill="white" stroke-width="3" />
                                        <path
                                            d="M12.6561 15.3444C13.8494 16.5376 15.639 16.6825 16.6534 15.6681L22.1637 10.1579C23.1781 9.14346 23.0331 7.35382 21.8399 6.1606C20.6467 4.96738 18.857 4.82242 17.8426 5.83683L15.0875 8.59196"
                                            stroke="#1A1A1A" fill="white" stroke-width="3" />
                                    </svg>
                                </a></li>
                        </ul>
                    </div>
                    <div class="video-news__bottom">
                        <div class="single-news__content video-news__content">
                            @if($news->lead)
                                <p class="single-news__paragraph">{{$news->lead}}</p>
                            @endif
                            <div class="video-player">
                                <video class="video-player__video-tag" src="{{asset('storage/public/' . $news->video)}}"
                                       poster="{{asset('storage/public/' . $news->preview)}}"></video>
                                <div class="video-navigation hidden">
                                    <div class="video-navigation__progress"></div>
                                    <div class="video-navigation__controls">
                                        <div class="video-navigation__controls_left">

                                            <button class="btn-reset video-navigation__btn">
                                                <svg class="video-navigation__btn_svg--play" width="12" height="14"
                                                     viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M11.3648 6.11953L1.4741 0.793746C0.807869 0.435006 0 0.917542 0 1.67422V12.3258C0 13.0825 0.807868 13.565 1.4741 13.2063L11.3648 7.88047C12.066 7.5029 12.066 6.4971 11.3648 6.11953Z" />
                                                </svg>
                                                <svg class="video-navigation__btn_svg--pause" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="6" y="4" width="4" height="16" rx="1" />
                                                    <rect x="14" y="4" width="4" height="16" rx="1" />
                                                </svg>
                                            </button>
                                            <div class="video-navigation__volume">
                                                <button class="btn-reset video-navigation__sound_btn">
                                                    <svg class="video-navigation__sound_btn-unmute_svg" width="18"
                                                         height="16" viewBox="0 0 18 16" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M7.32429 0.536043L3 4.4998V4.49994H1C0.447715 4.49994 0 4.94765 0 5.49994V10.4999C0 11.0522 0.447715 11.4999 1 11.4999H3V11.4998L7.32426 15.4639C7.96566 16.0519 9 15.5969 9 14.7267V1.27321C9 0.403119 7.9657 -0.0518867 7.32429 0.536043ZM11 5C12.6569 5 14 6.34315 14 8C14 9.65685 12.6569 11 11 11V5ZM11 3C13.7614 3 16 5.23858 16 8C16 10.7614 13.7614 13 11 13V15C14.866 15 18 11.866 18 8C18 4.13401 14.866 1 11 1V3Z" />
                                                    </svg>
                                                    <svg class="video-navigation__sound_btn-mute_svg" width="19"
                                                         height="16" viewBox="0 0 19 16" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M7.32429 0.536043L3 4.4998V4.49994H1C0.447715 4.49994 0 4.94765 0 5.49994V10.4999C0 11.0522 0.447715 11.4999 1 11.4999H3V11.4998L7.32426 15.4639C7.96566 16.0519 9 15.5969 9 14.7267V1.27321C9 0.403119 7.9657 -0.0518867 7.32429 0.536043ZM17.293 4.29297C17.6835 3.90244 18.3165 3.90244 18.707 4.29297C19.0976 4.68349 19.0976 5.31651 18.707 5.70703L16.4141 8L18.707 10.293C19.0976 10.6835 19.0976 11.3165 18.707 11.707C18.3165 12.0976 17.6835 12.0976 17.293 11.707L15 9.41406L12.707 11.707C12.3165 12.0976 11.6835 12.0976 11.293 11.707C10.9024 11.3165 10.9024 10.6835 11.293 10.293L13.5859 8L11.293 5.70703C10.9024 5.31651 10.9024 4.68349 11.293 4.29297C11.6835 3.90244 12.3165 3.90244 12.707 4.29297L15 6.58594L17.293 4.29297Z" />
                                                    </svg>
                                                </button>
                                                <input type="range" class="video-navigation__range-input">
                                                <div class="video-navigation__slider-styled"
                                                     data-id="video-navigation__slider-round"></div>
                                            </div>
                                            <div class="video-navigation__timeline">
                                                <div class="video-navigation__timeline_current">
                                                    <!-- <span>01</span>
                                                    :
                                                    <span>46</span> -->
                                                </div>
                                                /
                                                <div class="video-navigation__timeline_duration">
                                                    <!-- <span>04</span>
                                                    :
                                                    <span>35</span> -->
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn-reset video-navigation__fullscreen">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 1H15C16.1046 1 17 1.89543 17 3V6M6 1H3C1.89543 1 1 1.89543 1 3V6M1 12V15C1 16.1046 1.89543 17 3 17H6M12 17H15C16.1046 17 17 16.1046 17 15V12"
                                                    stroke="#F2F2F2" stroke-width="2" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="video-player__media_description">
                                    <h3 class="video-player__media_title">
                                        {{$news->title}}
                                    </h3>
                                    <time>04:35</time>
                                </div>
                                <button class="btn-reset video-player__play-btn">
                                    <svg width="88" height="88" viewBox="0 0 88 88" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="44" cy="44" r="44" />
                                        <path
                                            d="M59.4805 42.051C60.8138 42.8208 60.8138 44.7453 59.4805 45.5151L38.4205 57.6741C37.0871 58.4439 35.4205 57.4816 35.4205 55.942L35.4205 31.624C35.4205 30.0844 37.0871 29.1222 38.4205 29.892L59.4805 42.051Z" />
                                    </svg>
                                </button>
                            </div>

                            @if($news->content)
                                    <div class="single-news__subInner" style="margin-top: 10px">
                                        <div class="video-news__text" style="font-family: 'Golos Text', sans-serif; font-size: 16px">
                                            {!! $news->content !!}
                                        </div>
                                    </div>
                            @endif
                            <div class="single-news-other__inner--video">
                                <h2 class="single-news-other__title">Также смотрите</h2>
                                <ul class="list-reset news-block__list single-news-other__list">
                                    @if($similarNews)
                                        @foreach($similarNews as $news)
                                            <li class="news-item @if($news->type === 'video') news-item--media @endif">
                                                <div class="news-item__media">
                                                    <img src="{{asset('storage/public/' . $news->image)}}"
                                                         alt="{{$news->title}}">
                                                    <button class="btn-reset news-item--media__btn">
                                                        <svg width="10" height="12" viewBox="0 0 10 12" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z"
                                                                fill="white" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="news-item__bottom">
                                                    <h6 class="news-item__title">
                                                        <a href="{{route('home.news.single', $news->slug)}}">{{$news->title}}</a>
                                                    </h6>
                                                    <div class="news-item__info">
                                                        <time datetime="2025-04-1 18:35" class="news-item_time">
                                                            {{$news->published_at}}
                                                        </time>
                                                        <div class="news-item_views">
                                                            <div class="item-views__icon">

                                                                <svg width="14" height="10" viewBox="0 0 14 10" fill="none"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z" />
                                                                </svg>
                                                            </div>
                                                            <span>12</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="single-news__right-block video-news__right-block">
                            <div class="ads-block">
                                <img src="{{asset('assets/add.jpg')}}" alt="add">
                            </div>
                            <div class="content__popular popular-sidebar popular-sidebar--news">
                                <h3 class="popular-sidebar__title">Популярное</h3>
                                <ul class="list-reset popular-sidebar__list">
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Учёные создали материал, который восстанавливается
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="{{asset('assets/img/views1.svg')}}" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            ИИ научился распознавать эмоции с точностью 99%
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Неожиданный рекорд: новый фильм собрал миллиарды за неделю
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Книга, которую никто не ожидал: бестселлер от неизвестного автора
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Музыкальная сенсация: трек, который взорвал чарты за день
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Редкое природное явление: когда его можно увидеть?
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            В недрах Ингушетии обнаружен новый драгоценный минерал
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Учёные создали материал, который восстанавливается
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Учёные создали материал, который восстанавливается
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Учёные создали материал, который восстанавливается
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Учёные создали материал, который восстанавливается
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Учёные создали материал, который восстанавливается
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Учёные создали материал, который восстанавливается
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Учёные создали материал, который восстанавливается
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="popular-sidebar__item">
                                        <a href="#" class="popular-sidebar__item_text">
                                            Учёные создали материал, который восстанавливается
                                        </a>
                                        <div class="popular-sidebar__item_info">
                                            <time datetime="2024-09-19 21:34" class="popular-sidebar__item_time">
                                                19 сен, 21:34
                                            </time>
                                            <div class="popular-sidebar__item_views">
                                                <div class="item-views__icon">
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
                                                </div>
                                                <span>99</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <h4>Не удалось определить тип новости</h4>
    @endif
@endsection

@push('scripts')
    <script defer src="{{asset('js/video-news.page.js')}}"></script>
@endpush
