<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = session('locale');

        if (in_array($lang, ['fa', 'en', 'zh', 'ar', 'es', 'ru', 'de'])) {
            app()->setLocale($lang);
        }
        return $next($request);
    }
}
