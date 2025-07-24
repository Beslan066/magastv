<?php

namespace App\Http\Requests\Admin\VideoReportage;

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

        // For AJAX video upload
        if ($this->ajax() && $this->hasFile('video')) {
            return [
                'video' => 'required|file|mimetypes:video/mp4,video/quicktime,video/ogg,video/x-qt|max:204800',
            ];
        }

        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'lead' => 'required|string|max:255',
            'content' => 'nullable|string',
            'preview' => 'nullable|image|mimes:jpg,jpeg,webp,png',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/ogg,video/x-qt|max:204800',
            'status' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'deleter_id' => 'nullable|exists:users,id',
            'published_at' => 'nullable|date_format:Y-m-d\TH:i',
            'main_material' => 'nullable',

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


            // Image
            'image.string' => __('Изображение должно быть строкой'),
            'image.max' => __('Ссылка на изображение не должна превышать 255 символов'),


            // User ID
            'user_id.exists' => __('Указанный пользователь не найден'),

            // Category ID
            'category_id.exists' => __('Указанная категория не найдена'),

            // Deleter ID
            'deleter_id.exists' => __('Указанный удалитель не найден'),

            'published_at.required' => 'Укажите дату публикации.',
            'published_at.date_format' => 'Некорректный формат даты, используйте формат ГГГГ-ММ-ДДTЧЧ:ММ.',

            'video.required' => 'Пожалуйста, загрузите видеофайл',
            'video.max' => 'Размер видео не должен превышать 200MB',
            'video.mimetypes' => 'Поддерживаются только файлы MP4, MOV или OGG',
        ];
    }
}
