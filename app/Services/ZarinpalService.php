<?php

namespace App\Services;

use App\Models\Gateway;
use Illuminate\Support\Facades\Http;

class ZarinpalService
{
    public function request(int $amount, string $description, string $callbackUrl): array
    {
        $config = $this->getConfig();
        $merchantId = $config['merchantId'] ?? env('ZARINPAL_MERCHANT_ID');
        $mode = $config['mode'] ?? env('ZARINPAL_MODE', 'sandbox');

        // sandbox و normal
        $isSandbox = $mode === 'sandbox';

        $apiUrl = $isSandbox
            ? 'https://sandbox.zarinpal.com/pg/v4/payment/request.json'
            : 'https://api.zarinpal.com/pg/v4/payment/request.json';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($apiUrl, [
            'merchant_id' => $merchantId,
            'amount' => $amount,
            'description' => $description,
            'callback_url' => $callbackUrl,
        ]);

        $body = $response->json();
        $authority = $body['data']['authority'] ?? null;
        $code = $body['data']['code'] ?? 0;

        $startPayBase = $isSandbox
            ? 'https://sandbox.zarinpal.com/pg/StartPay/'
            : 'https://www.zarinpal.com/pg/StartPay/';

        return [
            'success' => $response->ok() && $code === 100 && $authority,
            'payment_url' => $authority ? $startPayBase . $authority : null,
            'authority' => $authority,
            'raw' => $body,
        ];
    }

    public function verify(string $authority, int $amount): array
    {
        $config = $this->getConfig();
        $merchantId = $config['merchantId'] ?? env('ZARINPAL_MERCHANT_ID');
        $mode = $config['mode'] ?? env('ZARINPAL_MODE', 'sandbox');
        $isSandbox = $mode === 'sandbox';

        $apiUrl = $isSandbox
            ? 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json'
            : 'https://api.zarinpal.com/pg/v4/payment/verify.json';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($apiUrl, [
            'merchant_id' => $merchantId,
            'amount' => $amount,
            'authority' => $authority,
        ]);

        $body = $response->json();
        $code = $body['data']['code'] ?? 0;

        return [
            'success' => $response->ok() && in_array($code, [100, 101]),
            'message' => $body['errors']['message'] ?? ($body['data']['message'] ?? 'ok'),
            'ref_id' => $body['data']['ref_id'] ?? null,
            'raw' => $body,
        ];
    }

    private function getConfig(): array
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
