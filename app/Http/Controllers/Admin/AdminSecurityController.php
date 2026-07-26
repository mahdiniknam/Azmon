<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\GoogleAuth;
use App\Services\AdminSecurityService;
use App\Services\Google2FAService;
use Illuminate\Http\Request;

class AdminSecurityController extends Controller
{
    public function __construct(
        protected AdminSecurityService $service,
        protected Google2FAService $google2FAService,
    ) {}

    public function index(Admin $admin)
    {
        $data = $this->service->getIndexData($admin);

        return view('admin.pages.admins.security', [
            'admin'            => $admin,
            'twoFactorDevices' => $data['twoFactorDevices'],
            'activeSessions'   => $data['activeSessions'],
        ]);
    }

    public function generateGoogle2FA(Admin $admin)
    {
        $data = $this->google2FAService->generate($admin);
        return back()->with([
            'twoFactorData' => $data,
            'show2faModal'  => true,
        ]);
    }

    public function verifyGoogle2FA(Request $request, Admin $admin)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);
        $secret = $request->get('secret');
        if (! $secret) {
            return back()->withErrors(['otp' => __('errors.session_expired')]);
        }

        if (! $this->google2FAService->verify($admin, $secret, $request->otp)) {
            return back()->withErrors(['otp' => __('errors.invalid_otp')]);
        }

        return back()->with('success', __('errors.google_2fa_activated'));
    }

    public function toggleGoogle2FA(Request $request)
    {
        $device = GoogleAuth::findOrFail($request->device_id);

        return back()->with([
            'showOtpModal' => true,
            'twoFactorDeviceId' => $device->id,
            'twoFactorAction' => 'toggle',
        ]);
    }

    public function deleteGoogle2FA(Request $request)
    {
        $device = GoogleAuth::findOrFail($request->device_id);

        return back()->with([
            'showOtpModal' => true,
            'twoFactorDeviceId' => $device->id,
            'twoFactorAction' => 'delete',
        ]);
    }


    public function verify2FAAction(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:google_auths,id',
            'otp' => 'required|digits:6',
            'action' => 'required|in:toggle,delete',
        ]);

        $device = GoogleAuth::findOrFail($request->device_id);

        if (! $this->google2FAService->verifyOtp($device, $request->otp)) {
            return back()->withErrors(['otp' => __('errors.invalid_otp')]);
        }

        match ($request->action) {
            'toggle' => $this->google2FAService->confirmToggle($device),
            'delete' => $this->google2FAService->delete($device),
        };

        return back()->with('success', __('errors.operation_success'));
    }


    public function logoutDevice(Request $request)
    {
        $this->service->logoutDevice($request->session_id);

        return back()->with('success', __('errors.device_logged_out'));
    }

    public function toggleSms(Admin $admin)
    {
        $this->service->toggleSms($admin);

        return back()->with('success', __('errors.operation_success'));
    }
}
