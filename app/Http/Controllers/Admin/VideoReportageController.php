<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VideoReportage\StoreRequest;
use App\Http\Requests\Admin\VideoReportage\UpdateRequest;
use App\Models\Category;
use App\Models\VideoReportage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoReportageController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all(); // Добавляем получение категорий

        $videos = VideoReportage::query()
            ->with(['user', 'category']) // eager loading для автора и категории
            ->when($request->search, function($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('lead', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->when($request->author, function($query, $author) {
                $query->whereHas('user', function($q) use ($author) {
                    $q->where('name', 'like', "%{$author}%");
                });
            })
            ->when($request->category, function($query, $category) {
                $query->where('category_id', $category);
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
                    case 'views_desc':
                        $query->orderBy('views', 'desc');
                        break;
                    default:
                        $query->orderBy('id', 'desc');
                }
            }, function($query) {
                $query->orderBy('id', 'desc'); // сортировка по умолчанию
            })
            ->paginate(10)
            ->withQueryString(); // сохраняем параметры в пагинации

        return view('admin.video-reportage.index', compact('videos', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.video-reportage.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        // Handle AJAX video upload
        // if ($request->ajax() && $request->hasFile('video')) {
        //     try {
        //         $path = Storage::disk('public')->put('videoReportages', $request->file('video'));
        //         return response()->json(['video_path' => $path]);
        //     } catch (\Exception $e) {
        //         return response()->json(['error' => $e->getMessage()], 500);
        //     }
        // }

        // Regular form submission
        if ($request->hasFile('preview')) {
            $path = Storage::disk('public')->put('previews', $request->file('preview'));
            $data['preview'] = $path ?? null;
        }

        // Use either the uploaded video path or the newly uploaded file
        // if ($request->has('uploaded_video_path')) {
        //     $data['video'] = $request->input('uploaded_video_path');
        // } elseif ($request->hasFile('video')) {
        //     $path = Storage::disk('public')->put('videoReportages', $request->file('video'));
        //     $data['video'] = $path ?? null;
        // }

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['main_material'] = $request->has('main_material') ? 1 : 0;
        $data['ing_news'] = $request->has('ing_news') ? 1 : 0;
        $data['status'] = $request->has('status') ? 1 : 0;

        VideoReportage::create($data);

        return redirect()->route('video-reportages.index')
            ->with('success', 'Видеорепортаж успешно создан');
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
    public function edit(VideoReportage $video_reportage)
    {
        $categories = Category::all();
        return view('admin.video-reportage.edit', compact('video_reportage', 'categories'));
    }

    public function update(UpdateRequest $request, VideoReportage $video_reportage)
    {
        $data = $request->validated();

        // Handle AJAX video upload
        // if ($request->ajax() && $request->hasFile('video')) {
        //     try {
        //         // Delete old video if exists
        //         if ($video_reportage->video) {
        //             Storage::disk('public')->delete($video_reportage->video);
        //         }

        //         $path = Storage::disk('public')->put('videoReportages', $request->file('video'));
        //         return response()->json(['video_path' => $path]);
        //     } catch (\Exception $e) {
        //         return response()->json(['error' => $e->getMessage()], 500);
        //     }
        // }

        // Handle preview image
        if ($request->hasFile('preview')) {
            // Delete old preview if exists
            if ($video_reportage->preview) {
                Storage::disk('public')->delete($video_reportage->preview);
            }

            $path = Storage::disk('public')->put('previews', $request->file('preview'));
            $data['preview'] = $path;
        }

        // Handle video file
        // if ($request->has('uploaded_video_path')) {
        //     $data['video'] = $request->input('uploaded_video_path');
        // } elseif ($request->hasFile('video')) {
        //     // Delete old video if exists
        //     if ($video_reportage->video) {
        //         Storage::disk('public')->delete($video_reportage->video);
        //     }

        //     $path = Storage::disk('public')->put('videoReportages', $request->file('video'));
        //     $data['video'] = $path;
        // }

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['main_material'] = $request->has('main_material') ? 1 : 0;
        $data['status'] = $request->has('status') ? 1 : 0;

        $video_reportage->update($data);

        return redirect()->route('video-reportages.index')
            ->with('success', 'Видеорепортаж успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VideoReportage $video_reportage)
    {
        try {
            // Обновляем поле deleter_id перед удалением
            $video_reportage->update([
                'deleter_id' => auth()->id(),
            ]);

            $video_reportage->delete();

            return redirect()->route('video-reportages.index')
                ->with('success', 'Видеорепортаж успешно удален');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}
