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
            <h4 class="card-header">Создание руководителя</h4>
        </div>

        <form action="{{route('supervisors.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mb-6 gy-6">
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4">
                                    <input type="text" class="form-control" placeholder="ФИО" name="name">
                                </div>

                                <div class="mb-4">
                                    <div class="input-group">
                                        <textarea class="form-control" placeholder="Должность" name="lead"></textarea>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <textarea id="summernote" name="content"></textarea>
                                </div>

                                <div class="mb-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Телефон" name="phone">
                                        <input type="text" class="form-control" placeholder="Факс" name="fax">
                                        <input type="text" class="form-control" placeholder="Email" name="email">
                                    </div>
                                </div>
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

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="status">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Текущий руководитель</label>
                                </div>
                            </div>
                    </div>
            </div>

                <div class="ml-2 mb-2">
                    <a href="{{route('supervisors.index')}}" class="btn btn-secondary">Отмена</a>
                    <button type="submit" class="btn btn-primary">Создать</button>
                </div>
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

@section('styles')
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@push('scripts')
    <!-- jQuery (необходим для Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
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
        });


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



    </script>


@endpush
