@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-header">Создание роли</h4>
        </div>

        <form action="{{route('roles.store')}}" method="post">
            @csrf

            <div class="card-body">
                <div class="mb-4 w-50">
                    <input type="text" class="form-control" id="basic-default-fullname" placeholder="Название роли" name="name">
                </div>

                <div class="demo-inline-spacing ml-2 mb-2">
                    <a href="{{route('roles.index')}}" class="btn btn-secondary">Отмена</a>
                    <button type="submit" class="btn btn-primary">Создать</button>
                </div>
            </div>

        </form>

    </div>

@endsection
