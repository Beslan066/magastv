@extends('layouts.admin')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Упсс!</strong> Ошибки валидации:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-header">Изменение передачи</h4>
        </div>

        <form action="{{route('radio-transfers.update', $transfer->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row mb-6 gy-6">
                <div class="col-xl">
                    <div class="card w-50">
                        <div class="card-body">
                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="Заголовок" name="title"
                                       value="{{$transfer->title}}">
                            </div>

                            @error('title')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="mb-4">
                                <input type="text" class="form-control"
                                       placeholder="URL (оставьте пустым для автоматического сгенерирования)"
                                       name="slug" value="{{$transfer->slug}}">
                            </div>

                            <div class="mb-4">
                                <div class="input-group">
                                    <textarea class="form-control" placeholder="Лид новости"
                                              name="lead">{{$transfer->lead}}</textarea>
                                </div>
                            </div>

                            @error('lead')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="input-group mb-4">
                                <select class="form-select" id="inputGroupSelect02" name="radio_show_type_id">
                                    @if(isset($transfer->radio_show_type_id))
                                        <option
                                            value="{{$transfer->radio_show_type_id}}">{{$transfer->radioShowType->title}}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">Выберите категорию...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            @error('radio_show_type_id')
                            <div class="mb-2 text-danger">{{$message}}</div>
                            @enderror

                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="file" class="form-control" id="inputGroupFile02" name="image"
                                           accept="image/*" @if($transfer->image)
                                               data-default-file="{{ asset('storage/public/' . $transfer->image) }}"
                                        @endif>
                                    <label class="input-group-text" for="inputGroupFile02">Изображение</label>
                                </div>
                                @error('image')
                                <div class="mb-2 text-danger">{{$message}}</div>
                                @enderror

                                <!-- Блок для текущего изображения слайдера -->
                                @if($transfer->image)
                                    <div class="current-slider-image-wrapper mt-3 position-relative">
                                        <h4 class="text-secondary">Текущее изображение</h4>
                                        <img src="{{ asset('storage/public/' . $transfer->image) }}"
                                             class="img-thumbnail current-slider-image"
                                             style="max-height: 200px">
                                        <button type="button"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-current-slider-image"
                                                title="Удалить изображение">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" name="remove_slider_image" id="remove_slider_image" value="0">
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl">
                <div class="card w-50">
                    <div class="card-body">
                        <div class="mb-2">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="ml-2 mb-2">
                <a href="{{route('radio-transfers')}}" class="btn btn-secondary">Отмена</a>
                <button type="submit" class="btn btn-primary">Обновить</button>
            </div>


        </form>

    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Упсс!</strong> Возникла ошибка при заполнении полей.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Обработка загрузки нового изображения слайдера
            $('#inputGroupFile03').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#sliderImagePreview').attr('src', e.target.result);
                        $('.new-slider-image-wrapper').show();
                        $('.current-slider-image-wrapper').hide();
                        $('#remove_slider_image').val('0');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Удаление текущего изображения слайдера
            $('.remove-current-slider-image').click(function() {
                if (confirm('Вы уверены, что хотите удалить текущее изображение слайдера?')) {
                    $('.current-slider-image-wrapper').hide();
                    $('#remove_slider_image').val('1');
                }
            });

            // Очистка превью нового изображения слайдера
            $('.clear-slider-preview').click(function() {
                $('#inputGroupFile03').val('');
                $('#sliderImagePreview').attr('src', '');
                $('.new-slider-image-wrapper').hide();
                $('.current-slider-image-wrapper').show();
            });

        });
    </script>

@endpush
