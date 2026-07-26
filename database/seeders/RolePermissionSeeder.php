<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::where('name','super-admin')->first();
        $admin = Role::where('name','admin')->first();
        $support = Role::where('name','support')->first();

        $superAdmin->syncPermissions(Permission::all());

        $admin->syncPermissions([
           'users.view', 
           'users.create', 
           'users.edit' ,

           'admins.view',
           'admins.create',
           'admins.edit',
        ]);

        $support->syncPermissions([
            'users.view',
            'admins.view',
        ]);
    }
}
