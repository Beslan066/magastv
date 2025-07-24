@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="card-header">Телепрограмма</h5>
            <div class="d-flex">
                <form action="{{ route('tv-programs.index') }}" method="GET" class="d-flex">
                    <input
                        type="date"
                        name="date"
                        class="form-control me-2"
                        value="{{ $date }}"
                        onchange="this.form.submit()"
                    >
                    <a href="{{ route('tv-programs.create') }}" class="btn btn-primary">
                        Добавить
                    </a>
                </form>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th class="fw-bold">Время</th>
                    <th class="fw-bold">Название</th>
                    <th class="fw-bold">Тип</th>
                    <th class="fw-bold">Дата</th>
                    <th class="fw-bold">Действие</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @forelse($programs as $program)
                    <tr>
                        <td>{{ $program->time_range }}</td>
                        <td>{{ $program->title }}</td>
                        @if(isset($program->tvShowType->title))
                            <td>{{ $program->tvShowType->title }}</td>
                        @endif
                        <td>
                            @if($program->image)
                                <img src="{{asset('storage/public/' . $program->image)}}" class="img-thumbnail old-image-preview" style="max-width: 120px">

                            @endif
                        </td>
                        <td>{{ $program->program_date->format('d.m.Y') }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('tv-programs.edit', $program->id) }}">
                                        <i class="icon-base bx bx-edit-alt me-1"></i>Изменить
                                    </a>
                                    <form action="{{ route('tv-programs.destroy', $program->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">
                                            <i class="icon-base bx bx-trash me-1"></i>Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Нет программ на выбранную дату</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script>
    document.getElementById('date-filter').addEventListener('change', function() {
        const date = this.value;
        window.location.href = "{{ route('tv-programs.index') }}?date=" + date;
    });
</script>
