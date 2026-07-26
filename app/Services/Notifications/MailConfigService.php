<?php

namespace App\Services\Notifications;

use App\Services\SettingService;

class MailConfigService
{
    public function applyFromSettings(): void
    {
        /** @var SettingService $settings */
        $settings = app(SettingService::class);

        $provider = $settings->get('email.provider.active', 'smtp');

        // فعلا فقط smtp
        $host = $settings->get("email.providers.$provider.host");
        $port = $settings->get("email.providers.$provider.port");
        $username = $settings->get("email.providers.$provider.username");
        $password = $settings->get("email.providers.$provider.password");
        $encryption = $settings->get("email.providers.$provider.encryption");
        $fromAddress = $settings->get("email.providers.$provider.from_address");
        $fromName = $settings->get("email.providers.$provider.from_name", env('APP_NAME'));

        if ($host) config(['mail.mailers.smtp.host' => $host]);
        if ($port) config(['mail.mailers.smtp.port' => $port]);
        if ($username) config(['mail.mailers.smtp.username' => $username]);
        if ($password) config(['mail.mailers.smtp.password' => $password]);
        config(['mail.mailers.smtp.encryption' => $encryption ?: null]);

        if ($fromAddress) config(['mail.from.address' => $fromAddress]);
        config(['mail.from.name' => $fromName ?: env('APP_NAME')]);
    }
}
