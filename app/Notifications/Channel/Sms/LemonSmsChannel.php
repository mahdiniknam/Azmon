<?php

namespace App\Notifications\Channel\Sms;

use App\Models\NotificationLogs;
use App\Notifications\SmsNotification;
use Illuminate\Support\Facades\Http;

class LemonSmsChannel
{
    public function send($notifiable, SmsNotification $notification)
    {
        $data = $notification->toSms($notifiable);

        // اگر provider فعال چیز دیگه بود، این channel بی‌خودی اجرا نشه
        if (($data['provider'] ?? null) !== 'limoHost') {
            return null;
        }

        // حتما موبایل داشته باشه
        if (empty($notifiable->mobile)) {
            return null;
        }

        $apiKey  = $data['limoHost']['api_key'] ?? null;
        $sender  = $data['limoHost']['sender'] ?? null; // اگر API لازم داشت
        $pattern = $data['pattern'] ?? null;

        if (!$apiKey || !$pattern) {
            return null;
        }

        // لاگ
        // $log = NotificationLogs::firstOrCreate(
        //     [
        //         'notifiable_id' => $notifiable->id,
        //         'notifiable_type' => get_class($notifiable),
        //     ],
        //     [
        //         'status' => NotificationLogs::STATUS_PENDING ?? 'pending',
        //     ]
        // );

        try {
            // Lemon: ReplaceToken آرایه‌ی مقدارها
            $params = array_values($data['parameters'] ?? []);

            $response = Http::withHeaders([
                'ApiKey' => $apiKey,
            ])->post('https://api.limosms.com/api/sendpatternmessage', [
                'OtpId'        => $pattern,
                'MobileNumber' => $notifiable->mobile,
                'ReplaceToken' => $params,
                // اگر نیاز شد:
                // 'Sender' => $sender,
            ]);

            if ($response->successful()) {
                // $log->update([
                //     'status' => NotificationLogs::STATUS_SUCCESS,
                // ]);
                return $response->json();
            }

            // $log->update([
            //     'status' => NotificationLogs::STATUS_FAILED ?? 'failed',
            //     'description' => $response->body(),
            // ]);

            logger()->error('Limo SMS failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;

        } catch (\Throwable $e) {
            // $log->update([
            //     'status' => NotificationLogs::STATUS_FAILED ?? 'failed',
            //     'description' => $e->getMessage(),
            // ]);

            logger()->error('Limo SMS exception', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return null;
        }
    }
}
