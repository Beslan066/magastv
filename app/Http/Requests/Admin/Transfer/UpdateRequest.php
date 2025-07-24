<?php

namespace App\Http\Requests\Admin\Transfer;

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
            'lead' => 'required|string|max:255',
            'published' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,webp,png',
            'slider_image' => 'nullable|image|mimes:jpg,jpeg,webp,png',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'deleter_id' => 'nullable|exists:users,id',
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
        ];
    }
}
