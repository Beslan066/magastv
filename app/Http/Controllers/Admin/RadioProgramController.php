<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RadioShow;
use App\Models\RadioShowType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RadioProgramController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));

        $programs = RadioShow::whereDate('program_date', $date)
            ->orderByRaw("SPLIT_PART(time_range, ' - ', 1)")
            ->get();

        return view('admin.radio-programs.index', compact('programs', 'date'));
    }

    public function create()
    {

        $categories = RadioShowType::all();

        return view('admin.radio-programs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time_range' => 'required|string|max:255',
            'program_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'radio_show_type_id' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            // Сохраняем в storage/app/public/tv-programs/
            $path = $request->file('image')->store('radio-programs', 'public');
            $validated['image'] = $path; // Путь будет 'tv-programs/файл.jpg'
        }


        $validated['user_id'] = Auth::id();

        RadioShow::create($validated);

        return redirect()->route('radio-programs.index')
            ->with('success', 'Программа успешно добавлена');
    }

    public function edit(RadioShow $radioProgram)
    {

        $categories = RadioShowType::all();

        return view('admin.radio-programs.edit', compact('categories', 'radioProgram'));
    }

    public function update(Request $request, RadioShow $radioProgram)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time_range' => 'required|string|max:255',
            'program_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'radio_show_type_id' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($radioProgram->image) {
                Storage::disk('public')->delete($radioProgram->image);
            }

            // Сохраняем новое в storage/app/public/tv-programs/
            $path = $request->file('image')->store('radio-programs', 'public');
            $validated['image'] = $path;
        }

        $radioProgram->update($validated);

        return redirect()->route('radio-programs.index')
            ->with('success', 'Программа успешно обновлена');
    }

    public function destroy(RadioShow $radioProgram)
    {
        if ($radioProgram->image) {
            Storage::disk('public')->delete($radioProgram->image);
        }

        $radioProgram->delete();

        return redirect()->route('radio-programs.index')
            ->with('success', 'Программа успешно удалена');
    }
}
