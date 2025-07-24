<div class="preview-container border p-3 rounded">
    @if(str()->startsWith($file->type, 'image/'))
        <img src="{{ Storage::url($file->path) }}" class="img-fluid" alt="Preview">
    @elseif(str()->startsWith($file->type, 'video/'))
        <video controls class="w-100">
            <source src="{{ Storage::url($file->path) }}" type="{{ $file->type }}">
        </video>
    @elseif(str()->startsWith($file->type, 'audio/'))
        <audio controls class="w-100">
            <source src="{{ Storage::url($file->path) }}" type="{{ $file->type }}">
        </audio>
    @else
        <div class="text-center py-4">
            <i class="far fa-file-alt fa-4x text-muted"></i>
            <div class="mt-2">{{ $file->name }}</div>
        </div>
    @endif
</div>
