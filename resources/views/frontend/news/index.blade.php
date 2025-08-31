@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/news-page.css')}}">
@endpush

@section()
    <main class="news-page" data-main>
        <section class="news-content">
            <div class="container">
                <div class="news-content__inner">
                    <div class="news-content__top">
                        <h1 class="page-title">Новости</h1>
                        <div class="news-content__tabs_wrapper">
                            <div class="tabs">
                                <ul class="list-reset tabs__list" id="categories-list">
                                    <li class="tab active" data-category-id="all">
                                        <span>Все</span>
                                    </li>
                                    @foreach($categories as $category)
                                        <li class="tab" data-category-id="{{ $category->id }}">
                                            <span>{{$category->name}}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <button class="btn-reset news-content__filters_btn">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 6L13 6" stroke="#1A1A1A" stroke-width="1.5" />
                                    <path d="M17 14L7 14" stroke="#1A1A1A" stroke-width="1.5" />
                                    <circle cx="5" cy="14" r="2.25" stroke="#1A1A1A" stroke-width="1.5" />
                                    <circle cx="15" cy="6" r="2.25" stroke="#1A1A1A" stroke-width="1.5" />
                                </svg>
                                Фильтры
                            </button>
                        </div>
                        <div class="filters">
                            <div class="filter-item filters--sort">
                                <span class="filter-item__title">
                                    Сортировка
                                </span>
                                <div class="dropdown">
                                    <button type="button" class="dropdown__button">По дате</button>
                                    <ul class="dropdown__list">
                                        <li class="dropdown__list-item" data-value="Любой">По дате</li>
                                        <li class="dropdown__list-item dropdown__list-item_active"
                                            data-value="до 100 дней">до 100 дней</li>
                                        <li class="dropdown__list-item" data-value="от 100 до 200 дней">от 100 до 200
                                            дней</li>
                                        <li class="dropdown__list-item" data-value="более 200 дней">более 200 дней</li>
                                    </ul>
                                    <input type="text" name="select-category" value="" class="dropdown__input_hidden">
                                </div>
                            </div>
                            <div class="filter-item filters--time">
                                <span class="filter-item__title">
                                    Период
                                </span>
                                <div class="dropdown">
                                    <button type="button" class="dropdown__button">Весь период</button>
                                    <ul class="dropdown__list">
                                        <li class="dropdown__list-item" data-value="Любой">Весь период</li>
                                        <li class="dropdown__list-item dropdown__list-item_active"
                                            data-value="Последняя неделя">Последняя неделя</li>
                                        <li class="dropdown__list-item" data-value="Последний месяц">Последний месяц
                                        </li>
                                        <li class="dropdown__list-item" data-value="Последний год">Последний год</li>
                                    </ul>
                                    <input type="text" name="select-category" value="" class="dropdown__input_hidden">
                                </div>
                            </div>
                            <div class="filter-item filters--content">
                                <span class="filter-item__title">
                                    Контент
                                </span>
                                <div class="dropdown">
                                    <button type="button" class="dropdown__button">Весь контент</button>
                                    <ul class="dropdown__list">
                                        <li class="dropdown__list-item" data-value="Любой">Весь контент</li>
                                        <li class="dropdown__list-item dropdown__list-item_active"
                                            data-value="до 100 дней">до 100 дней</li>
                                        <li class="dropdown__list-item" data-value="от 100 до 200 дней">от 100 до 200
                                            дней</li>
                                        <li class="dropdown__list-item" data-value="более 200 дней">более 200 дней</li>
                                    </ul>
                                    <input type="text" name="select-category" value="" class="dropdown__input_hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="news-content__bottom">
                        <div class="news-content__left">




                            <div class="news-content__news-block">
                                <ul class="list-reset news-block__list news-block__list--second">
                                    <li class="news-item news-item--second main-news-item" data-category="society">
                                        <a href="#">
                                            <div class="news-item__media">
                                                <img src="./assets/img/zagl1.jpg"
                                                     alt="С началом весны участились случаи возгорания сухой травы и сжигания мусора.">
                                                <button class="btn-reset news-item--media__btn">
                                                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z"
                                                            fill="white" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                        <div class="news-item__bottom">
                                            <h6 class="news-item__title">
                                                <a href="#">С началом весны участились случаи возгорания сухой
                                                    травы
                                                    и сжигания мусора.</a>
                                            </h6>
                                            <div class="news-item__descr">
                                                <p>С приходом весны участились случаи возгорания сухой травы и
                                                    несанкционированного сжигания мусора. Тёплая и ветреная погода
                                                    способствует быстрому распространению огня, создавая угрозу для
                                                    лесов, домов и даже жизни людей. Спасатели призывают соблюдать
                                                    правила пожарной безопасности и напоминают: даже небольшой
                                                    костёр может обернуться большой бедой.</p>
                                            </div>
                                            <div class="news-item__info">
                                                <time datetime="2025-04-1 18:35" class="news-item_time">
                                                    1 апр, 18:35
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
                                    <li class="news-item news-item--second" data-category="economy">
                                        <a href="#">
                                            <div class="news-item__media">
                                                <img src="./assets/img/newsItem2.png"
                                                     alt="В Карабулаке и Джейрахе прошли продовольственные ярмарки, приуроченные к священному месяцу Рамадан.">
                                                <button class="btn-reset news-item--media__btn">
                                                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z"
                                                            fill="white" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                        <div class="news-item__bottom">
                                            <h6 class="news-item__title">
                                                <a href="#">В Карабулаке и Джейрахе прошли продовольственные
                                                    ярмарки, приуроченные к священному месяцу Рамадан.</a>
                                            </h6>
                                            <div class="news-item__descr">
                                                <p>В Карабулаке и Джейрахе состоялись продовольственные ярмарки,
                                                    приуроченные к священному месяцу Рамадан. </p>
                                            </div>
                                            <div class="news-item__info">
                                                <time datetime="2025-03-28 12:53" class="news-item_time">
                                                    28 мар, 12:53
                                                </time>
                                                <div class="news-item_views">
                                                    <div class="item-views__icon">

                                                        <svg width="14" height="10" viewBox="0 0 14 10" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z" />
                                                        </svg>
                                                    </div>
                                                    <span>34</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="news-item news-item--second news-item--media" data-category="policy">
                                        <a href="#">
                                            <div class="news-item__media">
                                                <img src="./assets/img/newsItem3.png"
                                                     alt="7 апреля в кампусе “Школы 21” в Магасе начнётся седьмой отборочный «бассейн».">
                                                <button class="btn-reset news-item--media__btn">
                                                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z"
                                                            fill="white" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                        <div class="news-item__bottom">
                                            <h6 class="news-item__title">
                                                <a href="#">7 апреля в кампусе “Школы 21” в Магасе начнётся
                                                    седьмой отборочный «бассейн».</a>
                                            </h6>
                                            <div class="news-item__descr">
                                                <p>7 апреля в кампусе «Школы 21» в Магасе стартует уже седьмой
                                                    отборочный «бассейн» — интенсивный этап отбора, где участники
                                                    смогут погрузиться в мир программирования и проверить свои
                                                    навыки в условиях максимальной концентрации. </p>
                                            </div>
                                            <div class="news-item__info">
                                                <time datetime="2025-03-28 20:25" class="news-item_time">
                                                    28 мар, 20:25
                                                </time>
                                                <div class="news-item_views">
                                                    <div class="item-views__icon">

                                                        <svg width="14" height="10" viewBox="0 0 14 10" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z" />
                                                        </svg>
                                                    </div>
                                                    <span>142</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="news-item news-item--second" data-category="tourism">
                                        <a href="#">
                                            <div class="news-item__media">
                                                <img src="./assets/img/newsItem4.png"
                                                     alt="В НИИ прошел семинар, посвященный 255-летию добровольного вхождения Ингушетии в состав России.">
                                                <button class="btn-reset news-item--media__btn">
                                                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z"
                                                            fill="white" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                        <div class="news-item__bottom">
                                            <h6 class="news-item__title">
                                                <a href="#">В НИИ прошел семинар, посвященный 255-летию
                                                    добровольного вхождения Ингушетии в состав России.</a>
                                            </h6>
                                            <div class="news-item__descr">
                                                <p>В научно-исследовательском институте состоялся семинар,
                                                    посвящённый 255-летию исторического события – вхождению
                                                    Ингушетии в состав России. </p>
                                            </div>
                                            <div class="news-item__info">
                                                <time datetime="2025-03-28 12:53" class="news-item_time">
                                                    27 мар, 22:05
                                                </time>
                                                <div class="news-item_views">
                                                    <div class="item-views__icon">

                                                        <svg width="14" height="10" viewBox="0 0 14 10" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z" />
                                                        </svg>
                                                    </div>
                                                    <span>54</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="news-item news-item--second" data-category="entertainment">
                                        <a href="#">
                                            <div class="news-item__media">
                                                <img src="./assets/img/newsItem5.png"
                                                     alt="Зелимхан Бакаев включен в окончательный состав сборной России">
                                                <button class="btn-reset news-item--media__btn">
                                                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z"
                                                            fill="white" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                        <div class="news-item__bottom">
                                            <h6 class="news-item__title">
                                                <a href="#">Зелимхан Бакаев включен в окончательный состав
                                                    сборной России</a>
                                            </h6>
                                            <div class="news-item__descr">
                                                <p>Полузащитник Зелимхан Бакаев вошёл в финальный список игроков,
                                                    которые представят сборную России в предстоящих матчах.</p>
                                            </div>
                                            <div class="news-item__info">
                                                <time datetime="2025-03-27 23:53" class="news-item_time">
                                                    27 мар, 23:53
                                                </time>
                                                <div class="news-item_views">
                                                    <div class="item-views__icon">

                                                        <svg width="14" height="10" viewBox="0 0 14 10" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z" />
                                                        </svg>
                                                    </div>
                                                    <span>27</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="news-item news-item--second news-item--media"
                                        data-category="entertainment">
                                        <a href="#">
                                            <div class="news-item__media">
                                                <img src="./assets/img/newsItem6.png"
                                                     alt="Комфорт и безопасность: новые автобусы уже вышли на маршруты">
                                                <button class="btn-reset news-item--media__btn">
                                                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z"
                                                            fill="white" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                        <div class="news-item__bottom">
                                            <h6 class="news-item__title">
                                                <a href="#">Комфорт и безопасность: новые автобусы уже вышли на
                                                    маршруты</a>
                                            </h6>
                                            <div class="news-item__descr">
                                                <p>Горожане уже могут оценить новые современные автобусы, вышедшие
                                                    на маршруты. Комфортные сиденья, просторный салон и улучшенные
                                                    системы безопасности сделают поездки еще приятнее и удобнее для
                                                    пассажиров.</p>
                                            </div>
                                            <div class="news-item__info">
                                                <time datetime="2025-03-27 16:27" class="news-item_time">
                                                    27 мар, 16:27
                                                </time>
                                                <div class="news-item_views">
                                                    <div class="item-views__icon">

                                                        <svg width="14" height="10" viewBox="0 0 14 10" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z" />
                                                        </svg>
                                                    </div>
                                                    <span>264</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="news-item news-item--second news-item--media"
                                        data-category="entertainment">
                                        <a href="#">
                                            <div class="news-item__media">
                                                <img src="./assets/img/newsItem6.png"
                                                     alt="Комфорт и безопасность: новые автобусы уже вышли на маршруты">
                                                <button class="btn-reset news-item--media__btn">
                                                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z"
                                                            fill="white" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                        <div class="news-item__bottom">
                                            <h6 class="news-item__title">
                                                <a href="#">Комфорт и безопасность: новые автобусы уже вышли на
                                                    маршруты</a>
                                            </h6>
                                            <div class="news-item__descr">
                                                <p>Горожане уже могут оценить новые современные автобусы, вышедшие
                                                    на маршруты. Комфортные сиденья, просторный салон и улучшенные
                                                    системы безопасности сделают поездки еще приятнее и удобнее для
                                                    пассажиров.</p>
                                            </div>
                                            <div class="news-item__info">
                                                <time datetime="2025-03-27 16:27" class="news-item_time">
                                                    27 мар, 16:27
                                                </time>
                                                <div class="news-item_views">
                                                    <div class="item-views__icon">

                                                        <svg width="14" height="10" viewBox="0 0 14 10" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z" />
                                                        </svg>
                                                    </div>
                                                    <span>264</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                            <div class="tab-content" data-tab-content="2">


                                <div class="news-content__left_top">
                                    <article class="main-news">
                                        <div class="main-news__image">
                                            <img src="./assets/img/newsone.png" alt="Main news image">
                                        </div>
                                        <div class="main-news__info">
                                            <h4 class="main-news__title">
                                                <a href="#"> Более 40 мест для размещения туристов создали в
                                                    Ингушетии2</a>
                                            </h4>
                                            <div class="main-news__text">
                                                <p class="main-news__paragraph">
                                                    В Ингушетии появилось более 40 мест для размещения туристов в
                                                    мини-отелях в 2023-2024 годах, сообщил председатель комитета по
                                                    туризму
                                                    республики Магомед Цуроев во вторник.
                                                </p>
                                            </div>
                                            <div class="main-news__bottom">
                                                <time datetime="2025-04-1 21:34">Вчера, 21:34</time>
                                                <div class="main-news__views">
                                                    <div class="news-views__icon">
                                                        <svg width="14" height="10" viewBox="0 0 14 10" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z" />
                                                        </svg>


                                                    </div>
                                                    <span>34</span>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <div class="news-content__news-block">
                                    <ul class="list-reset news-block__list news-block__list--second">
                                        <li class="news-item news-item--second news-item--media">
                                            <div class="news-item__media">
                                                <img src="./assets/img/zagl.png" alt="News Item Preview">
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
                                                    <a href="#">С началом весны участились случаи возгорания сухой травы
                                                        и
                                                        сжигания мусора.</a>
                                                </h6>
                                                <div class="news-item__descr">
                                                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                                        Possimus
                                                        consequatur id harum! Aperiam, reprehenderit eaque.</p>
                                                </div>
                                                <div class="news-item__info">
                                                    <time class="news-item_time">
                                                        19 сен, 21:34
                                                    </time>
                                                    <div class="news-item_views">
                                                        <div class="item-views__icon">
                                                            <img src="./assets/img/Subtract.svg" alt="Eye icon">
                                                        </div>
                                                        <span>99</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="news-item news-item--second">
                                            <div class="news-item__media">
                                                <img src="./assets/img/zagl.png" alt="News Item Preview">
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
                                                    <a href="#">С началом весны участились случаи возгорания сухой травы
                                                        и
                                                        сжигания мусора.</a>
                                                </h6>
                                                <div class="news-item__descr">
                                                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                                        Possimus
                                                        consequatur id harum! Aperiam, reprehenderit eaque.</p>
                                                </div>
                                                <div class="news-item__info">
                                                    <time class="news-item_time">
                                                        19 сен, 21:34
                                                    </time>
                                                    <div class="news-item_views">
                                                        <div class="item-views__icon">
                                                            <img src="./assets/img/Subtract.svg" alt="Eye icon">
                                                        </div>
                                                        <span>99</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="news-item news-item--second">
                                            <div class="news-item__media">
                                                <img src="./assets/img/zagl.png" alt="News Item Preview">
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
                                                    <a href="#">С началом весны участились случаи возгорания сухой травы
                                                        и
                                                        сжигания мусора.</a>
                                                </h6>
                                                <div class="news-item__descr">
                                                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                                        Possimus
                                                        consequatur id harum! Aperiam, reprehenderit eaque.</p>
                                                </div>
                                                <div class="news-item__info">
                                                    <time class="news-item_time">
                                                        19 сен, 21:34
                                                    </time>
                                                    <div class="news-item_views">
                                                        <div class="item-views__icon">
                                                            <img src="./assets/img/Subtract.svg" alt="Eye icon">
                                                        </div>
                                                        <span>99</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <button class="news-content__load-more_btn">
                                Загрузить еще
                            </button>
                        </div>
                        <div class="news-content__right">
                            <div class="ads-block">
                                <img src="./assets/add.jpg" alt="add">
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
                                                    <img src="./assets/img/views1.svg" alt="Eye icon">
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
    </main>
@endsection

@push('scripts')
@endpush
