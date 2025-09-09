<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Constants\ValidationConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:' . ValidationConstants::MAX_NAME_LENGTH],
            'email' => [
                'sometimes',
                'email',
                'max:' . ValidationConstants::MAX_EMAIL_LENGTH,
                Rule::unique('students', 'email')->ignore($this->student->id)
            ],
            'school_class_id' => ['nullable', 'exists:school_classes,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не может превышать ' . ValidationConstants::MAX_NAME_LENGTH . ' символов.',
            'email.email' => 'Введите корректный email адрес.',
            'email.max' => 'Email не может превышать ' . ValidationConstants::MAX_EMAIL_LENGTH . ' символов.',
            'email.unique' => 'Студент с таким email уже существует.',
            'school_class_id.exists' => 'Выбранный класс не существует.',
        ];
    }
}
