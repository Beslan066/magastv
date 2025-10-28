@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="card-header">Анонсы радио</h5>

            <div class="d-flex align-items-center">
                <form class="d-flex">
                    <div class="input-group">
                        <span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Поиск..." value="{{ request('search') }}">
                    </div>
                </form>
                <a href="{{ route('radio-news.create') }}" type="button" class="btn btn-primary waves-effect waves-light ms-2">Добавить</a>
            </div>
        </div>

        <!-- Фильтры и сортировка -->
        <div class="card-body border-bottom">
            <form method="GET" action="{{ route('radio-news.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Автор</label>
                    <input type="text" name="author" class="form-control" placeholder="Имя автора" value="{{ request('author') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Статус</label>
                    <select name="status" class="form-select">
                        <option value="">Все статусы</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Опубликована</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Не опубликована</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">В эфире</label>
                    <select name="in_air" class="form-select">
                        <option value="">Все</option>
                        <option value="1" {{ request('in_air') == '1' ? 'selected' : '' }}>Да</option>
                        <option value="0" {{ request('in_air') == '0' ? 'selected' : '' }}>Нет</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Сортировка</label>
                    <select name="sort" class="form-select">
                        <option value="">По умолчанию (новые)</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Сначала старые</option>
                        <option value="published_desc" {{ request('sort') == 'published_desc' ? 'selected' : '' }}>По дате публикации</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>По названию (А-Я)</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>По названию (Я-А)</option>
                    </select>
                </div>

                <div class="col-12 d-flex justify-content-end">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Применить</button>
                        <a href="{{ route('radio-news.index') }}" class="btn btn-outline-secondary">Сбросить</a>
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
                    <th class="fw-bold">Создан</th>
                    <th class="fw-bold">Статус</th>
                    <th class="fw-bold">В эфире</th>
                    <th class="fw-bold">Действие</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @if(isset($news) && $news->count() > 0)
                    @foreach($news as $item)
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
                            <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                            @if($item->status == 1)
                                <td><span class="badge bg-label-success me-1">Опубликована</span></td>
                            @else
                                <td><span class="badge bg-label-primary me-1">Не опубликована</span></td>
                            @endif
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('radio-news.edit', $item->id) }}">
                                            <i class="icon-base bx bx-edit-alt me-1"></i>Изменить
                                        </a>
                                        <form action="{{ route('radio-news.destroy', $item->id) }}" method="post" class="d-inline">
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
                            <div class="text-muted">Анонсы радио не найдены</div>
                            @if(request()->anyFilled(['search', 'author', 'status', 'in_air']))
                                <a href="{{ route('radio-news.index') }}" class="btn btn-sm btn-outline-primary mt-2">
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
                {{ $news->links() }}
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
