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
            <h4 class="card-header">Изменение</h4>
        </div>

        <form action="{{route('supervisors.update', $supervisor->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row mb-6 gy-6">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="Заголовок" name="title" value="{{$supervisor->name}}">
                            </div>

                            @error('name')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror


                            <div class="mb-4">
                                <div class="input-group">
                                    <textarea class="form-control" placeholder="Должность" name="lead">{{$supervisor->lead}}</textarea>
                                </div>
                            </div>

                            @error('lead')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="mb-4">
                                <textarea id="summernote" name="content">
                                    {!! $supervisor->content !!}
                                </textarea>
                            </div>
                            @error('content')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Телефон" name="phone" value="{{$supervisor->phone}}">
                                    <input type="text" class="form-control" placeholder="Факс" name="fax" value="{{$supervisor->fax}}">
                                    <input type="text" class="form-control" placeholder="Email" name="email" value="{{$supervisor->email}}">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="file" class="form-control" id="inputGroupFile02" name="image" accept="image/*" @if($supervisor->image)
                                        data-default-file="{{ asset('storage/public/' . $supervisor->image) }}"
                                           @endif>
                                    <label class="input-group-text" for="inputGroupFile02">Изображение</label>
                                </div>
                                @error('image')
                                    <div class="mb-2 text-danger">{{$message}}</div>
                                @enderror

                                <!-- Блок для старого изображения -->
                                @if (isset($supervisor->image))
                                <div class="old-image-wrapper mt-3 position-relative">
                                    <h4 class="text-secondary">Текущее изображение</h4>
                                    <img src="{{asset('storage/public/' . $supervisor->image)}}" class="img-thumbnail old-image-preview" style="max-height: 200px">
                                </div>
                                @endif

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


                            <div class="mb-2">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            </div>

                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="status" @if($supervisor->status == 1)
                                    checked
                                    @endif>
                                <label class="form-check-label" for="flexSwitchCheckChecked">Текущий руководитель</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ml-2 mb-2">
                    <a href="{{route('supervisors.index')}}" class="btn btn-secondary">Отмена</a>
                    <button type="submit" class="btn btn-primary">Обновить</button>
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

@section('scripts')
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
    </script>
@endsection
