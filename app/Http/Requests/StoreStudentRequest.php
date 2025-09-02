<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Constants\ValidationConstants;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:' . ValidationConstants::MAX_NAME_LENGTH],
            'email' => [
                'required',
                'email',
                'max:' . ValidationConstants::MAX_EMAIL_LENGTH,
                'unique:students,email'
            ],
            'school_class_id' => ['nullable', 'exists:school_classes,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя студента обязательно для заполнения.',
            'name.max' => 'Имя не может превышать ' . ValidationConstants::MAX_NAME_LENGTH . ' символов.',
            'email.required' => 'Email обязателен для заполнения.',
            'email.email' => 'Введите корректный email адрес.',
            'email.max' => 'Email не может превышать ' . ValidationConstants::MAX_EMAIL_LENGTH . ' символов.',
            'email.unique' => 'Студент с таким email уже существует.',
            'school_class_id.exists' => 'Выбранный класс не существует.',
        ];
    }
}
