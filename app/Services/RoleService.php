<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function getAll()
    {
        return Role::query()
            ->where('guard_name', 'admin')
            ->withCount([
                'users as admins_count' => function ($q) {
                    $q->where('model_type', Admin::class);
                }
            ])
            ->orderBy('id', 'asc')
            ->paginate(10);
    }

    public function createRoleWithPermission(string $roleName, array $permissions, string $guardName)
    {
        return DB::transaction(function () use ($roleName, $permissions, $guardName) {
            //  جلوگیری از ساخت رول تکراری
            if (Role::where('name', $roleName)->where('guard_name', $guardName)->exists()) {
                throw new BusinessException('errors.role.already_exists');
            }
            try {
                $role = Role::firstOrCreate([
                    'name' => $roleName,
                    'guard_name' => $guardName
                ]);
                $permissionModel = Permission::whereIn('id', $permissions)->where('guard_name', $guardName)->get();

                $role->syncPermissions($permissionModel);
                return $role;
            } catch (\Throwable $e) {
                throw new BusinessException('errors.role_create_failed');
            }
        });
    }
    public function updateRolePermissions(Role $role, string $name, array $permissions)
    {
        return DB::transaction(function () use ($role, $name, $permissions) {
            $role->update(['name' => $name]);

            $permissionModels = Permission::whereIn('id', $permissions)
                ->where('guard_name', $role->guard_name)
                ->get();

            $role->syncPermissions($permissionModels);

            return $role;
        });
    }
    // وجود داشتن ادمینی با این رول
    public function deleteRole(Role $role)
    {
        $exist = $role->users()->exists();
        if (!$exist) {
            $role->syncPermissions([]);
            $role->delete();
            return true;
        } else {
            return false;
        }
    }
}
