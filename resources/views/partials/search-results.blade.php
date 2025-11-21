@foreach($results as $item)
    <div class="menu-news @if($item instanceof \App\Models\VideoReportage) menu-news--media @endif"
         data-menu-category="{{ $item->category->slug ?? '' }}">
        <div class="menu-news__media">
            @if($item instanceof \App\Models\VideoReportage)
                <video src="{{ Storage::url($item->video) }}" poster="{{ Storage::url($item->preview) }}"></video>
                <button class="btn-reset menu-news__play-btn">
                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z" fill="white"></path>
                    </svg>
                </button>
            @else
                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}">
            @endif
        </div>
        <div class="menu-news__info">
            <h6 class="menu-news__title">
                <a href="{{ $item instanceof \App\Models\VideoReportage ? route('video.show', $item->slug) : route('news.show', $item->slug) }}">
                    {{ $item->title }}
                </a>
            </h6>
            <div class="menu-news__text">
                <p>{{ $item->lead }}</p>
            </div>
            <div class="menu-news__meta">
                <time>{{ $item->published_at->format('d M, H:i') }}</time>
                <div class="menu-news__views">
                    <div class="menu-news__icon">
                        <svg width="18" height="12" viewBox="0 0 18 12" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.99998 0C14.0312 0 16.9533 4.44092 17.7656 5.875C17.921 6.14927 17.9148 6.47693 17.7461 6.74316C16.907 8.0657 13.9914 12 8.99998 12C4.00872 11.9999 1.0939 8.06568 0.254863 6.74316C0.086031 6.47689 0.078957 6.14935 0.234355 5.875C1.04653 4.44117 3.96865 0.000143146 8.99998 0ZM8.99998 3C7.34324 3.00013 5.99998 4.34323 5.99998 6C5.99998 7.65677 7.34324 8.99987 8.99998 9C10.6568 9 12 7.65685 12 6C12 4.34315 10.6568 3 8.99998 3Z"></path>
                        </svg>
                    </div>
                    <span>{{ $item->views }}</span>
                </div>
            </div>
        </div>
    </div>
@endforeach

@if($hasMore)
    <div class="menu-list__more">
        <a href="{{ route('search.all', ['query' => $query]) }}" class="btn btn--more">Все результаты</a>
    </div>
@endif
