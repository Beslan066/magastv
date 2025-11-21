@extends('layouts.frontend')

@section('content')
    <div class="container">
        <h1>Результаты поиска: "{{ $query }}"</h1>

        <div class="search-results">
            @if($news->count() > 0)
                <h2>Новости</h2>
                <div class="news-list">
                    @foreach($news as $item)
                        @include('partials.search-result-item', ['item' => $item, 'type' => 'news'])
                    @endforeach
                </div>
                {{ $news->links() }}
            @endif

            @if($videos->count() > 0)
                <h2>Видеорепортажи</h2>
                <div class="videos-list">
                    @foreach($videos as $item)
                        @include('partials.search-result-item', ['item' => $item, 'type' => 'video'])
                    @endforeach
                </div>
                {{ $videos->links() }}
            @endif

            @if($news->count() == 0 && $videos->count() == 0)
                <p>Ничего не найдено.</p>
            @endif
        </div>
    </div>
@endsection
