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
    public function index(Request $request)
    {
        $ageRestrictions = AgeRestriction::all(); // Получаем возрастные ограничения
        $radioShowTypes = RadioShowType::all(); // Получаем типы радио-передач

        $transfers = RadioTransfer::query()
            ->with(['user', 'age_restriction', 'radioShowType', 'programs']) // eager loading
            ->when($request->search, function($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('lead', 'like', "%{$search}%");
            })
            ->when($request->author, function($query, $author) {
                $query->whereHas('user', function($q) use ($author) {
                    $q->where('name', 'like', "%{$author}%");
                });
            })
            ->when($request->age_restriction, function($query, $ageRestriction) {
                $query->where('age_restriction_id', $ageRestriction);
            })
            ->when($request->radio_show_type, function($query, $radioShowType) {
                $query->where('radio_show_type_id', $radioShowType);
            })
            ->when($request->sort, function($query, $sort) {
                switch ($sort) {
                    case 'title_asc':
                        $query->orderBy('title', 'asc');
                        break;
                    case 'title_desc':
                        $query->orderBy('title', 'desc');
                        break;
                    case 'newest':
                        $query->orderBy('created_at', 'desc');
                        break;
                    case 'oldest':
                        $query->orderBy('created_at', 'asc');
                        break;
                    case 'programs_count_desc':
                        $query->withCount('programs')->orderBy('programs_count', 'desc');
                        break;
                    case 'programs_count_asc':
                        $query->withCount('programs')->orderBy('programs_count', 'asc');
                        break;
                    default:
                        $query->orderBy('id', 'desc');
                }
            }, function($query) {
                $query->orderBy('id', 'desc'); // сортировка по умолчанию
            })
            ->paginate(10)
            ->withQueryString(); // сохраняем параметры в пагинации

        return view('admin.radio-transfer.index', compact('transfers', 'ageRestrictions', 'radioShowTypes'));
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
