<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurriculumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lectures' => ['required', 'array', 'min:1'],
            'lectures.*.id' => ['required', 'exists:lectures,id'],
            'lectures.*.order' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'lectures.required' => 'Список лекций обязателен для заполнения.',
            'lectures.array' => 'Лекции должны быть представлены в виде массива.',
            'lectures.min' => 'Учебный план должен содержать хотя бы одну лекцию.',
            'lectures.*.id.required' => 'ID лекции обязателен.',
            'lectures.*.id.exists' => 'Указанная лекция не существует.',
            'lectures.*.order.required' => 'Порядковый номер лекции обязателен.',
            'lectures.*.order.integer' => 'Порядковый номер должен быть целым числом.',
            'lectures.*.order.min' => 'Порядковый номер должен быть не менее 1.',
        ];
    }

    // Опционально: кастомные имена атрибутов для сообщений об ошибках
    public function attributes(): array
    {
        return [
            'lectures.*.id' => 'лекция',
            'lectures.*.order' => 'порядковый номер',
        ];
    }
}
