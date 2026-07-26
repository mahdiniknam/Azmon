<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\Gateway;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Str;

class PaymentService
{
    public function __construct(private ZarinpalService $zarinpal)
    {
    }

    // پرداخت آزمون از درگاه زرین پال
    public function initPayment(User $user, Exam $exam): array
    {
        $amount = $this->calculateAmount($exam, $user);

        if ($amount <= 0) {
            return ['error' => true, 'message' => 'مبلغ پرداخت معتبر نیست.'];
        }

        $transaction = Transaction::create([
            'user_type' => get_class($user),
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'deposit',
            'exam_id' => $exam->id,
            'gateway' => 'zarinpal',
            'status' => false,
            'tracking_code' => null,
        ]);

        $callbackUrl = route('payment.zarinpal.callback');

        $result = $this->zarinpal->request(
            (int) $amount,
            'پرداخت آزمون: ' . $exam->title,
            $callbackUrl
        );

        if (! ($result['success'] ?? false)) {
            return [
                'error' => true,
                'message' => 'خطا در اتصال به درگاه. لطفا دوباره تلاش کنید.',
                'transaction' => $transaction,
            ];
        }

        $transaction->update([
            'tracking_code' => $result['authority'],
        ]);

        // authority رو تو سشن نگه میداریم برای کال‌بک
        session([
            'zp_transaction_id' => $transaction->id,
            'zp_amount' => $amount,
        ]);

        return [
            'error' => false,
            'transaction' => $transaction,
            'gateway_url' => $result['payment_url'],
        ];
    }

    // شارژ کیف پول از زرین پال
    public function initWalletCharge(User $user, int $amount): array
    {
        if ($amount < 1000) {
            return ['error' => true, 'message' => 'حداقل مبلغ شارژ ۱۰۰۰ تومان است.'];
        }

        $transaction = Transaction::create([
            'user_type' => get_class($user),
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'deposit',
            'exam_id' => null,
            'gateway' => 'zarinpal',
            'status' => false,
            'tracking_code' => null,
        ]);

        $callbackUrl = route('payment.zarinpal.callback');

        $result = $this->zarinpal->request(
            $amount,
            'شارژ کیف پول',
            $callbackUrl
        );

        if (! ($result['success'] ?? false)) {
            return [
                'error' => true,
                'message' => 'خطا در اتصال به درگاه. لطفا دوباره تلاش کنید.',
                'transaction' => $transaction,
            ];
        }

        $transaction->update([
            'tracking_code' => $result['authority'],
        ]);

        session([
            'zp_transaction_id' => $transaction->id,
            'zp_amount' => $amount,
        ]);

        return [
            'error' => false,
            'transaction' => $transaction,
            'gateway_url' => $result['payment_url'],
        ];
    }

    // پرداخت از کیف پول
    public function payFromWallet(User $user, Exam $exam): bool
    {
        $amount = $this->calculateAmount($exam, $user);

        if ($amount <= 0) {
            $exam->students()->syncWithoutDetaching([$user->id => ['is_paid' => true]]);

            return true;
        }

        if ($user->wallet_balance < $amount) {
            return false;
        }

        $user->decrement('wallet_balance', $amount);

        Transaction::create([
            'user_type' => get_class($user),
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'withdraw',
            'exam_id' => $exam->id,
            'gateway' => 'wallet',
            'status' => true,
            'tracking_code' => 'W-' . strtoupper(Str::random(8)),
        ]);

        $exam->students()->syncWithoutDetaching([$user->id => ['is_paid' => true]]);

        return true;
    }

    public function calculateAmount(Exam $exam, User $user): int
    {
        if (($exam->price ?? 0) <= 0) {
            return 0;
        }

        // اگه استاد باید پرداخت کنه، دانشجو رایگان شرکت میکنه
        if ($exam->payment_type === 'creator') {
            return 0;
        }

        return (int) $exam->price;
    }

    // تأیید پرداخت موفق
    public function confirmPayment(Transaction $transaction): bool
    {
        if ($transaction->status) {
            return true;
        }

        $transaction->update(['status' => true]);

        // شارژ کیف پول (بدون آزمون)
        if (! $transaction->exam_id && $transaction->type === 'deposit') {
            $user = $transaction->user;
            if ($user) {
                $user->increment('wallet_balance', (int) $transaction->amount);
            }

            return true;
        }

        // پرداخت آزمون
        if ($transaction->exam_id) {
            $exam = $transaction->exam;
            if ($exam) {
                if ($exam->payment_type === 'creator') {
                    $exam->update(['is_paid' => true]);
                } else {
                    $exam->students()->syncWithoutDetaching([
                        $transaction->user_id => ['is_paid' => true],
                    ]);
                }
            }
        }

        return true;
    }

    // تنظیمات درگاه فعال از پنل ادمین
    public function getActiveZarinpalConfig(): array
    {
        $gateway = Gateway::query()
            ->where('driver', 'zarinpal')
            ->where('is_active', true)
            ->first();

        if ($gateway && is_array($gateway->config)) {
            return $gateway->config;
        }

        return [
            'merchantId' => env('ZARINPAL_MERCHANT_ID', ''),
            'mode' => env('ZARINPAL_MODE', 'sandbox'),
        ];
    }
}
