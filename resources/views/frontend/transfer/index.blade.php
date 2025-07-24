@extends('layouts.frontend')

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
                            Передачи
                        </h1>
{{--                        <div class="news-content__tabs_wrapper">--}}
{{--                            <div class="tabs">--}}
{{--                                <ul class="list-reset tabs__list">--}}
{{--                                    <li class="tab active" data-tab="all">--}}
{{--                                        <span>Все</span>--}}
{{--                                    </li>--}}
{{--                                    @if(isset($categories))--}}
{{--                                        @foreach($categories as $category)--}}
{{--                                            <li class="tab" >--}}
{{--                                                <span>{{$category->title}}</span>--}}
{{--                                            </li>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="transfers__bottom">
                        <ul class="list-reset transfers__list">
                            @if(isset($transfers))
                                @foreach($transfers as $transfer)
                                    <li class="transferItem active">
                                        <div class="transferItem_media" style="height: 158px !important;">
                                            <img src="{{asset('storage/public/' . $transfer->image)}}" alt="{{$transfer->title}}">
                                        </div>
                                        <h6 class="transferItem_title">
                                            <a href="#">{{$transfer->title}}</a>
                                        </h6>
                                        <span class="transferItem_count">24 выпуска</span>
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
