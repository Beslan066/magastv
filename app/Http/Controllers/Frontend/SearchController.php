<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\VideoReportage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    // Метод для AJAX-поиска (живой поиск) - /search
    public function search(Request $request)
    {
        try {
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

            // Применяем поиск по тексту (регистронезависимый)
            if ($searchTerm) {
                // Для MySQL используем LOWER(), для PostgreSQL - ILIKE
                $dbDriver = DB::connection()->getDriverName();

                if ($dbDriver === 'pgsql') {
                    $newsQuery->where(function($q) use ($searchTerm) {
                        $q->where('title', 'ILIKE', '%' . $searchTerm . '%')
                            ->orWhere('lead', 'ILIKE', '%' . $searchTerm . '%');
                    });
                    $videosQuery->where(function($q) use ($searchTerm) {
                        $q->where('title', 'ILIKE', '%' . $searchTerm . '%')
                            ->orWhere('lead', 'ILIKE', '%' . $searchTerm . '%');
                    });
                } else {
                    // MySQL, SQLite
                    $searchTermLike = '%' . strtolower($searchTerm) . '%';
                    $newsQuery->where(function($q) use ($searchTermLike) {
                        $q->where(DB::raw('LOWER(title)'), 'like', $searchTermLike)
                            ->orWhere(DB::raw('LOWER(lead)'), 'like', $searchTermLike);
                    });
                    $videosQuery->where(function($q) use ($searchTermLike) {
                        $q->where(DB::raw('LOWER(title)'), 'like', $searchTermLike)
                            ->orWhere(DB::raw('LOWER(lead)'), 'like', $searchTermLike);
                    });
                }
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
                        $item->video_url = $item->video ?? '';
                        // ПРАВИЛЬНЫЙ РОУТ ДЛЯ ВИДЕОРЕПОРТАЖЕЙ
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

        } catch (\Exception $e) {
            Log::error('Search error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'html' => '<div class="no-results" style="color: #fff; padding: 20px; text-align: center;">Ошибка при выполнении поиска. Попробуйте позже.</div>',
                'total' => 0,
                'search_url' => route('search.all', ['q' => $request->query('q', ''), 'category' => $category])
            ], 200);
        }
    }

    // Метод для страницы всех результатов - /search/all
    public function allResults(Request $request)
    {
        try {
            $query = $request->query('q', '');
            $category = $request->query('category', 'all');

            // Если запрос пустой, показываем сообщение
            if (empty($query) || strlen($query) < 2) {
                return view('frontend.search.index', [
                    'query' => $query,
                    'news' => collect([]),
                    'videos' => collect([]),
                    'category' => $category,
                    'message' => 'Введите минимум 2 символа для поиска'
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

            // Применяем поиск по тексту (регистронезависимый)
            $dbDriver = DB::connection()->getDriverName();

            if ($dbDriver === 'pgsql') {
                $newsQuery->where(function($q) use ($query) {
                    $q->where('title', 'ILIKE', '%' . $query . '%')
                        ->orWhere('lead', 'ILIKE', '%' . $query . '%');
                });
                $videosQuery->where(function($q) use ($query) {
                    $q->where('title', 'ILIKE', '%' . $query . '%')
                        ->orWhere('lead', 'ILIKE', '%' . $query . '%');
                });
            } else {
                $searchTerm = '%' . strtolower($query) . '%';
                $newsQuery->where(function($q) use ($searchTerm) {
                    $q->where(DB::raw('LOWER(title)'), 'like', $searchTerm)
                        ->orWhere(DB::raw('LOWER(lead)'), 'like', $searchTerm);
                });
                $videosQuery->where(function($q) use ($searchTerm) {
                    $q->where(DB::raw('LOWER(title)'), 'like', $searchTerm)
                        ->orWhere(DB::raw('LOWER(lead)'), 'like', $searchTerm);
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

        } catch (\Exception $e) {
            Log::error('Search all results error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return view('frontend.search.index', [
                'query' => $request->query('q', ''),
                'news' => collect([]),
                'videos' => collect([]),
                'category' => $request->query('category', 'all'),
                'message' => 'Произошла ошибка при выполнении поиска. Попробуйте позже.'
            ]);
        }
    }
}
