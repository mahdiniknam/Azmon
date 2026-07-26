<?php

namespace App\Services;

use App\Models\BlockedIp;
use Illuminate\Support\Facades\Cache;

class BlocklistService
{
    /**
     * مسدود سازی یک ای‌پی
     */
    public function block(string $ip, string $type = 'temporary', ?string $description = null, ?int $hours = null)
    {
        $expiresAt = null;
        if($type === 'temporary' && $hours){
            $expiresAt = now()->addHours($hours);
        }

        $blockedIp = BlockedIp::updateOrCreate(
            ['ip_address' => $ip],
            [
                'type' => $type,
                'description' => $description,
                'expires_at' => $expiresAt,
                'is_active' => true,
                'starts_at' => now(),
            ]
        );

        // حذف کش قبلی برای اعمال تغییرات بلافاصله
        $this->clearIpCache($ip);

        return $blockedIp;
    }

    /**
     * رفع مسدودیت یک ای‌پی
     */
    public function unblock(string $ip): bool
    {
        $query = BlockedIp::where('ip_address', $ip);

        // اگر ای‌پی وجود نداشت، بیخودی کش را پاک نکن
        if (!$query->exists()) {
            return false;
        }

        $unblocked = $query->update([
            'is_active' => false,
            'expires_at' => now(),
        ]);

        $this->clearIpCache($ip);

        return true;
    }

    /**
     * بررسی مسدود بودن ای‌پی (با استفاده از لایه کش)
     */
    public function getBlockDetails(string $ip): ?BlockedIp
    {
        // کش کردن کل اطلاعات مدل برای ۳۰ دقیقه
        return Cache::remember("block_details_{$ip}", now()->addMinutes(30), function () use ($ip) {
            return BlockedIp::isBlocked($ip)->first();
        });
    }

    /**
     * پاکسازی کش مربوط به یک ای‌پی خاص
     */
    private function clearIpCache(string $ip): void
    {
        Cache::forget("block_details_{$ip}");
    }

    /**
     * ثبت یک تلاش ناموفق و چک کردن برای بلاک خودکار
     */
    public function recordAttempt(string $ip, string $key, int $maxAttempts, int $blockHours, string $reason): ?BlockedIp
    {
        $cacheKey = "attempts:{$key}:{$ip}";
        $attempts = Cache::get($cacheKey, 0) + 1;

        // ذخیره تعداد تلاش‌ها تا ۲۴ ساعت
        Cache::put($cacheKey, $attempts, now()->addDay());

        if ($attempts >= $maxAttempts) {
            $block = $this->block($ip, 'temporary', $reason, $blockHours);
            Cache::forget($cacheKey); // ریست کردن شمارنده بعد از بلاک شدن
            return $block;
        }

        return null;
    }
}
