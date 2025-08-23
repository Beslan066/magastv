<?php

namespace App\Http\Requests\Admin\AgeRestriction;

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
    public function rules(): array
    {
        return [
            'title' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            // Для поля name
            'name.required' => 'Название категории обязательно для заполнения.',

            // Для поля user_id
            'user_id.required' => 'Необходимо выбрать автора.',
            'user_id.in' => 'Выбранный автор не существует.',

            // Для поля deleter_id
            'deleter_id.in' => 'Недопустимый пользователь для удаления.',
        ];
    }
}
