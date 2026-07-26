<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userName' => ['required', 'string'], // می‌تواند موبایل یا ایمیل باشد
            'password' => ['required', 'string', 'min:6'],
            'captcha'  => ['required', 'min:5','max:5'],
        ];
    }
    public function messages()
    {
        return [
            'userName.required' => __('errors.required', ['attribute' => __('general.username_or_mobile')]),
            'password.required' => __('errors.required', ['attribute' => __('general.password')]),
            'captcha.required'  => __('errors.required', ['attribute' => __('general.captcha')]),
        ];
    }
}
