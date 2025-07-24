@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Просмотр файла</h4>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Превью файла -->
                <div class="col-md-6">
                    <div class="file-preview mb-4">
                        @include('partials.file-preview', ['file' => $file])
                    </div>
                </div>

                <!-- Информация о файле -->
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-3">Название:</dt>
                        <dd class="col-sm-9">{{ $file->name }}</dd>

                        <dt class="col-sm-3">Тип:</dt>
                        <dd class="col-sm-9">{{ $file->type }}</dd>

                        <dt class="col-sm-3">Размер:</dt>
                        <dd class="col-sm-9">{{ number_format($file->size / 1048576, 2) }} MB</dd>

                        <dt class="col-sm-3">Описание:</dt>
                        <dd class="col-sm-9">{{ $file->description ?? '—' }}</dd>

                        <dt class="col-sm-3">Загружен:</dt>
                        <dd class="col-sm-9">{{ $file->created_at->format('d.m.Y H:i') }}</dd>
                    </dl>

                    <div class="mt-4">
                        <a href="{{ Storage::url($file->path) }}"
                           class="btn btn-success"
                           download="{{ $file->name }}"
                           target="_blank">
                            <i class="fas fa-download"></i> Скачать
                        </a>
                        <a href="{{ route('files.edit', $file) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Редактировать
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
