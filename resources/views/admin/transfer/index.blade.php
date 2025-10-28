@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="card-header">Передачи</h5>

            <div class="d-flex align-items-center">
                <form class="d-flex">
                    <div class="input-group">
                        <span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Поиск..." value="{{ request('search') }}">
                    </div>
                </form>
                <a href="{{ route('transfers.create') }}" type="button" class="btn btn-primary waves-effect waves-light ms-2">Добавить</a>
            </div>
        </div>

        <!-- Фильтры и сортировка -->
        <div class="card-body border-bottom">
            <form method="GET" action="{{ route('transfers.index') }}" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Автор</label>
                    <input type="text" name="author" class="form-control" placeholder="Имя автора" value="{{ request('author') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Тип передачи</label>
                    <select name="category" class="form-select">
                        <option value="">Все типы</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->title ?? $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
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

                <div class="col-md-2">
                    <label class="form-label">В слайдере</label>
                    <select name="main_material" class="form-select">
                        <option value="">Все</option>
                        <option value="1" {{ request('main_material') == '1' ? 'selected' : '' }}>Да</option>
                        <option value="0" {{ request('main_material') == '0' ? 'selected' : '' }}>Нет</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Статус публикации</label>
                    <select name="published" class="form-select">
                        <option value="">Все</option>
                        <option value="1" {{ request('published') == '1' ? 'selected' : '' }}>Опубликовано</option>
                        <option value="0" {{ request('published') == '0' ? 'selected' : '' }}>Не опубликовано</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Сортировка</label>
                    <select name="sort" class="form-select">
                        <option value="">По умолчанию</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Сначала старые</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>По названию (А-Я)</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>По названию (Я-А)</option>
                        <option value="videos_count_desc" {{ request('sort') == 'videos_count_desc' ? 'selected' : '' }}>По кол-ву видео (убыв.)</option>
                        <option value="videos_count_asc" {{ request('sort') == 'videos_count_asc' ? 'selected' : '' }}>По кол-ву видео (возр.)</option>
                    </select>
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
                    <th class="fw-bold">Тип</th>
                    <th class="fw-bold">Видео</th>
                    <th class="fw-bold">Создан</th>
                    <th class="fw-bold">Ограничение</th>
                    <th class="fw-bold">В слайдере</th>
                    <th class="fw-bold">Статус</th>
                    <th class="fw-bold">Действие</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @if(isset($transfers) && $transfers->count() > 0)
                    @foreach($transfers as $item)
                        <tr>
                            <td><span>{{ $item->id }}</span></td>
                            <td>
                                <a href="{{ route('transfer', $item->id) }}" target="_blank">
                                    {{ Str::limit($item->title, 50) }}
                                </a>
                            </td>
                            @if(isset($item->user->name))
                                <td>{{ $item->user->name }}</td>
                            @else
                                <td><span class="text-muted">Нет автора</span></td>
                            @endif
                            <td>
                                @if($item->category)
                                    <span class="badge bg-label-info">{{ $item->category->title ?? $item->category->name }}</span>
                                @else
                                    <span class="text-muted">Без типа</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-label-secondary">{{ $item->videos_count ?? $item->videos->count() }}</span>
                            </td>
                            <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                @if($item->age_restriction)
                                    <span class="badge bg-label-warning">{{ $item->age_restriction->title }}</span>
                                @else
                                    <span class="text-muted">Нет</span>
                                @endif
                            </td>
                            <td>
                                @if($item->main_material == 1)
                                    <span class="badge bg-label-success">Да</span>
                                @else
                                    <span class="text-muted">Нет</span>
                                @endif
                            </td>
                            <td>
                                @if($item->published == 1)
                                    <span class="badge bg-label-success">Опубликовано</span>
                                @else
                                    <span class="badge bg-label-secondary">Не опубликовано</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('transfers.edit', $item->id) }}">
                                            <i class="icon-base bx bx-edit-alt me-1"></i>Изменить
                                        </a>
                                        <form action="{{ route('transfers.destroy', $item->id) }}" method="post" class="d-inline">
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
                        <td colspan="10" class="text-center py-4">
                            <div class="text-muted">Передачи не найдены</div>
                            @if(request()->anyFilled(['search', 'author', 'category', 'age_restriction', 'main_material', 'published']))
                                <a href="{{ route('transfers.index') }}" class="btn btn-sm btn-outline-primary mt-2">
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
