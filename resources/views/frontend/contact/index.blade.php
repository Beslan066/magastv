@extends('layouts.frontend')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap" rel="stylesheet">

    <!-- Inter -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <!-- Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/pages/contacts.page.css')}}">
@endpush

@section('content')
    <main class="contacts__page" data-main>
        <section class="contacts__contacts">
            <div class="container">
                <h1 class="page-title">
                    Контакты
                </h1>

                <div class="contacts__inner">
                    <div class="contacts__main">
                        <div class="contacts__main_top">
                            <div class="contacts-map">
                                <iframe
                                    src="{{$contacts->content}}" frameborder="0"></iframe>
                            </div>
                            <address class="contacts__address">
                                <ul class="list-reset contacts__address_list">
                                    <li class="contacts__addres_item">
                                        <span>Адрес</span>
                                        <a>{{$contacts->address}}</a>
                                    </li>
                                    <li class="contacts__addres_item">
                                        <span>Телефон</span>
                                        <a href="tel:{{$contacts->phone}}">{{$contacts->phone}}</a>
                                    </li>

                                    <li class="contacts__addres_item">
                                        <span>Факс</span>
                                        <a href="tel:{{$contacts->fax}}">{{$contacts->fax}}</a>
                                    </li>
                                    <li class="contacts__addres_item contacts__addres_item--email">
                                        <span>Email</span>
                                        <a href="mailto:{{$contacts->email}}">{{$contacts->email}}</a>
                                    </li>
                                </ul>
                            </address>
                        </div>
                        <div class="contacts__requisite requisite">
                            <!-- <a href="./assets/add.jpg" download="test">download</a> -->
                            <div class="requisite__header">
                                <h6 class="requisite__title">Реквизиты организации</h6>
                                <a href="#" class="requisite__download">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 12V15C4 16.1046 4.89543 17 6 17H14C15.1046 17 16 16.1046 16 15V12"
                                              stroke="#1A1A1A" stroke-width="1.5" />
                                        <path d="M10 3V13" stroke="#1A1A1A" stroke-width="1.5" />
                                        <path d="M14 9L10 13L6 9" stroke="#1A1A1A" stroke-width="1.5" />
                                    </svg>
                                    Скачать
                                </a>
                            </div>
                            <div class="requisite__body">
                                <ul class="list-reset requisite__list">
                                    <li class="requisite__item">
                                        <span class="requisite__item_title">Полное наименование</span>
                                        <span class="requisite__item_content">Государственное автономное учреждение
                                            Республики Ингушетия «Национальная телерадиокомпания «Магас»</span>
                                    </li>
                                    <li class="requisite__item">
                                        <span class="requisite__item_title">Юридический адрес</span>
                                        <span class="requisite__item_content">386001 Республика Ингушетия,г. Магас, пр-т
                                            И. Зязикова, 15</span>
                                    </li>
                                    <li class="requisite__item">
                                        <span class="requisite__item_title">ОГРН</span>
                                        <span class="requisite__item_content">1110608000480</span>
                                    </li>
                                    <li class="requisite__item">
                                        <span class="requisite__item_title">ИНН / КПП</span>
                                        <span class="requisite__item_content">0608017209 / 060801001</span>
                                    </li>
                                    <li class="requisite__item">
                                        <span class="requisite__item_title">Расчетный счет</span>
                                        <span class="requisite__item_content">40602810060350050031</span>
                                    </li>
                                    <li class="requisite__item">
                                        <span class="requisite__item_title">Наименование и адрес обслуживающего
                                            банка</span>
                                        <span class="requisite__item_content">Ставропольское отделение №5230 ПАО
                                            Сбербанк, г. Ставрополь</span>
                                    </li>
                                    <li class="requisite__item">
                                        <span class="requisite__item_title">Корреспондентский счет </span>
                                        <span class="requisite__item_content">30101810907020000615 </span>
                                    </li>
                                    <li class="requisite__item">
                                        <span class="requisite__item_title">Код БИК</span>
                                        <span class="requisite__item_content">040702615</span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="contacts__ads">
                        <div class="ads-block">
                            <img src="./assets/add.jpg" alt="add">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
