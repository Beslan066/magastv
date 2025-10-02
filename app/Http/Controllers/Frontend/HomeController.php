<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Audiobook;
use App\Models\AudiobookFile;
use App\Models\Category;
use App\Models\Contact;
use App\Models\News;
use App\Models\RadioBroadcast;
use App\Models\RadioNews;
use App\Models\RadioShow;
use App\Models\RadioShowType;
use App\Models\RadioTransfer;
use App\Models\Supervisor;
use App\Models\Transfer;
use App\Models\TvShow;
use App\Models\TvShowType;
use App\Models\VideoReportage;
use App\Models\VideoTransfer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()->orderBy('id', 'desc')->get();

        // Новость или видеорепортаж из главного банера
        $newsQuery = News::query()
            ->select('id', 'title', 'slug', 'lead', 'image as media', 'published_at', 'category_id', 'views')
            ->where('status', 1)
            ->where('main_material', 1)
            ->addSelect(DB::raw("'news' as type"));

        $videosQuery = VideoReportage::query()
            ->select('id', 'title', 'slug', 'lead', 'preview as media', 'published_at', 'category_id', 'views')
            ->where('status', 1)
            ->whereNot('ing_news', 1)
            ->where('main_material', 1)
            ->addSelect(DB::raw("'video' as type"));

        $mainPost = $newsQuery->unionAll($videosQuery)
            ->orderBy('published_at', 'desc')
            ->first();

        // Базовые запросы
        $newsQuery = News::query()
            ->select('id', 'title', 'slug', 'lead', 'image as media', 'published_at', 'category_id', 'views')
            ->where('status', 1)
            ->addSelect(DB::raw("'news' as type"));

        $videosQuery = VideoReportage::query()
            ->select('id', 'title', 'slug', 'lead', 'preview as media', 'published_at', 'category_id', 'views')
            ->where('status', 1)
            ->whereNot('ing_news', 1)
            ->addSelect(DB::raw("'video' as type"));

        // Применяем фильтр по категории, если он есть
        if ($request->has('category_id') && $request->category_id != 'all') {
            $newsQuery->where('category_id', $request->category_id);
            $videosQuery->where('category_id', $request->category_id);
        }

        $items = $newsQuery->unionAll($videosQuery)
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        $transfers = Transfer::query()
            ->orderBy('id', 'asc')
            ->select(['id', 'title', 'lead', 'published', 'slider_image', 'slider_video'])
            ->where('main_material', 1)
            ->get();

        $allTransfers = Transfer::query()->select('id', 'title', 'image', 'slider_video', 'age_restriction_id')
            ->with('age_restriction')
            ->orderBy('id', 'asc')->limit(16)->get();

        $popularVideos = VideoTransfer::query()
            ->select('id', 'title', 'preview', 'video', 'transfer_id')
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        // Популярные материалы (новости + видео)
        $popularQuery = News::query()
            ->select('id', 'title', 'slug', 'lead', 'image as media', 'published_at', 'category_id', 'views')
            ->where('status', 1)
            ->where('published_at', '>=', now()->subDays(7))
            ->addSelect(DB::raw("'news' as type"))
            ->unionAll(
                VideoReportage::query()
                    ->select('id', 'title', 'slug', 'lead', 'preview as media', 'published_at', 'category_id', 'views')
                    ->where('status', 1)
                    ->where('published_at', '>=', now()->subDays(7))
                    ->whereNot('ing_news', 1)
                    ->addSelect(DB::raw("'video' as type"))
            )
            ->orderBy('views', 'desc')
            ->limit(7);

        $popularItems = $popularQuery->get();

        return view('frontend.index', [
            'categories' => $categories,
            'mainPost' => $mainPost,
            'items' => $items,
            'transfers' => $transfers,
            'allTransfers' => $allTransfers,
            'popularItems' => $popularItems,
            'popularVideos' => $popularVideos,
        ]);
    }

    public function filterNews(Request $request)
    {
        $categoryId = $request->get('category_id');

        $newsQuery = News::query()
            ->select('id', 'title', 'slug', 'lead', 'image as media', 'published_at', 'category_id', 'views')
            ->where('status', 1)
            ->addSelect(DB::raw("'news' as type"));

        $videosQuery = VideoReportage::query()
            ->select('id', 'title', 'slug', 'lead', 'preview as media', 'published_at', 'category_id', 'views')
            ->where('status', 1)
            ->whereNot('ing_news', 1)
            ->addSelect(DB::raw("'video' as type"));


        if (!empty($categoryId) && $categoryId !== 'all') {
            $newsQuery->where('category_id', $categoryId);
            $videosQuery->where('category_id', $categoryId);
        }


        $items = $newsQuery->unionAll($videosQuery)
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        $html = '';

        foreach ($items as $item) {
            $route = route('home.news.single', $item->slug);
            $img = asset('storage/public/' . $item->media);
            $views = $item->views;
            $title = e($item->title);
            $lead = e($item->lead);
            $time = $item->formatted_published_at;
            $isVideo = $item->type === 'video';

            $videoBtn = $isVideo
                ? '<button class="btn-reset news-item--media__btn">
                <svg width="10" height="12" viewBox="0 0 10 12"><path d="M9.39 5.12L1.48.81C.81.44 0 .93 0 1.68v8.63c0 .76.81 1.24 1.48.87l7.91-4.31c.7-.38.7-1.38 0-1.68z" fill="white"/></svg>
              </button>'
                : '';

            $videoClass = $isVideo ? 'news-item--media' : '';

            $html .= <<<HTML
<li class="news-item {$videoClass}">
    <a href="{$route}">
        <div class="news-item__media">
            <img src="{$img}" alt="{$title}">
            {$videoBtn}
        </div>
    </a>
    <div class="news-item__bottom">
        <h6 class="news-item__title"><a href="{$route}">{$title}</a></h6>
        <div class="news-item__descr"><p>{$lead}</p></div>
        <div class="news-item__info">
            <time class="news-item_time">{$time}</time>
            <div class="news-item_views">
                <div class="item-views__icon">
                    <svg width="14" height="10" viewBox="0 0 14 10"><path d="M7 .33C11.65.33 13.99 5.22 14 5.25c0 0-2.33 4.42-7 4.42S0 5.25 0 5.25C.01 5.22 2.35.33 7 .33zm0 2.33A2.333 2.333 0 004.67 5c0 1.29 1.04 2.33 2.33 2.33a2.333 2.333 0 002.33-2.33A2.333 2.333 0 007 2.66z"/></svg>
                </div>
                <span>{$views}</span>
            </div>
        </div>
    </div>
</li>
HTML;
        }

        return response()->json(['html' => $html]);
    }

    public function onAir()
    {
        $today = Carbon::today()->format('Y-m-d');

        $tvProgramsToday = TvShow::whereDate('program_date', $today)
            ->orderBy('time_range')
            ->get();

        return view('frontend.live.live', [
            'tvProgramsToday' => $tvProgramsToday
        ]);
    }

    public function tvProgram(Request $request)
    {
        $today = now();
        $selectedDate = $request->date ? Carbon::parse($request->date) : $today;

        // Оптимизированный запрос с eager loading
        $tvShows = TvShow::with('tvShowType')
            ->whereDate('program_date', $selectedDate->format('Y-m-d'))
            ->orderBy('time_range')
            ->get();

        // Быстрое формирование дат без лишних вычислений
        $dates = collect(range(-3, 3))->map(function ($day) use ($today, $selectedDate) {
            $date = $today->copy()->addDays($day);
            return [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('j'),
                'month' => mb_strtolower($date->translatedFormat('M')),
                'weekday' => $date->translatedFormat('D'),
                'is_active' => $date->isSameDay($selectedDate),
            ];
        });

        $currentShowId = null;
        if ($selectedDate->isToday()) {
            $currentTime = $today->format('H:i');
            $currentShow = $tvShows->last(function ($show) use ($currentTime) {
                return Carbon::parse($show->time_range)->format('H:i') <= $currentTime;
            });
            $currentShowId = $currentShow->id ?? null;
        }

        return view('frontend.tv-program.index', compact('tvShows', 'dates', 'selectedDate', 'currentShowId'));
    }

    public function transfers()
    {
        $categories = TvShowType::query()->orderBy('id', 'desc')->get();
        $transfers = Transfer::query()->orderBy('id', 'asc')->get();

        return view('frontend.transfer.index', [
            'transfers' => $transfers,
            'categories' => $categories,
        ]);
    }

    public function transfer($transfer)
    {

        $transfer = Transfer::query()->where('id', $transfer)->first();

        $transferVideos = VideoTransfer::query()
            ->where('transfer_id', $transfer->id)
            ->orderBy('id', 'desc')
            ->limit(40)
            ->get();


        $transferVideosCount = $transferVideos->count();


        return view('frontend.transfer.transfer', [
            'transferVideos' => $transferVideos,
            'transfer' => $transfer,
            'transferVideoCount' => $transferVideosCount,
        ]);
    }


    public function radio(Request $request)
    {
        // Кэшируем типы программ на 1 час
        $radioShowTypes = Cache::remember('radio_show_types', 3600, function () {
            return RadioShowType::select('id', 'title')->get();
        });

        // Кэшируем события на 5 минут
        $events = Cache::remember('radio_events_10', 300, function () {
            return RadioNews::query()
                ->select('id', 'title', 'lead', 'image', 'published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->take(10)
                ->get()
                ->each(function ($item) {
                    $item->formatted_published_at = Carbon::parse($item->published_at)->format('d.m.Y');
                });
        });

        // Фильтрация программ БЕЗ кэширования
        $categoryId = $request->category_id ?? 'all';

        $news = RadioTransfer::query()
            ->with(['radioShowType' => function($query) {
                $query->select('id', 'title');
            }, 'age_restriction'])
            ->select('id', 'title', 'image', 'created_at', 'radio_show_type_id', 'age_restriction_id')
            ->where('created_at', '<=', now())
            ->orderBy('created_at', 'desc');

        if ($categoryId != 'all') {
            $news->where('radio_show_type_id', $categoryId);
        }

        $news = $news->limit(6)
            ->get()
            ->each(function ($item) {
                $item->formatted_published_at = Carbon::parse($item->created_at)->format('d.m.Y');
            });

        // Обработка даты и расписания
        $today = now();
        $selectedDate = $request->date ? Carbon::parse($request->date) : $today;

        // Кэшируем расписание на день
        $cacheKeyShows = 'radio_shows_' . $selectedDate->format('Y-m-d');
        $radioShows = Cache::remember($cacheKeyShows, 60, function () use ($selectedDate) {
            return RadioShow::with(['radioShowType' => function($query) {
                $query->select('id', 'title');
            }])
                ->select('id', 'title', 'time_range', 'program_date', 'radio_show_type_id')
                ->whereDate('program_date', $selectedDate->format('Y-m-d'))
                ->get()
                ->sortBy(function ($show) {
                    // Извлекаем время начала и преобразуем в сортируемый формат
                    $startTime = trim(explode('-', $show->time_range)[0]);
                    return Carbon::createFromFormat('H:i', $startTime)->format('Hi');
                })
                ->values()
                ->each(function ($show) use ($selectedDate) {
                    // Предварительно вычисляем активное шоу для сегодняшнего дня
                    if ($selectedDate->isToday()) {
                        [$startTime, $endTime] = explode('-', $show->time_range);
                        $start = Carbon::createFromTimeString(trim($startTime));
                        $end = Carbon::createFromTimeString(trim($endTime));
                        $now = now();

                        $show->is_active = $now->between($start, $end);
                        $show->formatted_time = trim($startTime);
                    } else {
                        $show->is_active = false;
                        $show->formatted_time = trim(explode('-', $show->time_range)[0]);
                    }
                });
        });


        // Определяем текущее активное шоу
        $currentShowId = null;
        if ($selectedDate->isToday()) {
            $currentShow = $radioShows->firstWhere('is_active', true);
            $currentShowId = $currentShow->id ?? null;
        }

        // Генерируем даты для календаря
        $dates = collect(range(-3, 3))->map(function ($day) use ($today, $selectedDate) {
            $date = $today->copy()->addDays($day);
            return [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('j'),
                'month' => mb_strtolower($date->translatedFormat('M')),
                'weekday' => $date->translatedFormat('D'),
                'is_active' => $date->isSameDay($selectedDate),
            ];
        });

        // Кэшируем аудиокниги на 1 час
        $books = Cache::remember('audio_books_6', 3600, function () {
            return Audiobook::query()
                ->with(['author' => function($query) {
                    $query->select('id', 'name');
                }])
                ->select('id', 'title', 'image', 'author_id')
                ->orderBy('id', 'desc')
                ->take(6)
                ->get();
        });

        return view('frontend.radio.index', [
            'events' => $events,
            'dates' => $dates,
            'selectedDate' => $selectedDate,
            'currentShowId' => $currentShowId,
            'radioShows' => $radioShows,
            'news' => $news,
            'radioShowTypes' => $radioShowTypes,
            'books' => $books,
            'selectedCategory' => $categoryId
        ]);
    }

    public function clearRadioCache()
    {
        Cache::forget('radio_show_types');
        Cache::forget('radio_events_10');
        Cache::forget('audio_books_6');

        // Очищаем кэш программ по категориям
        $categories = RadioShowType::pluck('id');
        foreach ($categories as $categoryId) {
            Cache::forget('radio_programs_' . $categoryId . '_6');
        }
        Cache::forget('radio_programs_all_6');

        // Очищаем кэш расписания на ближайшие дни
        for ($i = -3; $i <= 3; $i++) {
            $date = now()->addDays($i)->format('Y-m-d');
            Cache::forget('radio_shows_' . $date);
        }

        return response()->json(['success' => true]);
    }

    // Новый метод для AJAX фильтрации
    public function filterPrograms(Request $request)
    {
        // Проверяем, что запрос AJAX
        if (!$request->ajax()) {
            return response()->json(['error' => 'Only AJAX requests allowed'], 400);
        }

        $categoryId = $request->input('category_id');

        $newsQuery = RadioBroadcast::query()
            ->where('status', 1)
            ->with('radioShowType');

        if ($categoryId && $categoryId != 'all') {
            $newsQuery->where('radio_show_type_id', $categoryId);
        }

        $news = $newsQuery->orderBy('id', 'desc')
            ->limit(6)
            ->get();

        if ($news->count() > 0) {
            $html = '';
            foreach ($news as $item) {
                $html .= '
            <div class="radio-item">
                <div class="radio-item__image">
                    <img src="'.asset('storage/public/' . $item->image).'" alt="'.htmlspecialchars($item->title).'">
                </div>
                <div class="radio-item__bottom">
                    <div class="radio-item__nav">
                        <audio class="audio" preload="auto"
                               src="'.asset('storage/public/' . $item->audio).'"></audio>
                        <button class="btn-reset radio-item__play_btn">
                            <svg class="radio-item__play_btn--play-svg" width="12" height="14"
                                 viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.3648 6.11953L1.4741 0.793746C0.807869 0.435006 0 0.917542 0 1.67422V12.3258C0 13.0825 0.807868 13.565 1.4741 13.2063L11.3648 7.88047C12.066 7.5029 12.066 6.4971 11.3648 6.11953Z"
                                    fill="#545454"/>
                            </svg>
                            <svg class="radio-item__play_btn--stop-svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="6" y="4" width="4" height="16" rx="1" fill="#14AB28"/>
                                <rect x="14" y="4" width="4" height="16" rx="1" fill="#14AB28"/>
                            </svg>
                        </button>
                        <div class="radio-item__progress">
                            <div class="audio-slider"></div>
                            <div class="radio-item__timer">
                                <span class="duration">00:00</span>
                            </div>
                        </div>
                        <a href="'.asset('storage/public/' . $item->audio).'" download class="btn-reset radio-item__download">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 14V17C5 18.1046 5.89543 19 7 19H17C18.1046 19 19 18.1046 19 17V14"
                                    stroke="#545454" stroke-width="2"/>
                                <path d="M12 3V15" stroke="#545454" stroke-width="2"/>
                                <path d="M17 10L12 15L7 10" stroke="#545454" stroke-width="2"/>
                            </svg>
                        </a>
                    </div>
                    <div class="radio-item__info">
                        <h6 class="radio-item__title">
                            <a>'.htmlspecialchars($item->title).'</a>
                        </h6>
                        <div class="radio-item__meta">
                            <time datetime="2025-04-1 18:35">'.($item->formatted_published_at ?? '').'</time>
                        </div>
                    </div>
                </div>
            </div>';
            }

            return response()->json([
                'success' => true,
                'html' => $html,
                'count' => $news->count()
            ]);
        } else {
            return response()->json([
                'success' => true,
                'html' => '<div class="no-programs-message"><p >Программ на выбранную категорию нет</p></div>',
                'count' => 0
            ]);
        }
    }

    public function radioTransfers()
    {
        $transfers = RadioTransfer::query()
            ->with(['radioShowType' => function($query) {
                $query->select('id', 'title');
            }, 'age_restriction'])
            ->select('id', 'title', 'image', 'created_at', 'radio_show_type_id', 'age_restriction_id')
            ->orderBy('id', 'desc')
            ->get();


        return view('frontend.radio.transfers', [
            'transfers' => $transfers,
        ]);
    }

    public function radioTransferSingle(RadioTransfer $transfer)
    {

        return view('frontend.radio.transfer-single', [
            'transfer' => $transfer,
        ]);
    }

    public function radioBooks()
    {

        $books = Audiobook::query()
            ->orderBy('id', 'desc')
            ->paginate(12);

        return view('frontend.radio.books', [
            'books' => $books,
        ]);
    }

    public function booksSingle(Audiobook $book)
    {
        // Загружаем книгу вместе с её файлами
        $book->load('files');

        return view('frontend.radio.book-single', [
            'book' => $book,
        ]);
    }

    public function eventSingle(RadioNews $event)
    {
        return view('frontend.radio.event', [
            'event' => $event,
        ]);
    }

    public function watch()
    {
        return view('frontend.watch.index');
    }

    public function realese()
    {
        return view('frontend.realese.index');
    }

    public function ads()
    {

        return view('frontend.ads.index');
    }

    public function about()
    {
        $about = About::query()->latest()->first();
        $supervisor = Supervisor::query()->latest()->first();

        return view('frontend.about.index', [
            'supervisor' => $supervisor,
            'about' => $about,
        ]);
    }

    public function contact()
    {
        $contacts = Contact::query()->latest()->first();

        return view('frontend.contact.index', [
            'contacts' => $contacts,
        ]);
    }

    public function filterRadio(Request $request)
    {
        $categoryId = $request->get('category_id');
    }

    public function pravila()
    {
        return view('frontend.pravila');
    }

    public function soglasie() {
        return view('frontend.soglasie');
    }

    public function musicalCard()
    {
        return view('frontend.musical-card');
    }

    public function generateYandexNews()
    {
        // Получить данные новостей и видеорепортажей
        $newsQuery = News::query()
            ->select('id', 'title', 'slug', 'lead', 'content', 'image as media', 'published_at', 'category_id', 'views')
            ->where('status', 1)
            ->addSelect(DB::raw("'news' as type"));

        $videosQuery = VideoReportage::query()
            ->select('id', 'title', 'slug', 'lead', 'content', 'preview as media', 'published_at', 'category_id', 'views')
            ->where('status', 1)
            ->whereNot('ing_news', 1)
            ->addSelect(DB::raw("'video' as type"));

        // Объединяем новости и видеорепортажи
        $items = $newsQuery->unionAll($videosQuery)
            ->orderBy('published_at', 'desc')
            ->take(50)
            ->get();

        // Создать объект SimpleXMLElement для формирования XML
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>
    <rss xmlns:yandex="http://news.yandex.ru" xmlns:media="http://search.yahoo.com/mrss/" version="2.0"></rss>');

        $channel = $xml->addChild('channel');

        // Добавляем общую информацию о канале
        $channel->addChild('title', 'Magas.tv - Новости и видеорепортажи');
        $channel->addChild('link', 'https://magas.tv');
        $channel->addChild('lead', 'Последние новости и видеорепортажи');

        foreach ($items as $item) {
            // Создать элемент <item> для каждого материала
            $itemNode = $channel->addChild('item');
            $itemNode->addAttribute('turbo', 'true');

            $publishedDate = strtotime($item->published_at);
            $pubDate = date('D, d M Y H:i:s O', $publishedDate);

            // Добавить поля title, description и другие элементы
            $itemNode->addChild('title', htmlspecialchars($item->title, ENT_XML1));
            $itemNode->addChild('lead', htmlspecialchars($item->lead, ENT_XML1));

            // Полный текст (объединяем lead и description если есть)
            $fullText = $item->content;
            if (!empty($item->content)) {
                $fullText .= ' ' . $item->content;
            }
            $itemNode->addChild('yandex:full-text', htmlspecialchars(strip_tags($fullText), ENT_XML1), 'http://news.yandex.ru');
            $itemNode->addChild('pubDate', $pubDate);

            // Добавляем медиа-контент
            if ($item->media) {
                if ($item->type === 'video') {
                    // Для видео добавляем медиа-группу
                    $mediaGroup = $itemNode->addChild('media:group', '', 'http://search.yahoo.com/mrss/');
                    $mediaContent = $mediaGroup->addChild('media:content');
                    $mediaContent->addAttribute('url', asset('storage/' . $item->media));
                    $mediaContent->addAttribute('type', 'video/mp4');

                    $mediaThumbnail = $mediaGroup->addChild('media:thumbnail');
                    $mediaThumbnail->addAttribute('url', asset('storage/' . $item->media));

                    // Добавляем enclosure с превью
                    $enclosure = $itemNode->addChild('enclosure');
                    $enclosure->addAttribute('url', asset('storage/' . $item->media));
                    $enclosure->addAttribute('type', 'image/jpeg');

                } else {
                    // Для новостей добавляем изображение
                    $enclosure = $itemNode->addChild('enclosure');
                    $enclosure->addAttribute('url', asset('storage/' . $item->media));
                    $enclosure->addAttribute('type', 'image/jpeg');
                }
            }

            // Создать ссылку в зависимости от типа материала
            $link = 'https://magas.tv/';
            if ($item->type === 'video') {
                $link .= 'news/' . $item->slug;
            } else {
                $link .= 'news/' . $item->slug;
            }
            $itemNode->addChild('link', $link);

            // Добавляем категорию если есть
            if ($item->category_id) {
                $category = Category::find($item->category_id);
                if ($category) {
                    $itemNode->addChild('category', htmlspecialchars($category->name, ENT_XML1));
                }
            }
        }

        // Преобразовать XML в строку
        $xmlString = $xml->asXML();
        $xmlString = str_replace('&nbsp;', '&#160;', $xmlString);

        // Заменить двойные экранирования
        $xmlString = preg_replace('/&amp;(#[0-9]+|[a-z]+);/i', '&$1;', $xmlString);

        // Записать XML-строку в файл yandex-news.xml
        Storage::disk('public')->put('yandex-news.xml', $xmlString);

        // Вернуть ответ с XML-файлом
        return response($xmlString, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }


}
