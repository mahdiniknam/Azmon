<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeacher
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->is_active) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('teacher.login')->withErrors([
                'email' => 'حساب شما غیرفعال است. با پشتیبانی تماس بگیرید.',
            ]);
        }

        abort_unless($request->user()->role === 'teacher', 403);

        return $next($request);
    }
}
