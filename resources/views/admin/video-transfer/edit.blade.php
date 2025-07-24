@extends('layouts.admin')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Упсс!</strong> Ошибки валидации:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-header">Редактирование</h4>
        </div>

        <form action="{{ route('video-transfers.update', $videoTransfer->id) }}" method="post"
              enctype="multipart/form-data" id="videoTransferForm">
            @csrf
            @method('patch')
            <div class="row mb-6 gy-6">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label">Заголовок *</label>
                                <input type="text" class="form-control" placeholder="Введите заголовок" name="title"
                                       value="{{ old('title', $videoTransfer->title) }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">URL</label>
                                <input type="text" class="form-control"
                                       placeholder="Оставьте пустым для автоматического создания" name="slug"
                                       value="{{ old('slug', $videoTransfer->slug) }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Передача *</label>
                                <select class="form-select" name="transfer_id" required>
                                    <option value="">Выберите передачу...</option>
                                    @foreach($categories as $category)
                                        <option
                                            value="{{ $category->id }}" {{ $videoTransfer->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <!-- Блок для загрузки превью -->
                            <div class="mb-4">
                                <label class="form-label">Изображение превью</label>
                                @if($videoTransfer->preview)
                                    <div class="mb-3">
                                        <label>Текущее изображение:</label>
                                        <img src="{{ asset('storage/public/' . $videoTransfer->preview) }}"
                                             class="img-thumbnail d-block mb-2" style="max-height: 200px">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="deletePreview"
                                                   name="delete_preview">
                                            <label class="form-check-label" for="deletePreview">Удалить текущее
                                                изображение</label>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" class="form-control" name="preview" accept="image/*"
                                       id="previewUpload">
                                <div class="preview-wrapper mt-3 text-center" id="previewWrapper"
                                     style="display: none;">
                                    <img id="previewImage" class="img-thumbnail" style="max-height: 200px;">
                                    <button type="button" class="btn btn-sm btn-danger mt-2" id="removePreview">
                                        <i class="bx bx-trash"></i> Удалить
                                    </button>
                                </div>
                            </div>

                            <!-- Блок для видео -->
                            <!-- Блок для видео -->
                            <div class="mb-4">
                                @if($videoTransfer->video)
                                    <div class="mb-3">
                                        <label>Текущее видео:</label>
                                        <video controls class="w-100" poster="{{ asset('storage/public/'.$videoTransfer->preview) }}" style="max-height: 400px">
                                            <source src="{{ asset('storage/public/'.$videoTransfer->video) }}" type="video/mp4">
                                            Ваш браузер не поддерживает видео.
                                        </video>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="deleteVideo" name="delete_video">
                                            <label class="form-check-label" for="deleteVideo">Удалить текущее видео</label>
                                        </div>
                                    </div>
                                @endif

                                <label class="form-label">Новое видео (оставьте пустым, если не нужно менять)</label>
                                <div class="video-upload-container" id="videoDropzone">
                                    <input type="file" id="videoUpload" name="video" accept=".mp4,.mov,.ogg,video/mp4,video/quicktime,video/ogg" style="display: none;">
                                    <label for="videoUpload" class="video-upload-label">
                                        <i class="bx bx-cloud-upload fs-1 text-primary"></i>
                                        <h5 class="mt-2">Кликните для загрузки видео</h5>
                                        <p class="text-muted">MP4, MOV, OGG (до 200MB)</p>
                                    </label>
                                    <div class="progress mt-3" id="uploadProgress" style="display: none; height: 20px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <div id="videoInfo" class="mt-2"></div>
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="uploaded_video_path" id="uploadedVideoPath" value="{{ $videoTransfer->video ?? '' }}">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="uploaded_video_path" id="uploadedVideoPath" value="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('video-transfers.index') }}" class="btn btn-secondary">Отмена</a>
                <button type="submit" class="btn btn-primary">Обновить репортаж</button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .video-upload-container {
            border: 2px dashed #0d6efd;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s;
        }

        .video-upload-container:hover {
            background: #e9ecef;
            border-color: #0b5ed7;
        }

        .video-upload-label {
            cursor: pointer;
        }

        .video-upload-label h5 {
            color: #0d6efd;
            font-weight: 500;
        }

        #videoInfo {
            min-height: 24px;
        }

        .preview-wrapper img {
            max-width: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            // Инициализация редактора
            $('#summernote').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });


            if ('{{ $videoTransfer->video ?? '' }}') {
                $('#uploadedVideoPath').val('{{ $videoTransfer->video }}');
            }
            // Удаление превью
            $('#removePreview').click(function () {
                $('#previewUpload').val('');
                $('#previewWrapper').hide();
                // Если есть текущее изображение, отмечаем чекбокс удаления
                if ($('#deletePreview').length) {
                    $('#deletePreview').prop('checked', true);
                }
            });

// Если загружаем новое изображение, снимаем отметку с чекбокса удаления
            $('#previewUpload').change(function () {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#previewImage').attr('src', e.target.result);
                        $('#previewWrapper').show();
                        // Снимаем отметку с чекбокса удаления
                        if ($('#deletePreview').length) {
                            $('#deletePreview').prop('checked', false);
                        }
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Загрузка видео с прогресс-баром
            $('#videoUpload').change(function () {
                const file = this.files[0];
                if (!file) return;

                // Проверка размера файла
                if (file.size > 200 * 1024 * 1024) {
                    $('#videoInfo').html(
                        '<div class="alert alert-danger">Файл слишком большой (макс. 200MB)</div>'
                    );
                    $(this).val('');
                    return;
                }

                // Показываем информацию о файле
                $('#videoInfo').html(
                    '<div class="alert alert-info">' +
                    '<i class="bx bx-loader bx-spin"></i> ' +
                    'Подготовка к загрузке: ' + file.name + ' (' +
                    Math.round(file.size / (1024 * 1024)) + 'MB)' +
                    '</div>'
                );

                // Показываем прогресс-бар
                $('#uploadProgress').show();

                // Создаем FormData для AJAX-загрузки
                const formData = new FormData();
                formData.append('video', file);
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('_method', 'patch');
                formData.append('ajax_upload', true);

                // AJAX-загрузка файла
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route("video-transfers.update", $videoTransfer->id) }}', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                // Прогресс загрузки
                xhr.upload.onprogress = function (e) {
                    if (e.lengthComputable) {
                        const percent = Math.round((e.loaded / e.total) * 100);
                        $('.progress-bar').css('width', percent + '%');
                    }
                };

                // После загрузки
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.video_path) {
                                $('#videoInfo').html(
                                    '<div class="alert alert-success">' +
                                    '<i class="bx bx-check"></i> ' +
                                    'Видео успешно загружено: ' + file.name +
                                    '</div>'
                                );
                                $('#uploadedVideoPath').val(response.video_path);
                                $('#deleteVideo').prop('checked', false);
                            } else if (response.error) {
                                showError(response.error);
                            } else {
                                showError('Не удалось получить путь к видео');
                            }
                        } catch (e) {
                            showError('Ошибка обработки ответа сервера');
                        }
                    } else if (xhr.status === 422) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.errors && response.errors.video) {
                                showError(response.errors.video[0]);
                            } else {
                                showError('Ошибка валидации видеофайла');
                            }
                        } catch (e) {
                            showError('Ошибка валидации');
                        }
                    } else {
                        showError('Ошибка загрузки: ' + xhr.statusText);
                    }
                    setTimeout(() => $('#uploadProgress').hide(), 2000);
                };

                xhr.onerror = function () {
                    showError('Ошибка сети при загрузке видео');
                    $('#uploadProgress').hide();
                };

                xhr.send(formData);
            });

            function showError(message) {
                $('#videoInfo').html(
                    '<div class="alert alert-danger">' +
                    '<i class="bx bx-x"></i> ' + message +
                    '</div>'
                );
            }
        });
    </script>
@endpush
