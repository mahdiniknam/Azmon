<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExamRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'title' => ['required', 'string', 'max:255'],

            'description' => ['nullable', 'string'],

            'type' => ['required', 'string', 'max:50'],

            'duration' => ['required', 'integer', 'min:1'],

            'start_time' => ['required', 'date'],

            'end_time' => ['required', 'date', 'after:start_time'],

            'negative_score' => ['nullable', 'numeric', 'min:0'],

            'shuffle_questions' => ['nullable', 'boolean'],

            'shuffle_options' => ['nullable', 'boolean'],

            'subjects' => ['nullable', 'array'],

            'subjects.*.id' => ['exists:subjects,id'],

            'subjects.*.question_count' => ['nullable', 'integer'],

            'subjects.*.negative_score' => ['nullable', 'numeric'],

            'subjects.*.order' => ['nullable', 'integer'],

            'questions' => ['nullable', 'array'],

            'questions.*' => ['exists:questions,id'],
        ];
    }
}
