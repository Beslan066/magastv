@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/advertising.page.css')}}">
@endpush

@section('content')
    <main class="advertising__page" data-main>
        <section class="advertising__main">
            <div class="container">
                <div class="advertising__inner">
                    <h1 class="advertising__title">
                        Музыкальная открытка. "Шоана лаьрх1а илли"
                    </h1>
                    <div class="advertising__text">
                        <p>
                            Шоана лаьрх1а илли – концерт по вашим заявкам, где вы можете поздравить с днем рождения,
                            выразить благодарность или просто передать привет и порадовать родных и близких своим
                            вниманием. Ведь оно никогда не бывает лишним. Для вашего удобства мы выходим в эфир
                            ежедневно в 16:30.
                        </p>

                        <p>
                            Поздравление от ведущей + музыкальная композиция (до 4 мин) + показ 1 фото = 1000 руб.
                            (за каждое добавленное фото идёт доплата 100 руб.)
                        </p>

                        <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
                            <span>Видеопоздравление – 300 руб. (до 20 сек)</span>
                            <span>Обязательно: совершить оплату заранее!</span>
                            <span>Обязательно: прислать чек с датой оплаты!</span>
                            <span>Прислать информацию: ФИО, откуда, от кого в ТЕКСТОВОМ ВИДЕ…</span>
                            <span>Фотографии за столом, с едой, коллажи – НЕ ПРИНИМАЮТСЯ!</span>

                        </div>

                        <p style="display: flex; flex-direction: column; margin-bottom: 20px;">
                            <span>
                                ❗Привязка заказа по времени, по очередности – в начале или в конце программы + 10% – то есть 100 руб.
                            </span>
                            <span>❗Следите за эфиром с 16:30!</span>
                        </p>

                        <div style="display: flex; flex-direction: column;">
                            <span><b>Телефон для справок: 8 (963) – 172 – 65 – 59</b></span>
                            <span><b>Для оплаты введите сумму и нажмите на кнопку "Заплатить", далее следуйте инструкции.</b></span>
                        </div>

                        <h3>Для оплаты используйте удобный вам способ: Отсканируйте QR-код или напрямую через "Яндекс.Касса"</h3>

                        <div>
                            <img src="{{asset('assets/qr.jpeg')}}" alt="QR-код на оплату" height="200px" width="200px"/>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
