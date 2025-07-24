@extends('layouts.admin')

@section('content')

    <!-- start page title -->
    <div class="card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="card-header">Категории</h5>
            <a href="{{route('files.create')}}" type="button" class="btn btn-primary waves-effect waves-light">Добавить</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th class="fw-bold">id</th>
                    <th class="fw-bold">Название</th>
                    <th class="fw-bold">Тип</th>
                    <th class="fw-bold">Превью</th>
                    <th class="fw-bold">Создан</th>
                    <th class="fw-bold">Действие</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @if(isset($files))
                    @foreach($files as $file)
                        <tr>
                            <td><span>{{$file->id}}</span></td>
                            <td>{{$file->title}}</td>
                            <td>{{$file->type}}</td>
                            @if($file->type === 'audio')
                                <td>
                                    <div class="preview-index">
                                        <audio src="{{asset('storage/' . $file->path)}}" id="audioPreview" class="" controls></audio>
                                    </div>
                                </td>
                            @elseif($file->type === 'video')
                                <td>
                                    <div class="preview-index" style="width: 240px; height: 135px; overflow: hidden; border-radius: 5px">
                                        <video
                                            id="fluid-player-{{ $file->id}}"
                                            style="object-fit: cover; width: 100%; height: 100%"
                                            controls
                                        >
                                            <source src="{{ asset('storage/' . $file->path) }}" type="video/mp4" />
                                        </video>
                                    </div>
                                </td>
                            @elseif($file->type === 'image')
                                <div class="preview-index">
                                    <audio src="{{asset('storage/' . $file->path)}}" id="audioPreview" class="" controls></audio>
                                </div>
                            @endif
                            <td>{{$file->created_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{route('files.edit', $file->id)}}"><i class="icon-base bx bx-edit-alt me-1"></i>Изменить</a>
                                        <form action="{{route('files.destroy', $file->id)}}">
                                            @csrf
                                            @method('patch')
                                            <button type="submit" class="dropdown-item"><i class="icon-base bx bx-trash me-1"></i>Удалить</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
        </div>
    </div>
    <!-- end row -->
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализируем для каждого видео
        @foreach($files as $file)
        @if($file->type === 'video')
        fluidPlayer(
            'fluid-player-{{ $file->id }}',
            {
                layoutControls: {
                    primaryColor: "#696cff",
                    fillToContainer: true, // Адаптивность
                    autoPlay: false,
                    controls: {
                        autoHide: true
                    }
                }
            }
        );
        @endif
        @endforeach
    });
</script>
