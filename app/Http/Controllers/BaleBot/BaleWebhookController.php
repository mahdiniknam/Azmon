<?php

namespace App\Http\Controllers\BaleBot;

use App\Http\Controllers\Controller;
use App\Models\BaleAccountLink;
use App\Models\User;
use App\Services\BaleBotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BaleWebhookController extends Controller
{
    public function __invoke(Request $request, BaleBotService $baleBot)
    {
        try {
            $payload = $request->all();
            Log::info('BALE WEBHOOK HIT', $payload);

            $messageText = trim((string) data_get($payload, 'message.text', ''));
            $chatId = (string) data_get($payload, 'message.chat.id', '');
            $callbackData = (string) data_get($payload, 'callback_query.data', '');
            $callbackChatId = (string) data_get($payload, 'callback_query.message.chat.id', '');

            // اگر callback از دکمه شیشه‌ای آمد
            if ($callbackData && $callbackChatId) {
                if ($callbackData === 'help') {
                    $baleBot->sendMessage(
                        "📌 راهنما\n\n1) وارد سایت شو\n2) کد اتصال بله را بگیر\n3) همین‌جا برای من بفرست\n\nنمونه کد:\n123456",
                        $callbackChatId,
                        [
                            [
                                [
                                    'text' => 'ورود به سایت 🌐',
                                    'url' => config('app.url'),
                                ],
                            ],
                        ]
                    );
                }

                return response()->json(['ok' => true], 200);
            }

            if (! $chatId) {
                Log::warning('Bale webhook without chat id.', ['payload' => $payload]);
                return response()->json(['ok' => true], 200);
            }

            // /start
            if ($messageText === '/start' || Str::startsWith($messageText, '/start')) {
                $baleBot->sendMessage(
                    "سلام 👋\n\nبه ربات آزمون‌ساز خوش اومدی.\nبرای اتصال حساب، کد ۶ رقمی‌ای که داخل سایت گرفته‌ای را برای من بفرست.",
                    $chatId,
                    [
                        [
                            [
                                'text' => 'ورود به سایت 🌐',
                                'url' => config('app.url'),
                            ],
                        ],
                        [
                            [
                                'text' => 'راهنما',
                                'callback_data' => 'help',
                            ],
                        ],
                    ]
                );

                return response()->json(['ok' => true], 200);
            }

            // حالت 1: فقط کد 6 رقمی
            if (preg_match('/^\d{6}$/', $messageText)) {
                return $this->connectByCode($messageText, $chatId, $baleBot);
            }

            // حالت 2: connect 123456
            if (preg_match('/^connect\s+(\d{6})$/i', $messageText, $matches)) {
                return $this->connectByCode($matches[1], $chatId, $baleBot);
            }

            $baleBot->sendMessage(
                "❌ پیام نامعتبر است.\n\nلطفاً یکی از این دو حالت را ارسال کن:\n\n123456\nیا\nconnect 123456",
                $chatId,
                [
                    [
                        [
                            'text' => 'ورود به سایت 🌐',
                            'url' => config('app.url'),
                        ],
                    ],
                ]
            );

            return response()->json(['ok' => true], 200);
        } catch (\Throwable $e) {
            Log::error('Bale webhook error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['ok' => true], 200);
        }
    }

    private function connectByCode(string $code, string $chatId, BaleBotService $baleBot)
    {
        $link = BaleAccountLink::with('user')
            ->where('code', $code)
            ->first();

        if (! $link || ! $link->isUsable()) {
            $baleBot->sendMessage(
                "🚫 کد نامعتبر است یا منقضی شده.\n\nلطفاً از داخل سایت یک کد جدید بگیر.",
                $chatId,
                [
                    [
                        [
                            'text' => 'دریافت کد جدید 🌐',
                            'url' => config('app.url'),
                        ],
                    ],
                ]
            );

            return response()->json(['ok' => true], 200);
        }

        $existingUser = User::where('bale_chat_id', $chatId)->first();
        if ($existingUser && $existingUser->id !== $link->user_id) {
            $baleBot->sendMessage(
                "⚠️ این حساب بله قبلاً به کاربر دیگری متصل شده است.",
                $chatId
            );

            return response()->json(['ok' => true], 200);
        }

        $link->user->update([
            'bale_chat_id' => $chatId,
            'bale_linked_at' => now(),
        ]);

        $link->update([
            'chat_id' => $chatId,
            'used_at' => now(),
        ]);

        $baleBot->sendMessage(
            "✅ حساب شما با موفقیت به بله متصل شد.\n\nاز این به بعد گزارش‌ها و اعلان‌ها از همین ربات برای شما ارسال می‌شود.",
            $chatId,
            [
                [
                    [
                        'text' => 'ورود به پنل 🌐',
                        'url' => config('app.url'),
                    ],
                ],
            ]
        );

        return response()->json(['ok' => true], 200);
    }
}
