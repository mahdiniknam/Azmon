<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Transaction;
use App\Services\PaymentService;
use App\Services\ZarinpalService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function checkout(Exam $exam)
    {
        $user = auth()->user();
        $amount = $this->paymentService->calculateAmount($exam, $user);

        if ($amount <= 0) {
            return redirect()->route('student.exams.show', $exam)
                ->with('success', 'این آزمون رایگان است.');
        }

        if ($user->hasPaidForExam($exam)) {
            return redirect()->route('student.exams.show', $exam)
                ->with('success', 'قبلا پرداخت کرده‌اید.');
        }

        return view('payment.checkout', compact('exam', 'amount', 'user'));
    }

    public function pay(Exam $exam)
    {
        $user = auth()->user();

        if ($user->hasPaidForExam($exam)) {
            return redirect()->route('student.exams.show', $exam);
        }

        $result = $this->paymentService->initPayment($user, $exam);

        if ($result['error'] ?? false) {
            return back()->with('error', $result['message'] ?? 'خطا در پرداخت');
        }

        return redirect()->away($result['gateway_url']);
    }

    public function walletPay(Exam $exam)
    {
        $user = auth()->user();

        if ($user->hasPaidForExam($exam)) {
            return redirect()->route('student.exams.show', $exam)
                ->with('success', 'قبلا پرداخت کرده‌اید.');
        }

        if ($this->paymentService->payFromWallet($user, $exam)) {
            return redirect()->route('student.exams.show', $exam)
                ->with('success', 'پرداخت با موفقیت از کیف پول انجام شد.');
        }

        return back()->with('error', 'موجودی کیف پول کافی نیست.');
    }

    // کال‌بک زرین پال
    public function zarinpalCallback(Request $request, ZarinpalService $zarinpal)
    {
        $authority = $request->get('Authority');
        $status = $request->get('Status');

        $transactionId = session('zp_transaction_id');
        $amount = (int) session('zp_amount', 0);

        $transaction = null;

        if ($transactionId) {
            $transaction = Transaction::find($transactionId);
        }

        // اگه سشن نبود با authority پیدا کن
        if (! $transaction && $authority) {
            $transaction = Transaction::where('tracking_code', $authority)->first();
        }

        if (! $transaction) {
            return redirect()->route('student.payments.wallet')
                ->with('error', 'تراکنش پیدا نشد.');
        }

        if ($amount <= 0) {
            $amount = (int) $transaction->amount;
        }

        if ($status !== 'OK') {
            $transaction->update(['status' => false]);
            session()->forget(['zp_transaction_id', 'zp_amount']);

            return redirect()->route('payment.result', $transaction);
        }

        $verify = $zarinpal->verify($authority, $amount);

        if ($verify['success']) {
            $this->paymentService->confirmPayment($transaction);
        } else {
            $transaction->update(['status' => false]);
        }

        session()->forget(['zp_transaction_id', 'zp_amount']);

        return redirect()->route('payment.result', $transaction);
    }

    // شبیه‌ساز قدیمی - نگه داشتم شاید لازم شد
    public function fakeGateway(Transaction $transaction)
    {
        return view('payment.fake-gateway', compact('transaction'));
    }

    public function callback(Request $request, Transaction $transaction)
    {
        $success = $request->input('success') == '1';

        if ($success) {
            $this->paymentService->confirmPayment($transaction);
        } else {
            $transaction->update(['status' => false]);
        }

        return redirect()->route('payment.result', $transaction);
    }

    public function result(Transaction $transaction)
    {
        return view('payment.result', compact('transaction'));
    }

    public function calculateShare(Request $request)
    {
        return response()->json(['ok' => true]);
    }
}
