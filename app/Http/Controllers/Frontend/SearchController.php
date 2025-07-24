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
    public function search(Request $request)
    {
        $searchTerm = $request->query('q', '');
        $category = $request->query('category', 'all');

        // Базовые запросы с правильными путями к медиа
        $newsQuery = News::query()
            ->select([
                'id',
                'title',
                'slug',
                'lead',
                DB::raw("CASE
                WHEN image IS NOT NULL AND image != ''
                THEN CONCAT('".asset('storage/public')."/', image)
                ELSE '".asset('assets/default-news.jpg')."'
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
                THEN CONCAT('".asset('storage/public')."/', preview)
                ELSE '".asset('assets/default-video.jpg')."'
                END as media"),
                'published_at',
                'category_id',
                'views'
            ])
            ->where('status', 1)
            ->addSelect(DB::raw("'video' as type"));

        // Остальной код остается таким же...
        // Применяем поиск по тексту
        if ($searchTerm) {
            $searchTerm = '%' . $searchTerm . '%';
            $newsQuery->where(function($query) use ($searchTerm) {
                $query->where('title', 'like', $searchTerm)
                    ->orWhere('lead', 'like', $searchTerm);
            });

            $videosQuery->where(function($query) use ($searchTerm) {
                $query->where('title', 'like', $searchTerm)
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
                $item->category_slug = Category::find($item->category_id)->slug;
                return $item;
            });

        return response()->json([
            'items' => $items,
            'total' => $total
        ]);
    }
}
