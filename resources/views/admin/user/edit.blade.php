@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-header">Изменение пользователя</h4>
        </div>

        <form action="{{route('users.update', $user->id)}}" method="post">
            @csrf
            @method('patch')
            <div class="card-body">
                <div class="mb-4 w-50">
                    <input type="text" class="form-control" id="basic-default-fullname" placeholder="ФИО" name="name" value="{{$user->name}}">
                </div>

                <div class="mb-4 w-50">
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name="email" value="{{$user->email}}">
                </div>

                <div class="input-group mb-4 w-50">
                    <select class="form-select" id="inputGroupSelect02" name="role_id">
                        @if(isset($user->role))
                            <option value="{{$user->role->id}}">{{$user->role->name}}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        @else
                            <option value="">Выберите роль...</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <label class="input-group-text" for="inputGroupSelect02">Роли</label>
                </div>

                <div class="form-password-toggle w-50 mb-4">
                    <div class="input-group">
                        <input type="password" class="form-control" id="basic-default-password12" placeholder="Пароль" aria-describedby="basic-default-password2" name="password">
                        <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                    </div>
                </div>

                <div class="form-password-toggle w-50 mb-4">
                    <div class="input-group">
                        <input type="password" class="form-control" id="basic-default-password12" placeholder="Подтвердите пароль" aria-describedby="basic-default-password2" name="password_confirmation">
                        <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                    </div>
                </div>

                <div class="demo-inline-spacing mb-2">
                    <a href="{{route('users.index')}}" class="btn btn-secondary">Отмена</a>
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



