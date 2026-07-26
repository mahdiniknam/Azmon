<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BaleBotService
{
    public function sendMessage(string $text, ?string $chatId): void
    {
        if (! $this->isEnabled()) {
            return;
        }

        $token = $this->setting('bale.bot_token', config('services.bale.bot_token'));
        if (! $token || ! $chatId) {
            return;
        }

        try {
            Http::timeout(10)->post("https://tapi.bale.ai/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
            ])->throw();
        } catch (\Throwable $exception) {
            Log::warning('Bale message failed.', ['exception' => $exception::class]);
        }
    }

    public function sendAttemptReport(ExamAttempt $attempt, ?string $chatId = null): void
    {
        $attempt->loadMissing(['exam', 'user']);

        if (! $attempt->exam->resultsArePublished()) {
            return;
        }

        $chatId ??= $attempt->user?->bale_chat_id;
        if (! $chatId) {
            return;
        }

        $text = sprintf(
            "نتیجه آزمون: %s\nدانش‌آموز: %s\nنمره: %s از %s\nدرصد: %s%%\nصحیح: %d | غلط: %d | بی‌پاسخ: %d%s",
            $attempt->exam->title,
            $attempt->user->name ?? $attempt->user->email,
            $attempt->score,
            $attempt->max_score,
            $attempt->percentage,
            $attempt->correct_count,
            $attempt->wrong_count,
            $attempt->unanswered_count,
            $attempt->invalidated_at ? "\nمردود به دلیل تقلب: {$attempt->invalidated_reason}" : '',
        );

        $this->sendMessage($text, $chatId);
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

        $this->sendMessage(sprintf(
            "خلاصه آزمون: %s\nتعداد تلاش‌های نهایی: %d\nمیانگین درصد: %s%%\nجزئیات کامل در پنل استاد قابل مشاهده است.",
            $exam->title,
            $count,
            $average,
        ), $chatId);
    }

    public function sendAdminAlert(string $text): void
    {
        $this->sendMessage(
            $text,
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
            // During installation the settings table may not exist yet.
            return $fallback;
        }
    }
}
