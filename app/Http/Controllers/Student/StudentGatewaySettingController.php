
<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentGatewaySettingController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        return view('student.settings.gateway', compact('student'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'merchant_id' => 'required',
            'sandbox' => 'nullable|boolean',
        ]);

        Setting::updateOrCreate(
            ['key' => 'gateway.zarinpal.merchant_id'],
            ['value' => $request->merchant_id]
        );

        Setting::updateOrCreate(
            ['key' => 'gateway.zarinpal.sandbox'],
            ['value' => $request->boolean('sandbox') ? 1 : 0]
        );

        return back()->with('success', 'تنظیمات درگاه ذخیره شد.');
    }
}

