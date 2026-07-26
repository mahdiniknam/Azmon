<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatternOption extends Model
{
    // Type Const
    public const TYPE_SMS = 1;
    public const TYPE_EMAIL = 2;

    // ==== Admin Notifications ====
    public const ADMIN_OTP_PATTERN = 'admin_otp_pattern';
    public const ADMIN_NEW_TICKET = 'admin_new_ticket';
    public const ADMIN_LOGIN = 'admin_login';
    public const ADMIN_LOGIN_IP = 'admin_login_ip';
    public const ADMIN_SUCCESS_SWAP = 'admin_success_swap';
    public const ADMIN_FAIL_SWAP = 'admin_fail_swap';
    public const ADMIN_REJECT_SWAP = 'admin_reject_swap';
    public const ADMIN_WAITING_SWAP = 'admin_waiting_swap';
    public const ADMIN_SUCCESS_DEPOSIT = 'admin_success_deposit';

    // ==== User Notifications ====
    public const USER_OTP_PATTERN = 'user_otp_pattern';
    public const USER_CHANGE_MOBILE = 'user_change_mobile';
    public const USER_CHANGE_EMAIL = 'user_change_email';
    public const USER_CHANGE_PASSWORD = 'user_change_password';
    public const USER_REGISTER_SUCCESS = 'user_register_success';
    public const USER_NEW_LOGIN = 'user_new_login';
    public const USER_SUCCESS_SWAP = 'user_success_swap';
    public const USER_REJECT_SWAP = 'user_reject_swap';
    public const USER_WITHDRAW_OTP = 'user_withdraw_otp';
    public const USER_STAKING = 'user_staking';
    public const USER_NOTIFICATION = 'user_notification';
    public const USER_SUCCESS_DEPOSIT = 'user_success_deposit';
    public const USER_FISHING = 'user_fishing';

    // ==== Localization ====
    public const LANG_FA = 'fa';
    public const LANG_EN = 'en';

    protected $fillable = [
        'key',
        'type',
        'local',
        'value',
        'description',
    ];

    protected $casts = [
        'type' => 'integer',
    ];

    public function scopeEmail($q) { return $q->where('type', self::TYPE_EMAIL); }
    public function scopeSms($q)   { return $q->where('type', self::TYPE_SMS); }

    public static function getValue(string $key, int $type, ?string $locale = null, mixed $default = null): mixed
    {
        $locale = $locale ?? app()->getLocale();

        $row = static::query()
            ->where('key', $key)
            ->where('type', $type)
            ->where('local', $locale)
            ->first();

        return $row?->value ?? $default;
    }
}
