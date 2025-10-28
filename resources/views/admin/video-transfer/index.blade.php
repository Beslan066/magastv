@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="card-header">Видеопередачи</h5>

            <div class="d-flex align-items-center">
                <form class="d-flex">
                    <div class="input-group">
                        <span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Поиск..." value="{{ request('search') }}">
                    </div>
                </form>
                <a href="{{ route('video-transfers.create') }}" type="button" class="btn btn-primary waves-effect waves-light ms-2">Добавить</a>
            </div>
        </div>

        <!-- Фильтры и сортировка -->
        <div class="card-body border-bottom">
            <form method="GET" action="{{ route('video-transfers.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Автор</label>
                    <input type="text" name="author" class="form-control" placeholder="Имя автора" value="{{ request('author') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Передача</label>
                    <select name="transfer" class="form-select">
                        <option value="">Все передачи</option>
                        @foreach($transfers as $transfer)
                            <option value="{{ $transfer->id }}" {{ request('transfer') == $transfer->id ? 'selected' : '' }}>
                                {{ Str::limit($transfer->title, 40) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Просмотры от</label>
                    <input type="number" name="views_min" class="form-control" placeholder="0" value="{{ request('views_min') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Просмотры до</label>
                    <input type="number" name="views_max" class="form-control" placeholder="100000" value="{{ request('views_max') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Сортировка</label>
                    <select name="sort" class="form-select">
                        <option value="">По умолчанию</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Сначала старые</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>По названию (А-Я)</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>По названию (Я-А)</option>
                        <option value="views_desc" {{ request('sort') == 'views_desc' ? 'selected' : '' }}>По просмотрам (убыв.)</option>
                        <option value="views_asc" {{ request('sort') == 'views_asc' ? 'selected' : '' }}>По просмотрам (возр.)</option>
                    </select>
                </div>

                <!-- Дополнительные фильтры по дате -->
                <div class="col-md-3">
                    <label class="form-label">Дата с</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Дата по</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>

                <div class="col-12 d-flex justify-content-end">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Применить</button>
                        <a href="{{ route('transfers.index') }}" class="btn btn-outline-secondary">Сбросить</a>
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
                    <th class="fw-bold">Передача</th>
                    <th class="fw-bold">Просмотры</th>
                    <th class="fw-bold">Создан</th>
                    <th class="fw-bold">Действие</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @if(isset($videos) && $videos->count() > 0)
                    @foreach($videos as $item)
                        <tr>
                            <td><span>{{ $item->id }}</span></td>
                            <td>
                                {{ Str::limit($item->title, 60) }}
                            </td>
                            @if(isset($item->user->name))
                                <td>{{ $item->user->name }}</td>
                            @else
                                <td><span class="text-muted">Нет автора</span></td>
                            @endif
                            <td>
                                @if($item->transfer)
                                    <span class="badge bg-label-info">{{ Str::limit($item->transfer->title, 30) }}</span>
                                @else
                                    <span class="text-muted">Без передачи</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-label-secondary">{{ $item->views ?? 0 }}</span>
                            </td>
                            <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('video-transfers.edit', $item->id) }}">
                                            <i class="icon-base bx bx-edit-alt me-1"></i>Изменить
                                        </a>
                                        <form action="{{ route('video-transfers.destroy', $item->id) }}" method="post" class="d-inline">
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
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">Видеопередачи не найдены</div>
                            @if(request()->anyFilled(['search', 'author', 'transfer', 'views_min', 'views_max', 'date_from', 'date_to']))
                                <a href="{{ route('video-transfers.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                    Сбросить фильтры
                                </a>
                            @endif
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>

            <!-- Пагинация -->
            <div class="mt-2">
                {{ $videos->links() }}
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
