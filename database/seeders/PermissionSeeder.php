<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Users
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Admins
            'admins.view',
            'admins.create',
            'admins.edit',
            'admins.delete',

            // Roles & Permissions
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
        ];
        foreach($permissions as $permission){
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin'
            ]);
        }
    }
}
