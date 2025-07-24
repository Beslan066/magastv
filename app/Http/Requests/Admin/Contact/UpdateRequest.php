<?php

namespace App\Http\Requests\Admin\Contact;

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
            'content' => 'nullable|string',
            'address' => 'nullable|string|max:255',
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
            // User ID
            'user_id.exists' => __('Указанный пользователь не найден'),

            // Deleter ID
            'deleter_id.exists' => __('Указанный удалитель не найден'),

        ];
    }
}
