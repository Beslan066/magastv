@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="card-header">Руководители</h5>
            <a href="{{route('supervisors.create')}}" type="button" class="btn btn-primary waves-effect waves-light">Добавить</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th class="fw-bold">id</th>
                    <th class="fw-bold">Заголовок</th>
                    <th class="fw-bold">Автор</th>
                    <th class="fw-bold">Создан</th>
                    <th class="fw-bold">Статус</th>
                    <th class="fw-bold">Действие</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @if(isset($supervisors))
                    @foreach($supervisors as $item)
                        <tr>
                            <td><span>{{$item->id}}</span></td>
                            <td>{{$item->name}}</td>

                            @if(isset($item->user->name))
                                <td>{{$item->user->name}}</td>
                            @else
                                <td>Нет автора</td>
                            @endif
                            <td>{{$item->created_at}}</td>
                            @if($item->status == 1)
                                <td><span class="badge bg-label-success me-1">Текущий руководитель</span></td>
                            @else
                            @endif
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{route('supervisors.edit', $item->id)}}"><i class="icon-base bx bx-edit-alt me-1"></i>Изменить</a>
                                        <form action="{{route('supervisors.destroy', $item->id)}}" method="post">
                                            @csrf
                                            @method('delete')
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
