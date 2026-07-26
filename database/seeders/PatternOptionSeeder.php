<?php

namespace Database\Seeders;

use App\Models\PatternOption;
use Illuminate\Database\Seeder;

class PatternOptionSeeder extends Seeder
{
    public function run(): void
    {
        $patternsConfig = config('patterns') ?? [];

        // ایمیل
        $this->syncType(
            $patternsConfig['email']['user'] ?? [],
            $patternsConfig['email']['admin'] ?? [],
            PatternOption::TYPE_EMAIL
        );

        // پیامک
        $this->syncType(
            $patternsConfig['sms']['user'] ?? [],
            $patternsConfig['sms']['admin'] ?? [],
            PatternOption::TYPE_SMS
        );
    }

    private function syncType(array $userPatterns, array $adminPatterns, int $type): void
    {
        $patterns = array_merge($userPatterns, $adminPatterns);

        foreach ($patterns as $pattern) {
            $key = $pattern['key'];
            $description = $pattern['label'] ?? null;
            $defaultValues = $pattern['default_value'] ?? [];

            foreach ($defaultValues as $locale => $value) {

                // نکته مهم:
                // اگر قبلاً کاربر مقدار value رو تغییر داده باشه، ما overwrite نکنیم.
                $existing = PatternOption::query()
                    ->where('key', $key)
                    ->where('type', $type)
                    ->where('locale', $locale)
                    ->first();

                PatternOption::updateOrCreate(
                    [
                        'key'   => $key,
                        'type'  => $type,
                        'locale' => $locale,
                    ],
                    [
                        'value' => $existing?->value ?? $value,
                        'description' => $description,
                    ]
                );
            }
        }
    }
}
