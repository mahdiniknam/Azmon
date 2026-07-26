<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'key' => 'client_access_token_hash',
            'value' => null,
            'lang' => 'en',
            'description' => 'SHA256 hash of Client Access Token used for user APIs',
        ]);
        Setting::create([
            'key' => 'project_name',
            'value' => config('app.name'),
            'lang' => 'en',
            'description' => 'Project name shown in admin panel',
        ]);
    }
}
