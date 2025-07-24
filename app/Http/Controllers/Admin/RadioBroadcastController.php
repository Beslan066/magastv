<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RadioBroadcast\StoreRequest;
use App\Http\Requests\Admin\RadioBroadcast\UpdateRequest;
use App\Models\RadioShowType;
use App\Models\RadioBroadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RadioBroadcastController extends Controller
{
    public function index()
    {
        $radioBroadcast = RadioBroadcast::query()->orderBy('id', 'desc')->paginate(10);

        return view('admin.radio-broadcast.index', compact('radioBroadcast'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = RadioShowType::all();

        return view('admin.radio-broadcast.create', compact('categories'));
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

        // Обработка значения чекбокса
        $data['status'] = $request->has('status') ? 1 : 0;


        $radioBroadcast = RadioBroadcast::create($data);

        return redirect()->route('radio-broadcast.index');
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
    public function edit(RadioBroadcast $radioBroadcast)
    {
        $categories = RadioShowType::all();

        return view('admin.radio-broadcast.edit', compact('radioBroadcast', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, RadioBroadcast $radioBroadcast)
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

        // Обработка значения чекбокса
        $data['status'] = $request->has('status') ? 1 : 0;

        $radioBroadcast->update($data);

        return redirect()->route('radio-broadcast.index')->with('success', 'Radio item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RadioBroadcast $radioBroadcast)
    {
        try {
            // Обновляем поле deleter_id перед удалением
            $radioBroadcast->update([
                'deleter_id' => auth()->id(),
            ]);

            $radioBroadcast->delete();

            return redirect()->route('radio-broadcast.index')
                ->with('success', 'Категория успешно удалена');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
