<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:admins,email'],
            'phone'     => ['required', 'string', 'max:20', 'unique:admins,mobile'],
            'nationalCode' => ['nullable', 'string', 'unique:admins,national_code'],
            'password'  => ['required', 'string', 'confirmed', 'min:8'],
            'address'   => ['nullable', 'string'],
            'status'    => ['required', 'in:active,blocked'],

            // Roles (Spatie)
            'roles'     => ['required', 'array'],
            'roles.*'   => ['exists:roles,id'],
        ];
    }

    public function messages(): array
    {
        return [

            // First Name
            'firstName.required' => __('errors.required', ['attribute' => __('general.first_name')]),
            'firstName.string'   => __('errors.string', ['attribute' => __('general.first_name')]),
            'firstName.max'      => __('errors.max', ['attribute' => __('general.first_name'), 'max' => 255]),

            // Last Name
            'lastName.required' => __('errors.required', ['attribute' => __('general.last_name')]),
            'lastName.string'   => __('errors.string', ['attribute' => __('general.last_name')]),
            'lastName.max'      => __('errors.max', ['attribute' => __('general.last_name'), 'max' => 255]),

            // Email
            'email.required' => __('errors.required', ['attribute' => __('general.email')]),
            'email.email'    => __('errors.email', ['attribute' => __('general.email')]),
            'email.unique'   => __('errors.unique', ['attribute' => __('general.email')]),

            // Phone
            'phone.required' => __('errors.required', ['attribute' => __('general.phone')]),
            'phone.string'   => __('errors.string', ['attribute' => __('general.phone')]),
            'phone.max'      => __('errors.max', ['attribute' => __('general.phone'), 'max' => 20]),
            'phone.unique'   => __('errors.unique', ['attribute' => __('general.phone')]),

            // National Code
            'nationalCode.unique' => __('errors.unique', ['attribute' => __('general.national_code')]),

            // Password
            'password.required'  => __('errors.required', ['attribute' => __('general.password')]),
            'password.string'    => __('errors.string', ['attribute' => __('general.password')]),
            'password.confirmed' => __('errors.confirmed', ['attribute' => __('general.password')]),
            'password.min'       => __('errors.min', ['attribute' => __('general.password'), 'min' => 8]),

            // Address
            'address.string' => __('errors.string', ['attribute' => __('general.address')]),

            // Status
            'status.required' => __('errors.required', ['attribute' => __('general.status')]),
            'status.in'       => __('errors.in', ['attribute' => __('general.status')]),

            // Roles
            'roles.required' => __('errors.required', ['attribute' => __('general.roles')]),
            'roles.array'    => __('errors.array', ['attribute' => __('general.roles')]),
            'roles.*.exists' => __('errors.exists', ['attribute' => __('general.roles')]),
        ];
    }
}
