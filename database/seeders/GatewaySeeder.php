<?php

namespace Database\Seeders;

use App\Models\Gateway;
use Illuminate\Database\Seeder;

class GatewaySeeder extends Seeder
{
    public function run(): void
    {
        $drivers = config('gateways.drivers', []);

        foreach ($drivers as $driver => $meta) {
            Gateway::updateOrCreate(
                ['driver' => $driver],
                [
                    'title' => __($meta['title']),
                    'config' => [],
                    'is_active' => true,
                ]
            );
        }
    }
}
