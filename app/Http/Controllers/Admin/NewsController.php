<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\News\StoreRequest;
use App\Http\Requests\Admin\News\UpdateRequest;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all(); // Получаем категории для фильтра

        $news = News::query()
            ->with(['user', 'category']) // eager loading для автора и категории
            ->when($request->search, function($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('lead', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->when($request->author, function($query, $author) {
                $query->whereHas('user', function($q) use ($author) {
                    $q->where('name', 'like', "%{$author}%");
                });
            })
            ->when($request->category, function($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($request->main_material, function($query, $mainMaterial) {
                $query->where('main_material', $mainMaterial);
            })
            ->when($request->sort, function($query, $sort) {
                switch ($sort) {
                    case 'title_asc':
                        $query->orderBy('title', 'asc');
                        break;
                    case 'title_desc':
                        $query->orderBy('title', 'desc');
                        break;
                    case 'newest':
                        $query->orderBy('created_at', 'desc');
                        break;
                    case 'oldest':
                        $query->orderBy('created_at', 'asc');
                        break;
                    case 'views_desc':
                        $query->orderBy('views', 'desc');
                        break;
                    case 'published_desc':
                        $query->orderBy('published_at', 'desc');
                        break;
                    default:
                        $query->orderBy('id', 'desc');
                }
            }, function($query) {
                $query->orderBy('id', 'desc'); // сортировка по умолчанию
            })
            ->paginate(10)
            ->withQueryString(); // сохраняем параметры в пагинации

        return view('admin.news.index', compact('news', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.news.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $path = Storage::disk('public')->put('images', $data['image']);
            // Сохранение пути к изображению в базе данных
            $data['image'] = $path ?? null;
        }

        $data['slug'] = Str::slug($data['title']);

        // Главный материал
        $data['main_material'] = $request->has('main_material') ? 1 : 0;

        // Обработка значения чекбокса
        $data['status'] = $request->has('status') ? 1 : 0;


        $news = News::create($data);

        return redirect()->route('news.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $categories = Category::all();

        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, News $news)
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $path = Storage::disk('public')->put('images', $data['image']);
            // Сохранение пути к изображению в базе данных
            $data['image'] = $path ?? null;
        }

        $data['slug'] = Str::slug($data['title']);

        // Главный материал
        $data['main_material'] = $request->has('main_material') ? 1 : 0;

        // Обработка значения чекбокса
        $data['status'] = $request->has('status') ? 1 : 0;

        $news->update($data);

        return redirect()->route('news.index')->with('success', 'News updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        try {
            // Обновляем поле deleter_id перед удалением
            $news->update([
                'deleter_id' => auth()->id(),
            ]);

            $news->delete();

            return redirect()->route('news.index')
                ->with('success', 'Категория успешно удалена');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
