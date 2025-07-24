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
            <h4 class="card-header">Добавление программы</h4>
        </div>

        <form action="{{ route('tv-programs.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mb-6 gy-6">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="Название программы" name="title" required>
                            </div>

                            <div class="input-group mb-4">
                                <select class="form-select" id="inputGroupSelect02" name="tv_show_type_id">
                                    <option value="">Выберите категорию...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <label class="input-group-text" for="inputGroupSelect02">Категории</label>
                            </div>

                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="Время (например: 10:00 - 12:00)" name="time_range" required>
                            </div>

                            <div class="mb-4">
                                <input type="date" class="form-control" name="program_date" required>
                            </div>

                            <div class="mb-4">
                                <textarea class="form-control" placeholder="Описание" name="description" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="file" class="form-control" id="imageUpload" name="image" accept="image/*">
                                    <label class="input-group-text" for="imageUpload">Изображение</label>
                                </div>

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

                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="top_show">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Топ передача</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ml-2 mb-2">
                <a href="{{ route('tv-programs.index') }}" class="btn btn-secondary">Отмена</a>
                <button type="submit" class="btn btn-primary">Создать</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.querySelector('.new-image-wrapper').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('clearPreview').addEventListener('click', function() {
            document.getElementById('imageUpload').value = '';
            document.getElementById('imagePreview').src = '';
            document.querySelector('.new-image-wrapper').style.display = 'none';
        });

        // Установка текущей даты по умолчанию
        document.querySelector('input[name="program_date"]').valueAsDate = new Date();
    </script>
@endsection
