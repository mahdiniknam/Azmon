<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRoleRequest extends FormRequest
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
            'name' => 'required|string|max:50|unique:roles,name,null,id,guard_name,admin',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'integer|exists:permissions,id'
        ];
    }
    public function messages()
    {
        return [
            // Role name
            'name.required' => __('errors.required', ['attribute' => __('general.role_name')]),
            'name.string'   => __('errors.string', ['attribute' => __('general.role_name')]),
            'name.max'      => __('errors.max', [
                'attribute' => __('general.role_name'),
                'max' => 50
            ]),
            'name.unique'   => __('errors.unique', ['attribute' => __('general.role_name')]),

            // Permissions array
            'permissions.required' => __('errors.required', ['attribute' => __('general.permissions')]),
            'permissions.array'    => __('errors.array', ['attribute' => __('general.permissions')]),
            'permissions.min'      => __('errors.min', [
                'attribute' => __('general.permissions'),
                'min' => 1
            ]),

            // Each permission
            'permissions.*.integer' => __('errors.integer', ['attribute' => __('general.permission')]),
            'permissions.*.exists'  => __('errors.exists', ['attribute' => __('general.permission')]),
        ];
    }
}
