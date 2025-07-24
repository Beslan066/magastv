<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => 'nullable|string|max:255',
            'email' => [
                'nullable',
                'email',
                Rule::unique('users')->ignore($this->user->id)
            ],
            'password' => 'nullable|min:8|confirmed',
            'role_id' => 'nullable|exists:roles,id'
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'Введите корректный email адрес',
            'email.unique' => 'Этот email уже занят другим пользователем',
            'password.min' => 'Пароль должен быть не менее 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
            'role_id.exists' => 'Выбрана несуществующая роль',
        ];
    }
}
