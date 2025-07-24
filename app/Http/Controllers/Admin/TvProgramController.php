<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvShow;
use App\Models\TvShowType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TvProgramController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));

        $programs = TvShow::whereDate('program_date', $date)
            ->orderByRaw("SPLIT_PART(time_range, ' - ', 1)") // Для PostgreSQL
            ->get();

        return view('admin.tv-programs.index', compact('programs', 'date'));
    }

    public function create()
    {

        $categories = TvShowType::all();

        return view('admin.tv-programs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time_range' => 'required|string|max:255',
            'program_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'top_show' => 'nullable',
            'tv_show_type_id' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            // Сохраняем в storage/app/public/tv-programs/
            $path = $request->file('image')->store('tv-programs', 'public');
            $validated['image'] = $path; // Путь будет 'tv-programs/файл.jpg'
        }

        $validated['top_show'] = $request->has('top_show') ? 1 : 0;

        $validated['user_id'] = Auth::id();

        TvShow::create($validated);

        return redirect()->route('tv-programs.index')
            ->with('success', 'Программа успешно добавлена');
    }

    public function edit(TvShow $tvProgram)
    {

        $categories = TvShowType::all();

        return view('admin.tv-programs.edit', compact('tvProgram', 'categories'));
    }

    public function update(Request $request, TvShow $tvProgram)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time_range' => 'required|string|max:255',
            'program_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'tv_show_type_id' => 'nullable',
            'top_show' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($tvProgram->image) {
                Storage::disk('public')->delete($tvProgram->image);
            }

            // Сохраняем новое в storage/app/public/tv-programs/
            $path = $request->file('image')->store('tv-programs', 'public');
            $validated['image'] = $path;
        }

        $validated['top_show'] = $request->has('top_show') ? 1 : 0;

        $tvProgram->update($validated);

        return redirect()->route('tv-programs.index')
            ->with('success', 'Программа успешно обновлена');
    }

    public function destroy(TvShow $tvProgram)
    {
        if ($tvProgram->image) {
            Storage::disk('public')->delete($tvProgram->image);
        }

        $tvProgram->delete();

        return redirect()->route('tv-programs.index')
            ->with('success', 'Программа успешно удалена');
    }
}
