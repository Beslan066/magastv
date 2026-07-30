@extends('layouts.frontend')

@push('meta')
    <title>Результаты поиска - Национальная телерадиокомпания "Магас"</title>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/news-page.css')}}">
    <style>
        .search-results-page {
            padding: 40px 0;
            min-height: 60vh;
        }
        .search-results-page .page-title {
            font-family: 'Golos Text', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 10px;
        }
        .search-results-page .search-query {
            color: rgba(255,255,255,0.6);
            font-size: 18px;
            margin-bottom: 30px;
            font-family: 'Golos Text', sans-serif;
        }
        .search-results-page .search-query span {
            color: #70E780;
            font-weight: 600;
        }
        .search-results-page .search-count {
            color: rgba(255,255,255,0.6);
            font-family: 'Golos Text', sans-serif;
            font-size: 16px;
            margin-bottom: 20px;
            display: block;
        }
        .search-results-page .search-count strong {
            color: #70E780;
        }
        .search-results-page .news-content__news-block {
            width: 100%;
        }
        .search-results-page .news-block__list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }
        .search-results-page .news-item--second {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .search-results-page .news-item--second:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 25px rgba(0,0,0,0.3);
        }
        .search-results-page .news-item__media {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        .search-results-page .news-item__media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .search-results-page .news-item__media .news-item--media__btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0,0,0,0.7);
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .search-results-page .news-item__media .news-item--media__btn:hover {
            background: rgba(112, 231, 128, 0.8);
        }
        .search-results-page .news-item__bottom {
            padding: 15px;
        }
        .search-results-page .news-item__title {
            font-family: 'Golos Text', sans-serif;
            font-size: 18px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 10px;
            line-height: 1.3;
        }
        .search-results-page .news-item__title a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }
        .search-results-page .news-item__title a:hover {
            color: #70E780;
        }
        .search-results-page .news-item__descr p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 12px;
        }
        .search-results-page .news-item__info {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        .search-results-page .news-item_time {
            color: rgba(255, 255, 255, 0.5);
            font-size: 13px;
            font-family: 'Golos Text', sans-serif;
        }
        .search-results-page .no-results {
            text-align: center;
            padding: 60px 20px;
        }
        .search-results-page .no-results p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 18px;
            font-family: 'Golos Text', sans-serif;
        }
        .search-results-page .no-results a {
            display: inline-block;
            margin-top: 20px;
            color: #70E780;
            text-decoration: none;
            font-family: 'Golos Text', sans-serif;
            font-weight: 500;
            padding: 10px 30px;
            border: 1px solid #70E780;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .search-results-page .no-results a:hover {
            background: #70E780;
            color: #000;
        }
        .search-results-page .section-title {
            font-family: 'Golos Text', sans-serif;
            font-size: 24px;
            font-weight: 600;
            color: #70E780;
            margin-bottom: 20px;
        }
        .search-results-page .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        .search-results-page .pagination .page-item {
            list-style: none;
        }
        .search-results-page .pagination .page-link {
            display: block;
            padding: 8px 16px;
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            text-decoration: none;
            font-family: 'Golos Text', sans-serif;
            transition: all 0.3s;
        }
        .search-results-page .pagination .page-link:hover {
            background: rgba(112, 231, 128, 0.1);
            border-color: #70E780;
        }
        .search-results-page .pagination .active .page-link {
            background: #70E780;
            color: #000;
            border-color: #70E780;
        }
        .search-results-page .pagination .disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('content')
    <main class="search-results-page">
        <div class="container">
            <h1 class="page-title">Результаты поиска</h1>
            @if(!empty($query))
                <p class="search-query">
                    По запросу: <span>"{{ $query }}"</span>
                </p>
            @endif

            @if(isset($message))
                <div class="no-results">
                    <p>{{ $message }}</p>
                    <a href="{{ route('home') }}">Вернуться на главную</a>
                </div>
            @else
                @php
                    $totalResults = ($news->total() ?? 0) + ($videos->total() ?? 0);
                @endphp

                @if($totalResults > 0)
                    <span class="search-count">Найдено: <strong>{{ $totalResults }}</strong> записей</span>

                    <div class="news-content__news-block">
                        @if($news->count() > 0)
                            <h2 class="section-title">📰 Новости ({{ $news->total() }})</h2>
                            <ul class="list-reset news-block__list">
                                @foreach($news as $item)
                                    @include('partials.search-result-item', ['item' => $item, 'type' => 'news'])
                                @endforeach
                            </ul>
                            <div class="pagination">
                                {{ $news->appends(['q' => $query, 'category' => $category])->links() }}
                            </div>
                        @endif

                        @if($videos->count() > 0)
                            <h2 class="section-title" style="margin-top: 40px;">🎬 Видеорепортажи ({{ $videos->total() }})</h2>
                            <ul class="list-reset news-block__list">
                                @foreach($videos as $item)
                                    @include('partials.search-result-item', ['item' => $item, 'type' => 'video'])
                                @endforeach
                            </ul>
                            <div class="pagination">
                                {{ $videos->appends(['q' => $query, 'category' => $category])->links() }}
                            </div>
                        @endif
                    </div>
                @else
                    <div class="no-results">
                        <p>По вашему запросу "{{ $query }}" ничего не найдено.</p>
                        <a href="{{ route('home') }}">Вернуться на главную</a>
                    </div>
                @endif
            @endif
        </div>
    </main>
@endsection
