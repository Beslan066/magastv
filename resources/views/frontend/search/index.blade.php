@extends('layouts.frontend')

@section('content')
    <div class="container" style="padding: 40px 0; min-height: 60vh;">
        <h1 style="font-family: 'Golos Text', sans-serif; font-size: 32px; font-weight: 700; color: #fff; margin-bottom: 30px;">
            Результаты поиска: "{{ $query }}"
        </h1>

        @if(isset($message))
            <p style="color: rgba(255,255,255,0.7); font-size: 18px; text-align: center; padding: 40px 0;">{{ $message }}</p>
        @else
            <div class="search-results">
                @if($news->count() > 0 || $videos->count() > 0)
                    @if($news->count() > 0)
                        <h2 style="font-family: 'Golos Text', sans-serif; font-size: 24px; font-weight: 600; color: #70E780; margin-bottom: 20px;">
                            Новости ({{ $news->total() }})
                        </h2>
                        <div class="news-list" style="display: grid; gap: 20px;">
                            @foreach($news as $item)
                                @include('partials.search-result-item', ['item' => $item, 'type' => 'news'])
                            @endforeach
                        </div>
                        <div style="margin-top: 30px;">
                            {{ $news->appends(['q' => $query, 'category' => $category])->links('vendor.pagination.simple') }}
                        </div>
                    @endif

                    @if($videos->count() > 0)
                        <h2 style="font-family: 'Golos Text', sans-serif; font-size: 24px; font-weight: 600; color: #70E780; margin-bottom: 20px; margin-top: 40px;">
                             Видеорепортажи ({{ $videos->total() }})
                        </h2>
                        <div class="videos-list" style="display: grid; gap: 20px;">
                            @foreach($videos as $item)
                                @include('partials.search-result-item', ['item' => $item, 'type' => 'video'])
                            @endforeach
                        </div>
                        <div style="margin-top: 30px;">
                            {{ $videos->appends(['q' => $query, 'category' => $category])->links('vendor.pagination.simple') }}
                        </div>
                    @endif
                @else
                    <p style="color: rgba(255,255,255,0.7); font-size: 18px; text-align: center; padding: 40px 0;">
                        По вашему запросу "{{ $query }}" ничего не найдено.
                    </p>
                @endif
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .pagination .page-item {
            list-style: none;
        }

        .pagination .page-link {
            display: block;
            padding: 8px 16px;
            color: #000;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            text-decoration: none;
            font-family: 'Golos Text', sans-serif;
            transition: all 0.3s;
        }

        .pagination .page-link:hover {
            background: rgba(112, 231, 128, 0.1);
            border-color: #70E780;
        }

        .pagination .active .page-link {
            background: #70E780;
            color: #000;
            border-color: #70E780;
        }

        .pagination .disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
@endpush
