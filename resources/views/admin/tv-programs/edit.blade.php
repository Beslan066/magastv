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
            <h4 class="card-header">Редактирование программы</h4>
        </div>

        <form action="{{ route('tv-programs.update', $tvProgram->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mb-6 gy-6">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="Название программы"
                                       name="title" value="{{ old('title', $tvProgram->title) }}" required>
                            </div>

                            <div class="input-group mb-4">
                                <select class="form-select" id="inputGroupSelect02" name="category_id">
                                    @if(isset($tvProgram->tvShowType))
                                        <option value="{{$tvProgram->tvShowType->id}}">{{ $tvProgram->tvShowType->title }}</option>
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
                                <input type="text" class="form-control" placeholder="Время (например: 10:00 - 12:00)"
                                       name="time_range" value="{{ old('time_range', $tvProgram->time_range) }}" required>
                            </div>

                            <div class="mb-4">
                                <input type="date" class="form-control" name="program_date"
                                       value="{{ old('program_date', $tvProgram->program_date->format('Y-m-d')) }}" required>
                            </div>

                            <div class="mb-4">
                                <textarea class="form-control" placeholder="Описание" name="description" rows="5">{{ old('description', $tvProgram->description) }}</textarea>
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

                                @if($tvProgram->image)
                                    <div class="existing-image-wrapper mt-3">
                                        <div class="position-relative d-inline-block">
                                            <img src="{{ asset('storage/public/' . $tvProgram->image) }}"
                                                 alt="{{ $tvProgram->title }}"
                                                 style="max-width: 200px;">

                                        </div>
                                    </div>
                                @endif

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
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="top_show" @if($tvProgram->top_show == 1)
                                    checked
                                    @endif>
                                <label class="form-check-label" for="flexSwitchCheckChecked">Топ передача</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ml-2 mb-2">
                <a href="{{ route('tv-programs.index') }}" class="btn btn-secondary">Отмена</a>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
