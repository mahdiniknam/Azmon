<?php
namespace App\Services;

use App\Exceptions\BusinessException;
use App\Models\Otp;
use App\Models\User;
use App\Services\BlocklistService;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Create a new class instance.
     */

    public function __construct(protected BlocklistService $blocklistService)
    {}

    //پیدا کردن یوزر با استفاده از ایمیل یا شماره همراه
    public function findUserByIdentifier(string $identifier): ?User
    {
        return filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $identifier)->first()
            : User::where('mobile', $identifier)->first();
    }

    public function register(array $data): User
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'mobile'     => $data['mobile'],
            'country_id' => $data['country_id'],
            'password'   => $data['password'], // cast => hashed
            'status'     => 'pending',
        ]);
    }

    public function sendOtp(User $user, string $type): int
    {
        $block = $this->blocklistService->recordAttempt(
            request()->ip(),
            'otp_request',
            10,
            6,
            'بیش از حد مجاز درخواست کد OTP ارسال شده است'
        );
        if ($block) {
            throw new BusinessException(__('Too many requests. Please try again after 6 hours.'), 403);
        }

        $otpCode = rand(100000, 999999);

        // ابطال کدهای قبلی برای این کاربر/ادمین و این عملیات
        Otp::where('authenticatable_id', $user->id)
            ->where('authenticatable_type', get_class($user))
            ->where('type', $type)
            ->update(['used' => true]);

        // ایجاد رکورد جدید
        Otp::create([
            'authenticatable_id'   => $user->id,
            'authenticatable_type' => get_class($user),
            'code'                 => bcrypt($otpCode),
            'type'                 => $type,
            'expires_at'           => now()->addMinutes(2),
        ]);
        return $otpCode;
    }
    public function verifyOtp(string $identifier, string $otp, string $type): User
    {
        $user = $this->findUserByIdentifier($identifier);

        if (! $user) {
            throw new BusinessException('errors.user_not_found');
        }

        // ۱. گرفتن کدهای استفاده نشده و منقضی نشده
        $otpRecords = Otp::where('authenticatable_id', $user->id)
            ->where('authenticatable_type', get_class($user))
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

        // ۲. اگر کد اشتباه بود، اینجا منطق بلاک را اجرا می‌کنیم
        if (! $validRecord) {
            $block = $this->blocklistService->recordAttempt(
                request()->ip(),
                'otp_verify',
                10, // حداکثر ۱۰ بار تلاش
                6,  // ۶ ساعت بن
                '۱۰ بار تلاش ناموفق برای تایید کد OTP'
            );

            if ($block) {
                throw new BusinessException(__('You are blocked for 6 hours due to many wrong attempts.'), 403);
            }

            throw new BusinessException('errors.invalid_otp');
        }

        // ۳. باطل کردن کد بعد از استفاده
        $validRecord->update(['used' => true]);

        return $user;
    }

    public function findUserByLogin(string $login)
    {
        return filter_var($login, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $login)->first()
            : User::where('mobile', $login)->first();
    }
    public function checkPassword(User $user, string $password)
    {
        if (! Hash::check($password, $user->password)) {
            // ثبت تلاش ناموفق در سرویس بلاک‌لیست
            $block = $this->blocklistService->recordAttempt(
                request()->ip(),
                'login_password',
                5, // در اینجا حساسیت را روی ۵ بار گذاشتیم (مطابق استاندارد بانکی)
                6, // ۶ ساعت بن
                'تلاش مکرر با پسورد اشتباه در مرحله لاگین'
            );

            if ($block) {
                throw new BusinessException(__('Too many login attempts. You are blocked for 6 hours.'), 403);
            }

            throw new BusinessException(__('errors.invalid_password'), 401);
        }
    }
    //ریست کردن پسورد
    public function resetPassword(User $user, string $newPassword)
    {
        $user->update(['password' => $newPassword]); // cast => hashed
        return $user;
    }
    //ارسال او تی پی برای فورگت پسورد
    public function sendResetOtp(User $user, string $via): int
    {
        // تعیین کلید Cache بر اساس روش ارسال
        $prefix = $via === 'email' ? 'otp_reset_email_' : 'otp_reset_mobile_';

        // انتخاب شناسه برای ارسال: ایمیل یا موبایل
        $identifier = $via === 'email' ? $user->email : $user->mobile;

        // استفاده از همون تابع sendOtp
        return $this->sendOtp($identifier, $prefix);
    }
}
