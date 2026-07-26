<?php

namespace App\Http\Middleware;

use App\Support\helpers\RequestContext;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SetLogInfoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $context = app(RequestContext::class);

        $routeName = $request->route()?->getName();

        $context->route = $routeName;
        $context->ip = $request->ip();
        $context->isAdmin = $routeName && str_starts_with($routeName, 'admin.');

        return $next($request);
    }
}
