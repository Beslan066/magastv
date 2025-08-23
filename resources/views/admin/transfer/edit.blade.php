@extends('layouts.admin')

@push('styles')
    <style>
        .current-video-wrapper video,
        #videoPreview {
            max-height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .remove-current-video {
            margin-top: 10px;
        }

        .progress {
            height: 20px;
            margin-bottom: 5px;
        }

        .video-upload-status {
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
@endpush

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
            <h4 class="card-header">Изменение передачи</h4>
        </div>

        <form action="{{route('transfers.update', $transfer->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row mb-6 gy-6">
                <div class="col-xl">
                    <div class="card w-50">
                        <div class="card-body">
                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="Заголовок" name="title"
                                       value="{{$transfer->title}}">
                            </div>

                            @error('title')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="mb-4">
                                <input type="text" class="form-control"
                                       placeholder="URL (оставьте пустым для автоматического сгенерирования)"
                                       name="slug" value="{{$transfer->slug}}">
                            </div>

                            <div class="mb-4">
                                <div class="input-group">
                                    <textarea class="form-control" placeholder="Лид новости"
                                              name="lead">{{$transfer->lead}}</textarea>
                                </div>
                            </div>

                            @error('lead')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="mb-4">
                                <div class="input-group">
                                    <textarea class="form-control" placeholder="Например: по будням"
                                              name="published">{{$transfer->published}}</textarea>
                                </div>
                            </div>

                            @error('published')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="input-group mb-4">
                                <select class="form-select" id="inputGroupSelect02" name="category_id">
                                    @if(isset($transfer->category_id))
                                        <option
                                            value="{{$transfer->category_id}}">{{$transfer->category->title}}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">Выберите категорию...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <label class="input-group-text" for="inputGroupSelect02">Категории</label>
                            </div>
                            @error('category_id')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="file" class="form-control" id="inputGroupFile02" name="image"
                                           accept="image/*" @if($transfer->image)
                                               data-default-file="{{ asset('storage/public/' . $transfer->image_main) }}"
                                        @endif>
                                    <label class="input-group-text" for="inputGroupFile02">Изображение</label>
                                </div>
                                @error('image')
                                <div class="mb-2 text-danger">{{$message}}</div>
                                @enderror

                                <!-- Блок для текущего изображения слайдера -->
                                @if($transfer->slider_image)
                                    <div class="current-slider-image-wrapper mt-3 position-relative">
                                        <h4 class="text-secondary">Текущее изображение слайдера</h4>
                                        <img src="{{ asset('storage/public/' . $transfer->slider_image) }}"
                                             class="img-thumbnail current-slider-image"
                                             style="max-height: 200px">
                                        <button type="button"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-current-slider-image"
                                                title="Удалить изображение">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" name="remove_slider_image" id="remove_slider_image" value="0">
                                @endif

                                <!-- Блок для превью нового изображения слайдера -->
                                <div class="new-slider-image-wrapper mt-3" style="display: none">
                                    <h4 class="text-secondary">Новое изображение слайдера</h4>
                                    <div class="position-relative d-inline-block">
                                        <img id="sliderImagePreview" class="img-thumbnail" style="max-height: 200px">
                                        <button type="button"
                                                class="btn btn-light btn-sm position-absolute top-0 end-0 m-1 rounded-circle clear-slider-preview"
                                                title="Удалить изображение">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Поле для загрузки видео слайдера -->
                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="file" class="form-control" id="sliderVideo" name="slider_video"
                                           accept="video/*">
                                    <label class="input-group-text" for="sliderVideo">Видео для слайдера</label>
                                </div>
                                @error('slider_video')
                                <div class="mb-2 text-danger">{{ $message }}</div>
                                @enderror

                                <!-- Блок для текущего видео -->
                                @if($transfer->slider_video)
                                    <div class="current-video-wrapper mt-3 position-relative">
                                        <h4 class="text-secondary">Текущее видео слайдера</h4>
                                        <video controls class="img-thumbnail" style="max-height: 200px; width: 100%;">
                                            <source src="{{ asset('storage/public/' . $transfer->slider_video) }}"
                                                    type="video/mp4">
                                        </video>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-danger btn-sm remove-current-video">
                                                <i class="bx bx-trash"></i> Удалить видео
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="remove_slider_video" id="remove_slider_video" value="0">
                                @endif

                                <!-- Индикатор загрузки нового видео -->
                                <div id="videoUploadProgress" class="mt-2" style="display: none;">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small class="text-muted">Загрузка: <span id="progressPercent">0</span>%</small>
                                    <div id="uploadStatus" class="mt-1"></div>
                                </div>

                                <!-- Предпросмотр нового видео -->
                                <div id="videoPreviewWrapper" class="mt-3" style="display: none;">
                                    <h4 class="text-secondary">Новое видео слайдера</h4>
                                    <video id="videoPreview" controls class="img-thumbnail"
                                           style="max-height: 200px; width: 100%;">
                                        Ваш браузер не поддерживает видео
                                    </video>
                                    <button type="button" class="btn btn-light btn-sm mt-1" id="clearVideoPreview">
                                        <i class="bx bx-trash"></i> Удалить видео
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl">
                <div class="card w-50">
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="input-group">
                                <input type="file" class="form-control slider-image-upload" id="inputGroupFile03"
                                       name="slider_image" accept="image/*">
                                <label class="input-group-text" for="inputGroupFile03">Изображение для слайдера</label>
                            </div>
                            @error('slider_image')
                            <div class="mb-2 text-danger">{{ $message }}</div>
                            @enderror

                            <!-- Блок для текущего изображения слайдера -->
                            @if($transfer->slider_image)
                                <div class="current-slider-image-wrapper mt-3 position-relative">
                                    <h4 class="text-secondary">Текущее изображение слайдера</h4>
                                    <img src="{{ asset('storage/public/' . $transfer->slider_image) }}"
                                         class="img-thumbnail current-slider-image"
                                         style="max-height: 200px">
                                </div>
                                <input type="hidden" name="remove_slider_image" id="remove_slider_image" value="0">
                            @endif

                            <!-- Блок для превью нового изображения слайдера -->
                            <div class="new-slider-image-wrapper mt-3" style="display: none">
                                <h4 class="text-secondary">Новое изображение слайдера</h4>
                                <div class="position-relative d-inline-block">
                                    <img id="sliderImagePreview" class="img-thumbnail" style="max-height: 200px">
                                    <button type="button"
                                            class="btn btn-light btn-sm position-absolute top-0 end-0 m-1 rounded-circle clear-slider-preview"
                                            title="Удалить изображение">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{--                        <div class="input-group mb-4">--}}
                        {{--                            <select class="form-select" id="inputGroupSelect02" name="reportage_id">--}}
                        {{--                                <option value="">Фоторепортаж...</option>--}}
                        {{--                                @if(isset($photoreportages))--}}
                        {{--                                    @foreach($photoreportages as $photoreportage)--}}
                        {{--                                        <option value="{{ $photoreportage->id }}">--}}
                        {{--                                            {{ $photoreportage->name }}--}}
                        {{--                                        </option>--}}
                        {{--                                    @endforeach--}}
                        {{--                                @endif--}}
                        {{--                            </select>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="input-group mb-4">--}}
                        {{--                            <select class="form-select" id="inputGroupSelect02" name="category_id">--}}
                        {{--                                <option value="">Видео к новости...</option>--}}
                        {{--                                @if(isset($videos))--}}
                        {{--                                    @foreach($videos as $video)--}}
                        {{--                                        <option value="{{ $video->id }}">--}}
                        {{--                                            {{ $video->name }}--}}
                        {{--                                        </option>--}}
                        {{--                                    @endforeach--}}
                        {{--                                @endif--}}
                        {{--                            </select>--}}
                        {{--                        </div>--}}

                        <div class="input-group mb-4">
                            <select class="form-select" id="inputGroupSelect02" name="age_restriction_id">
                                @if(isset($tvProgram->age_restriction))
                                    <option value="{{$tvProgram->age_restriction->id}}">{{ $tvProgram->age_restriction->title }}</option>
                                @else
                                    <option value="">Нет</option>
                                    @foreach($ages as $age)
                                        <option value="{{ $age->id }}">
                                            {{ $age->title }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <label class="input-group-text" for="inputGroupSelect02">Возрастное ограничение</label>
                        </div>


                        <div class="mb-2">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        </div>

                        <div class="form-check form-switch mb-2 mt-2">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                                   name="main_material" @if($transfer->main_material == 1)
                                       checked
                                @endif>
                            <label class="form-check-label" for="flexSwitchCheckChecked">Выводить в слайдер</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ml-2 mb-2">
                <a href="{{route('transfers.index')}}" class="btn btn-secondary">Отмена</a>
                <button type="submit" class="btn btn-primary">Обновить</button>
            </div>


        </form>

    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Упсс!</strong> Возникла ошибка при заполнении полей.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Обработка загрузки нового изображения слайдера
            $('#inputGroupFile03').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#sliderImagePreview').attr('src', e.target.result);
                        $('.new-slider-image-wrapper').show();
                        $('.current-slider-image-wrapper').hide();
                        $('#remove_slider_image').val('0');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Удаление текущего изображения слайдера
            $('.remove-current-slider-image').click(function() {
                if (confirm('Вы уверены, что хотите удалить текущее изображение слайдера?')) {
                    $('.current-slider-image-wrapper').hide();
                    $('#remove_slider_image').val('1');
                }
            });

            // Очистка превью нового изображения слайдера
            $('.clear-slider-preview').click(function() {
                $('#inputGroupFile03').val('');
                $('#sliderImagePreview').attr('src', '');
                $('.new-slider-image-wrapper').hide();
                $('.current-slider-image-wrapper').show();
            });

            // Обработка выбора видео
            $('#sliderVideo').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Показываем предпросмотр
                    const videoPreview = document.getElementById('videoPreview');
                    const videoURL = URL.createObjectURL(file);
                    videoPreview.src = videoURL;
                    $('#videoPreviewWrapper').show();

                    // Скрываем текущее видео
                    $('.current-video-wrapper').hide();
                    $('#remove_slider_video').val('0');

                    // Показываем индикатор прогресса
                    $('#videoUploadProgress').show();

                    // Симулируем прогресс загрузки
                    simulateUploadProgress();
                }
            });

            // Удаление текущего видео
            $('.remove-current-video').click(function() {
                if (confirm('Вы уверены, что хотите удалить текущее видео?')) {
                    $('.current-video-wrapper').hide();
                    $('#remove_slider_video').val('1');
                }
            });

            // Очистка превью нового видео
            $('#clearVideoPreview').click(function() {
                $('#sliderVideo').val('');
                $('#videoPreview').attr('src', '');
                $('#videoPreviewWrapper').hide();
                $('#videoUploadProgress').hide();
                $('.current-video-wrapper').show();
                $('#remove_slider_video').val('0');
            });

            // Функция симуляции прогресса загрузки
            function simulateUploadProgress() {
                let progress = 0;
                const progressBar = document.querySelector('.progress-bar');
                const progressPercent = document.getElementById('progressPercent');
                const uploadStatus = document.getElementById('uploadStatus');

                uploadStatus.innerHTML = '<div class="text-info">Загрузка начата...</div>';

                const interval = setInterval(() => {
                    progress += 5;
                    if (progress <= 100) {
                        progressBar.style.width = progress + '%';
                        progressPercent.textContent = progress;

                        if (progress === 100) {
                            uploadStatus.innerHTML = '<div class="text-success">Видео успешно загружено!</div>';
                            clearInterval(interval);
                        }
                    }
                }, 200);
            }
        });
    </script>

@endpush
