@extends('layouts.frontend')

@push('meta')
    <title>Аудио-передачи НТРК "Магас"</title>
@endpush


@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/transfers.page.css')}}">
@endpush

@section('content')
    <main class="transfers__page" data-main>
        <section class="transfers-content">
            <div class="container">
                <div class="transfers__inner">
                    <div class="transfers__top">
                        <h1 class="page-title">
                            Программы
                        </h1>
                    </div>
                    <div class="transfers__bottom">
                        <ul class="list-reset transfers__list">
                            @if(isset($transfers))
                                @foreach($transfers as $transfer)
                                    <li class="transferItem active">
                                        <div class="transferItem_media" style="height: 158px !important;">
                                            <a href="{{route('radio.transfer.single', $transfer->id)}}">
                                                <img src="{{asset('storage/public/' . $transfer->image)}}" alt="{{$transfer->title}}">
                                            </a>
                                        </div>
                                        <div class="radio-item__info">
                                            <h6 class="transferItem_title">
                                                <a href="{{route('radio.transfer.single', $transfer->id)}}">{{$transfer->title}}</a>
                                                @if(isset($transfer->age_restriction))
                                                    <span class="age-span">
                                                            {{$transfer->age_restriction->title}}
                                                        </span>
                                                @endif
                                            </h6>
                                        </div>

                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
