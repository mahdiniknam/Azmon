<?php

use App\Support\helpers\RouteDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

if (! function_exists('model_display_name')) {
    /**
     * Get display name for a model (instance or class name).
     *
     * @param  Model|string  $model  Model instance OR fully-qualified class name
     */
    function model_display_name(Model | string $model): string
    {
        $class = is_string($model) ? $model : $model::class;

        // 1) اگر مدل اسم کاستوم داده بود (static property)
        if (property_exists($class, 'displayName') && ! empty($class::$displayName)) {
            return (string) $class::$displayName;
        }

        // 2) از روی جدول کلید ترجمه رو بساز
        $instance = is_string($model) ? new $class() : $model;
        $table    = $instance->getTable();

        $key = "translist.{$table}.this"; // مسیر فایل ترجمه شما

        if (trans()->has($key)) {
            return __($key);
        }

        // 3) fallback
        return Str::headline(class_basename($class));
    }
}

if (! function_exists('route_display_name')) {
    function route_display_name(?string $routeName): string
    {
        return RouteDisplay::make($routeName);
    }
}

if (! function_exists('model_field_label')) {
    function model_field_label(string $modelType, string $field): string
    {
        $model = class_basename($modelType);

        // 1️⃣ ترجمه مخصوص مدل
        $key = "model.$model.$field";
        if (trans()->has($key)) {
            return __($key);
        }

        // 2️⃣ fallback عمومی
        $generalKey = "general.$field";

        if (trans()->has($generalKey)) {
            return __($generalKey);
        }

        // 3️⃣ fallback نهایی
        return ucfirst(str_replace('_', ' ', $field));
    }
}
if (! function_exists('get_created_at')) {
    function get_created_at($date, string $format = 'Y/m/d - H:i:s')
    {
        // return app(Kernel::class)->formatDate(
        //     $date,
        //     $format
        // );
    }
}
