<?php

namespace App\Services\Notifications;

use App\Models\PatternOption;

class PatternService
{
    public function getValue(string $key, int $type, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();

        // اول زبان فعلی
        $row = PatternOption::query()
            ->where('key', $key)
            ->where('type', $type)
            ->where('locale', $locale)
            ->first();

        if ($row?->value) return $row->value;

        // fallback en
        $row = PatternOption::query()
            ->where('key', $key)
            ->where('type', $type)
            ->where('locale', 'en')
            ->first();

        return $row?->value;
    }

    public function renderText(string $template, array $parameters = []): string
    {
        // جایگزینی %key% ها
        foreach ($parameters as $k => $v) {
            $template = str_replace('%'.$k.'%', (string) $v, $template);
        }
        return $template;
    }
}
