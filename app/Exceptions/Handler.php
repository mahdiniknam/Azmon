<?php

namespace App\Exceptions;

use App\Exceptions\BusinessException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Illuminate\Auth\AuthenticationException; // اضافه کردن این use

class Handler extends ExceptionHandler
{
    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // اگر درخواست برای پنل ادمین است
        if (
            $request->is('AryaGostaran2025/admin/*') ||
            in_array('admin', $exception->guards())
        ) {
            return redirect()->guest(route('admin.login'));
        }

        // برای سایر موارد (کاربران عادی)
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => __('errors.unauthorized'),
            ], 401);
        }

        // ریدایرکت به صفحه لاگین پیش‌فرض
        return redirect()->guest(route('admin.login'));
    }

    public function render($request, Throwable $e)
    {
        // اگر ریکوئست ای‌پی‌آی است یا هدر Json دارد
        if ($request->expectsJson() || $request->is('api/*')) {

            // ۱. خطاهای منطق کسب و کار (Business)
            if ($e instanceof BusinessException) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], $e->status);
            }

            // ۲. خطاهای ولیدیشن
            if ($e instanceof ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => __('errors.validation'),
                    'errors'  => $e->errors(),
                ], 422);
            }

            // ۳. خطای پیدا نشدن روت یا مدل
            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => __('errors.not_found'),
                ], 404);
            }

            // ۴. خطای عدم دسترسی
            if ($e instanceof UnauthorizedHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => __('errors.unauthorized'),
                ], 401);
            }

            // ۵. خطاهای پیش‌بینی نشده سرور
            return response()->json([
                'success' => false,
                'message' => config('app.debug') ? $e->getMessage() : __('errors.server_error'),
            ], 500);
        }

        return parent::render($request, $e);
    }
}
