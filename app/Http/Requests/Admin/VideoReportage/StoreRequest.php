<?php

namespace App\Http\Requests\Admin\VideoReportage;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
    public function rules()
    {

        // For AJAX video upload
        if ($this->ajax() && $this->hasFile('video')) {
            return [
                'video' => 'required|file|mimetypes:video/mp4,video/quicktime,video/ogg,video/x-qt|max:204800', // 200MB
            ];
        }

        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug',
            'lead' => 'required|string|max:255',
            'content' => 'nullable|string',
            'preview' => 'nullable|image|mimes:jpg,jpeg,webp,png',
            'video' => 'required_without:uploaded_video_path|file|mimetypes:video/mp4,video/quicktime,video/ogg,video/x-qt|max:204800', // 200MB
            'status' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'deleter_id' => 'nullable|exists:users,id',
            'published_at' => 'required|date_format:Y-m-d\TH:i',
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

            'image_author.nullable' => 'Заполните краткое image_author.',
            'image_author.string' => 'Краткое image_author должно быть строкой.',
            'image_author.max' => 'Длина краткого image_author не должна превышать 255 символов.',

            'image_description.nullable' => 'Заполните краткое image_description.',
            'image_description.string' => 'Краткое image_description должно быть строкой.',
            'image_description.max' => 'Длина краткого image_description не должна превышать 255 символов.',

            'published_at.required' => 'Укажите дату публикации.',
            'published_at.date_format' => 'Некорректный формат даты, используйте формат ГГГГ-ММ-ДДTЧЧ:ММ.',
        ];
    }
}
