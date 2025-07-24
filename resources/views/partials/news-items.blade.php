@foreach($items as $item)
    <li class="news-item @if($item->type === 'video') news-item--media @endif">
        <a href="{{route('home.news.single', $item->slug)}}">
            <div class="news-item__media">
                <img src="{{asset('storage/public/' . $item->media)}}" alt="{{$item->title}}">
                @if($item->type === 'video')
                    <button class="btn-reset news-item--media__btn">
                        <svg>...</svg>
                    </button>
                @endif
            </div>
        </a>
        <div class="news-item__bottom">
            <h6 class="news-item__title">
                <a href="{{route('home.news.single', $item->slug)}}">{{$item->title}}</a>
            </h6>
            <div class="news-item__descr">
                <p>{{$item->lead}}</p>
            </div>
            <div class="news-item__info">
                <time datetime="{{$item->published_at}}" class="news-item_time">
                    {{$item->formatted_published_at}}
                </time>
                <div class="news-item_views">
                    <div class="item-views__icon">
                        <svg>...</svg>
                    </div>
                    <span>{{$item->views}}</span>
                </div>
            </div>
        </div>
    </li>
@endforeach
