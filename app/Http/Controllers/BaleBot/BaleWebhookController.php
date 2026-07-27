<?php

namespace App\Http\Controllers\BaleBot;

use App\Http\Controllers\Controller;
use App\Models\BaleAccountLink;
use App\Models\User;
use App\Services\BaleBotService;
use Illuminate\Http\Request;

class BaleWebhookController extends Controller
{
    public function __invoke(Request $request, BaleBotService $baleBot)
    {
        $payload = $request->all();

        $message = data_get($payload, 'message.text');
        $chatId = (string) data_get($payload, 'message.chat.id');

        if (! $message || ! $chatId) {
            return response()->json(['ok' => true]);
        }

        $message = trim($message);

        if ($message === '/start') {
            $baleBot->sendMessage(
                "سلام!\nبرای اتصال حساب، کد 6 رقمی که در سایت گرفته‌اید را ارسال کنید.\nمثال:\nconnect 123456",
                $chatId
            );

            return response()->json(['ok' => true]);
        }

        if (preg_match('/^connect\s+(\d{6})$/i', $message, $matches)) {
            $code = $matches[1];

            $link = BaleAccountLink::with('user')
                ->where('code', $code)
                ->first();

            if (! $link || ! $link->isUsable()) {
                $baleBot->sendMessage('کد نامعتبر است یا منقضی شده.', $chatId);
                return response()->json(['ok' => true]);
            }

            $existingUser = User::where('bale_chat_id', $chatId)->first();
            if ($existingUser && $existingUser->id !== $link->user_id) {
                $baleBot->sendMessage('این حساب بله قبلاً به کاربر دیگری متصل شده است.', $chatId);
                return response()->json(['ok' => true]);
            }

            $link->user->update([
                'bale_chat_id' => $chatId,
                'bale_linked_at' => now(),
            ]);

            $link->update([
                'chat_id' => $chatId,
                'used_at' => now(),
            ]);

            $baleBot->sendMessage('حساب شما با موفقیت متصل شد.', $chatId);

            return response()->json(['ok' => true]);
        }

        $baleBot->sendMessage(
            "دستور نامعتبر است.\nبرای اتصال حساب بنویس:\nconnect 123456",
            $chatId
        );

        return response()->json(['ok' => true]);
    }
}
