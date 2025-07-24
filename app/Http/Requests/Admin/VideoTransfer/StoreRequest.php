<?php

namespace App\Http\Requests\Admin\VideoTransfer;

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
                'video' => 'required|file|mimetypes:video/mp4,video/quicktime,video/ogg,video/x-qt|max:204800',
            ];
        }

        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug',
            'preview' => 'nullable|image|mimes:jpg,jpeg,webp,png',
            'video' => 'required_without:uploaded_video_path|file|mimetypes:video/mp4,video/quicktime,video/ogg,video/x-qt|max:2048',
            'user_id' => 'required|exists:users,id',
            'transfer_id' => 'required|exists:categories,id',
            'deleter_id' => 'nullable|exists:users,id',
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


            // Image
            'preview.string' => __('Изображение должно быть строкой'),


            // User ID
            'user_id.exists' => __('Указанный пользователь не найден'),

            // Category ID
            'transfer_id.exists' => __('Указанная передача не найдена'),

            // Deleter ID
            'deleter_id.exists' => __('Указанный удалитель не найден'),

            'video.required' => 'Пожалуйста, загрузите видеофайл',
            'video.max' => 'Размер видео не должен превышать 2GB',
            'video.mimetypes' => 'Поддерживаются только файлы MP4, MOV или OGG',
        ];
    }
}
