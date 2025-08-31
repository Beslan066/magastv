<?php

namespace App\Http\Requests\Admin\AudiobookFile;

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
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug',
            'audio' => 'nullable|file|mimes:mp3|max:102400', // 100MB в KB
            'user_id' => 'required|exists:users,id',
            'deleter_id' => 'nullable|exists:users,id',
            'audiobook_id' => 'required'
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
            'audiobook_id.required' => __('Обязательно указать книгу'),


            // User ID
            'user_id.exists' => __('Указанный пользователь не найден'),

            // Deleter ID
            'deleter_id.exists' => __('Указанный удалитель не найден'),

            'published_at.required' => 'Укажите дату публикации.',
            'published_at.date_format' => 'Некорректный формат даты, используйте формат ГГГГ-ММ-ДДTЧЧ:ММ.',

            'audio.file' => 'Файл должен быть корректным аудиофайлом.',
            'audio.mimes' => 'Поддерживается только формат MP3.',
            'audio.max' => __('Размер аудиофайла не должен превышать 100MB'),
        ];
    }
}
