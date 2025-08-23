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
        $transfers = Transfer::query()->orderBy('id', 'desc')->paginate(10);

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
            $data['image'] = $path ?? null;
        }

        // Изображение для слайдера
        if (isset($data['slider_image'])) {
            $path = Storage::disk('public')->put('slides', $data['slider_image']);
            $data['slider_image'] = $path ?? null;
        }

        // Видео для слайдера
        // Видео для слайдера
        if ($request->hasFile('slider_video')) {
            $data['video_upload_status'] = 'uploading';
            $data['video_upload_progress'] = 0;
        } elseif ($request->filled('video_path')) {
            // Если видео было загружено через AJAX
            $data['slider_video'] = $request->video_path;
            $data['video_upload_status'] = 'completed';
            $data['video_upload_progress'] = 100;
        }

        $data['slug'] = Str::slug($data['title']);
        $data['main_material'] = $request->has('main_material') ? 1 : 0;

        $transfer = Transfer::create($data);

        // Загрузка видео (если есть)
        if ($request->hasFile('slider_video')) {
            $this->handleVideoUpload($transfer, $request->file('slider_video'));
        }

        return redirect()->route('transfers.index');
    }

    private function handleVideoUpload(Transfer $transfer, $videoFile)
    {
        try {
            $path = Storage::disk('public')->put('videos', $videoFile);

            $transfer->update([
                'slider_video' => $path,
                'video_upload_status' => 'completed',
                'video_upload_progress' => 100
            ]);

        } catch (\Exception $e) {
            $transfer->update([
                'video_upload_status' => 'failed',
                'video_upload_progress' => 0
            ]);
        }
    }

// Отдельный метод для AJAX загрузки (если нужно)
    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,avi,mov,wmv|max:102400'
        ]);

        try {
            $path = Storage::disk('public')->put('videos', $request->file('video'));

            return response()->json([
                'success' => true,
                'path' => $path,
                'message' => 'Видео успешно загружено'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка загрузки видео: ' . $e->getMessage()
            ], 500);
        }
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

        // Главное изображение
        if (isset($data['image'])) {
            // Удаляем старое изображение если есть
            if ($transfer->image) {
                Storage::disk('public')->delete($transfer->image);
            }
            $path = Storage::disk('public')->put('images', $data['image']);
            $data['image'] = $path ?? null;
        }

        // Изображение для слайдера
        if (isset($data['slider_image'])) {
            // Удаляем старое изображение если есть
            if ($transfer->slider_image) {
                Storage::disk('public')->delete($transfer->slider_image);
            }
            $path = Storage::disk('public')->put('slides', $data['slider_image']);
            $data['slider_image'] = $path ?? null;
        }

        // Видео для слайдера
        if ($request->hasFile('slider_video')) {
            // Удаляем старое видео если есть
            if ($transfer->slider_video) {
                Storage::disk('public')->delete($transfer->slider_video);
            }

            $path = Storage::disk('public')->put('videos', $request->file('slider_video'));
            $data['slider_video'] = $path;
            $data['video_upload_status'] = 'completed';
            $data['video_upload_progress'] = 100;
        }

        // Удаление видео если запрошено
        if ($request->has('remove_slider_video') && $request->remove_slider_video == 1) {
            if ($transfer->slider_video) {
                Storage::disk('public')->delete($transfer->slider_video);
            }
            $data['slider_video'] = null;
            $data['video_upload_status'] = null;
            $data['video_upload_progress'] = 0;
        }

        $data['slug'] = Str::slug($data['title']);
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
