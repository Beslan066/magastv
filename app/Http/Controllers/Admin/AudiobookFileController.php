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
    public function index()
    {
        $books = AudiobookFile::query()->orderBy('id', 'desc')->paginate(10);

        return view('admin.books-file.index', compact('books'));
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
