<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitAnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->id === $this->route('attempt')?->user_id;
    }

    public function rules(): array
    {
        return [
            'question_id' => ['required', 'integer', 'exists:questions,id'],
            'question_option_id' => ['nullable', 'integer'],
        ];
    }
}
