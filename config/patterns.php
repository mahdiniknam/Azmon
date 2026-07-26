<?php

use App\Models\PatternOption;

return [

    /*
    |--------------------------------------------------------------------------
    | EMAIL PATTERNS
    |--------------------------------------------------------------------------
    | اینجا متن/تمپلیت ایمیل‌ها (یا محتوای ایمیل) رو نگه می‌داریم
    | کاربر فقط value رو توی Setting تغییر میده
    */
    'email' => [
        'user' => [
            [
                'key' => PatternOption::USER_OTP_PATTERN,
                'default_value' => [
                    'fa' => 'کاربر گرامی، کد تایید شما %code% است.',
                    'en' => 'Dear user, your verification code is %code%.',
                ],
                'label' => 'general.pattern.opt_code',
            ],
            [
                'key' => PatternOption::USER_CHANGE_MOBILE,
                'default_value' => [
                    'fa' => 'برای تغییر شماره موبایل، کد تایید %code% را وارد کنید.',
                    'en' => 'To change your mobile number, enter the verification code %code%.',
                ],
                'label' => 'general.pattern.change_mobile_opt_code',
            ],
            [
                'key' => PatternOption::USER_CHANGE_EMAIL,
                'default_value' => [
                    'fa' => 'برای تغییر ایمیل، کد تایید %code% را وارد کنید.',
                    'en' => 'To change your email, enter the verification code %code%.',
                ],
                'label' => 'general.pattern.change_email_opt_code',
            ],
            [
                'key' => PatternOption::USER_CHANGE_PASSWORD,
                'default_value' => [
                    'fa' => 'برای تغییر رمز عبور، کد تایید شما %code% است.',
                    'en' => 'To change your password, your verification code is %code%.',
                ],
                'label' => 'general.pattern.change_password_opt_code',
            ],
            [
                'key' => PatternOption::USER_REGISTER_SUCCESS,
                'default_value' => [
                    'fa' => 'کاربر گرامی، ثبت‌نام شما با موفقیت انجام شد.',
                    'en' => 'Dear user, your registration was successful.',
                ],
                'label' => 'general.pattern.user_register_success',
            ],
            [
                'key' => PatternOption::USER_NEW_LOGIN,
                'default_value' => [
                    'fa' => 'کاربر گرامی، یک ورود جدید با آی‌پی %ip_address% به حساب کاربری شما انجام شد.',
                    'en' => 'Dear user, a new login to your account was made from IP %ip_address%.',
                ],
                'label' => 'general.pattern.new_login',
            ],
            [
                'key' => PatternOption::USER_SUCCESS_SWAP,
                'default_value' => [
                    'fa' => 'کاربر گرامی، سواپ رمز ارز %from_currency% به %to_currency% به مقدار %amount% با موفقیت انجام شد.',
                    'en' => 'Dear user, the swap of %from_currency% to %to_currency% with the amount of %amount% has been successfully completed.',
                ],
                'label' => 'general.pattern.user_success_swap',
            ],

            [
                'key' => PatternOption::USER_REJECT_SWAP,
                'default_value' => [
                    'fa' => 'کاربر گرامی، سواپ رمز ارز %from_currency% به %to_currency% به مقدار %amount% توسط سایت انجام نشد.',
                    'en' => 'Dear user, the swap of %from_currency% to %to_currency% with the amount of %amount% was not completed by the system.',
                ],
                'label' => 'general.pattern.user_reject_swap',
            ],
            [
                'key' => PatternOption::USER_WITHDRAW_OTP,
                'default_value' => [
                    'fa' => 'کاربر گرامی کد تایید برداشت از کیف پول شما %code% میباشد.',
                    'en' => 'Dear user, your wallet withdrawal verification code is %code%.',
                ],
                'label' => 'general.pattern.user_withdraw_otp',
            ],
            [
                'key' => PatternOption::USER_STAKING,
                'default_value' => [
                    'fa' => 'کاربر گرامی، استیک شماره %id% شما  %status% شد.',
                    'en' => 'Dear user, your staking number %id% has  %status%.',
                ],
                'label' => 'general.pattern.user_staking',
            ],
            [
                'key' => PatternOption::USER_NOTIFICATION,
                'default_value' => [
                    'fa' => 'کاربر گرامی، به اطلاع می‌رسانیم %message% . با تشکر.',
                    'en' => 'Dear user, we inform you that %message%. Thank you.',
                ],
                'label' => 'general.pattern.user_notification',
            ],
            [
                'key' => PatternOption::USER_SUCCESS_DEPOSIT,
                'default_value' => [
                    'fa' => 'کاربر گرامی، واریز %currency% به مقدار %amount% روی شبکه %network% با موفقیت انجام شد.',
                    'en' => 'Dear user, your deposit of %amount% %currency% on the %network% network was successful.',
                ],
                'label' => 'general.pattern.user_success_deposit',
            ],
            [
                'key' => PatternOption::USER_FISHING,
                'default_value' => [
                    'fa' => 'با سلام و احترام،
کاربر گرامی، با توجه به بررسی‌های انجام‌شده، تراکنش شماره %transaction_id% به مبلغ %amount% از طریق یک کارت بانکی غیرمجاز (که در بخش کارت‌های بانکی پنل کاربری شما تأیید نشده است) انجام شده است.',
                    'en' => 'Dear User,
Following our investigations, transaction number %transaction_id% with the amount of %amount% has been made using an unauthorized bank card that has not been verified in your user panel.
',
                ],
                'label' => 'general.pattern.user_fishing',
            ],
            // ... بقیه user email ها
        ],

        'admin' => [
            [
                'key' => PatternOption::ADMIN_OTP_PATTERN,
                'default_value' => [
                    'fa' => 'مدیر گرامی، کد تایید شما %code% است.',
                    'en' => 'Dear admin, your verification code is %code%.',
                ],
                'label' => 'general.pattern.opt_code',
            ],
            [
                'key' => PatternOption::ADMIN_NEW_TICKET,
                'default_value' => [
                    'fa' => 'مدیر گرامی، تیکت جدید با شماره %ticket_id% با عنوان "%title%" توسط کاربر %user_id% با وضعیت %status% ثبت شد.',
                    'en' => 'Dear admin, a ticket #%ticket_id% with title "%title%" was %status% by user %user_id%.',
                ],
                'label' => 'general.pattern.new_ticket',
            ],
            [
                'key' => PatternOption::ADMIN_LOGIN,
                'default_value' => [
                    'fa' => 'مدیر گرامی، %admin_name% هم اکنون وارد پنل ادمین شد.',
                    'en' => 'Dear admin, %admin_name% has logged into the admin panel.',
                ],
                'label' => 'general.pattern.new_login',
            ],
            [
                'key' => PatternOption::ADMIN_LOGIN_IP,
                'default_value' => [
                    'fa' => 'مدیر گرامی، شما هم اکنون با آی‌پی %ip_address% وارد پنل ادمین شدید.',
                    'en' => 'Dear admin, you just logged into the admin panel with IP %ip_address%.',
                ],
                'label' => 'general.pattern.new_login_with_ip',
            ],

            [
                'key' => PatternOption::ADMIN_SUCCESS_SWAP,
                'default_value' => [
                    'fa' => 'مدیر گرامی، سواپ رمز ارز %from_currency% به %to_currency% به مقدار %amount% با موفقیت انجام شد.',
                    'en' => 'Dear admin, the swap of %from_currency% to %to_currency% with the amount of %amount% has been successfully completed.',
                ],
                'label' => 'general.pattern.admin_success_swap',
            ],
            [
                'key' => PatternOption::ADMIN_FAIL_SWAP,
                'default_value' => [
                    'fa' => 'مدیر گرامی، سواپ رمز ارز %from_currency% به %to_currency% به مقدار %amount% توسط تامین کننده انجام نشد.',
                    'en' => 'Dear admin, the swap of %from_currency% to %to_currency% with the amount of %amount% was not completed by the supplier.',
                ],
                'label' => 'general.pattern.admin_fail_swap',
            ],
            [
                'key' => PatternOption::ADMIN_REJECT_SWAP,
                'default_value' => [
                    'fa' => 'مدیر گرامی، سواپ رمز ارز %from_currency% به %to_currency% به مقدار %amount% به علت مشخص نکردن وضعیت نهایی آن توسط سایت رد شد.',
                    'en' => 'Dear admin, the swap of %from_currency% to %to_currency% with the amount of %amount% was rejected by the system due to the final status not being specified.',
                ],
                'label' => 'general.pattern.admin_reject_swap',
            ],
            [
                'key' => PatternOption::ADMIN_WAITING_SWAP,
                'default_value' => [
                    'fa' => 'مدیر گرامی، سواپ رمز ارز %from_currency% به %to_currency% به مقدار %amount% در وضعیت انتظار است و هنوز وضعیت نهایی مشخص نشده است.',
                    'en' => 'Dear admin, the swap of %from_currency% to %to_currency% with the amount of %amount% is currently pending and the final status has not been determined yet.',
                ],
                'label' => 'general.pattern.admin_waiting_swap',
            ],
            [
                'key' => PatternOption::ADMIN_SUCCESS_DEPOSIT,
                'default_value' => [
                    'fa' => 'مدیر گرامی، واریز %currency% به مقدار %amount% روی شبکه %network% توسط کاربر با شناسه %user% با موفقیت انجام شد.',
                    'en' => 'Dear admin, a deposit of %amount% %currency% by user with Id %user% on the %network% network was successfully completed.',
                ],
                'label' => 'general.pattern.admin_success_deposit',
            ],
            // ... بقیه admin email ها
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | SMS PATTERNS (نمونه)
    |--------------------------------------------------------------------------
    | اینجا یک نمونه گذاشتم تا بدونی چطور اضافه کنی.
    | key ها بهتره مثل email همان key ها باشند (مثلا USER_OTP_PATTERN)
    | ولی تایپش TYPE_SMS میشه.
    */
    'sms' => [
        'user' => [
            [
                'key' => PatternOption::USER_OTP_PATTERN,
                'default_value' => [
                    'fa' => 102225
                ],

                'label' => 'general.pattern.opt_code',
            ],
        ],

        'admin' => [
            [
                'key' => PatternOption::ADMIN_NEW_TICKET,
                'default_value' => [
                    'fa' => 102225
                ],
                'label' => 'general.pattern.new_ticket',
            ],
        ],
    ],

];
