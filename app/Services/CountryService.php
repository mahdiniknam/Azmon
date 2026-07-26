<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

class CountryService
{
    /**
     * دریافت لیست کشورها با اولویت ایران
     */
    public function getAllCountries(?string $search = null): Collection
    {
        $query = Country::query();

        // فیلتر جستجو
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('native', 'like', "%{$search}%")
                  ->orWhere('phonecode', 'like', "%{$search}%");
            });
        }

        // دریافت داده‌ها
        $countries = $query->get();

        // سورت کردن در سطح Collection (بهینه برای حجم دیتای کشورها)
        return $countries->sort(function ($a, $b) {
            // ۱. اولویت اول: ایران همیشه بالا باشد
            if ($a->iso2 === 'IR') return -1;
            if ($b->iso2 === 'IR') return 1;

            // ۲. سورت بقیه کشورها بر اساس نام (اگر native نبود از name استفاده کن)
            $nameA = $a->native ?? $a->name;
            $nameB = $b->native ?? $b->name;

            return strcmp($nameA, $nameB);
        })->values(); // تبدیل به Array استاندارد برای JSON
    }
}