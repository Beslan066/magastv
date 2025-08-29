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
                    ->whereNot('ing_news', 1)
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
                    ->whereNot('ing_news', 1)
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
            ->where('published_at', '>=', now()->subDays(7))
            ->addSelect(DB::raw("'news' as type"))
            ->unionAll(
                VideoReportage::query()
                    ->select('id', 'title', 'slug', 'lead', 'preview as media', 'published_at', 'views', 'category_id')
                    ->where('status', 1)
                    ->where('published_at', '>=', now()->subDays(7))
                    ->whereNot('ing_news', 1)
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

            // Добавляем поле media для видеорепортажей
            if ($item) {
                $item->media = $item->preview;
            }
        } else {
            // Для новостей также добавляем поле media
            $item->media = $item->image;
        }

        // Если ничего не найдено — 404
        if (!$item) {
            abort(404);
        }

        // Форматируем дату
        $item->formatted_published_at = \Carbon\Carbon::parse($item->published_at)->format('d.m.Y H:i');

        // Увеличиваем счетчик просмотров
        $item->incrementViews();

        // Получаем похожие материалы (перемешанные новости и видео)
        $similarNews = News::query()
            ->where('category_id', $item->category_id)
            ->where('id', '!=', $item->id ?? null)
            ->where('status', 1)
            ->select('id', 'title', 'slug', 'image as media', 'published_at', 'views', 'category_id')
            ->addSelect(DB::raw("'news' as type"))
            ->limit(3);

        $similarVideos = VideoReportage::query()
            ->where('category_id', $item->category_id)
            ->where('id', '!=', $item->id ?? null)
            ->where('status', 1)
            ->whereNot('ing_news', 1)
            ->select('id', 'title', 'slug', 'preview as media', 'published_at', 'views', 'category_id')
            ->addSelect(DB::raw("'video' as type"))
            ->limit(3);

        // Объединяем и перемешиваем
        $similarItems = $similarNews->unionAll($similarVideos)
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->formatted_published_at = \Carbon\Carbon::parse($item->published_at)->format('d.m.Y H:i');
                return $item;
            })
            ->shuffle();

        // Популярные материалы (новости + видео)
        $popularQuery = News::query()
            ->select('id', 'title', 'slug', 'image as media', 'published_at', 'category_id', 'views')
            ->where('status', 1)
            ->where('published_at', '>=', now()->subDays(7))
            ->addSelect(DB::raw("'news' as type"))
            ->unionAll(
                VideoReportage::query()
                    ->select('id', 'title', 'slug', 'preview as media', 'published_at', 'category_id', 'views')
                    ->where('status', 1)
                    ->where('published_at', '>=', now()->subDays(7))
                    ->whereNot('ing_news', 1)
                    ->addSelect(DB::raw("'video' as type"))
            )
            ->orderBy('views', 'desc')
            ->limit(7);

        $popularItems = $popularQuery->get()
            ->map(function ($item) {
                $item->formatted_published_at = \Carbon\Carbon::parse($item->published_at)->format('d.m.Y H:i');
                return $item;
            });

        return view('frontend.news.single', [
            'news' => $item,
            'type' => $type,
            'similarItems' => $similarItems, // переименовано для ясности
            'popularItems' => $popularItems,
        ]);
    }

    public function newsIng(Request $request)
    {
        $categories = Category::query()->orderBy('id', 'desc')->get();

        if ($request->ajax()) {
            try {
                $page = $request->input('page', 1);
                $perPage = 12;
                $offset = ($page - 1) * $perPage;

                // Получаем параметры фильтрации
                $categoryId = $request->input('category');
                $sort = $request->input('sort', 'published_at');
                $period = $request->input('period');

                // Валидация параметров
                $categoryId = is_numeric($categoryId) ? (int)$categoryId : null;
                $sort = in_array($sort, ['published_at', 'views']) ? $sort : 'published_at';
                $period = in_array($period, ['week', 'month', 'year']) ? $period : null;

                // Базовый запрос
                $query = VideoReportage::query()
                    ->select('id', 'title', 'slug', 'lead', 'preview as media', 'published_at', 'views', 'category_id')
                    ->where('ing_news', 1)
                    ->where('status', 1);

                // Применяем фильтры
                if ($categoryId) {
                    $query->where('category_id', $categoryId);
                }

                if ($period) {
                    $dateFilter = now();
                    switch ($period) {
                        case 'week': $dateFilter = now()->subWeek(); break;
                        case 'month': $dateFilter = now()->subMonth(); break;
                        case 'year': $dateFilter = now()->subYear(); break;
                    }
                    $query->where('published_at', '>=', $dateFilter);
                }

                // Сортировка
                $sortDirection = 'desc';
                $query->orderBy($sort, $sortDirection);

                // Получаем элементы
                $total = $query->count();
                $items = $query->offset($offset)
                    ->limit($perPage)
                    ->get()
                    ->map(function ($item) {
                        $item->published_at = \Carbon\Carbon::parse($item->published_at);
                        $item->formatted_published_at = $item->published_at->format('d.m.Y H:i');
                        // Правильный путь к изображению
                        $item->media = $item->media ? asset('storage/public/' . $item->media) : asset('assets/default-image.jpg');
                        return $item;
                    });

                $hasMore = ($offset + $perPage) < $total;

                return response()->json([
                    'html' => view('frontend.partials.news.news_items', compact('items'))->render(),
                    'hasMore' => $hasMore
                ]);

            } catch (\Exception $e) {
                \Log::error('Ing news loading error: ' . $e->getMessage());
                return response()->json([
                    'html' => '',
                    'hasMore' => false
                ], 500);
            }
        }

        // Первоначальная загрузка
        $news = VideoReportage::query()
            ->where('ing_news', 1)
            ->where('status', 1)
            ->orderBy('published_at', 'desc')
            ->take(12)
            ->get()
            ->map(function ($item) {
                $item->published_at = \Carbon\Carbon::parse($item->published_at);
                $item->formatted_published_at = $item->published_at->format('d.m.Y H:i');
                $item->media = $item->preview ? asset('storage/public/' . $item->preview) : asset('assets/default-image.jpg');
                return $item;
            });

        // Популярные видео
        $popularItems = VideoReportage::query()
            ->where('ing_news', 1)
            ->where('status', 1)
            ->orderBy('views', 'desc')
            ->limit(15)
            ->get()
            ->map(function ($item) {
                $item->published_at = \Carbon\Carbon::parse($item->published_at);
                $item->formatted_published_at = $item->published_at->format('d.m.Y H:i');
                return $item;
            });

        return view('frontend.news.ing', compact('categories', 'news', 'popularItems'));
    }
}
