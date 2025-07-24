<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\File\StoreRequest;
use App\Http\Requests\Admin\File\UpdateRequest;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $files = File::query()->orderBy('id', 'desc')->paginate(10);
        return view('admin.file.index', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.file.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $file = $request->file('file');
        $category = $this->getFileCategory($file);

        $path = $file->store("public/{$category}");
        $relativePath = str_replace('public/', '', $path);

        File::create([
            'title' => $request->title,
            'path' => $relativePath,
            'type' => $category,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        return redirect()->route('files.index');
    }

    private function getFileCategory($file)
    {
        $mimeType = $file->getMimeType();

        return match (true) {
            str_starts_with($mimeType, 'image/') => 'image',
            str_starts_with($mimeType, 'video/') => 'video', // Было 'videos'
            str_starts_with($mimeType, 'audio/') => 'audio',
            default => 'document',
        };
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.file.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.file.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, File $file)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            // Удаляем старый файл
            Storage::delete($file->path);

            // Сохраняем новый файл
            $newFile = $request->file('file');
            $path = $newFile->store('public/uploads');

            $data['path'] = $path;
            $data['type'] = $newFile->getMimeType();
            $data['size'] = $newFile->getSize();
        }

        $file->update($data);

        return redirect()->route('files.show', $file)
            ->with('success', 'Файл успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
