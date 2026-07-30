<li class="news-item news-item--second search-result-item">
    <a href="{{ $type === 'video' ? route('home.videos.single', ['slug' => $item->slug]) : route('home.news.single', ['slug' => $item->slug]) }}">
        <div class="news-item__media">
            @if($type === 'video')
                @php
                    $imageUrl = isset($item->preview) ? asset('storage/public/' . $item->preview) :
                               (isset($item->image) ? asset('storage/public/' . $item->image) : asset('assets/default-video.jpg'));
                @endphp
                <img src="{{ $imageUrl }}" alt="{{ $item->title }}">
                <button class="btn-reset news-item--media__btn">
                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z" fill="white" />
                    </svg>
                </button>
            @else
                @php
                    $imageUrl = isset($item->image) ? asset('storage/public/' . $item->image) :
                               (isset($item->media) ? $item->media : asset('assets/default-news.jpg'));
                @endphp
                <img src="{{ $imageUrl }}" alt="{{ $item->title }}">
            @endif
        </div>
    </a>
    <div class="news-item__bottom">
        <h6 class="news-item__title">
            <a href="{{ $type === 'video' ? route('home.videos.single', ['slug' => $item->slug]) : route('home.news.single', ['slug' => $item->slug]) }}">
                {{ $item->title }}
            </a>
        </h6>
        <div class="news-item__descr">
            <p>{{ Str::limit($item->lead ?? '', 150) }}</p>
        </div>
        <div class="news-item__info">
            <time datetime="{{ isset($item->published_at) ? \Carbon\Carbon::parse($item->published_at)->format('Y-m-d H:i') : '' }}" class="news-item_time">
                {{ isset($item->published_at) ? \Carbon\Carbon::parse($item->published_at)->format('d.m.Y H:i') : '' }}
            </time>
        </div>
    </div>
</li>
