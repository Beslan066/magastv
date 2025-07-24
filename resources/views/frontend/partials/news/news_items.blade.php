@if($items)
    @foreach($items as $news)
        <li class="news-item news-item--second @if($news->type === 'video') news-item--media @endif">
            <a href="{{ $news->type === 'news' ? route('home.news.single', $news->slug) : route('home.videos.single', $news->slug) }}">
                <div class="news-item__media active">
                    <img src="{{ asset('storage/public/' . $news->media) }}"
                         alt="{{ $news->title }}"
                         onerror="this.src='{{ asset('assets/img/default-news.jpg') }}'">
                    @if($news->type === 'video')
                        <button class="btn-reset news-item--media__btn">
                            <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z" fill="white"/>
                            </svg>
                        </button>
                    @endif
                </div>
            </a>
            <div class="news-item__bottom">
                <h6 class="news-item__title">
                    <a href="{{ $news->type === 'news' ? route('home.news.single', $news->slug) : route('home.videos.single', $news->slug) }}">
                        {{ $news->title }}
                    </a>
                </h6>
                <div class="news-item__descr">
                    <p>{{ $news->lead }}</p>
                </div>
                <div class="news-item__info">
                    <time datetime="{{ $news->published_at->format('Y-m-d H:i') }}" class="news-item_time">
                        {{ $news->published_at->format('d M, H:i') }}
                    </time>
                    <div class="news-item_views">
                        <div class="item-views__icon">
                            <svg width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z"/>
                            </svg>
                        </div>
                        <span>{{ $news->views }}</span>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
@endif
