@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/about-us.page.css')}}">
@endpush

@section('content')
    <main class="about-us" data-main>
        <section class="about-us__content">
            <div class="container">
                <h1 class="page-title">
                    О компании
                </h1>
                <div class="about-us__inner">
                    <div class="about-us--left">
                        <div class="about-us__text">
                            <p>
                                {{$about->lead}}
                            </p>
                        </div>
                        <div class="about-us__media">
                            <div class="about-us__image">
                                <img src="{{asset('storage/public/' . $about->image)}}" alt="Здание НТРК Магас">
                            </div>
                            @if($about->image_author)
                                <span class="about-us__media_subtitle">
                                Фото: НТРК Магас
                            </span>
                            @endif
                        </div>
                        <div class="about-us__text">
                            {!! $about->content !!}
                        </div>
                    </div>
                    @if($supervisor)
                        <div class="about-us--right">
                            <div class="about-us__director director">
                                <div class="director__top">
                                    <div class="director__image">
                                        <img src="{{asset('storage/public/' . $supervisor->image)}}"
                                             alt="{{$supervisor->name}}">
                                    </div>
                                </div>
                                <div class="director__bottom">
                                    <div class="director__info">
                                        <h6 class="director__name">{{$supervisor->name}}</h6>
                                        <span>{{$supervisor->lead}}</span>
                                    </div>
                                    <address class="director__address">
                                        <ul class="list-reset director__list">
                                            <li class="director__item">
                                                <span>Телефон</span>
                                                <a>{{$supervisor->phone}}</a>
                                            </li>
                                            <li class="director__item">
                                                <span>Факс</span>
                                                <a href="tel:88734554055">{{$supervisor->fax}}</a>
                                            </li>
                                            <li class="director__item">
                                                <span>Email</span>
                                                <a href="mailto:magas.tv@magas.tv">{{$supervisor->email}}</a>
                                            </li>
                                        </ul>
                                    </address>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
