<?php
namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminAuthService
{
    public function __construct(
        protected AdminNotificationService $adminNotificationService
    ) {}
    protected function filterColumn(string $value): string
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
    }
    //ساختار لاگین ادمین
    // در AdminService.php
    public function login(array $credentials): array
    {
        $field = $this->filterColumn($credentials['userName']);
        $admin = Admin::where($field, $credentials['userName'])->first();

        if (! $admin) {
            return ['success' => false, 'message' => trans('errors.username_not_found')];
        }

        if (! Hash::check($credentials['password'], $admin->password)) {
            return ['success' => false, 'message' => trans('errors.password_incorect')];
        }

        if (! $admin->isActive()) {
            return ['success' => false, 'message' => trans('errors.status_id_inactive')];
        }

        // آیا نیاز به مرحله ۲ هست؟
        $needsSms  = (bool) $admin->otp_enabled;
        $needsTotp = (bool) $admin->two_factor_enabled; // از accessor مدل

        if ($needsSms || $needsTotp) {
            return [
                'success'            => true,
                'challenge_required' => true,
                'admin'              => $admin,
                'needs'              => [
                    'sms'  => $needsSms,
                    'totp' => $needsTotp,
                ],
            ];
        }
        $message = [
            'titleFa' => 'ورود ادمین',
            'descFa'  => " ورود ادمین {$admin->full_name}با موفقیت انجام شد",
        ];
        app($this->adminNotificationService->createInternalForAdmin($admin->id, $message));
        // اگر مرحله ۲ لازم نیست، لاگین نهایی همینجا
        auth('admin')->login($admin);

        return [
            'success'            => true,
            'challenge_required' => false,
            'message'            => 'ورود موفقیت‌آمیز بود.',
        ];
    }

    // log out
    public function logout(): array
    {
        try {
            // گرفتن اطلاعات کاربر قبل از لاگ‌اوت
            $admin = Auth::guard('admin')->user();

            // انجام لاگ‌اوت
            Auth::guard('admin')->logout();
            // ارسال اعلان خروج ادمین
            $message = [
                'titleFa' => 'خروج ادمین',
                'descFa'  => " خروج ادمین {$admin->full_name}با موفقیت انجام شد",
            ];
            app($this->adminNotificationService->createInternalForAdmin($admin->id, $message));
            // آماده کردن داده‌های پاسخ
            $response = [
                'success' => true,
                'message' => trans('auth.logout_success'),
            ];

            // اگر کاربر وجود داشت، اطلاعات را اضافه کن
            if ($admin) {
                $response['user'] = [
                    'id'    => $admin->id,
                    'name'  => $admin->name,
                    'email' => $admin->email,
                ];
                // لاگ کردن خروج (اختیاری)
                Log::channel('admin_activity')->info('Admin logged out', [
                    'admin_id'      => $admin->id,
                    'admin_name'    => $admin->name,
                    'admin_email'   => $admin->email,
                    'logged_out_at' => now()->toDateTimeString(),
                ]);
            }
            return $response;
        } catch (\Exception $e) {
            // لاگ کردن خطا
            Log::error('Logout failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => trans('errors.logout_failed'),
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ];
        }
    }
}
