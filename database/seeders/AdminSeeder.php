<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::create([
            'first_name' => 'admin',
            'last_name' => 'test',
            'national_code' => '0910000000',
            'mobile' => '1',
            'address' => 'test',
            'status' => 'active',
            'email' => 'mahdi@gmail.com',
            'password' => '11111111',
            'otp_enabled' => 0,
        ]);
        $role = Role::where('name', 'super-admin')->first();
        $admin->syncRoles($role);
    }
}
