<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TvShowType\StoreRequest;
use App\Http\Requests\Admin\TvShowType\UpdateRequest;
use App\Models\Category;
use App\Models\TvShowType;
use Illuminate\Http\Request;

class TvShowTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = TvShowType::query()->orderBy('id', 'desc')->paginate(10);

        return view('admin.tv-show.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = TvShowType::query()->orderBy('id', 'desc')->paginate(10);

        return view('admin.tv-show.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $category = TvShowType::create($data);

        $category->save();

        return redirect()->route('tv-show-type.index')->with('success', 'Tv type created successfully.');
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
    public function edit(TvShowType $tvShowType)
    {
        return view('admin.tv-show.edit', compact('tvShowType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, TvShowType $tvShowType)
    {
        $data = $request->validated();

        $tvShowType->update($data);

        return redirect()->route('tv-show-type.index')->with('success', 'Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TvShowType $category)
    {
        try {
            // Обновляем поле deleter_id перед удалением
            $category->update([
                'deleter_id' => auth()->id(),
            ]);

            $category->delete();

            return redirect()->route('tv-show-type.index')
                ->with('success', 'Категория успешно удалена');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
