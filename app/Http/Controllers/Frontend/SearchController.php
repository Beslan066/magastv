<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\VideoReportage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    // Метод для AJAX-поиска (живой поиск) - /search
    public function search(Request $request)
    {
        $searchTerm = $request->query('q', '');
        $category = $request->query('category', 'all');

        // Если поисковый запрос пустой или слишком короткий
        if (empty($searchTerm) || strlen($searchTerm) < 2) {
            return response()->json([
                'html' => '<div class="no-results" style="color: #fff; padding: 20px; text-align: center;">Введите минимум 2 символа для поиска</div>',
                'total' => 0,
                'search_url' => route('search.all', ['q' => $searchTerm, 'category' => $category])
            ]);
        }

        // Базовые запросы
        $newsQuery = News::query()
            ->select([
                'id',
                'title',
                'slug',
                'lead',
                'image',
                DB::raw("'news' as type"),
                'published_at',
                'category_id',
                'views'
            ])
            ->where('status', 1);

        $videosQuery = VideoReportage::query()
            ->select([
                'id',
                'title',
                'slug',
                'lead',
                'preview as image',
                DB::raw("'video' as type"),
                'published_at',
                'category_id',
                'views'
            ])
            ->where('status', 1);

        // Применяем поиск по тексту
        if ($searchTerm) {
            $searchTermLike = '%' . $searchTerm . '%';
            $newsQuery->where(function($q) use ($searchTermLike) {
                $q->where('title', 'like', $searchTermLike)
                    ->orWhere('lead', 'like', $searchTermLike);
            });

            $videosQuery->where(function($q) use ($searchTermLike) {
                $q->where('title', 'like', $searchTermLike)
                    ->orWhere('lead', 'like', $searchTermLike);
            });
        }

        // Применяем фильтр по категории
        if ($category !== 'all') {
            $categoryId = Category::where('slug', $category)->value('id');
            if ($categoryId) {
                $newsQuery->where('category_id', $categoryId);
                $videosQuery->where('category_id', $categoryId);
            }
        }

        // Объединяем запросы
        $unionQuery = $newsQuery->unionAll($videosQuery);

        // Получаем общее количество результатов
        $total = DB::table(DB::raw("({$unionQuery->toSql()}) as combined"))
            ->mergeBindings($unionQuery->getQuery())
            ->count();

        // Получаем ограниченный набор результатов
        $items = $unionQuery
            ->orderBy('published_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($item) {
                // Добавляем category_slug
                $category = Category::find($item->category_id);
                $item->category_slug = $category ? $category->slug : 'uncategorized';

                // Формируем правильный URL для медиа
                if ($item->type === 'video') {
                    $item->media = $item->image ? Storage::url($item->image) : asset('assets/default-video.jpg');
                    $item->video_url = $item->video ?? ''; // Если есть поле video
                    $item->url = route('home.videos.single', ['slug' => $item->slug]);
                } else {
                    $item->media = $item->image ? Storage::url($item->image) : asset('assets/default-news.jpg');
                    $item->url = route('home.news.single', ['slug' => $item->slug]);
                }

                return $item;
            });

        // Генерируем HTML через партиал
        $html = view('partials.search-results', [
            'results' => $items,
            'hasMore' => $total > 10,
            'query' => $searchTerm
        ])->render();

        return response()->json([
            'html' => $html,
            'total' => $total,
            'search_url' => route('search.all', ['q' => $searchTerm, 'category' => $category])
        ]);
    }

    // Метод для страницы всех результатов - /search/all
    public function allResults(Request $request)
    {
        $query = $request->query('q', '');
        $category = $request->query('category', 'all');

        // Базовые запросы
        $newsQuery = News::query()
            ->select([
                'id',
                'title',
                'slug',
                'lead',
                'image',
                DB::raw("'news' as type"),
                'published_at',
                'category_id',
                'views'
            ])
            ->where('status', 1);

        $videosQuery = VideoReportage::query()
            ->select([
                'id',
                'title',
                'slug',
                'lead',
                'preview as image',
                DB::raw("'video' as type"),
                'published_at',
                'category_id',
                'views'
            ])
            ->where('status', 1);

        // Применяем поиск по тексту
        if ($query) {
            $searchTerm = '%' . $query . '%';
            $newsQuery->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('lead', 'like', $searchTerm);
            });

            $videosQuery->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('lead', 'like', $searchTerm);
            });
        }

        // Применяем фильтр по категории
        if ($category !== 'all') {
            $categoryId = Category::where('slug', $category)->value('id');
            if ($categoryId) {
                $newsQuery->where('category_id', $categoryId);
                $videosQuery->where('category_id', $categoryId);
            }
        }

        // Получаем отдельные результаты для пагинации
        $news = $newsQuery->orderBy('published_at', 'desc')->paginate(10);
        $videos = $videosQuery->orderBy('published_at', 'desc')->paginate(10);

        return view('frontend.search.index', [
            'query' => $query,
            'news' => $news,
            'videos' => $videos,
            'category' => $category
        ]);
    }
}
