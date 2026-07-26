<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'is_active' => 'required|in:0,1',
            'role'=> 'required|in:student,teacher',
        ];
    }
    public function messages()
    {
        return [
            // First Name
            'name.required' => __('errors.required', ['attribute' => __('general.first_name')]),
            'name.string' => __('errors.string', ['attribute' => __('general.first_name')]),
            'name.max' => __('errors.max', ['attribute' => __('general.first_name'), 'max' => 255]),

     

            // Email
            'email.required' => __('errors.required', ['attribute' => __('general.email')]),
            'email.email' => __('errors.email', ['attribute' => __('general.email')]),
            'email.unique' => __('errors.unique', ['attribute' => __('general.email')]),

            // Password
            'password.required' => __('errors.required', ['attribute' => __('general.password')]),
            'password.string' => __('errors.string', ['attribute' => __('general.password')]),
           
            'password.min' => __('errors.min', ['attribute' => __('general.password'), 'min' => 8]),

            // Phone
            'phone.required' => __('errors.required', ['attribute' => __('general.phone')]),
            'phone.string' => __('errors.string', ['attribute' => __('general.phone')]),
            'phone.max' => __('errors.max', ['attribute' => __('general.phone'), 'max' => 20]),

            // Status
            'status.required' => __('errors.required', ['attribute' => __('general.status')]),
            'status.in' => __('errors.in', ['attribute' => __('general.status')]),

    
        ];
    }
}
