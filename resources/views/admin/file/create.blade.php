@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-header">Загрузка файлов</h4>
        </div>

        <form action="{{ route('files.store') }}" method="post" enctype="multipart/form-data" id="uploadForm" data-file-upload>
            @csrf

            <div class="card-body">
                <div class="mb-4">
                    <input type="text" class="form-control" placeholder="Заголовок" name="title">
                </div>

                <div class="input-group mb-4">
                    <input type="file" class="form-control" id="inputGroupFile02" name="file" accept="file/*">
                </div>

                <div id="uploadProgress" class="progress mb-3 d-none">
                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                </div>

                <div id="previewContainer" class="d-none mb-4">
                    <div class="file-preview">
                        <div class="preview-content">
                            <img id="imagePreview" class="img-fluid d-none" style="max-height: 150px">
                            <video id="videoPreview" class="d-none" controls style="max-height: 150px"></video>
                            <audio id="audioPreview" class="d-none" controls></audio>
                            <div id="docPreview" class="d-none">
                                <i class="fas fa-file-pdf fa-3x"></i>
                                <div class="file-extension"></div>
                            </div>
                        </div>
                        <div class="file-name mt-2 text-center"></div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Загрузить</button>
                    <button type="button" id="cancelUpload" class="btn btn-danger d-none">
                        <i class="fas fa-times-circle"></i> Отмена
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        #uploadProgress {
            height: 20px;
        }

        .preview-content {
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 5px;
        }

        #videoPreview, #audioPreview {
            max-width: 100%;
        }

        .progress {
            height: 25px;
            border-radius: 4px;
        }

        .progress-bar {
            transition: width 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .file-preview {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 15px;
        }

        #docPreview {
            text-align: center;
            color: #dc3545;
        }

        .file-extension {
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 5px;
        }

    </style>
@endsection

<script >
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.querySelector('input[type="file"]');
        const progressBar = document.querySelector('.progress-bar');
        const uploadProgress = document.getElementById('uploadProgress');
        const previewContainer = document.getElementById('previewContainer');
        const previewElements = {
            image: document.getElementById('imagePreview'),
            video: document.getElementById('videoPreview'),
            audio: document.getElementById('audioPreview'),
            doc: document.getElementById('docPreview')
        };

        input.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Скрываем все превью перед загрузкой нового
            Object.values(previewElements).forEach(el => el.classList.add('d-none'));

            const fileType = file.type;
            const fileReader = new FileReader();

            fileReader.onload = function(e) {
                if (fileType.startsWith('image/')) {
                    previewElements.image.src = e.target.result;
                    previewElements.image.classList.remove('d-none');
                } else if (fileType.startsWith('video/')) {
                    previewElements.video.src = e.target.result;
                    previewElements.video.classList.remove('d-none');
                } else if (fileType.startsWith('audio/')) {
                    previewElements.audio.src = e.target.result;
                    previewElements.audio.classList.remove('d-none');
                } else {
                    previewElements.doc.classList.remove('d-none');
                    previewElements.doc.querySelector('.file-extension').textContent = file.name.split('.').pop().toUpperCase();
                }

                previewContainer.classList.remove('d-none');

                // Показываем прогресс-бар и анимируем его (симуляция загрузки)
                uploadProgress.classList.remove('d-none');
                progressBar.style.width = '0%';
                progressBar.textContent = '0%';

                let progress = 0;
                const interval = setInterval(() => {
                    progress += 10;
                    progressBar.style.width = `${progress}%`;
                    progressBar.textContent = `${progress}%`;

                    if (progress >= 100) clearInterval(interval);
                }, 200);
            };

            if (fileType.startsWith('image/') || fileType.startsWith('video/') || fileType.startsWith('audio/')) {
                fileReader.readAsDataURL(file);
            } else {
                previewContainer.classList.remove('d-none');
            }
        });
    });
</script>

