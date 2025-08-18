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
            <h4 class="card-header">Изменение события</h4>
        </div>

        <form action="{{route('admin.radio.books.update', $audiobook->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row mb-6 gy-6">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="Заголовок" name="title" value="{{$audiobook->title}}">
                            </div>

                            @error('title')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="mb-4">
                                <input type="text" class="form-control"  placeholder="URL (оставьте пустым для автоматического сгенерирования)" name="slug" value="{{$audiobook->slug}}">
                            </div>

                            <div class="mb-4">
                                <div class="input-group">
                                    <textarea class="form-control" placeholder="Описание" name="lead">{{$audiobook->lead}}</textarea>
                                </div>
                            </div>

                            @error('lead')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="input-group mb-4">
                                <select class="form-select" id="inputGroupSelect02" name="author_id">
                                    @if(isset($audiobook->author))
                                        <option value="{{$audiobook->author->id}}">{{$audiobook->author->name}}</option>
                                    @else
                                        <option value="">Выберите категорию...</option>
                                        @foreach($authors as $author)
                                            <option value="{{ $author->id }}">
                                                {{ $author->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <label class="input-group-text" for="inputGroupSelect02">Авторы</label>
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
                                    <input type="file" class="form-control" id="inputGroupFile02" name="image" accept="image/*" @if($audiobook->image)
                                        data-default-file="{{ asset('storage/public/' . $audiobook->image) }}"
                                           @endif>
                                    <label class="input-group-text" for="inputGroupFile02">Изображение</label>
                                </div>
                                @error('image')
                                    <div class="mb-2 text-danger">{{$message}}</div>
                                @enderror

                                <!-- Блок для старого изображения -->
                                @if (isset($audiobook->image))
                                <div class="old-image-wrapper mt-3 position-relative">
                                    <h4 class="text-secondary">Текущее изображение</h4>
                                    <img src="{{asset('storage/public/' . $audiobook->image)}}" class="img-thumbnail old-image-preview" style="max-height: 200px">
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


                            @if (isset($audiobook->audio))
                                <div class="old-image-wrapper mt-3 position-relative">
                                    <h4 class="text-secondary">Текущее аудио</h4>
                                    <audio controls src="{{asset('storage/public/' . $audiobook->audio)}}"></audio>
                                    <a href="{{asset('storage/public/' . $audiobook->audio)}}" target="_blank">Скачать</a>
                                </div>
                            @endif

                            <!-- Блок для нового изображения -->
                            <div class="new-image-wrapper mt-3" style="display: none">
                                <div class="position-relative d-inline-block">
                                    <img id="audioreview" class="img-thumbnail" style="max-height: 200px">
                                    <button type="button" class="btn btn-light btn-sm position-absolute top-0 end-0 m-1 rounded-circle"
                                            id="clearPreview" title="Удалить аудио">
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
                        </div>
                    </div>
                </div>

                <div class="ml-2 mb-2">
                    <a href="{{route('admin.radio.books')}}" class="btn btn-secondary">Отмена</a>
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
