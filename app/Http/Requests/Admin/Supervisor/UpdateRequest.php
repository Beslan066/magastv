<?php

namespace App\Http\Requests\Admin\Supervisor;

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
            'lead' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,webp,png',
            'status' => 'nullable',
            'phone' => 'nullable|string|max:255',
            'fax' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
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

            // Image
            'image.string' => __('Изображение должно быть строкой'),
            'image.max' => __('Ссылка на изображение не должна превышать 255 символов'),


            // User ID
            'user_id.exists' => __('Указанный пользователь не найден'),

            // Deleter ID
            'deleter_id.exists' => __('Указанный удалитель не найден'),

        ];
    }
}
