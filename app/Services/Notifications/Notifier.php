<?php

namespace App\Services\Notifications;

use App\Models\PatternOption;
use App\Notifications\EmailNotification;
use App\Notifications\SmsNotification;

class Notifier
{
    public function __construct(protected PatternService $patterns) {}

    /**
     * ارسال ایمیل با متن آزاد (بدون Pattern)
     */
    public function email(object $notifiable, string $title, string $message, array $parameters = []): void
    {
        $notifiable->notify(new EmailNotification([
            'title' => $title,
            'message' => $message,
            'parameters' => $parameters,
        ]));
    }

    /**
     * ارسال ایمیل با PatternOption (TYPE_EMAIL)
     */
    public function emailByPattern(object $notifiable, string $patternKey, array $parameters = [], ?string $title = null): void
    {
        $template = $this->patterns->getValue($patternKey, PatternOption::TYPE_EMAIL);

        if (!$template) return;
        $text = $this->patterns->renderText($template, $parameters);
        $this->email(
            $notifiable,
            $title ?? trans('general.email_subject'),
            $text,
            $parameters
        );
    }

    /**
     * ارسال SMS با PatternOption (TYPE_SMS) - چون provider ها pattern-based هستند
     */
    public function smsByPattern(object $notifiable, string $patternKey, array $parameters = []): void
    {
        $patternCode = $this->patterns->getValue($patternKey, PatternOption::TYPE_SMS);
        if (!$patternCode) return;

        $notifiable->notify(new SmsNotification($patternCode, $parameters));
    }

    /**
     * ارسال همزمان چند کانال بر اساس نیاز
     * channels: ['sms','email']
     */
    public function send(object $notifiable, array $channels, ?string $patternKey = null, array $parameters = [], ?string $title = null, ?string $message = null): void
    {
        $channels = array_unique($channels);
        // EMAIL
        if (in_array('email', $channels, true)) {
            if ($patternKey) {
                $this->emailByPattern($notifiable, $patternKey, $parameters, $title);
            } elseif ($title !== null && $message !== null) {
                $this->email($notifiable, $title, $message, $parameters);
            }
        }

        // SMS
        if (in_array('sms', $channels, true) && $patternKey) {
            $this->smsByPattern($notifiable, $patternKey, $parameters);
        }
    }
}
