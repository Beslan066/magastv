<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AudiobookFile\StoreRequest;
use App\Http\Requests\Admin\AudiobookFile\UpdateRequest;
use App\Models\Audiobook;
use App\Models\AudiobookFile;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AudiobookFileController extends Controller
{
    public function index(Request $request)
    {
        $audiobooks = Audiobook::all(); // Получаем все аудиокниги для фильтра

        $books = AudiobookFile::query()
            ->with(['user', 'audiobook', 'audiobook.author']) // eager loading
            ->when($request->search, function($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhereHas('audiobook', function($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                            ->orWhereHas('author', function($q2) use ($search) {
                                $q2->where('name', 'like', "%{$search}%");
                            });
                    });
            })
            ->when($request->audiobook, function($query, $audiobookId) {
                $query->where('audiobook_id', $audiobookId);
            })
            ->when($request->user, function($query, $userId) {
                $query->where('user_id', $userId);
            })
            ->when($request->has_audio, function($query, $hasAudio) {
                if ($hasAudio == 'yes') {
                    $query->whereNotNull('audio')->where('audio', '!=', '');
                } elseif ($hasAudio == 'no') {
                    $query->whereNull('audio')->orWhere('audio', '');
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
                    case 'audiobook_asc':
                        $query->join('audiobooks', 'audiobook_files.audiobook_id', '=', 'audiobooks.id')
                            ->orderBy('audiobooks.title', 'asc')
                            ->select('audiobook_files.*');
                        break;
                    case 'audiobook_desc':
                        $query->join('audiobooks', 'audiobook_files.audiobook_id', '=', 'audiobooks.id')
                            ->orderBy('audiobooks.title', 'desc')
                            ->select('audiobook_files.*');
                        break;
                    default:
                        $query->orderBy('id', 'desc');
                }
            }, function($query) {
                $query->orderBy('id', 'desc'); // сортировка по умолчанию
            })
            ->paginate(10)
            ->withQueryString(); // сохраняем параметры в пагинации

        return view('admin.books-file.index', compact('books', 'audiobooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Audiobook::query()->orderBy('id', 'desc')->get();

        return view('admin.books-file.create', ['categories' => $categories]);
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

        if (isset($data['audio'])) {
            $path = Storage::disk('public')->put('audios', $data['audio']);
            // Сохранение пути к изображению в базе данных
            $data['audio'] = $path ?? null;
        }

        $data['slug'] = Str::slug($data['title']);

        $book = AudiobookFile::create($data);

        return redirect()->route('bookFiles');
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
    public function edit(AudiobookFile $audiobookFile)
    {

        $categories = Audiobook::query()->orderBy('id', 'desc')->get();


        return view('admin.books-file.edit', [
            'audiobookFile' => $audiobookFile,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, AudiobookFile $audiobookFile)
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $path = Storage::disk('public')->put('images', $data['image']);
            // Сохранение пути к изображению в базе данных
            $data['image'] = $path ?? null;
        }

        if (isset($data['audio'])) {
            $path = Storage::disk('public')->put('audios', $data['audio']);
            // Сохранение пути к изображению в базе данных
            $data['audio'] = $path ?? null;
        }

        $data['slug'] = Str::slug($data['title']);

        $audiobookFile->update($data);

        return redirect()->route('bookFiles')->with('success', 'Radio item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AudiobookFile $audiobookFile)
    {
        try {
            // Обновляем поле deleter_id перед удалением
            $audiobookFile->update([
                'deleter_id' => auth()->id(),
            ]);

            $audiobookFile->delete();

            return redirect()->route('bookFiles')
                ->with('success', 'Категория успешно удалена');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
