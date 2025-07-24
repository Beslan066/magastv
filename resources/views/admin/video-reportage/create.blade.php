@extends('layouts.admin')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Упс!</strong> Ошибки валидации:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-header">Создание видеорепортажа</h4>
        </div>

        <form action="{{ route('video-reportages.store') }}" method="post" enctype="multipart/form-data" id="videoReportageForm">
            @csrf
            <div class="row mb-6 gy-6">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label">Заголовок *</label>
                                <input type="text" class="form-control" placeholder="Введите заголовок" name="title" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">URL</label>
                                <input type="text" class="form-control" placeholder="Оставьте пустым для автоматического создания" name="slug">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Лид новости *</label>
                                <textarea class="form-control" placeholder="Краткое описание" name="lead" rows="3" required></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Содержание</label>
                                <textarea id="summernote" name="content"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Категория *</label>
                                <select class="form-select" name="category_id" required>
                                    <option value="">Выберите категорию...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                <input type="file" class="form-control" name="preview" accept="image/*" id="previewUpload">
                                <div class="preview-wrapper mt-3 text-center" id="previewWrapper" style="display: none;">
                                    <img id="previewImage" class="img-thumbnail" style="max-height: 200px;">
                                    <button type="button" class="btn btn-sm btn-danger mt-2" id="removePreview">
                                        <i class="bx bx-trash"></i> Удалить
                                    </button>
                                </div>
                            </div>

                            <!-- Блок для загрузки видео -->
                            <div class="mb-4">
                                <label class="form-label">Видео файл *</label>
                                <div class="video-upload-container" id="videoDropzone">
                                    <input type="file" id="videoUpload" name="video"
                                           accept="video/mp4,video/quicktime,video/ogg,video/x-qt" style="display: none;">
                                    <label for="videoUpload" class="video-upload-label">
                                        <i class="bx bx-cloud-upload fs-1 text-primary"></i>
                                        <h5 class="mt-2">Кликните для загрузки видео</h5>
                                        <p class="text-muted">MP4, MOV, OGG (до 200MB)</p>
                                    </label>
                                    <div class="progress mt-3" id="uploadProgress" style="display: none; height: 20px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                             role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <div id="videoInfo" class="mt-2"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Дата публикации *</label>
                                <input type="datetime-local" name="published_at" class="form-control"
                                       value="{{ now()->timezone('Europe/Moscow')->format('Y-m-d\TH:i') }}" required>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="mainMaterialSwitch" name="main_material">
                                <label class="form-check-label" for="mainMaterialSwitch">Главный материал</label>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="statusSwitch" name="status" checked>
                                <label class="form-check-label" for="statusSwitch">Опубликовано</label>
                            </div>

                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('video-reportages.index') }}" class="btn btn-secondary">Отмена</a>
                <button type="submit" class="btn btn-primary">Создать репортаж</button>
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

        const videoUpload = document.getElementById('videoUpload');

        $(document).ready(function() {
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

            // Превью изображения
            $('#previewUpload').change(function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImage').attr('src', e.target.result);
                        $('#previewWrapper').show();
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Удаление превью
            $('#removePreview').click(function() {
                $('#previewUpload').val('');
                $('#previewWrapper').hide();
            });

            // Загрузка видео с прогресс-баром
            if (videoUpload) {
                videoUpload.addEventListener('change', function() {
                    const file = this.files[0];
                    if (!file) return;

                    // Check file size
                    if (file.size > 200 * 1024 * 1024) {
                        $('#videoInfo').html(
                            '<div class="alert alert-danger">Файл слишком большой (макс. 200MB)</div>'
                        );
                        $(this).val('');
                        return;
                    }

                    // Show file info
                    $('#videoInfo').html(
                        '<div class="alert alert-info">' +
                        '<i class="bx bx-loader bx-spin"></i> ' +
                        'Подготовка к загрузке: ' + file.name + ' (' +
                        Math.round(file.size / (1024 * 1024)) + 'MB)' +
                        '</div>'
                    );

                    // Show progress bar
                    $('#uploadProgress').show();

                    // Create FormData
                    const formData = new FormData();
                    formData.append('video', file);
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('ajax_upload', true); // Add flag for AJAX request

                    // AJAX request
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '{{ route("video-reportages.store") }}', true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                    // Progress handler
                    xhr.upload.onprogress = function(e) {
                        if (e.lengthComputable) {
                            const percent = Math.round((e.loaded / e.total) * 100);
                            $('.progress-bar').css('width', percent + '%');
                        }
                    };

                    // Response handler
                    xhr.onload = function() {
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
                                    // Store the path in a hidden field
                                    $('<input>').attr({
                                        type: 'hidden',
                                        name: 'uploaded_video_path',
                                        value: response.video_path
                                    }).appendTo('form');
                                    // Remove the video file input to prevent duplicate upload
                                    $('#videoUpload').val('');
                                } else if (response.error) {
                                    showError(response.error);
                                } else {
                                    showError('Не удалось получить путь к видео');
                                }
                            } catch (e) {
                                showError('Ошибка обработки ответа сервера');
                            }
                        } else if (xhr.status === 422) {
                            // Handle validation errors
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

                    xhr.onerror = function() {
                        showError('Ошибка сети при загрузке видео');
                        $('#uploadProgress').hide();
                    };

                    xhr.send(formData);
                });
            }

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
