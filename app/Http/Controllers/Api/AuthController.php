<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendForgotPasswordOtpRequest;
use App\Http\Requests\Auth\VerifyForgotPasswordOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Services\BlocklistService;
use App\Services\OtpService;
use App\Traits\ApiResponseTrait;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected AuthService $authService,
        protected BlocklistService $blacklistService,
        protected OtpService $otpService,
    ) {}
    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());

        // اصلاح شد: به جای رشته، شیء یوزر و نوع عملیات فرستاده می‌شود
        $otp = $this->otpService->sendOtp($user, 'register');

        return $this->successResponse([
            'user' => new UserResource($user),
            'otp' => $otp,
        ], __('OTP sent to mobile'), 201);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(VerifyOtpRequest $request)
    {
        // تمام لاجیک‌ها (پیدا کردن یوزر، چک کردن بلاک، چک کردن کد و باطل کردن آن) در اینجا انجام می‌شود
        $user = $this->otpService->verifyOtp(
            $request->identifier,
            $request->otp,
            $request->type
        );

        // کارهای تکمیلی بعد از وریفای موفق
        if ($request->type === 'register') {
            $user->update([
                'mobile_verified_at' => now(),
                'status' => 'active',
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            'user'  => new UserResource($user),
        ], __('Authentication successful'));
    }


    /**
     * Login (only verified users)
     */
    public function login(LoginRequest $request)
    {
        $user = $this->authService->findUserByLogin($request->user_name);

        if (!$user) {
            return $this->errorResponse(__('errors.invalid_login'), 422);
        }

        // تمام چک کردن‌های پسورد و بلاک شدن احتمالی اینجا مدیریت می‌شود
        $this->authService->checkPassword($user, $request->password);

        // ارسال OTP هم که قبلاً در سرویس هوشمند شده بود
        $otp = $this->otpService->sendOtp($user, 'login');

        return $this->successResponse([
            'user' => new UserResource($user),
            'otp'  => $otp,
        ], __('OTP sent to mobile for login'));
    }

    //ارسال کد او تی پی برای فورگت پسورد
    public function sendForgotPasswordOtp(SendForgotPasswordOtpRequest $request)
    {
        $user = $this->authService->findUserByIdentifier($request->identifier);

        if (!$user) {
            throw new BusinessException('errors.user_not_found');
        }

        // اصلاح شد: استفاده از متد sendOtp به جای sendResetOtp برای یکپارچگی
        $otp = $this->otpService->sendOtp($user, 'forgetpass');

        return $this->successResponse([
            'otp' => $otp,
        ], __('OTP sent successfully'));
    }

    //هندل کردن درست بودن کد ارسالی برای فورگت
    public function verifyForgotPasswordOtp(VerifyForgotPasswordOtpRequest $request)
    {
        // اصلاح شد: مطابق با متد جدید verifyOtp در سرویس
        $user = $this->otpService->verifyOtp(
            $request->identifier,
            $request->otp,
            'forgetpass'
        );

        // اینجا می‌توانید آن توکن امنیتی موقت را که قبلاً بحث کردیم صادر کنید
        return $this->successResponse([
            'user' => new UserResource($user),
        ], __('OTP verified successfully'));
    }

    //ریست کردن پسورد
    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = $this->authService->findUserByIdentifier($request->identifier);

        if (!$user) {
            throw new BusinessException('errors.user_not_found');
        }

        $this->authService->resetPassword($user, $request->new_password);

        return $this->successResponse([], __('Password reset successfully'));
    }
}
