<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Constants\ValidationConstants;
use Illuminate\Foundation\Http\FormRequest;

class StoreLectureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'topic' => [
                'required',
                'string',
                'max:' . ValidationConstants::MAX_TOPIC_LENGTH,
                'unique:lectures,topic'
            ],
            'description' => ['nullable', 'string', 'max:' . ValidationConstants::MAX_DESCRIPTION_LENGTH],
        ];
    }

    public function messages(): array
    {
        return [
            'topic.required' => 'Тема лекции обязательна для заполнения.',
            'topic.max' => 'Тема лекции не может превышать ' . ValidationConstants::MAX_TOPIC_LENGTH . ' символов.',
            'topic.unique' => 'Лекция с такой темой уже существует.',
            'description.max' => 'Описание не может превышать ' . ValidationConstants::MAX_DESCRIPTION_LENGTH . ' символов.',
        ];
    }
}
