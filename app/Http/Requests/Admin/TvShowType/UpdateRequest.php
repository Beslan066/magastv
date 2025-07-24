<?php

namespace App\Http\Requests\Admin\TvShowType;

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
            'title' => 'nullable|string|max:255',
            'user_id' => 'required|in:1,2,3',
            'deleter_id' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            // Для поля name
            'title.string' => 'Название категории должно быть строкой.',
            'title.max' => 'Название категории не должно превышать 255 символов.',

            // Для поля user_id
            'user_id.required' => 'Необходимо выбрать автора.',
            'user_id.in' => 'Выбранный автор не существует.',
        ];
    }
}
