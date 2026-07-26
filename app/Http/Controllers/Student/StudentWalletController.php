
<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\ZarinpalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentWalletController extends Controller
{
    public function __construct(private ZarinpalService $zarinpal) {}

    public function index()
    {
        $student = Auth::guard('student')->user();
        $wallet = $student->wallet()->firstOrCreate([]);

        return view('student.wallet.index', compact('student', 'wallet'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1000',
        ]);

        $student = Auth::guard('student')->user();
        $amount = $request->amount;

        $payment = $this->zarinpal->request(
            amount: $amount,
            description: 'شارژ کیف پول دانشجو',
            callbackUrl: route('student.wallet.callback')
        );

        return redirect()->away($payment['payment_url']);
    }

    public function callback(Request $request)
    {
        $student = Auth::guard('student')->user();
        $wallet = $student->wallet()->firstOrCreate([]);

        $result = $this->zarinpal->verify(
            authority: $request->get('Authority'),
            amount: $request->get('amount', 0)
        );

        if ($result['success']) {
            $wallet->increment('balance', $request->get('amount', 0));
            $wallet->save();
            return redirect()->route('student.wallet.index')->with('success', 'کیف پول با موفقیت شارژ شد.');
        }

        return redirect()->route('student.wallet.index')->with('error', 'شارژ کیف پول با شکست مواجه شد.');
    }
}
