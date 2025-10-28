<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Audiobook\StoreRequest;
use App\Http\Requests\Admin\Audiobook\UpdateRequest;
use App\Models\Audiobook;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AudiobookController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::all(); // Получаем всех авторов для фильтра

        $books = Audiobook::query()
            ->with(['user', 'author', 'files']) // eager loading
            ->when($request->search, function($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('lead', 'like', "%{$search}%")
                    ->orWhereHas('author', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->when($request->author, function($query, $authorId) {
                $query->where('author_id', $authorId);
            })
            ->when($request->user, function($query, $userId) {
                $query->where('user_id', $userId);
            })
            ->when($request->has_files, function($query, $hasFiles) {
                if ($hasFiles == 'yes') {
                    $query->has('files');
                } elseif ($hasFiles == 'no') {
                    $query->doesntHave('files');
                }
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
                    case 'author_asc':
                        $query->join('authors', 'audiobooks.author_id', '=', 'authors.id')
                            ->orderBy('authors.name', 'asc')
                            ->select('audiobooks.*');
                        break;
                    case 'files_count_desc':
                        $query->withCount('files')->orderBy('files_count', 'desc');
                        break;
                    default:
                        $query->orderBy('id', 'desc');
                }
            }, function($query) {
                $query->orderBy('id', 'desc'); // сортировка по умолчанию
            })
            ->paginate(10)
            ->withQueryString(); // сохраняем параметры в пагинации

        return view('admin.books.index', compact('books', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $authors = Author::all();

        return view('admin.books.create', [
            'authors' => $authors,
        ]);
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

        $book = Audiobook::create($data);

        return redirect()->route('admin.radio.books');
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
    public function edit(Audiobook $audiobook)
    {

        $authors = Author::all();

        return view('admin.books.edit', compact('audiobook', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Audiobook $audiobook)
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $path = Storage::disk('public')->put('images', $data['image']);
            // Сохранение пути к изображению в базе данных
            $data['image'] = $path ?? null;
        }

        $data['slug'] = Str::slug($data['title']);

        $audiobook->update($data);

        return redirect()->route('admin.radio.books')->with('success', 'Radio item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Audiobook $audiobook)
    {
        try {
            // Обновляем поле deleter_id перед удалением
            $audiobook->update([
                'deleter_id' => auth()->id(),
            ]);

            $audiobook->delete();

            return redirect()->route('admin.radio.books')
                ->with('success', 'Категория успешно удалена');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
