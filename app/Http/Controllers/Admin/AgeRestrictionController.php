<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AgeRestriction\StoreRequest;
use App\Http\Requests\Admin\AgeRestriction\UpdateRequest;
use App\Models\AgeRestriction;
use Illuminate\Http\Request;

class AgeRestrictionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $ages = AgeRestriction::query()->orderBy('id', 'desc')->paginate(5);

        return view('admin.age.index', compact('ages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.age.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $age = AgeRestriction::create($data);

        $age->save();

        return redirect()->route('ages.index')->with('success', 'Category created successfully.');
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
    public function edit(AgeRestriction $ageRestriction)
    {
        return view('admin.age.edit', compact('ageRestriction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, AgeRestriction $ageRestriction)
    {
        $data = $request->validated();

        $ageRestriction->update($data);

        return redirect()->route('ages.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AgeRestriction $ageRestriction)
    {
        try {
            $ageRestriction->delete();

            return redirect()->route('ages.index')
                ->with('success', 'Категория успешно удалена');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
