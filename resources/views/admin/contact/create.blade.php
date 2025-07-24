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
            <h4 class="card-header">Контакты - создание</h4>
        </div>

        <form action="{{route('contacts.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mb-6 gy-6">
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body w-50">
                                <div class="mb-4">
                                    <input type="text" class="form-control" placeholder="Ссылка на карту или другой фрейм" name="content">
                                </div>

                                <div class="mb-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Адрес" name="address">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Телефон" name="phone">
                                        <input type="text" class="form-control" placeholder="Факс" name="fax">
                                        <input type="text" class="form-control" placeholder="Email" name="email">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                </div>
                            </div>
                        </div>
                    </div>

            </div>

                <div class="ml-2 mb-2">
                    <a href="{{route('contacts.index')}}" class="btn btn-secondary">Отмена</a>
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
