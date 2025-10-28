@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="card-header">Авторы</h5>

            <div class="d-flex align-items-center">
                <form class="d-flex" method="GET" action="{{ route('authors.index') }}">
                    <div class="input-group">
                        <span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Поиск авторов..." value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ route('authors.index') }}" class="btn btn-outline-secondary" type="button">
                                <i class="tf-icons bx bx-x"></i>
                            </a>
                        @endif
                    </div>
                </form>
                <a href="{{ route('authors.create') }}" type="button" class="btn btn-primary waves-effect waves-light ms-2">Добавить</a>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th class="fw-bold">id</th>
                    <th class="fw-bold">Автор</th>
                    <th class="fw-bold">Создан</th>
                    <th class="fw-bold">Действие</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @if(isset($authors) && $authors->count() > 0)
                    @foreach($authors as $item)
                        <tr>
                            <td><span>{{ $item->id }}</span></td>
                            <td>
                                {{ $item->name }}
                            </td>
                            <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('authors.edit', $item->id) }}">
                                            <i class="icon-base bx bx-edit-alt me-1"></i>Изменить
                                        </a>
                                        <form action="{{ route('authors.destroy', $item->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('Вы уверены?')">
                                                <i class="icon-base bx bx-trash me-1"></i>Удалить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <div class="text-muted">
                                @if(request('search'))
                                    Авторы по запросу "{{ request('search') }}" не найдены
                                @else
                                    Авторы не найдены
                                @endif
                            </div>
                            @if(request('search'))
                                <a href="{{ route('authors.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                    Показать всех авторов
                                </a>
                            @endif
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>

            <!-- Пагинация -->
            <div class="mt-2">
                {{ $authors->links() }}
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
