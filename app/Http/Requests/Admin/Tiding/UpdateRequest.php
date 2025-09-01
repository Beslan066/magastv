<?php

namespace App\Http\Requests\Admin\Tiding;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $videoReportageId = $this->route('video_reportage');


        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'lead' => 'nullable|string',
            'preview' => 'nullable|image|mimes:jpg,jpeg,webp,png',
            'video' => 'nullable',
            'status' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'deleter_id' => 'nullable|exists:users,id',
            'published_at' => 'nullable|date_format:Y-m-d\TH:i',
        ];
    }

    public function messages()
    {
        return [
            // Title
            'title.required' => __('Заголовок обязателен для заполнения'),
            'title.string' => __('Заголовок должен быть строкой'),
            'title.max' => __('Заголовок не должен превышать 255 символов'),

            // Slug
            'slug.string' => __('URL-адрес должен быть строкой'),
            'slug.max' => __('URL-адрес не должен превышать 255 символов'),
            'slug.unique' => __('Такой URL-адрес уже используется'),

            // Lead
            'lead.required' => __('Лид обязателен для заполнения'),
            'lead.string' => __('Лид должен быть строкой'),
            'lead.max' => __('Лид не должен превышать 255 символов'),


            // User ID
            'user_id.exists' => __('Указанный пользователь не найден'),

            // Deleter ID
            'deleter_id.exists' => __('Указанный удалитель не найден'),

            'published_at.required' => 'Укажите дату публикации.',
            'published_at.date_format' => 'Некорректный формат даты, используйте формат ГГГГ-ММ-ДДTЧЧ:ММ.',

            'video.required' => 'Пожалуйста, загрузите видеофайл',
//            'video.max' => 'Размер видео не должен превышать 200MB',
//            'video.mimetypes' => 'Поддерживаются только файлы MP4, MOV или OGG',
        ];
    }
}
