<?php

namespace App\Notifications\Channel\Sms;

use App\Notifications\SmsNotification;
use Illuminate\Support\Facades\Http;

class MeliPayamakChannel
{
    public function send($notifiable, SmsNotification $notification)
    {

        // فقط نوتیف‌هایی که toSms دارن
        if (!method_exists($notification, 'toSms')) {
            return null;
        }

        $data = $notification->toSms($notifiable);

        if (($data['provider'] ?? null) !== 'melipayamak') {
            return null;
        }

        if (empty($notifiable->mobile)) {
            return null;
        }

        $username = $data['melipayamak']['username'] ?? null;
        $password = $data['melipayamak']['password'] ?? null;
        $pattern  = $data['pattern'] ?? null;

        if (!$username || !$password || !$pattern) {
            return null;
        }

        try {
            $params = array_map(fn($v) => (string) $v, array_values($data['parameters'] ?? []));
            $text = implode(';', $params);

            $payload = [
                'username' => $username,
                'password' => $password,
                'text'     => $text,
                'to'       => $notifiable->mobile,
                'bodyId'   => $pattern,
            ];

            $response = Http::post('https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber', $payload);
            if ($response->successful()) {
                return $response->json();
            }

            logger()->error('MeliPayamak SMS failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'payload' => $payload,
            ]);

            return null;
        } catch (\Throwable $e) {
            logger()->error('MeliPayamak SMS exception', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return null;
        }
    }
}
