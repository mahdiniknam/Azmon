<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    /**
     * کلید کش برای هر تنظیم.
     */
    private function cacheKey(string $key, ?string $lang): string
    {
        $lang = $lang ?? '*';
        return "settings:{$lang}:{$key}";
    }

    /**
     * گرفتن مقدار یک کلید (اختیاری: بر اساس lang)
     */
    public function get(string $key, mixed $default = null, ?string $lang = null): mixed
    {
        $lang ??= app()->getLocale();
        Artisan::call('cache:clear');
        return Cache::remember($this->cacheKey($key, $lang), now()->addMinutes(30), function () use ($key, $default, $lang) {

            // 1) اول تلاش با زبان جاری
            $row = Setting::query()
                ->where('key', $key)
                ->where('lang', $lang)
                ->first();

            if ($row) return $row->value;

            // 2) اگر نبود، fallback به گلوبال (*)
            $rowGlobal = Setting::query()
                ->where('key', $key)
                ->where('lang', '*')
                ->first();

            if ($rowGlobal) return $rowGlobal->value;

            // 3) اگر باز نبود، fallback به null (اگر قبلاً اینطوری ذخیره شده)
            $rowNull = Setting::query()
                ->where('key', $key)
                ->whereNull('lang')
                ->first();

            return $rowNull?->value ?? $default;
        });
    }



    /**
     * ست/آپدیت مقدار یک کلید
     */
    public function set(string $key, mixed $value, ?string $lang = null, ?string $description = null)
    {
        // برای تنظیمات سیستمی اگر lang پاس داده نشد، '*' بگذار
        $lang ??= '*';

        $row = Setting::query()->updateOrCreate(
            ['key' => $key, 'lang' => $lang],
            [
                'value' => $value === null ? null : (string) $value,
                'description' => $description,
            ]
        );
        Cache::forget($this->cacheKey($key, $lang));

        return $row;
    }

    /**
     * ست کردن چند مقدار با هم (برای فرم‌ها عالیه)
     */
    public function setMany(array $items, ?string $lang = null): void
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value, $lang);
        }
    }

    /**
     * حذف کلید
     */
    public function forget(string $key, ?string $lang = null): void
    {
        $lang ??= app()->getLocale();

        Setting::query()
            ->where('key', $key)
            ->where('lang', $lang)
            ->delete();

        Cache::forget($this->cacheKey($key, $lang));
    }
}
