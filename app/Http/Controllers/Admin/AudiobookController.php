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
    public function index()
    {
        $books = Audiobook::query()->orderBy('id', 'desc')->paginate(10);

        return view('admin.books.index', compact('books'));
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

        if (isset($data['audio'])) {
            $path = Storage::disk('public')->put('audios', $data['audio']);
            // Сохранение пути к изображению в базе данных
            $data['audio'] = $path ?? null;
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

        if (isset($data['audio'])) {
            $path = Storage::disk('public')->put('audios', $data['audio']);
            // Сохранение пути к изображению в базе данных
            $data['audio'] = $path ?? null;
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
