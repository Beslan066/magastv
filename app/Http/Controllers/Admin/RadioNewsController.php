<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RadioNews\StoreRequest;
use App\Http\Requests\Admin\RadioNews\UpdateRequest;
use App\Models\RadioNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RadioNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = RadioNews::query()->orderBy('id', 'desc')->paginate(10);

        return view('admin.radio-news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.radio-news.create');
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


        // Обработка значения чекбокса
        $data['status'] = $request->has('status') ? 1 : 0;


        $news = RadioNews::create($data);

        return redirect()->route('radio-news.index');
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
    public function edit(RadioNews $radioNews)
    {

        return view('admin.radio-news.edit', compact('radioNews'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, RadioNews $radioNews)
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $path = Storage::disk('public')->put('images', $data['image']);
            // Сохранение пути к изображению в базе данных
            $data['image'] = $path ?? null;
        }

        $data['slug'] = Str::slug($data['title']);

        // Обработка значения чекбокса
        $data['status'] = $request->has('status') ? 1 : 0;

        $radioNews->update($data);

        return redirect()->route('radio-news.index')->with('success', 'News updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RadioNews $radioNews)
    {
        try {
            // Обновляем поле deleter_id перед удалением
            $radioNews->update([
                'deleter_id' => auth()->id(),
            ]);

            $radioNews->delete();

            return redirect()->route('radio-news.index')
                ->with('success', 'Категория успешно удалена');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
