<?php

namespace App\Http\Controllers\BaleBot;

use App\Http\Controllers\Controller;
use App\Models\BaleAccountLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BaleConnectionController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        BaleAccountLink::where('user_id', $user->id)
            ->whereNull('used_at')
            ->delete();

        $link = BaleAccountLink::create([
            'user_id' => $user->id,
            'code' => (string) random_int(100000, 999999),
            'expires_at' => now()->addMinutes(1000),
        ]);

        return back()->with('bale_connect_code', $link->code);
    }

    public function disconnect(Request $request)
    {
        $user = $request->user();
        $user->update([
            'bale_chat_id' => null,
            'bale_linked_at' => null,
        ]);

        return back()->with('success', 'اتصال بله حذف شد.');
    }


    public function setupWebhook($password)
    {
        if ($password !== env('SETUP_PASSWORD')) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $token = env('BALE_BOT_TOKEN');
        // آدرس کامل وب‌هوک شما (مثلاً https://site.com/webhooks/bale)
        $webhookUrl = url('/webhooks/bale');

        if (!$token) {
            return '❌ توکن بله (BALE_BOT_TOKEN) در فایل env تنظیم نشده است.';
        }

        $url = "https://tapi.bale.ai/bot{$token}/setWebhook";

        $response = Http::timeout(20)->post($url, [
            'url' => $webhookUrl,
        ]);

        if ($response->successful()) {
            return "✅ وب‌هوک بله با موفقیت تنظیم شد!<br>آدرس ثبت شده: {$webhookUrl}";
        }

        return "❌ خطا در تنظیم وب‌هوک: " . $response->body();
    }

    /**
     * استعلام وضعیت بات و وب‌هوک بله
     * آدرس تست: domain.com/bale/status/YOUR_PASSWORD
     */
    public function getWebhookStatus($password)
    {
        if ($password !== env('SETUP_PASSWORD')) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $token = env('BALE_BOT_TOKEN');
        $url = "https://tapi.bale.ai/bot{$token}/getWebhookInfo";

        $response = Http::timeout(20)->get($url);

        if ($response->successful()) {
            $data = $response->json();
            $info = $data['result'] ?? [];

            return "✅ اتصال به بله برقرار است.<br>" .
                "آدرس فعلی وب‌هوک: " . ($info['url'] ?? 'تنظیم نشده') . "<br>" .
                "پیام‌های در انتظار: " . ($info['pending_update_count'] ?? 0);
        }

        return "❌ خطا در دریافت وضعیت از بله: " . $response->body();
    }
}
