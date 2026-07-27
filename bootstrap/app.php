<?php

use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\CheckIpBlocklist;
use App\Http\Middleware\EnsureStudent;
use App\Http\Middleware\EnsureTeacher;
use App\Http\Middleware\SetLogInfoMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // استثنا کردن وب‌هوک بله از بررسی توکن CSRF
        $middleware->validateCsrfTokens(except: [
            'webhooks/bale',
        ]);

        $middleware->api(append: CheckIpBlocklist::class);

        $middleware->alias([
            'auth.admin' => AdminAuth::class,
            'setLogInfo' => SetLogInfoMiddleware::class,
            'student' => EnsureStudent::class,
            'teacher' => EnsureTeacher::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // مدیریت استثناها و خطاها در اینجا قرار می‌گیرد
    })->create();
