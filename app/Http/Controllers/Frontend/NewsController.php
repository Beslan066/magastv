<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\Tiding;
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
                        case 'week':
                            $dateFilter = now()->subWeek();
                            break;
                        case 'month':
                            $dateFilter = now()->subMonth();
                            break;
                        case 'year':
                            $dateFilter = now()->subYear();
                            break;
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
        }

        // Если не нашли, ищем в tidings
        if (!$item) {
            $item = Tiding::where('slug', $slug)->first();
            $type = 'tiding';

            // Добавляем поле media для tidings
            if ($item) {
                $item->media = $item->preview; // у Tiding поле называется preview
            }
        }

        // Если ничего не найдено — 404
        if (!$item) {
            abort(404);
        }

        // Форматируем дату
        $item->formatted_published_at = \Carbon\Carbon::parse($item->published_at)->format('d.m.Y H:i');

        // Увеличиваем счетчик просмотров
        $item->incrementViews();

        // Получаем похожие материалы (перемешанные новости, видео и tidings)
        $similarNews = News::query()
            ->where('category_id', $item->category_id ?? null)
            ->where('id', '!=', $item->id ?? null)
            ->where('status', 1)
            ->select('id', 'title', 'slug', 'image as media', 'published_at', 'views', 'category_id')
            ->addSelect(DB::raw("'news' as type"))
            ->limit(3);

        $similarVideos = VideoReportage::query()
            ->where('category_id', $item->category_id ?? null)
            ->where('id', '!=', $item->id ?? null)
            ->where('status', 1)
            ->whereNot('ing_news', 1)
            ->select('id', 'title', 'slug', 'preview as media', 'published_at', 'views', 'category_id')
            ->addSelect(DB::raw("'video' as type"))
            ->limit(3);

        // Для Tiding убираем фильтр по category_id и добавляем NULL для соответствия структуре
        $similarTidings = Tiding::query()
            ->where('id', '!=', $item->id ?? null)
            ->where('status', 1)
            ->select('id', 'title', 'slug', 'preview as media', 'published_at', 'views')
            ->addSelect(DB::raw("NULL as category_id")) // добавляем NULL для отсутствующего поля
            ->addSelect(DB::raw("'tiding' as type"))
            ->limit(3);

        // Объединяем и перемешиваем
        $similarItems = $similarNews->unionAll($similarVideos)
            ->unionAll($similarTidings)
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->formatted_published_at = \Carbon\Carbon::parse($item->published_at)->format('d.m.Y H:i');
                return $item;
            })
            ->shuffle();

        // Популярные материалы (новости + видео + tidings)
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
            ->unionAll(
                Tiding::query()
                    ->select('id', 'title', 'slug', 'preview as media', 'published_at', 'views')
                    ->addSelect(DB::raw("NULL as category_id")) // добавляем NULL для отсутствующего поля
                    ->where('status', 1)
                    ->where('published_at', '>=', now()->subDays(7))
                    ->addSelect(DB::raw("'tiding' as type"))
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
            'similarItems' => $similarItems,
            'popularItems' => $popularItems,
        ]);
    }

    public function newsIng(Request $request)
    {
        // Получаем параметры фильтрации и сортировки
        $sort = $request->get('sort', 'published_at_desc');
        $period = $request->get('period', 'all');
        $contentType = $request->get('content', 'all');
        $page = $request->get('page', 1);

        // Получаем главный пост (самую последнюю новость)
        $mainPost = Tiding::query()
            ->where('status', 1)
            ->orderBy('published_at', 'desc')
            ->first();

        // Основной запрос для tidings
        $query = Tiding::query()
            ->where('status', 1);

        // Исключаем главный пост только для подгрузки (page > 1)
        if ($page > 1 && $mainPost) {
            $query->where('id', '!=', $mainPost->id);
        }

        // Применяем фильтр по периоду
        if ($period !== 'all') {
            $dateFilter = now();
            switch ($period) {
                case 'week':
                    $dateFilter = $dateFilter->subWeek();
                    break;
                case 'month':
                    $dateFilter = $dateFilter->subMonth();
                    break;
                case 'year':
                    $dateFilter = $dateFilter->subYear();
                    break;
            }
            $query->where('published_at', '>=', $dateFilter);
        }

        // Применяем фильтр по типу контента
        if ($contentType !== 'all' && $contentType !== '') {
            $query->where('category', $contentType);
        }

        // Применяем сортировку
        switch ($sort) {
            case 'published_at_asc':
                $query->orderBy('published_at', 'asc');
                break;
            case 'views_desc':
                $query->orderBy('views', 'desc');
                break;
            case 'views_asc':
                $query->orderBy('views', 'asc');
                break;
            default:
                $query->orderBy('published_at', 'desc');
                break;
        }

        // Если это AJAX-запрос для подгрузки
        if ($request->ajax()) {
            $tidings = $query->paginate(6, ['*'], 'page', $page);

            $html = '';
            foreach ($tidings as $tiding) {
                $html .= $this->generateTidingItemHtml($tiding);
            }

            return response()->json([
                'html' => $html,
                'hasMore' => $tidings->hasMorePages()
            ]);
        }

        // Основной запрос для первой загрузки (включаем главный пост)
        $tidings = $query->where('id', '!=', $mainPost->id)->paginate(6);

        // Популярные Хоамаш
        $popularItems = Tiding::query()
            ->select('id', 'title', 'slug', 'lead', 'preview as media', 'published_at', 'views')
            ->where('status', 1)
            ->where('published_at', '>=', now()->subDays(7))
            ->orderBy('views', 'desc')
            ->limit(15)
            ->get();

        return view('frontend.news.ing', [
            'mainPost' => $mainPost,
            'tidings' => $tidings,
            'currentSort' => $sort,
            'currentPeriod' => $period,
            'currentContent' => $contentType,
            'popularItems' => $popularItems,
        ]);
    }

    private function generateTidingItemHtml($tiding)
    {
        $isVideo = $tiding->type === 'video';

        return '
    <li class="news-item news-item--second ' . ($isVideo ? 'news-item--media' : '') . '" data-category="' . ($tiding->category ?? 'general') . '">
        <a href="' . route('news.show', $tiding->id) . '">
            <div class="news-item__media">
                <img src="' . asset('storage/public/' . $tiding->preview) . '" alt="' . $tiding->title . '">
                ' . ($isVideo ? '
                <button class="btn-reset news-item--media__btn">
                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.39052 5.1221L1.47885 0.806647C0.812478 0.44317 0 0.925483 0 1.68454V10.3155C0 11.0745 0.812477 11.5568 1.47885 11.1934L9.39052 6.8779C10.0854 6.49888 10.0854 5.50112 9.39052 5.1221Z" fill="white"/>
                    </svg>
                </button>' : '') . '
            </div>
        </a>
        <div class="news-item__bottom">
            <h6 class="news-item__title">
                <a href="' . route('news.show', $tiding->id) . '">' . $tiding->title . '</a>
            </h6>
            <div class="news-item__descr">
                <p>' . $tiding->lead . '</p>
            </div>
            <div class="news-item__info">
                <time datetime="' . $tiding->published_at . '" class="news-item_time">
                    ' . $tiding->formated_published_at . '
                </time>
                <div class="news-item_views">
                    <div class="item-views__icon">
                        <svg width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 0.333496C11.6523 0.333496 13.9857 5.21553 14 5.24561C14 5.24561 11.6667 9.6665 7 9.6665C2.33333 9.6665 0 5.24561 0 5.24561C0.0143304 5.21553 2.34771 0.333496 7 0.333496ZM7 2.6665C5.71134 2.6665 4.66699 3.71182 4.66699 5.00049C4.66717 6.289 5.71144 7.3335 7 7.3335C8.28856 7.3335 9.33283 6.289 9.33301 5.00049C9.33301 3.71182 8.28866 2.6665 7 2.6665Z"/>
                        </svg>
                    </div>
                    <span>' . ($tiding->views ?? 0) . '</span>
                </div>
            </div>
        </div>
    </li>';
    }
}
