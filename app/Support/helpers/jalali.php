<?php

use Morilog\Jalali\Jalalian;
use Illuminate\Support\Carbon;

if (! function_exists('to_jalali')) {
    /**
     * تبدیل Carbon/DateTime/string به Jalalian
     */
    function to_jalali($date, ?string $tz = 'Asia/Tehran'): ?Jalalian
    {
        if (empty($date)) return null;

        // اگر خودِ Jalalian بود
        if ($date instanceof Jalalian) return $date;

        // Carbon / DateTime
        if ($date instanceof \DateTimeInterface) {
            return Jalalian::fromDateTime(Carbon::instance($date)->setTimezone($tz));
        }

        // string
        return Jalalian::fromDateTime(Carbon::parse($date, $tz));
    }
}

if (! function_exists('jdate')) {
    /**
     * نمایش تاریخ شمسی به فرمت دلخواه
     */
    function jdate($date, string $format = 'Y/m/d H:i', ?string $tz = 'Asia/Tehran'): string
    {
        $j = to_jalali($date, $tz);
        return $j ? $j->format($format) : '-';
    }
}

if (! function_exists('jalali_to_carbon')) {
    /**
     * تبدیل ورودی شمسی (مثل 1404/12/20 13:30) به Carbon برای ذخیره در DB
     */
    function jalali_to_carbon(string $jalaliDate, string $format = 'Y/m/d H:i', ?string $tz = 'Asia/Tehran'): Carbon
    {
        return Jalalian::fromFormat($format, $jalaliDate)->toCarbon()->setTimezone($tz);
    }
}
