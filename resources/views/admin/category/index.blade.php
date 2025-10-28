@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="card-header">Категории</h5>

            <div class="d-flex align-items-center">
                <form class="d-flex" method="GET" action="{{ route('categories.index') }}">
                    <div class="input-group">
                        <span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Поиск категорий..."
                               value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary" type="button">
                                <i class="tf-icons bx bx-x"></i>
                            </a>
                        @endif
                    </div>
                </form>
                <a href="{{ route('categories.create') }}" type="button"
                   class="btn btn-primary waves-effect waves-light ms-2">Добавить</a>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th class="fw-bold">id</th>
                    <th class="fw-bold">Название</th>
                    <th class="fw-bold">Автор</th>
                    <th class="fw-bold">Создан</th>
                    <th class="fw-bold">Статус</th>
                    <th class="fw-bold">Действие</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $category)
                        <tr>
                            <td><span>{{ $category->id }}</span></td>
                            <td>
                                {{ $category->name }}
                                @if($category->slug)
                                    <br><small class="text-muted">{{ $category->slug }}</small>
                                @endif
                            </td>
                            @if(isset($category->user->name))
                                <td>{{ $category->user->name }}</td>
                            @else
                                <td><span class="text-muted">Нет автора</span></td>
                            @endif
                            <td>{{ $category->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-label-success me-1">Активна</span>
                                @else
                                    <span class="badge bg-label-secondary me-1">Неактивна</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('categories.edit', $category->id) }}">
                                            <i class="icon-base bx bx-edit-alt me-1"></i>Изменить
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="post"
                                              class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="dropdown-item"
                                                    onclick="return confirm('Вы уверены?')">
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
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">
                                @if(request('search'))
                                    Категории по запросу "{{ request('search') }}" не найдены
                                @else
                                    Категории не найдены
                                @endif
                            </div>
                            @if(request('search'))
                                <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                    Показать все категории
                                </a>
                            @endif
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>


        <!-- Пагинация -->
        <div class="mt-2">
            {{ $categories->links() }}
        </div>
    </div>
    <!-- end row -->
@endsection
