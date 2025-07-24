<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
use App\Models\Contact;
use App\Models\News;
use App\Models\RadioBroadcast;
use App\Models\RadioNews;
use App\Models\RadioShow;
use App\Models\Supervisor;
use App\Models\Transfer;
use App\Models\TvShow;
use App\Models\TvShowType;
use App\Models\VideoReportage;
use App\Models\VideoTransfer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()->orderBy('id', 'desc')->get();

        // Новость из главного банера
        $mainPost = News::query()
            ->orderBy('published_at', 'desc')
            ->where('main_material', 1)
            ->latest()
            ->first();

        // Базовые запросы
        $newsQuery = News::query()
            ->select('id', 'title', 'slug', 'lead', 'image as media', 'published_at', 'category_id', 'views')
            ->where('status', 1)
            ->addSelect(DB::raw("'news' as type"));

        $videosQuery = VideoReportage::query()
            ->select('id', 'title', 'slug', 'lead', 'preview as media', 'published_at', 'category_id', 'views')
            ->where('status', 1)
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
            ->orderBy('id', 'desc')
            ->select(['id', 'title', 'lead', 'published', 'slider_image'])
            ->where('main_material', 1)
            ->get();

        $allTransfers = Transfer::query()->select('id', 'title', 'image')->orderBy('id', 'desc')->limit(12)->get();

        $popularVideos = VideoTransfer::query()
            ->select('id', 'title', 'preview', 'video', 'transfer_id')
            ->orderBy('views', 'desc')
            ->limit(6)
            ->get();


        // Популярные материалы (новости + видео)
        $popularQuery = News::query()
            ->select('id', 'title', 'slug', 'lead', 'image as media', 'published_at', 'category_id', 'views')
            ->where('status', 1)
            ->addSelect(DB::raw("'news' as type"))
            ->unionAll(
                VideoReportage::query()
                    ->select('id', 'title', 'slug', 'lead', 'preview as media', 'published_at', 'category_id', 'views')
                    ->where('status', 1)
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
        $transfers = Transfer::query()->orderBy('id', 'desc')->get();

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
            ->limit(10)
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

        $events = RadioNews::query()
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        $news = RadioBroadcast::query()
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();

        $today = now();
        $selectedDate = $request->date ? Carbon::parse($request->date) : $today;

        // Оптимизированный запрос с eager loading
        $radioShows = RadioShow::with('radioShowType')
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
            $currentShow = $radioShows->last(function ($show) use ($currentTime) {
                return Carbon::parse($show->time_range)->format('H:i') <= $currentTime;
            });
            $currentShowId = $currentShow->id ?? null;
        }

        return view('frontend.radio.index', [
            'events' => $events,
            'dates' => $dates,
            'selectedDate' => $selectedDate,
            'currentShowId' => $currentShowId,
            'radioShows' => $radioShows,
            'news' => $news,
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


}
