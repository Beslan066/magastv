@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="card-header">Радио-передачи</h5>

            <div class="d-flex align-items-center">
                <form class="d-flex">
                    <div class="input-group">
                        <span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Поиск..." value="{{ request('search') }}">
                    </div>
                </form>
                <a href="{{ route('radio-transfers.create') }}" type="button" class="btn btn-primary waves-effect waves-light ms-2">Добавить</a>
            </div>
        </div>

        <!-- Фильтры и сортировка -->
        <div class="card-body border-bottom">
            <form method="GET" action="{{ route('radio-transfers') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Автор</label>
                    <input type="text" name="author" class="form-control" placeholder="Имя автора" value="{{ request('author') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Тип передачи</label>
                    <select name="radio_show_type" class="form-select">
                        <option value="">Все типы</option>
                        @foreach($radioShowTypes as $type)
                            <option value="{{ $type->id }}" {{ request('radio_show_type') == $type->id ? 'selected' : '' }}>
                                {{ $type->title ?? $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Возрастное ограничение</label>
                    <select name="age_restriction" class="form-select">
                        <option value="">Все ограничения</option>
                        @foreach($ageRestrictions as $restriction)
                            <option value="{{ $restriction->id }}" {{ request('age_restriction') == $restriction->id ? 'selected' : '' }}>
                                {{ $restriction->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Сортировка</label>
                    <select name="sort" class="form-select">
                        <option value="">По умолчанию (новые)</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Сначала старые</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>По названию (А-Я)</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>По названию (Я-А)</option>
                        <option value="programs_count_desc" {{ request('sort') == 'programs_count_desc' ? 'selected' : '' }}>По кол-ву программ (убыв.)</option>
                        <option value="programs_count_asc" {{ request('sort') == 'programs_count_asc' ? 'selected' : '' }}>По кол-ву программ (возр.)</option>
                    </select>
                </div>

                <div class="col-12 d-flex justify-content-end">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Применить</button>
                        <a href="{{ route('radio-transfers') }}" class="btn btn-outline-secondary">Сбросить</a>
                    </div>
                </div>

                <!-- Скрытые поля для сохранения поиска при фильтрации -->
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
            </form>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th class="fw-bold">id</th>
                    <th class="fw-bold">Заголовок</th>
                    <th class="fw-bold">Автор</th>
                    <th class="fw-bold">Тип</th>
                    <th class="fw-bold">Программы</th>
                    <th class="fw-bold">Ограничение</th>
                    <th class="fw-bold">Создан</th>
                    <th class="fw-bold">Действие</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @if(isset($transfers) && $transfers->count() > 0)
                    @foreach($transfers as $item)
                        <tr>
                            <td><span>{{ $item->id }}</span></td>
                            <td>
                                {{ Str::limit($item->title, 50) }}
                            </td>
                            @if(isset($item->user->name))
                                <td>{{ $item->user->name }}</td>
                            @else
                                <td><span class="text-muted">Нет автора</span></td>
                            @endif
                            <td>
                                @if($item->radioShowType)
                                    <span class="badge bg-label-info">{{ $item->radioShowType->title ?? $item->radioShowType->name }}</span>
                                @else
                                    <span class="text-muted">Без типа</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-label-secondary">{{ $item->programs_count ?? $item->programs->count() }}</span>
                            </td>
                            <td>
                                @if($item->age_restriction)
                                    <span class="badge bg-label-warning">{{ $item->age_restriction->title }}</span>
                                @else
                                    <span class="text-muted">Нет</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('radio-transfers.edit', $item->id) }}">
                                            <i class="icon-base bx bx-edit-alt me-1"></i>Изменить
                                        </a>
                                        <form action="{{ route('radio-transfers.destroy', $item->id) }}" method="post" class="d-inline">
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
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">Радио-передачи не найдены</div>
                            @if(request()->anyFilled(['search', 'author', 'radio_show_type', 'age_restriction']))
                                <a href="{{ route('radio-transfers') }}" class="btn btn-sm btn-outline-primary mt-2">
                                    Сбросить фильтры
                                </a>
                            @endif
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>

            <div class="mt-2">
                {{ $transfers->links() }}
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
