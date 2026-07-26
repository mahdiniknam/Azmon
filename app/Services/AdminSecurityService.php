<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\GoogleAuth;
use Illuminate\Support\Facades\DB;

class AdminSecurityService
{
    public function __construct(
        protected Google2FAService $google2FA
    ) {}

    /* ===================== INDEX DATA ===================== */
    public function getIndexData(Admin $admin): array
    {
        return [
            'twoFactorDevices' => $admin->googleAuths()->get(),
            'activeSessions'  => $this->getActiveSessions($admin),
        ];
    }

    /* ===================== SESSIONS ===================== */
    protected function getActiveSessions(Admin $admin)
    {
        return DB::table('sessions')
            ->where('user_id', $admin->id)
            ->orderByDesc('last_activity')
            ->get()
            ->map(fn($s) => (object) [
                'id'            => $s->id,
                'ip_address'    => $s->ip_address,
                'device'        => str_contains($s->user_agent, 'Mobile') ? 'Mobile' : 'Desktop',
                'platform'      => str_contains($s->user_agent, 'Windows') ? 'Windows' : 'Other',
                'browser'       => str_contains($s->user_agent, 'Chrome') ? 'Chrome' : 'Other',
                'last_activity' => now()->setTimestamp($s->last_activity),
            ]);
    }

    public function logoutDevice(string $sessionId): void
    {
        DB::table('sessions')->where('id', $sessionId)->delete();
    }

    /* ===================== SMS OTP ===================== */
    public function toggleSms(Admin $admin): void
    {
        $admin->update([
            'otp_enabled' => ! $admin->otp_enabled
        ]);
    }
}
