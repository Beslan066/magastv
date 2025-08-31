<?php

namespace App\Http\Requests\Admin\AudiobookFile;

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
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'audio' => 'nullable|file|mimes:mp3',
            'user_id' => 'required|exists:users,id',
            'deleter_id' => 'nullable|exists:users,id',
            'audiobook_id' => 'required',
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

            'audiobook_id.required' => __('Обязательно указать книгу'),



            // User ID
            'user_id.exists' => __('Указанный пользователь не найден'),

            // Deleter ID
            'deleter_id.exists' => __('Указанный удалитель не найден'),


            'audio.file' => 'Файл должен быть корректным аудиофайлом.',
            'audio.mimes' => 'Поддерживается только формат MP3.',
        ];
    }
}
