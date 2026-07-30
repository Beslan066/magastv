<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\VideoReportage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                'items' => [],
                'total' => 0,
                'search_url' => route('search.all', ['q' => $searchTerm, 'category' => $category])
            ]);
        }

        // Базовые запросы с правильными путями к медиа
        $newsQuery = News::query()
            ->select([
                'id',
                'title',
                'slug',
                'lead',
                DB::raw("CASE
                    WHEN image IS NOT NULL AND image != ''
                    THEN CONCAT('" . asset('storage/public') . "/', image)
                    ELSE '" . asset('assets/default-news.jpg') . "'
                    END as media"),
                'published_at',
                'category_id',
                'views'
            ])
            ->where('status', 1)
            ->addSelect(DB::raw("'news' as type"));

        $videosQuery = VideoReportage::query()
            ->select([
                'id',
                'title',
                'slug',
                'lead',
                DB::raw("CASE
                    WHEN preview IS NOT NULL AND preview != ''
                    THEN CONCAT('" . asset('storage/public') . "/', preview)
                    ELSE '" . asset('assets/default-video.jpg') . "'
                    END as media"),
                'published_at',
                'category_id',
                'views'
            ])
            ->where('status', 1)
            ->addSelect(DB::raw("'video' as type"));

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

        // Объединяем запросы и получаем результаты
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
                $category = Category::find($item->category_id);
                $item->category_slug = $category ? $category->slug : 'uncategorized';

                // Добавляем правильный URL для ссылки
                if ($item->type === 'video') {
                    $item->url = route('home.videos.single', ['slug' => $item->slug]);
                } else {
                    $item->url = route('home.news.single', ['slug' => $item->slug]);
                }

                // Добавляем поле type для определения в партиале
                $item->type = $item->type; // уже есть
                $item->media = $item->media; // уже есть

                return $item;
            });

        $html = view('partials.search-results', [
            'results' => $items,
            'hasMore' => $total > 10,
            'query' => $request->query('q', '')
        ])->render();

        return response()->json([
            'html' => $html,
            'total' => $total,
            'search_url' => route('search.all', ['q' => $request->query('q', ''), 'category' => $category])
        ]);

        return response()->json([
            'items' => $items,
            'total' => $total,
            'search_url' => route('search.all', ['q' => $request->query('q', ''), 'category' => $category])
        ]);
    }

    // Метод для страницы всех результатов - /search/all (использует вашу существующую страницу)
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
                DB::raw("CASE
                    WHEN image IS NOT NULL AND image != ''
                    THEN CONCAT('" . asset('storage/public') . "/', image)
                    ELSE '" . asset('assets/default-news.jpg') . "'
                    END as media"),
                'published_at',
                'category_id',
                'views'
            ])
            ->where('status', 1)
            ->addSelect(DB::raw("'news' as type"));

        $videosQuery = VideoReportage::query()
            ->select([
                'id',
                'title',
                'slug',
                'lead',
                DB::raw("CASE
                    WHEN preview IS NOT NULL AND preview != ''
                    THEN CONCAT('" . asset('storage/public') . "/', preview)
                    ELSE '" . asset('assets/default-video.jpg') . "'
                    END as media"),
                'published_at',
                'category_id',
                'views'
            ])
            ->where('status', 1)
            ->addSelect(DB::raw("'video' as type"));

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

        // Используем вашу существующую страницу
        return view('frontend.search.index', [
            'query' => $query,
            'news' => $news,
            'videos' => $videos,
            'category' => $category
        ]);
    }
}
