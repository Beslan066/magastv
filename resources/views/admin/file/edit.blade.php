@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-header">Редактирование файла</h4>
        </div>

        <form action="{{ route('files.update', $file) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <!-- Текущий файл -->
                <div class="mb-4">
                    <label class="form-label">Текущий файл</label>
                    <div class="file-preview">
                        @include('partials.file-preview', ['file' => $file])
                    </div>
                </div>

                <!-- Поле для изменения файла -->
                <div class="mb-4" id="dropZone" style="border: 2px dashed #ccc; padding: 2rem; cursor: pointer;">
                    <label for="fileInput" class="form-label d-block text-center">
                        <i class="fas fa-cloud-upload-alt fa-3x"></i>
                        <div class="mt-2">Перетащите файлы сюда или кликните для выбора</div>
                    </label>
                    <input type="file" class="form-control d-none" id="fileInput" ...>
                </div>

                <!-- Название файла -->
                <div class="mb-4">
                    <label for="name" class="form-label">Название</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="{{ old('name', $file->name) }}" required>
                </div>

                <!-- Описание -->
                <div class="mb-4">
                    <label for="description" class="form-label">Описание</label>
                    <textarea class="form-control" id="description" name="description"
                              rows="3">{{ old('description', $file->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Обновить</button>
                <button type="button" id="cancelUpload" class="btn btn-danger d-none">
                    <i class="fas fa-times-circle"></i> Отмена
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    @include('partials.upload-scripts')

    <script>
        // Дополнительные скрипты для страницы редактирования
        $(document).ready(function() {
            // Обработка замены файла
            $('#fileInput').change(function() {
                if (this.files.length > 0) {
                    $('.file-preview').hide();
                } else {
                    $('.file-preview').show();
                }
            });
        });
    </script>
@endsection
