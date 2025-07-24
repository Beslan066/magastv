@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="card-header">Категории</h5>
            <a href="{{route('tv-show-type.create')}}" type="button" class="btn btn-primary waves-effect waves-light">Добавить</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th class="fw-bold">id</th>
                    <th class="fw-bold">Название</th>
                    <th class="fw-bold">Автор</th>
                    <th class="fw-bold">Создан</th>
                    <th class="fw-bold">Действие</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @if(isset($categories))
                    @foreach($categories as $category)
                        <tr>
                            <td><span>{{$category->id}}</span></td>
                            <td>{{$category->title}}</td>
                            @if(isset($category->user->name))
                                <td>{{$category->user->name}}</td>
                            @else
                                <td>Нет автора</td>
                            @endif
                            <td>{{$category->created_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{route('tv-show-type.edit', $category->id)}}"><i class="icon-base bx bx-edit-alt me-1"></i>Изменить</a>
                                        <form action="{{route('tv-show-type.destroy', $category->id)}}">
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
