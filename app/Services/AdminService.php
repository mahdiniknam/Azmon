<?php

namespace App\Services;

use App\Filters\UserFilter;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminService
{
    public function index()
    {
        return Admin::filters(new UserFilter())
            ->latest()
            ->paginate(10);
    }
    public function store(array $data)
    {
        $admin = Admin::create([
            'first_name' => $data['firstName'],
            'last_name'  => $data['lastName'],
            'email'     => $data['email'],
            'mobile'     => $data['phone'],
            'national_code' => $data['nationalCode'] ?? null,
            'address'   => $data['address'] ?? null,
            'status'    => $data['status'],
            'password'  => $data['password'],
        ]);
        $roles = Role::whereIn('id', $data['roles'])->where('guard_name', 'admin')->get();
        $admin->syncRoles($roles);

        return $admin;
    }

    public function update(array $data, Admin $admin)
    {
        if (!empty($data['password'])) {
            $admin->update(['password' => $data['password']]);
        }
        if (isset($data['roles'])) {
            $admin->roles()->sync($data['roles']);
        }
        return $admin->update([
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'email' => $data['email'],
            'mobile' => $data['phone'],
            'address' => $data['address'],
            'status' => $data['status'],
            'national_code' => $data['nationalCode'],
        ]);
    }

}
