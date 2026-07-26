<?php

namespace App\Notifications;

use App\Services\Notifications\MailConfigService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class EmailNotification extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public array $payload = [])
    {
        $this->queue = 'email';
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // تنظیم mail از settings
        app(MailConfigService::class)->applyFromSettings();

        $subject = (string)($this->payload['title'] ?? trans('general.email_subject'));
        $message = (string)($this->payload['message'] ?? '');

        return (new MailMessage)
            ->subject($subject)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('templates.email', [
                'message' => $message,
                'notifiable' => $notifiable,
                'title' => $subject,
                'description' => $message,
                'parameters' => $this->payload['parameters'] ?? [],
            ]);
    }
}
