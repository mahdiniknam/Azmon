<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user')->id;
        return [
            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => 'nullable|string|confirmed|min:8',
            'phone' => 'required|string|max:20',

            'status' => 'required|in:active,pending,blocked',
            'role' => 'required|in:student,teacher',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => __('errors.required', ['attribute' => __('general.first_name')]),
           
            'email.required' => __('errors.required', ['attribute' => __('general.email')]),
            'email.unique' => __('errors.email_taken'),
            'password.min' => __('errors.min', ['attribute' => __('general.password'), 'min' => 8]),
            'password.confirmed' => __('errors.password_mismatch'),
            'phone.required' => __('errors.required', ['attribute' => __('general.phone')]),
        
      
            'status.required' => __('errors.required', ['attribute' => __('general.status')]),
            'status.in' => __('errors.in', ['attribute' => __('general.status')]),
       
        ];
    }
}
