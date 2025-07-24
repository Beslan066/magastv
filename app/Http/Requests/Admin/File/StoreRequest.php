<?php

namespace App\Http\Requests\Admin\File;

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
        $maxVideoSize = 1024 * 1024 * 250; // 250MB
        $maxImageSize = 1024 * 1024 * 10; // 10MB

        return [
            'title' => 'required|string|max:255',
            'file' => [
                'required',
                'file',
                function ($attribute, $value, $fail) use ($maxVideoSize, $maxImageSize) {
                    $mime = $value->getMimeType();
                    $size = $value->getSize();

                    if (str_starts_with($mime, 'video/') && $size > $maxVideoSize) {
                        $fail('Видео файл не должен превышать 250MB');
                    }

                    if (str_starts_with($mime, 'image/') && $size > $maxImageSize) {
                        $fail('Изображение не должно превышать 10MB');
                    }
                }
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => __('Заголовок обязателен для заполнения'),
            'title.string' => __('Заголовок должен быть строкой'),
            'title.max' => __('Заголовок не должен превышать 255 символов'),

            'file.required' => __('Файл обязателен для заполнения'),

        ];
    }
}
