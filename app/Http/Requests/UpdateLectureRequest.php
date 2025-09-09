<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Constants\ValidationConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLectureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'topic' => [
                'sometimes',
                'string',
                'max:' . ValidationConstants::MAX_TOPIC_LENGTH,
                Rule::unique('lectures', 'topic')->ignore($this->lecture->id)
            ],
            'description' => ['sometimes', 'nullable', 'string', 'max:' . ValidationConstants::MAX_DESCRIPTION_LENGTH],
        ];
    }

    public function messages(): array
    {
        return [
            'topic.string' => 'Тема лекции должна быть строкой.',
            'topic.max' => 'Тема лекции не может превышать ' . ValidationConstants::MAX_TOPIC_LENGTH . ' символов.',
            'topic.unique' => 'Лекция с такой темой уже существует.',
            'description.max' => 'Описание не может превышать ' . ValidationConstants::MAX_DESCRIPTION_LENGTH . ' символов.',
        ];
    }
}
