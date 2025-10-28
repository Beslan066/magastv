@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="card-header">Файлы аудиокниг</h5>

            <div class="d-flex align-items-center">
                <form class="d-flex">
                    <div class="input-group">
                        <span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Поиск..." value="{{ request('search') }}">
                    </div>
                </form>
                <a href="{{ route('bookFiles.create') }}" type="button" class="btn btn-primary waves-effect waves-light ms-2">Добавить</a>
            </div>
        </div>

        <!-- Фильтры и сортировка -->
        <div class="card-body border-bottom">
            <form method="GET" action="{{ route('bookFiles') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Аудиокнига</label>
                    <select name="audiobook" class="form-select">
                        <option value="">Все аудиокниги</option>
                        @foreach($audiobooks as $audiobook)
                            <option value="{{ $audiobook->id }}" {{ request('audiobook') == $audiobook->id ? 'selected' : '' }}>
                                {{ $audiobook->title }}
                                @if($audiobook->author)
                                    ({{ $audiobook->author->name }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Аудиофайл</label>
                    <select name="has_audio" class="form-select">
                        <option value="">Все файлы</option>
                        <option value="yes" {{ request('has_audio') == 'yes' ? 'selected' : '' }}>С аудио</option>
                        <option value="no" {{ request('has_audio') == 'no' ? 'selected' : '' }}>Без аудио</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Сортировка</label>
                    <select name="sort" class="form-select">
                        <option value="">По умолчанию (новые)</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Сначала старые</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>По названию файла (А-Я)</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>По названию файла (Я-А)</option>
                        <option value="audiobook_asc" {{ request('sort') == 'audiobook_asc' ? 'selected' : '' }}>По книге (А-Я)</option>
                        <option value="audiobook_desc" {{ request('sort') == 'audiobook_desc' ? 'selected' : '' }}>По книге (Я-А)</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <div class="btn-group w-100">
                        <button type="submit" class="btn btn-primary">Применить</button>
                        <a href="{{ route('bookFiles') }}" class="btn btn-outline-secondary">Сбросить</a>
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
                    <th class="fw-bold">Название файла</th>
                    <th class="fw-bold">Аудиокнига</th>
                    <th class="fw-bold">Автор книги</th>
                    <th class="fw-bold">Создатель</th>
                    <th class="fw-bold">Аудио</th>
                    <th class="fw-bold">Создан</th>
                    <th class="fw-bold">Действие</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @if(isset($books) && $books->count() > 0)
                    @foreach($books as $item)
                        <tr>
                            <td><span>{{ $item->id }}</span></td>
                            <td>
                                <strong>{{ Str::limit($item->title, 40) }}</strong>
                                @if($item->slug)
                                    <br><small class="text-muted">{{ $item->slug }}</small>
                                @endif
                            </td>
                            <td>
                                @if($item->audiobook)
                                    <span class="badge bg-label-info">
                                        {{ Str::limit($item->audiobook->title, 30) }}
                                    </span>
                                @else
                                    <span class="text-muted">Нет книги</span>
                                @endif
                            </td>
                            <td>
                                @if($item->audiobook && $item->audiobook->author)
                                    <span class="badge bg-label-primary">
                                        {{ $item->audiobook->author->name }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            @if(isset($item->user->name))
                                <td>{{ $item->user->name }}</td>
                            @else
                                <td><span class="text-muted">Нет создателя</span></td>
                            @endif
                            <td>
                                @if($item->audio)
                                    <span class="badge bg-label-success">
                                        <i class="bx bx-volume-full me-1"></i>Есть
                                    </span>
                                @else
                                    <span class="badge bg-label-secondary">Нет</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('bookFiles.edit', $item->id) }}">
                                            <i class="icon-base bx bx-edit-alt me-1"></i>Изменить
                                        </a>
                                        @if($item->audio)
                                            <a class="dropdown-item" href="#">
                                                <i class="icon-base bx bx-play me-1"></i>Прослушать
                                            </a>
                                        @endif
                                        <form action="{{ route('bookFiles.destroy', $item->id) }}" method="post" class="d-inline">
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
                            <div class="text-muted">Файлы аудиокниг не найдены</div>
                            @if(request()->anyFilled(['search', 'audiobook', 'has_audio']))
                                <a href="{{ route('bookFiles') }}" class="btn btn-sm btn-outline-primary mt-2">
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
                {{ $books->links() }}
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
