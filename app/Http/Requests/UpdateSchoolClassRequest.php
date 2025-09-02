<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Constants\ValidationConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSchoolClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'string',
                'max:' . ValidationConstants::MAX_CLASS_NAME_LENGTH,
                Rule::unique('school_classes', 'name')->ignore($this->school_class->id)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Название класса должно быть строкой.',
            'name.max' => 'Название класса не может превышать ' . ValidationConstants::MAX_CLASS_NAME_LENGTH . ' символов.',
            'name.unique' => 'Класс с таким названием уже существует.',
        ];
    }
}
