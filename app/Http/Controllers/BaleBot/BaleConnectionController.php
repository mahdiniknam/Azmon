<?php

namespace App\Http\Controllers\BaleBot;

use App\Http\Controllers\Controller;
use App\Models\BaleAccountLink;
use Illuminate\Http\Request;

class BaleConnectionController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        BaleAccountLink::where('user_id', $user->id)
            ->whereNull('used_at')
            ->delete();

        $link = BaleAccountLink::create([
            'user_id' => $user->id,
            'code' => (string) random_int(100000, 999999),
            'expires_at' => now()->addMinutes(10),
        ]);

        return back()->with('bale_connect_code', $link->code);
    }

    public function disconnect(Request $request)
    {
        $user = $request->user();
        $user->update([
            'bale_chat_id' => null,
            'bale_linked_at' => null,
        ]);

        return back()->with('success', 'اتصال بله حذف شد.');
    }
}
