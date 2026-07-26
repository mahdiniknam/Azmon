<?php

namespace App\Notifications;

use App\Notifications\Channel\Sms\LemonSmsChannel;
use App\Notifications\Channel\Sms\MeliPayamakChannel;
use App\Services\SettingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class SmsNotification extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $patternCode,       // value داخل PatternOption برای TYPE_SMS
        public ?array $parameters = null  // ['code'=>..., ...]
    ) {
        $this->queue = 'sms';
    }

    public function via(object $notifiable): array
    {

        /** @var SettingService $settings */
        $settings = app(SettingService::class);
        $active = $settings->get('sms.provider.active', 'melipayamak');

        return match ($active) {
            'limoHost'   => [LemonSmsChannel::class],
            'melipayamak' => [MeliPayamakChannel::class],
            default       => [MeliPayamakChannel::class],
        };
    }

    /**
     * این متد رو Channelهای SMS صدا میزنن
     */
    public function toSms(object $notifiable): array
    {
        /** @var SettingService $settings */
        $settings = app(SettingService::class);
        $active = $settings->get('sms.provider.active', 'melipayamak');
        return [
            'pattern' => $this->patternCode,
            'parameters' => $this->parameters ?? [],

            // credentials بر اساس provider فعال
            'provider' => $active,
            'melipayamak' => [
                'username' => $settings->get('sms.providers.melipayamak.username'),
                'password' => $settings->get('sms.providers.melipayamak.password'),
            ],
            'limoHost' => [
                'api_key' => $settings->get('sms.providers.limoHost.api_key'),
                'sender'  => $settings->get('sms.providers.limoHost.sender'),
            ],
        ];
    }
}
