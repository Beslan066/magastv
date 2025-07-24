@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-header">Создание категории передач радио</h4>
        </div>

        <form action="{{route('radio-show-type.store')}}" method="post">
            @csrf
            <div class="card-body">
                <div class="mb-4 w-50">
                    <input type="text" class="form-control" id="basic-default-fullname" placeholder="Заголовок" name="title">
                </div>

                <div class="input-group mb-4 w-50">
                    <select class="form-select" id="inputGroupSelect02" name="user_id">
                        <option value="{{auth()->user()->id}}">{{auth()->user()->name}}</option>
                    </select>
                    <label class="input-group-text" for="inputGroupSelect02">Автор</label>
                </div>

                <div class="mb-2">
                    <a href="{{route('radio-show-type.index')}}" class="btn btn-secondary">Отмена</a>
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

