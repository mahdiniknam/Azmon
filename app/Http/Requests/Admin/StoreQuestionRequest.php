<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'subject_id' => ['required', 'exists:subjects,id'],
            'question_text' => ['required', 'string'],
            'score' => ['required', 'numeric', 'min:0'],
            'difficulty' => ['required', 'in:easy,medium,hard'],

            'options' => ['required', 'array', 'min:2'],
            'options.*' => ['required', 'string'],
            'correct_option' => ['required', 'integer', 'min:0'],
        ];
    }
    public function messages(): array
    {
        return [
            'subject_id.required' => 'انتخاب درس الزامی است.',
            'subject_id.exists' => 'درس انتخاب‌شده معتبر نیست.',

            'question_text.required' => 'متن سوال الزامی است.',

            'score.required' => 'نمره سوال الزامی است.',
            'score.numeric' => 'نمره سوال باید عددی باشد.',
            'score.min' => 'نمره سوال نمی‌تواند منفی باشد.',

            'difficulty.required' => 'انتخاب سطح سختی الزامی است.',
            'difficulty.in' => 'سطح سختی انتخاب‌شده معتبر نیست.',

            'options.required' => 'گزینه‌ها الزامی هستند.',
            'options.array' => 'فرمت گزینه‌ها معتبر نیست.',
            'options.min' => 'حداقل دو گزینه باید وارد شود.',
            'options.*.required' => 'متن همه گزینه‌ها الزامی است.',

            'correct_option.required' => 'انتخاب گزینه صحیح الزامی است.',
        ];
    }
}
