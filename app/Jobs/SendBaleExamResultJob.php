<?php

use App\Models\ExamAttempt;
use App\Services\BaleBotService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendBaleExamResultJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $attemptId
    ) {}

    public function handle(BaleBotService $baleBotService): void
    {
        $attempt = ExamAttempt::with(['user', 'exam'])->find($this->attemptId);

        if (! $attempt || ! $attempt->user) {
            return;
        }

        if ($attempt->bale_report_sent_at) {
            return;
        }

        $baleBotService->sendAttemptReport($attempt);

        $attempt->update([
            'bale_report_sent_at' => now(),
        ]);
    }
}
