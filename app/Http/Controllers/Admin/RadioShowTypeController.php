<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RadioShow\StoreRequest;
use App\Http\Requests\Admin\RadioShow\UpdateRequest;
use App\Models\Category;
use App\Models\RadioShowType;
use App\Models\TvShowType;
use Illuminate\Http\Request;

class RadioShowTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = RadioShowType::query()->orderBy('id', 'desc')->paginate(10);

        return view('admin.radio-show-type.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = RadioShowType::query()->orderBy('id', 'desc')->paginate(10);

        return view('admin.radio-show-type.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $category = RadioShowType::create($data);

        $category->save();

        return redirect()->route('radio-show-type.index')->with('success', 'Radio type created successfully.');
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
    public function edit(RadioShowType $radioShowType)
    {
        return view('admin.radio-show-type.edit', compact('radioShowType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, RadioShowType $radioShowType)
    {
        $data = $request->validated();

        $radioShowType->update($data);

        return redirect()->route('radio-show-type.index')->with('success', 'Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RadioShowType $category)
    {
        try {
            // Обновляем поле deleter_id перед удалением
            $category->update([
                'deleter_id' => auth()->id(),
            ]);

            $category->delete();

            return redirect()->route('radio-show-type.index')
                ->with('success', 'Категория успешно удалена');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
