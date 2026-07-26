<?php

namespace App\Providers;

use App\Services\Notifications\MailConfigService;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // اگر خواستی bind خاصی بزنی اینجا
        $this->app->singleton(MailConfigService::class, fn () => new MailConfigService());
    }

    public function boot(): void
    {
        // هر درخواست وب / هر بار بوت شدن اپ، از دیتابیس کانفیگ ایمیل رو ست کن
        // برای صف هم مشکلی نداره چون داخل EmailNotification هم apply می‌کنی.
        try {
            app(MailConfigService::class)->applyFromSettings();
        } catch (\Throwable $e) {
            // نذار پروژه به خاطر ستینگ‌های خالی کرش کنه
            report($e);
        }
    }
}
