@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-header">Создание автора</h4>
        </div>

        <form action="{{route('authors.store')}}" method="post">
            @csrf

            <div class="card-body">
                <div class="mb-4 w-50">
                    <input type="text" class="form-control" id="basic-default-fullname" placeholder="Заголовок" name="name">
                </div>

                <div class="mb-2">
                    <a href="{{route('authors.index')}}" class="btn btn-secondary">Отмена</a>
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
@endsection

@section('scripts')
    <!-- jQuery (необходим для Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Summernote JS -->

@endsection
