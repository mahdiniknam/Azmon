<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BaleBotService
{
    public function sendMessage(
        string $text,
        ?string $chatId,
        array $inlineKeyboard = [],
        array $extra = []
    ): void {
        if (! $this->isEnabled()) {
            Log::info('Bale disabled, message skipped.');
            return;
        }

        $token = $this->setting('bale.bot_token', config('services.bale.bot_token'));

        if (! $token || ! $chatId) {
            Log::warning('Bale message skipped due to missing token/chat_id.', [
                'has_token' => (bool) $token,
                'chat_id' => $chatId,
            ]);
            return;
        }

        $payload = array_merge([
            'chat_id' => $chatId,
            'text' => $text,
        ], $extra);

        if (! empty($inlineKeyboard)) {
            $payload['reply_markup'] = [
                'inline_keyboard' => $inlineKeyboard,
            ];
        }

        try {
            $response = Http::asJson()
                ->timeout(15)
                ->post("https://tapi.bale.ai/bot{$token}/sendMessage", $payload);

            if (! $response->successful()) {
                Log::warning('Bale sendMessage failed.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'payload' => $payload,
                ]);
                return;
            }

            Log::info('Bale message sent successfully.', [
                'chat_id' => $chatId,
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Bale message exception.', [
                'message' => $exception->getMessage(),
                'class' => $exception::class,
            ]);
        }
    }

    public function sendSuccessMessage(?string $chatId, string $text): void
    {
        $this->sendMessage($text, $chatId, [
            [
                [
                    'text' => 'ورود به سایت 🌐',
                    'url' => config('app.url'),
                ],
            ],
        ]);
    }

    public function sendHelpMessage(?string $chatId): void
    {
        $this->sendMessage(
            "سلام 👋\n\nبرای اتصال حساب، کد ۶ رقمی‌ای که داخل سایت گرفته‌ای را برای من بفرست.",
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
    }

    // public function sendAttemptReport(ExamAttempt $attempt, ?string $chatId = null): void
    // {
    //     $attempt->loadMissing(['exam', 'user']);

    //     if (! $attempt->exam->resultsArePublished()) {
    //         return;
    //     }

    //     $chatId ??= $attempt->user?->bale_chat_id;
    //     if (! $chatId) {
    //         return;
    //     }

    //     $text = sprintf(
    //         "📘 نتیجه آزمون: %s\n👤 دانش‌آموز: %s\n🏆 نمره: %s از %s\n📊 درصد: %s%%\n✅ صحیح: %d\n❌ غلط: %d\n➖ بی‌پاسخ: %d%s",
    //         $attempt->exam->title,
    //         $attempt->user->name ?? $attempt->user->email,
    //         $attempt->score,
    //         $attempt->max_score,
    //         $attempt->percentage,
    //         $attempt->correct_count,
    //         $attempt->wrong_count,
    //         $attempt->unanswered_count,
    //         $attempt->invalidated_at ? "\n🚫 مردود به دلیل تقلب: {$attempt->invalidated_reason}" : '',
    //     );

    //     $this->sendMessage($text, $chatId, [
    //         [
    //             [
    //                 'text' => 'پنل دانش‌آموز 🌐',
    //                 'url' => config('app.url'),
    //             ],
    //         ],
    //     ]);
    // }

    public function sendAttemptReport(ExamAttempt $attempt, ?string $chatId = null): void
    {
        $attempt->loadMissing(['exam', 'user']);

        $chatId ??= $attempt->user?->bale_chat_id;

        Log::info('Preparing Bale attempt report', [
            'attempt_id' => $attempt->id,
            'chat_id' => $chatId,
            'exam_title' => $attempt->exam?->title,
            'score' => $attempt->score,
        ]);

        if (! $chatId) {
            Log::warning('Bale report skipped: no chat id', [
                'attempt_id' => $attempt->id,
                'user_id' => $attempt->user?->id,
            ]);
            return;
        }

        $score = number_format((float) $attempt->score, 2, '.', '');
        $maxScore = number_format((float) ($attempt->max_score ?? 0), 2, '.', '');
        $percentage = number_format((float) ($attempt->percentage ?? 0), 2, '.', '');

        $text = sprintf(
            "📘 نتیجه آزمون: %s\n👤 دانش‌آموز: %s\n🏆 نمره: %s از %s\n📊 درصد: %s%%\n✅ صحیح: %d\n❌ غلط: %d\n➖ بی‌پاسخ: %d%s",
            $attempt->exam->title ?? '—',
            $attempt->user->name ?? $attempt->user->email ?? '—',
            $score,
            $maxScore,
            $percentage,
            (int) ($attempt->correct_count ?? 0),
            (int) ($attempt->wrong_count ?? 0),
            (int) ($attempt->unanswered_count ?? 0),
            $attempt->invalidated_at ? "\n🚫 مردود به دلیل تقلب: {$attempt->invalidated_reason}" : ''
        );

        Log::info('Sending Bale message', [
            'attempt_id' => $attempt->id,
            'chat_id' => $chatId,
            'text' => $text,
        ]);

        $this->sendMessage($text, $chatId , [
            [
                [
                    'text' => 'مشاهده نتیجه آزمون 🌐',
                    'url' => route('student.attempts.result', $attempt),
                ],
            ],
        ]);
    }



    public function sendTeacherSummary(Exam $exam): void
    {
        $exam->loadMissing('creator');

        $chatId = $exam->creator?->bale_chat_id;
        if (! $chatId || ! $exam->resultsArePublished()) {
            return;
        }

        $attempts = $exam->attempts()->whereNotNull('finished_at');
        $count = (clone $attempts)->count();
        $average = $count > 0 ? round((float) (clone $attempts)->avg('percentage'), 2) : 0;

        $text = sprintf(
            "📚 خلاصه آزمون: %s\n👥 تعداد تلاش‌های نهایی: %d\n📈 میانگین درصد: %s%%\n\nجزئیات کامل در پنل استاد قابل مشاهده است.",
            $exam->title,
            $count,
            $average,
        );

        $this->sendMessage($text, $chatId, [
            [
                [
                    'text' => 'پنل استاد 🌐',
                    'url' => config('app.url'),
                ],
            ],
        ]);
    }

    public function sendAdminAlert(string $text): void
    {
        $this->sendMessage(
            "🚨 هشدار سیستم\n\n{$text}",
            $this->setting('bale.report_chat_id', config('services.bale.report_chat_id')),
        );
    }

    private function isEnabled(): bool
    {
        return filter_var(
            $this->setting('bale.enabled', config('services.bale.enabled', false)),
            FILTER_VALIDATE_BOOL
        );
    }

    private function setting(string $key, mixed $fallback = null): mixed
    {
        try {
            return Setting::getValue($key, $fallback);
        } catch (\Throwable $exception) {
            return $fallback;
        }
    }
}
