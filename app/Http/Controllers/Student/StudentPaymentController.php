<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class StudentPaymentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $transactions = Transaction::where('user_id', $user->id)
            ->where('user_type', get_class($user))
            ->with('exam')
            ->latest()
            ->paginate(15);

        return view('student.pages.payments.index', compact('transactions'));
    }

    public function wallet()
    {
        $user = auth()->user();
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->where('user_type', get_class($user))
            ->latest()
            ->take(5)
            ->get();

        return view('student.pages.payments.wallet', compact('user', 'recentTransactions'));
    }

    // شارژ کیف پول با زرین پال
    public function charge(Request $request, PaymentService $paymentService)
    {
        $request->validate([
            'amount' => 'required|integer|min:1000',
        ], [
            'amount.required' => 'مبلغ را وارد کنید.',
            'amount.min' => 'حداقل مبلغ ۱۰۰۰ تومان است.',
        ]);

        $user = auth()->user();
        $result = $paymentService->initWalletCharge($user, (int) $request->amount);

        if ($result['error'] ?? false) {
            return back()->with('error', $result['message'] ?? 'خطا در اتصال به درگاه');
        }

        return redirect()->away($result['gateway_url']);
    }
}
