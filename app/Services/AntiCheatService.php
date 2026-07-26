<?php

namespace App\Services;

use App\Models\ExamAttempt;
use App\Models\SuspiciousEvent;
use Illuminate\Http\Request;

class AntiCheatService
{
    public function record(Request $request, ExamAttempt $attempt): array
    {
        $type = (string) $request->string('type')->limit(100);
        $recentDuplicate = $attempt->suspiciousEvents()
            ->where('type', $type)
            ->where('occurred_at', '>=', now()->subSeconds(5))
            ->exists();

        if (! $recentDuplicate) {
            SuspiciousEvent::create([
                'exam_attempt_id' => $attempt->id,
                'user_id' => $request->user()->id,
                'type' => $type,
                'payload' => $request->input('payload', []),
                'ip_address' => $request->ip(),
                'user_agent' => (string) $request->userAgent(),
                'occurred_at' => now(),
            ]);
        }

        $count = $attempt->suspiciousEvents()->count();
        $byType = $attempt->suspiciousEvents()
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type')
            ->all();

        return [
            'count' => $count,
            'by_type' => $byType,
            'duplicate_skipped' => $recentDuplicate,
        ];
    }
}
