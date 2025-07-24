<?php

namespace App\Http\Requests\Admin\About;

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
            'lead' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,webp,png',
            'user_id' => 'required|exists:users,id',
            'deleter_id' => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
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
