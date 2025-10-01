@extends('layouts.frontend')

@push('meta')
    <title>Реклама НТРК "Магас"</title>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/advertising.page.css')}}">
@endpush

@section('content')
    <main class="advertising__page" data-main>
        <section class="advertising__main">
            <div class="container">
                <div class="advertising__inner">


                    <h1 class="advertising__title">
                        Реклама
                    </h1>
                    <div class="advertising__text">
                        <p>

                            Размещение рекламы на телерадиокомпании НТРК "Магас" — <b>это эффективный способ
                                донести информацию</b> о вашем продукте или услуге до широкой аудитории. Мы предлагаем
                            разнообразные форматы рекламных роликов, которые помогут вам привлечь внимание потенциальных
                            клиентов и повысить узнаваемость вашего бренда.
                        </p>

                    </div>
                    <div class="advertising__priceList">
                        <div class="advertising__priceList_img">
                            <picture>
                                <source srcset="{{asset('assets/img/priceListMobile.jpg')}}" media="(max-width:600px)">
                                <img src="{{asset('assets/img/pricelist.jpg')}}" alt="Price list">
                            </picture>
                        </div>
                        <a href="{{asset('assets/Цены.pdf')}}" download="Цены"
                           class="advertising__priceList_download">Скачать прай-лист на ТВ-рекламу</a>
                    </div>
                    <div class="advertising__text">
                        <p>
                            Для получения подробной информации о тарифах, доступных рекламных форматах, условиях
                            размещения и графике выхода рекламных материалов, а также для обсуждения индивидуальных
                            условий сотрудничества и персонализированных предложений, вы можете обратиться в нашу
                            рекламную службу. Мы с удовольствием проконсультируем вас, предоставим актуальный прайс-лист
                            и поможем подобрать оптимальное решение.
                        </p>

                    </div>
                    <div class="advertising__cards">
                        <article class="advertising__card">
                            <div class="advertising__card_inner">
                                <div class="advertising__card_body">
                                    <ul class="list-reset advertising__card_list">
                                        <li class="advertising__card_item">
                                            <span>Телефон:</span> <a href="tel:88734554055">8 (8734) 55-40-55</a>
                                            <span>Эл. почта:</span> <a href="mailto:advertising@ntrk-magas.ru">magas@magas.tv</a>

                                        </li>

                                        <li class="advertising__card_item" style="margin-top: 10px">

                                            <span>Контактное лицо</span>
                                            <a>Саид Сапралиев (директор по рекламе)</a>
                                            <span>Эл. почта:</span> <a href="mailto:said-ms@mail.ru">said-ms@mail.ru</a>
                                            <span>Телефон менеджера:</span>
                                            <a href="tel:79631740033">
                                                +7 963 174-00-33
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
