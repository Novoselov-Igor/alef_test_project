<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Constants\ValidationConstants;
use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:' . ValidationConstants::MAX_CLASS_NAME_LENGTH,
                'unique:school_classes,name'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название класса обязательно для заполнения.',
            'name.max' => 'Название класса не может превышать ' . ValidationConstants::MAX_CLASS_NAME_LENGTH . ' символов.',
            'name.unique' => 'Класс с таким названием уже существует.',
        ];
    }
}
