<?php

namespace App\Http\Requests\Admin\RadioBroadcast;

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
            'lead' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,webp,png',
            'audio' => 'nullable|file|mimes:mp3',
            'status' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'radio_show_type_id' => 'required|exists:categories,id',
            'deleter_id' => 'nullable|exists:users,id',
            'image_author' => 'nullable|string|max:255',
            'image_description' => 'nullable|string|max:255',
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

            'image_author.required' => 'Заполните краткое image_author.',
            'image_author.string' => 'Краткое image_author должно быть строкой.',
            'image_author.max' => 'Длина краткого image_author не должна превышать 255 символов.',

            'image_description.required' => 'Заполните краткое image_description.',
            'image_description.string' => 'Краткое image_description должно быть строкой.',
            'image_description.max' => 'Длина краткого image_description не должна превышать 255 символов.',

            'published_at.required' => 'Укажите дату публикации.',
            'published_at.date_format' => 'Некорректный формат даты, используйте формат ГГГГ-ММ-ДДTЧЧ:ММ.',
        ];
    }
}
