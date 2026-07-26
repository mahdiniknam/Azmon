<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ۱. غیرفعال کردن موقت بررسی کلیدهای خارجی
        Schema::disableForeignKeyConstraints();

        $this->call([
            CountrySeeder::class,
            CountryUpdateSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            RolePermissionSeeder::class,
            SettingSeeder::class,
            AdminSeeder::class,
            PatternOptionSeeder::class,
            GatewaySeeder::class,
        ]);

        // ۲. فعال کردن مجدد بررسی کلیدهای خارجی
        Schema::enableForeignKeyConstraints();
    }
}
