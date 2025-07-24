@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="card-header">Роли</h5>
            <a href="{{route('users.create')}}" type="button" class="btn btn-primary waves-effect waves-light">Добавить</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th class="fw-bold">id</th>
                    <th class="fw-bold">Имя</th>
                    <th class="fw-bold">Роль</th>
                    <th class="fw-bold">Создан</th>
                    <th class="fw-bold">Статус</th>
                    <th class="fw-bold">Действие</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @if(isset($users))
                    @foreach($users as $user)
                        <tr>
                            <td><span>{{$user->id}}</span></td>
                            <td>{{$user->name}}</td>
                            @if(isset($user->role))
                                <td>{{$user->role->name}}</td>
                            @else
                                <td>Нет роли</td>
                            @endif
                            <td>{{$user->created_at}}</td>
                            <td><span class="badge bg-label-success me-1">Active</span></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{route('users.edit', $user->id)}}"><i class="icon-base bx bx-edit-alt me-1"></i>Изменить</a>
                                        <form action="{{route('users.destroy', $user->id)}}">
                                            @csrf
                                            @method('patch')
                                            <button type="submit" class="dropdown-item"><i class="icon-base bx bx-trash me-1"></i>Удалить</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
        </div>
    </div>
    <!-- end row -->
@endsection
