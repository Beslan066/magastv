@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="card-header">Аудиокниги</h5>

            <div class="d-flex align-items-center">
                <form class="d-flex">
                    <div class="input-group">
                        <span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Поиск..." value="{{ request('search') }}">
                    </div>
                </form>
                <a href="{{ route('admin.radio.books.create') }}" type="button" class="btn btn-primary waves-effect waves-light ms-2">Добавить</a>
            </div>
        </div>

        <!-- Фильтры и сортировка -->
        <div class="card-body border-bottom">
            <form method="GET" action="{{ route('admin.radio.books') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Автор книги</label>
                    <select name="author" class="form-select">
                        <option value="">Все авторы</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Файлы</label>
                    <select name="has_files" class="form-select">
                        <option value="">Все книги</option>
                        <option value="yes" {{ request('has_files') == 'yes' ? 'selected' : '' }}>С файлами</option>
                        <option value="no" {{ request('has_files') == 'no' ? 'selected' : '' }}>Без файлов</option>
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
                        <option value="author_asc" {{ request('sort') == 'author_asc' ? 'selected' : '' }}>По автору (А-Я)</option>
                        <option value="files_count_desc" {{ request('sort') == 'files_count_desc' ? 'selected' : '' }}>По кол-ву файлов</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <div class="btn-group w-100">
                        <button type="submit" class="btn btn-primary">Применить</button>
                        <a href="{{ route('admin.radio.books') }}" class="btn btn-outline-secondary">Сбросить</a>
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
                    <th class="fw-bold">Автор книги</th>
                    <th class="fw-bold">Создатель</th>
                    <th class="fw-bold">Файлы</th>
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
                                <strong>{{ Str::limit($item->title, 50) }}</strong>
                                @if($item->lead)
                                    <br><small class="text-muted">{{ Str::limit($item->lead, 30) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($item->author)
                                    <span class="badge bg-label-info">{{ $item->author->name }}</span>
                                @else
                                    <span class="text-muted">Нет автора</span>
                                @endif
                            </td>
                            @if(isset($item->user->name))
                                <td>{{ $item->user->name }}</td>
                            @else
                                <td><span class="text-muted">Нет создателя</span></td>
                            @endif
                            <td>
                                <span class="badge bg-label-{{ $item->files->count() > 0 ? 'success' : 'secondary' }}">
                                    {{ $item->files->count() }} файл(ов)
                                </span>
                            </td>
                            <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin.radio.books.edit', $item->id) }}">
                                            <i class="icon-base bx bx-edit-alt me-1"></i>Изменить
                                        </a>
                                        @if($item->files->count() > 0)
                                            <a class="dropdown-item" href="#">
                                                <i class="icon-base bx bx-file me-1"></i>Файлы ({{ $item->files->count() }})
                                            </a>
                                        @endif
                                        <form action="{{ route('admin.radio.books.destroy', $item->id) }}" method="post" class="d-inline">
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
                            <div class="text-muted">Аудиокниги не найдены</div>
                            @if(request()->anyFilled(['search', 'author', 'has_files']))
                                <a href="{{ route('admin.radio.books') }}" class="btn btn-sm btn-outline-primary mt-2">
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
