<div class="search-result-item" style="background: rgba(255, 255, 255, 0.05); border-radius: 12px; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.1); transition: transform 0.3s, box-shadow 0.3s;">
    <div class="search-result-item__media" style="position: relative; height: 200px; overflow: hidden;">
        @if($type === 'video')
            @php
                $imageUrl = isset($item->preview) ? Storage::url($item->preview) : (isset($item->image) ? Storage::url($item->image) : asset('assets/default-video.jpg'));
            @endphp
            <img src="{{ $imageUrl }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                    <circle cx="24" cy="24" r="24" fill="rgba(0,0,0,0.7)"/>
                    <path d="M30 24L20 30V18L30 24Z" fill="white"/>
                </svg>
            </div>
            <div style="position: absolute; bottom: 10px; right: 10px; background: rgba(0,0,0,0.8); padding: 4px 12px; border-radius: 4px;">
                <span style="color: #fff; font-size: 12px; font-family: 'Golos Text', sans-serif;">▶ Видео</span>
            </div>
        @else
            @php
                $imageUrl = isset($item->image) ? Storage::url($item->image) : (isset($item->media) ? $item->media : asset('assets/default-news.jpg'));
            @endphp
            <img src="{{ $imageUrl }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            <div style="position: absolute; bottom: 10px; right: 10px; background: rgba(0,0,0,0.8); padding: 4px 12px; border-radius: 4px;">
                <span style="color: #fff; font-size: 12px; font-family: 'Golos Text', sans-serif;">📰 Новость</span>
            </div>
        @endif
    </div>
    <div class="search-result-item__content" style="padding: 15px;">
        <h3 style="font-family: 'Golos Text', sans-serif; font-size: 18px; font-weight: 600; color: #fff; margin-bottom: 10px; line-height: 1.3;">
            <a href="{{ $type === 'video' ? route('home.videos.single', ['slug' => $item->slug]) : route('home.news.single', ['slug' => $item->slug]) }}"
               style="color: #fff; text-decoration: none; transition: color 0.3s;">
                {{ $item->title }}
            </a>
        </h3>
        @if(!empty($item->lead))
            <p style="color: rgba(255, 255, 255, 0.7); font-size: 14px; line-height: 1.6; margin-bottom: 12px;">
                {{ Str::limit($item->lead, 150) }}
            </p>
        @endif
        <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap; padding-top: 10px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
            <time style="color: rgba(255, 255, 255, 0.5); font-size: 13px; font-family: 'Golos Text', sans-serif;">
                {{ isset($item->published_at) ? \Carbon\Carbon::parse($item->published_at)->format('d.m.Y H:i') : '' }}
            </time>
            <span style="color: rgba(255, 255, 255, 0.5); font-size: 13px; font-family: 'Golos Text', sans-serif;">
                👁 {{ $item->views ?? 0 }}
            </span>
            @if(isset($item->category) && $item->category)
                <span style="color: #70E780; font-size: 13px; font-family: 'Golos Text', sans-serif; background: rgba(112, 231, 128, 0.1); padding: 2px 12px; border-radius: 12px;">
                    {{ $item->category->name ?? '' }}
                </span>
            @endif
        </div>
    </div>
</div>

<style>
    .search-result-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 25px rgba(0,0,0,0.3);
    }
    .search-result-item__content h3 a:hover {
        color: #70E780 !important;
    }
</style>
