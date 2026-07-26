<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'lang',
        'description',
    ];

    /**
     * گرفتن مقدار یک تنظیمات
     */
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();

        if ($setting) {
            return $setting->value;
        }

        return $default;
    }

    /**
     * ذخیره یا به‌روزرسانی یک تنظیمات
     */
    public static function setValue($key, $value, $description = null)
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'description' => $description,
                'lang' => app()->getLocale() // اگر از چندزبانی استفاده می‌کنی
            ]
        );
    }
}
