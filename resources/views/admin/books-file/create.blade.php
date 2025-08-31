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
            <h4 class="card-header">Добавление файла</h4>
        </div>

        <form action="{{route('bookFiles.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mb-6 gy-6">
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4">
                                    <input type="text" class="form-control" placeholder="Заголовок" name="title">
                                </div>

                                <div class="mb-4">
                                    <input type="text" class="form-control"  placeholder="URL (оставьте пустым для автоматического сгенерирования)" name="slug">
                                </div>

                                <div class="input-group mb-4">
                                    <select class="form-select" id="inputGroupSelect02" name="audiobook_id">
                                        <option value="">Выберите аудиокнигу...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
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
                                <div class="mb-4">

                                    <div class="input-group">
                                        <input type="file" class="form-control" id="inputGroupFile02" name="audio" accept="audio/*">
                                        <label class="input-group-text" for="inputGroupFile02">Аудио</label>
                                    </div>

                                    <!-- Блок для нового изображения -->
                                    <div class="new-image-wrapper mt-3" style="display: none">
                                        <div class="position-relative d-inline-block">
                                            <img id="imagePreview" class="img-thumbnail" style="max-height: 200px">
                                            <button type="button" class="btn btn-light btn-sm position-absolute top-0 end-0 m-1 rounded-circle"
                                                    id="clearPreview" title="Удалить аудио">
                                                <i class="bx bx-trash"></i>
                                            </button>
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
                    <a href="{{route('bookFiles')}}" class="btn btn-secondary">Отмена</a>
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
