<?php

namespace App\Http\Requests\Admin\VideoTransfer;

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
        $videoTransferId = $this->route('video_transfers');

        // For AJAX video upload
        if ($this->ajax() && $this->hasFile('video')) {
            return [
                'video' => 'required|file|mimes:mp4,mov,ogg,qt|max:204800'
            ];
        }

        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'preview' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'video' => 'nullable|file|mimes:mp4,mov,ogg,qt|max:204800',
            'user_id' => 'required|exists:users,id',
            'transfer_id' => 'required|exists:categories,id',
            'deleter_id' => 'nullable|exists:users,id',
            'delete_preview' => 'nullable|boolean',
            'delete_video' => 'nullable|boolean',
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
            'category_id.exists' => __('Указанная категория не найдена'),

            // Deleter ID
            'deleter_id.exists' => __('Указанный удалитель не найден'),

            'video.required' => 'Пожалуйста, загрузите видеофайл',
            'video.max' => 'Размер видео не должен превышать 2GB',
            'video.mimetypes' => 'Поддерживаются только файлы MP4, MOV или OGG',
        ];
    }
}
