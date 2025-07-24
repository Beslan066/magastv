<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\VideoReportage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function news(Request $request)
    {
        $categories = Category::query()->orderBy('id', 'desc')->get();

        // Новость из главного банера
        $mainPost = News::query()
            ->orderBy('published_at', 'desc')
            ->where('main_material', 1)
            ->latest()
            ->first();

        $perPage = 6;

        if ($request->ajax()) {
            try {
                $page = $request->input('page', 1);
                $offset = ($page - 1) * $perPage;

                // Получаем параметры фильтрации
                $categoryId = $request->input('category');
                $sort = $request->input('sort', 'published_at');
                $period = $request->input('period');
                $contentType = $request->input('content');

                // Валидация параметров
                $categoryId = is_numeric($categoryId) ? (int)$categoryId : null;
                $sort = in_array($sort, ['published_at', 'views']) ? $sort : 'published_at';
                $period = in_array($period, ['week', 'month', 'year']) ? $period : null;
                $contentType = in_array($contentType, ['news', 'video']) ? $contentType : null;

                // Базовые запросы
                $newsQuery = News::query()
                    ->select('id', 'title', 'slug', 'lead', 'image as media', 'published_at', 'views', 'category_id')
                    ->where('status', 1)
                    ->addSelect(DB::raw("'news' as type"));

                $videosQuery = VideoReportage::query()
                    ->select('id', 'title', 'slug', 'lead', 'preview as media', 'published_at', 'views', 'category_id')
                    ->where('status', 1)
                    ->addSelect(DB::raw("'video' as type"));

                // Применяем фильтры
                if ($categoryId) {
                    $newsQuery->where('category_id', $categoryId);
                    $videosQuery->where('category_id', $categoryId);
                }

                if ($contentType) {
                    if ($contentType === 'news') {
                        $videosQuery->whereRaw('1 = 0');
                    } else {
                        $newsQuery->whereRaw('1 = 0');
                    }
                }

                if ($period) {
                    $dateFilter = now();
                    switch ($period) {
                        case 'week': $dateFilter = now()->subWeek(); break;
                        case 'month': $dateFilter = now()->subMonth(); break;
                        case 'year': $dateFilter = now()->subYear(); break;
                    }
                    $newsQuery->where('published_at', '>=', $dateFilter);
                    $videosQuery->where('published_at', '>=', $dateFilter);
                }

                // Объединяем запросы
                $unionQuery = $newsQuery->unionAll($videosQuery);

                // Сортировка
                $sortField = $sort === 'views' ? 'views' : 'published_at';
                $sortDirection = 'desc';

                // Получаем элементы
                $items = DB::table(DB::raw("({$unionQuery->toSql()}) as sub"))
                    ->mergeBindings($unionQuery->getQuery())
                    ->orderBy($sortField, $sortDirection)
                    ->offset($offset)
                    ->limit($perPage)
                    ->get()
                    ->map(function ($item) {
                        $item->published_at = \Carbon\Carbon::parse($item->published_at);
                        $item->formatted_published_at = $item->published_at->format('d.m.Y H:i');
                        return $item;
                    });

                $total = DB::table(DB::raw("({$unionQuery->toSql()}) as sub"))
                    ->mergeBindings($unionQuery->getQuery())
                    ->count();

                $hasMore = ($offset + $perPage) < $total;

                return response()->json([
                    'html' => view('frontend.partials.news.news_items', compact('items'))->render(),
                    'hasMore' => $hasMore
                ]);

            } catch (\Exception $e) {
                \Log::error('News loading error: ' . $e->getMessage());
                return response()->json([
                    'html' => '',
                    'hasMore' => false
                ], 500);
            }
        }

        // Первоначальная загрузка
        $items = News::query()
            ->select('id', 'title', 'slug', 'lead', 'image as media', 'published_at', 'views', 'category_id')
            ->where('status', 1)
            ->addSelect(DB::raw("'news' as type"))
            ->unionAll(
                VideoReportage::query()
                    ->select('id', 'title', 'slug', 'lead', 'preview as media', 'published_at', 'views', 'category_id')
                    ->where('status', 1)
                    ->addSelect(DB::raw("'video' as type"))
            )
            ->orderBy('published_at', 'desc')
            ->take($perPage)
            ->get()
            ->map(function ($item) {
                $item->published_at = \Carbon\Carbon::parse($item->published_at);
                $item->formatted_published_at = $item->published_at->format('d.m.Y H:i');
                return $item;
            });

        $popularItems = News::query()
            ->select('id', 'title', 'slug', 'lead', 'image as media', 'published_at', 'views', 'category_id')
            ->where('status', 1)
            ->addSelect(DB::raw("'news' as type"))
            ->unionAll(
                VideoReportage::query()
                    ->select('id', 'title', 'slug', 'lead', 'preview as media', 'published_at', 'views', 'category_id')
                    ->where('status', 1)
                    ->addSelect(DB::raw("'video' as type"))
            )
            ->orderBy('views', 'desc')
            ->limit(15)
            ->get();

        return view('frontend.news.index', compact('categories', 'mainPost', 'items', 'popularItems'));
    }

    public function newsSingle($slug)
    {
        // Ищем сначала в новостях
        $item = News::where('slug', $slug)->first();
        $type = 'news';

        // Если не нашли, ищем в видео
        if (!$item) {
            $item = VideoReportage::where('slug', $slug)->first();
            $type = 'video';
        }

        // Если ничего не найдено — 404
        if (!$item) {
            abort(404);
        }

        // Увеличиваем счетчик просмотров
        $item->incrementViews();

        // Получаем похожие материалы
        $similarNews = News::query()
            ->where('category_id', $item->category_id)
            ->where('id', '!=', $item->id ?? null)
            ->limit(3)
            ->get();

        $similarVideos = VideoReportage::query()
            ->where('category_id', $item->category_id)
            ->where('id', '!=', $item->id ?? null)
            ->limit(3)
            ->get();

        $similarItems = $similarNews->concat($similarVideos)->shuffle();

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


        return view('frontend.news.single', [
            'news' => $item,
            'type' => $type,
            'similarNews' => $similarItems,
            'popularItems' => $popularItems,
        ]);
    }
}
