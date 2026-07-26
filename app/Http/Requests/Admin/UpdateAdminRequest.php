<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $adminId = $this->route('admin')->id;

        return [
            'firstName' => 'required|string|max:255',
            'lastName'  => 'required|string|max:255',

            'email' => 'required|email|unique:admins,email,' . $adminId,

            'password' => 'nullable|string|confirmed|min:8',

            'phone' => 'required|string|max:20|unique:admins,mobile,' . $adminId,

            'nationalCode' => 'nullable|unique:admins,national_code,' . $adminId,

            'address' => 'nullable|string|max:500',

            'roles'   => 'nullable|array|min:1',
            'roles.*' => 'exists:roles,id',

            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'firstName.required' => __('errors.required', ['attribute' => __('general.first_name')]),
            'lastName.required'  => __('errors.required', ['attribute' => __('general.last_name')]),

            'email.required' => __('errors.required', ['attribute' => __('general.email_address')]),
            'email.email'    => __('errors.email'),
            'email.unique'   => __('errors.email_taken'),

            'password.min'        => __('errors.min', ['attribute' => __('general.password'), 'min' => 8]),
            'password.confirmed' => __('errors.password_mismatch'),

            'phone.required' => __('errors.required', ['attribute' => __('general.phone_number')]),
            'phone.unique'   => __('errors.phone_taken'),

            'nationalCode.unique' => __('errors.national_code_unique'),

            'address.max' => __('errors.max', ['attribute' => __('general.address'), 'max' => 500]),

            'roles.required' => __('errors.required', ['attribute' => __('general.roles')]),
            'roles.array'    => __('errors.array', ['attribute' => __('general.roles')]),
            'roles.min'      => __('errors.roles_min'),
            'roles.*.exists' => __('errors.role_invalid'),

            'status.required' => __('errors.required', ['attribute' => __('general.account_status')]),
            'status.in'       => __('errors.in', ['attribute' => __('general.account_status')]),
        ];
    }
}
