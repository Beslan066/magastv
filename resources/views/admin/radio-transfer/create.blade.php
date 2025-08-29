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
            <h4 class="card-header">Создание передачи</h4>
        </div>

        <form action="{{route('radio-transfers.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mb-6 gy-6">
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4">
                                    <input type="text" class="form-control" placeholder="Заголовок" name="title">
                                </div>

                                @error('title')
                                <div class="mb-2 text-danger">{{$message}}</div>
                                @enderror

                                <div class="mb-4">
                                    <input type="text" class="form-control"  placeholder="URL (оставьте пустым для автоматического сгенерирования)" name="slug">
                                </div>

                                <div class="mb-4">
                                    <div class="input-group">
                                        <textarea class="form-control" placeholder="Лид новости" name="lead"></textarea>
                                    </div>
                                </div>

                                @error('lead')
                                <div class="mb-2 text-danger">{{$message}}</div>
                                @enderror


                                <div class="input-group mb-4">
                                    <select class="form-select" id="inputGroupSelect02" name="radio_show_type_id">
                                        <option value="">Выберите категорию...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @error('category_id')
                                <div class="mb-2 text-danger">{{$message}}</div>
                                @enderror


                            </div>
                        </div>
                    </div>
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4">
                                    <!-- Блок для предпросмотра нового изображения -->
                                    <div class="mb-4">
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="inputGroupFile02" name="image" accept="image/*">
                                            <label class="input-group-text" for="inputGroupFile02">Изображение</label>
                                        </div>

                                        <!-- Блок для нового изображения -->
                                        <div class="new-image-wrapper mt-3" style="display: none">
                                            <div class="position-relative d-inline-block">
                                                <img id="imagePreview" class="img-thumbnail" style="max-height: 200px">
                                                <button type="button" class="btn btn-light btn-sm position-absolute top-0 end-0 m-1 rounded-circle"
                                                        id="clearPreview" title="Удалить изображение">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                </div>

                            </div>
                    </div>
            </div>

                <div class="ml-2 mb-2">
                    <a href="{{route('radio-transfers')}}" class="btn btn-secondary">Отмена</a>
                    <button type="submit" class="btn btn-primary">Создать</button>
                </div>
            </div>
        </form>

    </div>
@endsection


@push('scripts')
    <!-- jQuery (необходим для Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        const fileInput = document.getElementById('inputGroupFile02');
        const newImageWrapper = document.querySelector('.new-image-wrapper');
        const oldImageWrapper = document.querySelector('.old-image-wrapper');
        const preview = document.getElementById('imagePreview');
        const clearBtn = document.getElementById('clearPreview');

        // Обработчик выбора файла
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    newImageWrapper.style.display = 'block';
                    if (oldImageWrapper) oldImageWrapper.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });

        // Обработчик очистки
        clearBtn.addEventListener('click', function() {
            // Сбрасываем поле ввода файла
            fileInput.value = '';

            // Скрываем новый превью
            newImageWrapper.style.display = 'none';
            preview.src = '';

            // Показываем старое изображение (если есть)
            if (oldImageWrapper) oldImageWrapper.style.display = 'block';
        });

        // Новый код для превью slider_image
        document.getElementById('inputGroupFile03').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('sliderImagePreview').src = e.target.result;
                    document.querySelector('.new-slider-image-wrapper').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Очистка превью slider_image
        document.getElementById('clearSliderPreview').addEventListener('click', function() {
            document.getElementById('inputGroupFile03').value = '';
            document.getElementById('sliderImagePreview').src = '';
            document.querySelector('.new-slider-image-wrapper').style.display = 'none';
        });
    </script>
@endpush
