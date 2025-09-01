<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tiding\StoreRequest;
use App\Http\Requests\Admin\Tiding\UpdateRequest;
use App\Models\Category;
use App\Models\Tiding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TidingController extends Controller
{
    public function index()
    {
        $news = Tiding::query()->orderBy('id', 'desc')->paginate(10);

        return view('admin.tiding.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tiding.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();


        // Regular form submission
        if ($request->hasFile('preview')) {
            $path = Storage::disk('public')->put('previews', $request->file('preview'));
            $data['preview'] = $path ?? null;
        }


        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['status'] = $request->has('status') ? 1 : 0;

        Tiding::create($data);

        return redirect()->route('tidings.index')
            ->with('success', 'tiding успешно создан');
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
    public function edit(Tiding $tiding)
    {
        return view('admin.tiding.edit', [
            'tiding' => $tiding,
        ]);
    }

    public function update(UpdateRequest $request, Tiding $tiding)
    {
        $data = $request->validated();


        // Handle preview image
        if ($request->hasFile('preview')) {
            // Delete old preview if exists
            if ($tiding->preview) {
                Storage::disk('public')->delete($tiding->preview);
            }

            $path = Storage::disk('public')->put('previews', $request->file('preview'));
            $data['preview'] = $path;
        }


        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['status'] = $request->has('status') ? 1 : 0;

        $tiding->update($data);

        return redirect()->route('tidings.index')
            ->with('success', 'tiding успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tiding $tiding)
    {
        try {
            // Обновляем поле deleter_id перед удалением
            $tiding->update([
                'deleter_id' => auth()->id(),
            ]);

            $tiding->delete();

            return redirect()->route('tidings.index')
                ->with('success', 'tiding успешно удален');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
