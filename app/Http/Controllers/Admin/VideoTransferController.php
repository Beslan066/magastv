<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VideoTransfer\StoreRequest;
use App\Http\Requests\Admin\VideoTransfer\UpdateRequest;
use App\Models\Transfer;
use App\Models\VideoTransfer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoTransferController extends Controller
{
    public function index()
    {
        $videos = VideoTransfer::query()->orderBy('id', 'desc')->paginate(10);

        return view('admin.video-transfer.index', [
            'videos' => $videos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Transfer::all();

        return view('admin.video-transfer.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        // Handle AJAX video upload
        if ($request->ajax() && $request->hasFile('video')) {
            try {
                $path = Storage::disk('public')->put('videoTransfers', $request->file('video'));
                return response()->json(['video_path' => $path]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        // Regular form submission
        if ($request->hasFile('preview')) {
            $path = Storage::disk('public')->put('previews', $request->file('preview'));
            $data['preview'] = $path ?? null;
        }

        // Use either the uploaded video path or the newly uploaded file
        if ($request->has('uploaded_video_path')) {
            $data['video'] = $request->input('uploaded_video_path');
        } elseif ($request->hasFile('video')) {
            $path = Storage::disk('public')->put('videoTransfers', $request->file('video'));
            $data['video'] = $path ?? null;
        }

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);


        VideoTransfer::create($data);

        return redirect()->route('video-transfers.index')
            ->with('success', 'Видеопередача успешно создан');
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
    public function edit(VideoTransfer $videoTransfer)
    {
        $categories = Transfer::all();
        return view('admin.video-transfer.edit', [
            'videoTransfer' => $videoTransfer,
            'categories' => $categories

        ]);
    }

    public function update(UpdateRequest $request, VideoTransfer $videoTransfer)
    {
        $data = $request->validated();

        // Handle AJAX video upload
        if ($request->ajax() && $request->hasFile('video')) {
            try {
                // Delete old video if exists
                if ($videoTransfer->video) {
                    Storage::disk('public')->delete($videoTransfer->video);
                }

                $path = Storage::disk('public')->put('videoTransfers', $request->file('video'));
                return response()->json(['video_path' => $path]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        // Handle preview
        if ($request->hasFile('preview')) {
            if ($videoTransfer->preview) {
                Storage::disk('public')->delete($videoTransfer->preview);
            }
            $data['preview'] = $request->file('preview')->store('previews', 'public');
        } elseif ($request->has('delete_preview')) {
            if ($videoTransfer->preview) {
                Storage::disk('public')->delete($videoTransfer->preview);
            }
            $data['preview'] = null;
        } else {
            $data['preview'] = $videoTransfer->preview;
        }

        // Handle video - здесь основное изменение
        if ($request->has('delete_video')) {
            // Если отмечено удаление видео
            if ($videoTransfer->video) {
                Storage::disk('public')->delete($videoTransfer->video);
            }
            $data['video'] = null;
        } elseif ($request->hasFile('video')) {
            // Если загружено новое видео
            if ($videoTransfer->video) {
                Storage::disk('public')->delete($videoTransfer->video);
            }
            $data['video'] = $request->file('video')->store('videoTransfers', 'public');
        } elseif ($request->filled('uploaded_video_path')) {
            // Если есть путь к загруженному видео (из AJAX или текущее)
            $data['video'] = $request->input('uploaded_video_path');
        } else {
            // Если ничего не выбрано - оставляем текущее
            $data['video'] = $videoTransfer->video;
        }

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $videoTransfer->update($data);

        return redirect()->route('video-transfers.index')
            ->with('success', 'Transfer успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VideoTransfer $videoTransfer)
    {
        try {
            // Обновляем поле deleter_id перед удалением
            $videoTransfer->update([
                'deleter_id' => auth()->id(),
            ]);

            $videoTransfer->delete();

            return redirect()->route('video-transfers.index')
                ->with('success', 'Видеорепортаж успешно удален');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
