<?php

namespace App\Jobs;

use App\Models\ExamAttempt;
use App\Services\BaleBotService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendBaleExamResultJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $attemptId
    ) {}

    public function handle(BaleBotService $baleBotService): void
    {
        Log::info('SendBaleExamResultJob started', [
            'attempt_id' => $this->attemptId,
        ]);

        $attempt = ExamAttempt::with(['user', 'exam'])->find($this->attemptId);

        if (! $attempt || ! $attempt->user) {
            Log::warning('SendBaleExamResultJob aborted: attempt or user missing', [
                'attempt_id' => $this->attemptId,
            ]);
            return;
        }

        Log::info('Attempt loaded for Bale report', [
            'attempt_id' => $attempt->id,
            'user_id' => $attempt->user->id,
            'bale_chat_id' => $attempt->user->bale_chat_id,
            'already_sent_at' => $attempt->bale_report_sent_at,
        ]);

        if ($attempt->bale_report_sent_at) {
            Log::info('Bale report skipped: already sent', [
                'attempt_id' => $attempt->id,
            ]);
            return;
        }

        $baleBotService->sendAttemptReport($attempt);

        $attempt->forceFill([
            'bale_report_sent_at' => now(),
        ])->save();

        Log::info('Bale report marked as sent', [
            'attempt_id' => $attempt->id,
        ]);
    }
}
