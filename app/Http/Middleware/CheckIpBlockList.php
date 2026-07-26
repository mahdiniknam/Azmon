<?php

namespace App\Http\Middleware;

use App\Services\BlocklistService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIpBlockList
{
    public function __construct(
        protected BlocklistService $blacklistService
    ) {}

    // app/Http/Middleware/CheckIpBlacklist.php

    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        // استفاده از متد جدید سرویس
        $block = $this->blacklistService->getBlockDetails($ip);

        if ($block) {
            $message = "دسترسی شما مسدود شده است.";

            if ($block->type === 'temporary' && $block->expires_at) {
                $remainingMinutes = now()->diffInMinutes($block->expires_at);
                $message = "به دلیل مسائل امنیتی، دسترسی شما موقتاً مسدود است. لطفاً {$remainingMinutes} دقیقه دیگر تلاش کنید.";
            }

            return response()->json([
                'status'  => 'error',
                'message' => $message,
                'reason'  => $block->description, // علت بلاک (مثلاً: ۱۰ بار کد اشتباه)
            ], 403);
        }

        return $next($request);
    }
}
