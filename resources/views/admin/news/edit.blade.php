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
            <h4 class="card-header">Изменение новости</h4>
        </div>

        <form action="{{route('news.update', $news->slug)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row mb-6 gy-6">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="Заголовок" name="title" value="{{$news->title}}">
                            </div>

                            @error('title')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="mb-4">
                                <input type="text" class="form-control"  placeholder="URL (оставьте пустым для автоматического сгенерирования)" name="slug" value="{{$news->slug}}">
                            </div>

                            <div class="mb-4">
                                <div class="input-group">
                                    <textarea class="form-control" placeholder="Лид новости" name="lead">{{$news->lead}}</textarea>
                                </div>
                            </div>

                            @error('lead')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="mb-4">
                                <textarea id="summernote" name="content">
                                    {!! $news->content !!}
                                </textarea>
                            </div>
                            @error('content')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror


                            <div class="input-group mb-4">
                                <select class="form-select" id="inputGroupSelect02" name="category_id">
                                    @if(isset($news->category_id))
                                        <option value="{{$news->category_id}}">{{$news->category->name}}</option>
                                    @else
                                        <option value="">Выберите категорию...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <label class="input-group-text" for="inputGroupSelect02">Категории</label>
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
                                <div class="input-group">
                                    <input type="file" class="form-control" id="inputGroupFile02" name="image" accept="image/*" @if($news->image)
                                        data-default-file="{{ asset('storage/public/' . $news->image_main) }}"
                                           @endif>
                                    <label class="input-group-text" for="inputGroupFile02">Изображение</label>
                                </div>
                                @error('image')
                                    <div class="mb-2 text-danger">{{$message}}</div>
                                @enderror

                                <!-- Блок для старого изображения -->
                                @if (isset($news->image))
                                <div class="old-image-wrapper mt-3 position-relative">
                                    <h4 class="text-secondary">Текущее изображение</h4>
                                    <img src="{{asset('storage/public/' . $news->image)}}" class="img-thumbnail old-image-preview" style="max-height: 200px">
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

                            <div class="mb-2">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            </div>

                            <div class="form-group w-50 mb-4">
                                <div class="form-group w-50">
                                    <input type="datetime-local" class="datetime_input" name="published_at"
                                           style="color: #495057; width: 250px; border: 1px solid #ced4da;
                                   padding: 5px !important; "
                                           value="{{ $news->published_at ? date('Y-m-d\TH:i', strtotime($news->published_at)) : '' }}"                            >
                                </div>
                            </div>

                            @error('published_at')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="form-check form-switch mb-2 mt-2">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="main_material" @if($news->main_material == 1)
                                    checked
                                    @endif>
                                <label class="form-check-label" for="flexSwitchCheckChecked">Главная новость</label>
                            </div>

                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="status" @if($news->status == 1)
                                    checked
                                    @endif>
                                <label class="form-check-label" for="flexSwitchCheckChecked">Опубликовано</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ml-2 mb-2">
                    <a href="{{route('news.index')}}" class="btn btn-secondary">Отмена</a>
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
