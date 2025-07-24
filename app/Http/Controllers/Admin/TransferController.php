<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Transfer\StoreRequest;
use App\Http\Requests\Admin\Transfer\UpdateRequest;
use App\Models\Category;
use App\Models\News;
use App\Models\Transfer;
use App\Models\TvShowType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transfers = Transfer::paginate(10);

        return view('admin.transfer.index', [
            'transfers' => $transfers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = TvShowType::all();

        return view('admin.transfer.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();



        // Главное изображение
        if (isset($data['image'])) {
            $path = Storage::disk('public')->put('images', $data['image']);
            // Сохранение пути к изображению в базе данных
            $data['image'] = $path ?? null;
        }

        // Изображение для слайдера телепередач на главной
        if (isset($data['slider_image'])) {
            $path = Storage::disk('public')->put('slides', $data['slider_image']);
            // Сохранение пути к изображению в базе данных
            $data['slider_image'] = $path ?? null;
        }


        $data['slug'] = Str::slug($data['title']);

        // Главный материал
        $data['main_material'] = $request->has('main_material') ? 1 : 0;


        $transfer = Transfer::create($data);

        return redirect()->route('transfers.index');
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
    public function edit(Transfer $transfer)
    {
        $categories = TvShowType::all();

        return view('admin.transfer.edit', [
            'transfer' => $transfer,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Transfer $transfer)
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $path = Storage::disk('public')->put('images', $data['image']);
            // Сохранение пути к изображению в базе данных
            $data['image'] = $path ?? null;
        }

        if (isset($data['slider_image'])) {
            $path = Storage::disk('public')->put('slides', $data['slider_image']);
            // Сохранение пути к изображению в базе данных
            $data['slider_image'] = $path ?? null;
        }

        $data['slug'] = Str::slug($data['title']);

        // Главный материал
        $data['main_material'] = $request->has('main_material') ? 1 : 0;

        $transfer->update($data);

        return redirect()->route('transfers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        try {
            // Обновляем поле deleter_id перед удалением
            $transfer->update([
                'deleter_id' => auth()->id(),
            ]);

            $transfer->delete();

            return redirect()->route('transfers.index')
                ->with('success', 'Категория успешно удалена');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
