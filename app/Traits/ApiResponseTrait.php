<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * پاسخ موفق با داده‌ها
     */
    public function successResponse($data = [], string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'count' => is_array($data) || $data instanceof \Countable ? count($data) : null,
            'data' => $data
        ], $code);
    }

    /**
     * پاسخ خطا
     */
    public function errorResponse(string $message = 'Error', int $code = 400, $data = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
