<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RadioTransfer\StoreRequest;
use App\Http\Requests\Admin\RadioTransfer\UpdateRequest;
use App\Models\AgeRestriction;
use App\Models\RadioTransfer;
use App\Models\RadioShowType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RadioTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transfers = RadioTransfer::query()->orderBy('id', 'desc')->paginate(10);


        return view('admin.radio-transfer.index', [
            'transfers' => $transfers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = RadioShowType::all();
        $ages = AgeRestriction::all();


        return view('admin.radio-transfer.create', [
            'categories' => $categories,
            'ages' => $ages,
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
            $data['image'] = $path ?? null;
        }


        $data['slug'] = Str::slug($data['title']);

        $transfer = RadioTransfer::create($data);


        return redirect()->route('radio-transfers');
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
    public function edit(RadioTransfer $transfer)
    {
        $categories = RadioShowType::all();
        $ages = AgeRestriction::all();


        return view('admin.radio-transfer.edit', [
            'transfer' => $transfer,
            'categories' => $categories,
            'ages' => $ages,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, RadioTransfer $transfer)
    {
        $data = $request->validated();

        // Главное изображение
        if (isset($data['image'])) {
            // Удаляем старое изображение если есть
            if ($transfer->image) {
                Storage::disk('public')->delete($transfer->image);
            }
            $path = Storage::disk('public')->put('images', $data['image']);
            $data['image'] = $path ?? null;
        }


        $data['slug'] = Str::slug($data['title']);

        $transfer->update($data);

        return redirect()->route('radio-transfers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RadioTransfer $transfer)
    {
        try {
            // Обновляем поле deleter_id перед удалением
            $transfer->update([
                'deleter_id' => auth()->id(),
            ]);

            $transfer->delete();

            return redirect()->route('radio-transfers')
                ->with('success', 'Категория успешно удалена');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
