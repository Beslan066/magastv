<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Supervisor\StoreRequest;
use App\Http\Requests\Admin\Supervisor\UpdateRequest;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supervisors = Supervisor::all();

        return view('admin.supervisor.index', [
            'supervisors' => $supervisors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.supervisor.create');
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


        // Обработка значения чекбокса
        $data['status'] = $request->has('status') ? 1 : 0;


        $supervisor = Supervisor::create($data);

        return redirect()->route('supervisors.index');
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
    public function edit(Supervisor $supervisor)
    {

        return view('admin.supervisor.edit', [
            'supervisor' => $supervisor
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Supervisor $supervisor)
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $path = Storage::disk('public')->put('images', $data['image']);
            // Сохранение пути к изображению в базе данных
            $data['image'] = $path ?? null;
        }


        // Обработка значения чекбокса
        $data['status'] = $request->has('status') ? 1 : 0;

        $supervisor->update($data);

        return redirect()->route('supervisors.index')->with('success', 'supervisors updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supervisor $supervisor)
    {
        try {
            // Обновляем поле deleter_id перед удалением
            $supervisor->update([
                'deleter_id' => auth()->id(),
            ]);

            $supervisor->delete();

            return redirect()->route('supervisors.index')
                ->with('success', 'Руководитель успешно удалена');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
