<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'status' => 'required|numeric|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'وارد کردن نام درس الزامی میباشد.',
            'title.string' => 'نام درس باید متن باشد.',
            'title.max' => 'نام درس نباید بیشتر از 200 کاراکتر باشد.',


            'description.required' => 'توضیحات برای درس الزامی میباشد.',
            'description.string' => 'توضیحات درس باید متن باشد.',
            'description.max' => 'توضیحات درس نباید بیشتر از 200 کاراکتر باشد.',

            'status.required' => 'توضیحات برای درس الزامی میباشد.',
            'status.numeric' => 'وضعیت فقط باید فعال یا غیر فعال باشد.',

        ];
    }
}
