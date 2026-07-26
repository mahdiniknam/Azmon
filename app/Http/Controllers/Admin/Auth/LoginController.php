<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Services\OtpService;
use App\Services\Google2FAService;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\AdminLoginRequest;
use App\Models\PatternOption;
use App\Services\AdminAuthService;
use App\Services\AdminService;
use App\Services\CaptchaService;
use App\Services\Notifications\Notifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function __construct(
        protected CaptchaService $captchaService,
        protected AdminService $adminService,
        protected AdminAuthService $adminAuthService,
        protected OtpService $otpService,
        protected Google2FAService $google2FAService,
    ) {}
    public function showLoginForm()
    {
        if (request()->has('reset_challenge')) {
            Session::forget('admin_login_challenge');
        }

        $captcha = $this->captchaService->createCapcha();
        // ذخیره در سشن برای بررسی بعدی
        Session::put('captcha', [
            'value' => Hash::make($captcha->getPhrase()),
            'time' => now()->addSeconds(90),
        ]);
        $loginChallenge = Session::get('admin_login_challenge'); // ممکنه null باشه
        return view('admin.pages.Auth.login', compact('captcha', 'loginChallenge'));
    }

    public function refreshCaptcha()
    {
        $captcha = $this->captchaService->createCapcha();
        Session::put('captcha', [
            'value' => Hash::make($captcha->getPhrase()),
            'time' => now()->addSeconds(90),
        ]);
        return response()->json(['captcha' => $captcha->inline()]);
    }

    // در LoginController.php
    public function loginWithPassword(AdminLoginRequest $request)
    {
        try {
            // بررسی کپچا
            if (!$this->captchaService->checkCaptcha($request->captcha)) {
                return back()->withErrors(['captcha' => __('errors.captcha_invalid')])->withInput();
            }

            // تلاش برای لاگین
            $loginResult = $this->adminAuthService->login(
                $request->only('userName', 'password'),
            );

            if ($loginResult['success']) {

                // اگر مرحله ۲ لازم بود
                if (!empty($loginResult['challenge_required'])) {
                    /** @var \App\Models\Admin $admin */
                    $admin = $loginResult['admin'];
                    $needs = $loginResult['needs'];

                    // state مرحله ۲
                    Session::put('admin_login_challenge', [
                        'admin_id' => $admin->id,
                        'needs_sms' => (bool) $needs['sms'],
                        'needs_totp' => (bool) $needs['totp'],
                        'otp_type' => 'admin_login',
                        'created_at' => now()->toDateTimeString(),
                    ]);

                    // اگر SMS لازم بود کد بفرست
                    if ($needs['sms']) {
                        $otpCode = $this->otpService->sendOtp($admin, 'admin_login');
                        app(Notifier::class)->send($admin, ['sms'], PatternOption::USER_OTP_PATTERN, ['user_id' => $otpCode]);
                    }

                    return redirect()->route('admin.login')
                        ->with('success', 'رمز عبور تایید شد. لطفاً کدهای امنیتی را وارد کنید.');
                }
                // اگر مرحله ۲ لازم نیست، مثل قبل
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', __('auth.login_success'));
            }

            // اگر لاگین ناموفق بود
            $errors = [];

            // تشخیص اینکه خطا مربوط به کدام فیلد است
            if (str_contains($loginResult['message'], trans('errors.username_not_found'))) {
                $errors['userName'] = $loginResult['message'];
            } elseif (str_contains($loginResult['message'], trans('errors.password_incorect'))) {
                $errors['password'] = $loginResult['message'];
            } elseif (str_contains($loginResult['message'], trans('errors.status_id_inactive'))) {
                $errors['general'] = $loginResult['message'];
            } else {
                $errors['general'] = $loginResult['message'];
            }
            return back()
                ->withErrors($errors)
                ->withInput($request->only('userName')); // فقط نام کاربری را نگه دارید، نه رمز عبور
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => __('errors.server_error')])
                ->withInput();
        }
    }

    public function verifyLoginChallenge(Request $request)
    {
        $challenge = Session::get('admin_login_challenge');
        if (!$challenge || empty($challenge['admin_id'])) {
            return redirect()->route('admin.login')->withErrors(['general' => __('errors.session_expired')]);
        }

        /** @var Admin $admin */
        $admin = Admin::find($challenge['admin_id']);
        if (!$admin) {
            Session::forget('admin_login_challenge');
            return redirect()->route('admin.login')->withErrors(['general' => __('errors.user_not_found')]);
        }

        // ولیدیشن شرطی
        $rules = [];
        if (!empty($challenge['needs_sms'])) {
            $rules['sms_otp'] = ['required', 'digits:6'];
        }
        if (!empty($challenge['needs_totp'])) {
            $rules['totp_otp'] = ['required', 'digits:6'];
        }
        $request->validate($rules);

        try {
            // 1) SMS OTP
            if (!empty($challenge['needs_sms'])) {
                $this->otpService->verifyOtpForAuthenticatable($admin, $request->sms_otp, $challenge['otp_type'], 'admin');
            }

            // 2) Google TOTP
            if (!empty($challenge['needs_totp'])) {
                $device = $admin->activeGoogleAuth()->first();
                if (!$device || !$this->google2FAService->verifyOtp($device, $request->totp_otp)) {
                    return back()->withErrors(['totp_otp' => __('errors.invalid_otp')]);
                }
            }

            // لاگین نهایی
            auth('admin')->login($admin);

            // پاک کردن state
            Session::forget('admin_login_challenge');

            return redirect()->intended(route('admin.dashboard'))->with('success', __('auth.login_success'));
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }


    public function logout(Request $request)
    {
        try {
            // فراخوانی سرویس لاگ‌اوت
            $logoutResult = $this->adminAuthService->logout();

            // باطل کردن session کامل
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // پاک کردن session کپچا (اگر وجود دارد)
            Session::forget('captcha');

            if ($logoutResult['success']) {
                // ریدایرکت به صفحه لاگین با پیام موفقیت
                return redirect()->route('admin.login')
                    ->with('success', $logoutResult['message']);
            }

            // اگر لاگ‌اوت ناموفق بود
            return back()
                ->with('error', $logoutResult['message']);
        } catch (\Exception $e) {
            // لاگ کردن خطا
            Log::error('Logout controller error: ' . $e->getMessage());

            // حتی اگر خطا داشت، کاربر را به صفحه لاگین ببر
            Auth::guard('admin')->logout();
            $request->session()->invalidate();

            return redirect()->route('admin.login')
                ->with('error', __('errors.server_error'));
        }
    }
}
