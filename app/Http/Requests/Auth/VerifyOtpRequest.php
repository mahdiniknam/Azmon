<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
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
            'identifier' => 'required|string',
            'otp'    => 'required|digits:6',
            'type'   => 'required|in:register,login',
        ];
    }
    public function messages(): array
    {
        return [
            'identifier.required' => __('errors.required', ['attribute' => 'شناسه کاربری']),
            'via.required'        => __('errors.required', ['attribute' => 'روش ارسال']),
            'via.in'              => __('errors.in', ['attribute' => 'روش ارسال']),
            'otp.required'        => __('errors.otp_required'),
            'otp.digits'          => __('errors.invalid_otp'),
            'type.in'             => __('errors.in', ['attribute' => 'نوع عملیات']),
        ];
    }
}
