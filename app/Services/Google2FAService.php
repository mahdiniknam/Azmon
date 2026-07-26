<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\GoogleAuth;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Google2FAService
{
    protected Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    public function generate(Admin $admin): array
    {
        $secret = $this->google2fa->generateSecretKey();

        $qrUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $admin->email,
            $secret
        );

        // فقط دیتا – هیچ ذخیره‌ای، هیچ QR Image
        return [
            'secret' => $secret,
            'qrUrl'  => $qrUrl,
        ];
    }

    public function verify(Admin $admin, string $secret, string $otp): bool
    {
        if (! $this->google2fa->verifyKey($secret, $otp)) {
            return false;
        }

        $qrUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $admin->email,
            $secret
        );
        $admin->googleAuths()->create([
            'secret'      => $secret,
            'url'         => $qrUrl,
            'is_enabled'  => true,
            'verified_at' => now(),
        ]);

        return true;
    }
    public function verifyOtp(GoogleAuth $device, string $otp): bool
    {
        return $this->google2fa->verifyKey(
            $device->secret,
            $otp
        );
    }


    public function confirmToggle(GoogleAuth $device): void
    {
        $device->update([
            'is_enabled' => ! $device->is_enabled
        ]);
    }

    public function delete(GoogleAuth $device): void
    {
        $device->delete();
    }
}
