<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
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
            'identifier'    => 'required|string',
            'new_password'   => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase() // حداقل یک حرف بزرگ و یک حرف کوچک
                    ->numbers()   // حداقل یک عدد
                // ->symbols() // اگر نماد خاص هم خواستید این را اضافه کنید
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'new_password.min' => __('errors.password_complexity'),
            'new_password.mixed' => __('errors.password_complexity'),
            'new_password.numbers' => __('errors.password_complexity'),
            'new_password.confirmed' => __('errors.password_mismatch'),
            'first_name.required' => __('errors.required', ['attribute' => 'نام']),
            'last_name.required'  => __('errors.required', ['attribute' => 'نام خانوادگی']),
            'email.required'      => __('errors.required', ['attribute' => 'ایمیل']),
            'email.unique'        => __('errors.email_taken'),
            'mobile.unique'       => __('errors.mobile_taken'),
            // ... بقیه پیام ها
        ];
    }
}
