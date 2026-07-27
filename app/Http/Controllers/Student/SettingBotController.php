<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingBotController extends Controller
{
    public function show(Request $request)
    {
        return view('student.pages.botBale.show', [
            'user' => $request->user(),
            'activeBaleCode' => $request->user()->baleLinks()
                ->whereNull('used_at')
                ->where('expires_at', '>', now())
                ->latest()
                ->first(),
            'baleBotUsername' => 'https://ble.ir/Azmonsaz_bot',
        ]);
    }
}
