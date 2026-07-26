<?php

namespace App\Services;

use App\Models\Otp;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\BusinessException;
use App\Services\BlocklistService;

class OtpService
{

    public function __construct(protected BlocklistService $blocklistService) {}

    /**
     * ارسال کد OTP برای هر مدلی که Authenticatable باشد
     *
     * @param mixed $authenticatable (User یا Admin)
     * @param string $type نوع عملیات
     * @return int کد OTP
     */
    public function sendOtp($authenticatable, string $type): int
    {
        // شناسایی نوع کاربر برای لاگ بهتر
        $userType = $authenticatable instanceof Admin ? 'admin' : 'user';

        $block = $this->blocklistService->recordAttempt(
            request()->ip(),
            "otp_request_{$userType}",
            10,
            6,
            "بیش از حد مجاز درخواست کد OTP برای {$userType} ارسال شده است"
        );

        if ($block) {
            throw new BusinessException(__('Too many requests. Please try again after 6 hours.'), 403);
        }

        $otpCode = rand(100000, 999999);

        // ابطال کدهای قبلی برای این کاربر/ادمین و این عملیات
        Otp::where('authenticatable_id', $authenticatable->id)
            ->where('authenticatable_type', get_class($authenticatable))
            ->where('type', $type)
            ->update(['used' => true]);

        // ایجاد رکورد جدید
        Otp::create([
            'authenticatable_id' => $authenticatable->id,
            'authenticatable_type' => get_class($authenticatable),
            'code' => bcrypt($otpCode),
            'type' => $type,
            'expires_at' => now()->addMinutes(2),
        ]);

        // TODO: اینجا می‌توانید کد را از طریق SMS یا ایمیل ارسال کنید
        // این قسمت به سیستم اطلاع‌رسانی شما بستگی دارد

        return $otpCode;
    }

    /**
     * تایید کد OTP برای هر مدلی که Authenticatable باشد
     *
     * @param string $identifier (ایمیل یا موبایل)
     * @param string $otp کد دریافتی
     * @param string $type نوع عملیات
     * @param string $userType نوع کاربر ('user' یا 'admin')
     * @return mixed مدل احراز هویت شده
     */
    public function verifyOtp(string $identifier, string $otp, string $type, string $userType = 'user')
    {
        // پیدا کردن کاربر/ادمین بر اساس شناسه
        if ($userType === 'admin') {
            $authenticatable = Admin::where('email', $identifier)
                ->orWhere('mobile', $identifier)
                ->first();
        } else {
            $authenticatable = User::where('email', $identifier)
                ->orWhere('mobile', $identifier)
                ->first();
        }

        if (!$authenticatable) {
            throw new BusinessException('errors.user_not_found');
        }

        // ۱. گرفتن کدهای استفاده نشده و منقضی نشده
        $otpRecords = Otp::where('authenticatable_id', $authenticatable->id)
            ->where('authenticatable_type', get_class($authenticatable))
            ->where('type', $type)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->get();

        $validRecord = null;

        foreach ($otpRecords as $record) {
            if (Hash::check($otp, $record->code)) {
                $validRecord = $record;
                break;
            }
        }

        // ۲. اگر کد اشتباه بود، منطق بلاک را اجرا می‌کنیم
        if (!$validRecord) {
            $block = $this->blocklistService->recordAttempt(
                request()->ip(),
                "otp_verify_{$userType}",
                10,
                6,
                "۱۰ بار تلاش ناموفق برای تایید کد OTP برای {$userType}"
            );

            if ($block) {
                throw new BusinessException(__('You are blocked for 6 hours due to many wrong attempts.'), 403);
            }

            throw new BusinessException('errors.invalid_otp');
        }

        // ۳. باطل کردن کد بعد از استفاده
        $validRecord->update(['used' => true]);

        return $authenticatable;
    }

    //مخصوص قسمت لاگین ادمین 
    public function verifyOtpForAuthenticatable($authenticatable, string $otp, string $type, string $userType = 'admin'): void
    {
        $otpRecords = Otp::where('authenticatable_id', $authenticatable->id)
            ->where('authenticatable_type', get_class($authenticatable))
            ->where('type', $type)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->get();

        $validRecord = null;
        foreach ($otpRecords as $record) {
            if (Hash::check($otp, $record->code)) {
                $validRecord = $record;
                break;
            }
        }

        if (!$validRecord) {
            $block = $this->blocklistService->recordAttempt(
                request()->ip(),
                "otp_verify_{$userType}",
                10,
                6,
                "۱۰ بار تلاش ناموفق برای تایید کد OTP برای {$userType}"
            );

            if ($block) {
                throw new BusinessException(__('You are blocked for 6 hours due to many wrong attempts.'), 403);
            }

            throw new BusinessException('errors.invalid_otp');
        }

        $validRecord->update(['used' => true]);
    }


    /**
     * بررسی وجود کد فعال برای کاربر/ادمین
     */
    public function hasActiveOtp($authenticatable, string $type): bool
    {
        return Otp::where('authenticatable_id', $authenticatable->id)
            ->where('authenticatable_type', get_class($authenticatable))
            ->where('type', $type)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->exists();
    }

    /**
     * ابطال تمام کدهای کاربر/ادمین
     */
    public function invalidateAllOtps($authenticatable, string $type = null): void
    {
        $query = Otp::where('authenticatable_id', $authenticatable->id)
            ->where('authenticatable_type', get_class($authenticatable))
            ->where('used', false);

        if ($type) {
            $query->where('type', $type);
        }

        $query->update(['used' => true]);
    }
}
