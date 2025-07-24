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
            <h4 class="card-header">Контакты - изменение</h4>
        </div>

        <form action="{{route('contacts.update', $contact->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row mb-6 gy-6">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="Ссылка на карту или другой фрейм" name="content" value="{{$contact->content}}">
                            </div>
                            @error('content')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Адрес" name="address" value="{{$contact->phone}}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Телефон" name="phone" value="{{$contact->phone}}">
                                    <input type="text" class="form-control" placeholder="Факс" name="fax" value="{{$contact->fax}}">
                                    <input type="text" class="form-control" placeholder="Email" name="email" value="{{$contact->email}}">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-2">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ml-2 mb-2">
                    <a href="{{route('contacts.index')}}" class="btn btn-secondary">Отмена</a>
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
