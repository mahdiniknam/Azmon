<?php
// resources/lang/fa/errors.php
return [
    // General errors
    'validation' => 'اطلاعات ارسال شده معتبر نیست.',
    'unauthorized' => 'دسترسی غیرمجاز است.',
    'forbidden' => 'دسترسی ممنوع است.',
    'not_found' => 'منبع مورد نظر پیدا نشد.',
    'method_not_allowed' => 'متد درخواستی مجاز نیست.',
    'server_error' => 'خطای داخلی سرور.',
    'service_unavailable' => 'سرویس در دسترس نیست.',
    'too_many_requests' => 'تعداد درخواست‌ها بیش از حد مجاز است.',
    'action_failed' => 'عملیات انجام نشد.',
    'something_wrong' => 'مشکلی پیش آمده است.',
    'bad_request' => 'درخواست نامعتبر است.',
    'timeout' => 'زمان درخواست به پایان رسیده است.',

    // Authentication errors
    'invalid_login' => 'اطلاعات ورود اشتباه است.',
    'unauthenticated' => 'احراز هویت انجام نشده است.',
    'token_expired' => 'توکن منقضی شده است.',
    'token_invalid' => 'توکن نامعتبر است.',
    'token_missing' => 'توکن ارسال نشده است.',
    'session_expired' => 'جلسه منقضی شده است.',

    // OTP errors
    'invalid_otp' => 'کد وارد شده نامعتبر یا منقضی شده است.',
    'otp_expired' => 'کد OTP منقضی شده است.',
    'otp_required' => 'وارد کردن کد OTP الزامی است.',
    'otp_send_failed' => 'ارسال کد OTP با خطا مواجه شد.',
    'otp_attempts_exceeded' => 'تعداد تلاش‌های OTP بیش از حد مجاز است.',

    // Registration errors
    'password_incorect' => 'رمز عبور اشتباه است.',
    'email_taken' => 'ایمیل قبلا ثبت شده است.',
    'mobile_taken' => 'شماره موبایل قبلا ثبت شده است.',
    'password_mismatch' => 'رمز عبور و تکرار آن یکسان نیست.',
    'user_not_found' => 'کاربری با این اطلاعات یافت نشد.',
    'invalid_password' => 'رمز عبور اشتباه است.',
    'password_complexity' => 'رمز عبور باید حداقل شامل یک حرف بزرگ، یک حرف کوچک و یک عدد باشد.',
    'mobile_not_verified' => 'شماره موبایل شما هنوز تایید نشده است.',
    'email_not_verified' => 'ایمیل شما هنوز تایید نشده است.',
    'account_disabled' => 'حساب کاربری غیرفعال شده است.',
    'account_pending' => 'حساب کاربری در حالت انتظار است.',
    'account_locked' => 'حساب کاربری قفل شده است.',

    // User errors
    'profile_update_failed' => 'به روزرسانی پروفایل با خطا مواجه شد.',
    'password_update_failed' => 'تغییر رمز عبور با خطا مواجه شد.',
    'current_password_incorrect' => 'رمز عبور فعلی اشتباه است.',
    'user_update_failed' => 'به روزرسانی کاربر با خطا مواجه شد.',
    'user_delete_failed' => 'حذف کاربر با خطا مواجه شد.',
    'user_create_failed' => 'ایجاد کاربر با خطا مواجه شد.',

    // File errors
    'file_upload_failed' => 'آپلود فایل با خطا مواجه شد.',
    'file_too_large' => 'حجم فایل بسیار بزرگ است.',
    'file_type_not_allowed' => 'نوع فایل مجاز نیست.',
    'file_not_found' => 'فایل مورد نظر پیدا نشد.',
    'file_delete_failed' => 'حذف فایل با خطا مواجه شد.',

    // Database errors
    'database_connection' => 'خطا در اتصال به پایگاه داده.',
    'query_failed' => 'اجرای درخواست پایگاه داده با خطا مواجه شد.',
    'record_not_found' => 'رکورد مورد نظر یافت نشد.',
    'duplicate_entry' => 'رکورد تکراری است.',
    'constraint_violation' => 'محدودیت پایگاه داده نقض شده است.',

    // Payment errors
    'payment_failed' => 'پرداخت با خطا مواجه شد.',
    'insufficient_funds' => 'موجودی کافی نیست.',
    'payment_gateway_error' => 'خطا در درگاه پرداخت.',
    'transaction_failed' => 'تراکنش با خطا مواجه شد.',
    'refund_failed' => 'بازپرداخت با خطا مواجه شد.',

    // Email errors
    'email_send_failed' => 'ارسال ایمیل با خطا مواجه شد.',
    'email_required' => 'ایمیل الزامی است.',
    'email_format_invalid' => 'فرمت ایمیل نامعتبر است.',

    // SMS errors
    'sms_send_failed' => 'ارسال پیامک با خطا مواجه شد.',
    'mobile_required' => 'شماره موبایل الزامی است.',
    'mobile_format_invalid' => 'فرمت شماره موبایل نامعتبر است.',

    // Validation errors (generic)
    'required' => 'وارد کردن فیلد :attribute الزامی است.',
    'string' => 'فیلد :attribute باید به صورت متن باشد.',
    'max' => 'فیلد :attribute نباید بیشتر از :max کاراکتر باشد.',
    'min' => 'فیلد :attribute نباید کمتر از :min کاراکتر باشد.',
    'email' => 'فرمت ایمیل وارد شده صحیح نیست.',
    'unique' => 'این :attribute قبلاً ثبت شده است.',
    'confirmed' => 'تاییدیه :attribute با اصل آن مطابقت ندارد.',
    'digits' => 'فیلد :attribute باید دقیقاً :digits رقم باشد.',
    'in' => 'گزینه انتخاب شده برای :attribute نامعتبر است.',
    'numeric' => 'فیلد :attribute باید عددی باشد.',
    'integer' => 'فیلد :attribute باید عدد صحیح باشد.',
    'boolean' => 'فیلد :attribute باید درست یا غلط باشد.',
    'date' => 'فیلد :attribute باید تاریخ معتبر باشد.',
    'date_format' => 'فرمت فیلد :attribute باید :format باشد.',
    'url' => 'فیلد :attribute باید یک آدرس اینترنتی معتبر باشد.',
    'ip' => 'فیلد :attribute باید یک آدرس IP معتبر باشد.',
    'image' => 'فیلد :attribute باید یک تصویر باشد.',
    'mimes' => 'فیلد :attribute باید از نوع :values باشد.',
    'mimetypes' => 'فیلد :attribute باید از نوع :values باشد.',
    'size' => 'فیلد :attribute باید :size کیلوبایت باشد.',
    'between' => 'فیلد :attribute باید بین :min و :max باشد.',
    'regex' => 'فرمت فیلد :attribute نامعتبر است.',
    'required_if' => 'فیلد :attribute زمانی الزامی است که :other برابر :value باشد.',
    'required_unless' => 'فیلد :attribute الزامی است مگر اینکه :other برابر :value باشد.',
    'required_with' => 'فیلد :attribute زمانی الزامی است که :values موجود باشد.',
    'required_with_all' => 'فیلد :attribute زمانی الزامی است که :values موجود باشد.',
    'required_without' => 'فیلد :attribute زمانی الزامی است که :values موجود نباشد.',
    'required_without_all' => 'فیلد :attribute زمانی الزامی است که هیچکدام از :values موجود نباشد.',
    'same' => 'فیلد :attribute و :other باید یکسان باشند.',
    'different' => 'فیلد :attribute و :other باید متفاوت باشند.',
    'exists' => 'مقدار انتخاب شده برای :attribute نامعتبر است.',
    'timezone' => 'فیلد :attribute باید یک منطقه زمانی معتبر باشد.',
    'json' => 'فیلد :attribute باید یک رشته JSON معتبر باشد.',
    'array' => 'فیلد :attribute باید یک آرایه باشد.',
    'national_code_required' => 'کد ملی الزامی است.',
    'national_code_unique' => 'این کد ملی قبلاً ثبت شده است.',
    'postal_code_numeric' => 'کد پستی باید عددی باشد.',
    'country_required' => 'انتخاب کشور الزامی است.',
    'country_integer' => 'کشور باید عدد صحیح باشد.',
    'address_required' => 'آدرس الزامی است.',
    'phone_required' => 'شماره تلفن الزامی است.',
    'phone_max' => 'شماره تلفن نباید بیشتر از :max کاراکتر باشد.',
    'status_in' => 'وضعیت باید یکی از موارد: :values باشد.',

    'username_not_found' => 'کاربری با این مشخصات یافت نشد.',
    'status_id_inactive' => 'حساب کاربری غیرفعال است.',

    // برای status.in می‌توانیم پیام سفارشی هم داشته باشیم
    'status_active_pending_blocked' => 'وضعیت باید یکی از موارد "فعال"، "انتظار" یا "غیرفعال" باشد.',

    // Custom validation messages
    'password' => [
        'min' => 'رمز عبور باید حداقل :min کاراکتر باشد.',
        'mixed' => 'رمز عبور باید شامل حروف بزرگ و کوچک باشد.',
        'numbers' => 'رمز عبور باید شامل اعداد باشد.',
        'symbols' => 'رمز عبور باید شامل نمادها باشد.',
    ],

    'mobile' => [
        'iran' => 'شماره موبایل باید ایرانی باشد.',
    ],
    // roles
    'role' => [
        'already_exists'     => 'این نقش قبلاً ایجاد شده است',
        'permission_invalid' => 'برخی از دسترسی‌های انتخاب‌شده معتبر نیستند',
        'create_failed'      => 'خطا در ایجاد نقش کاربری',
        'role_has_admins' => 'این نقش به ادمین‌ها اختصاص داده شده و قابل حذف نیست.'
    ],
    'super_admin_cannot_be_deleted' => 'شما نمیتوانید سوپر ادمین را حذف کنید',

    // Success messages (for consistency)
    'success' => 'عملیات با موفقیت انجام شد.',
    'created' => 'با موفقیت ایجاد شد.',
    'updated' => 'با موفقیت به روزرسانی شد.',
    'deleted' => 'با موفقیت حذف شد.',
    'sent' => 'با موفقیت ارسال شد.',
    'verified' => 'با موفقیت تایید شد.',
    'logged_in' => 'با موفقیت وارد شدید.',
    'registered' => 'ثبت‌نام با موفقیت انجام شد.',
    'google_2fa_activated' => 'تایید دو مرحله ای فعال شد',
    'operation_success' => ' عملیات با موفقیت انجام شد',

    // Warning messages
    'warning' => 'هشدار',
    'confirm_action' => 'آیا از انجام این عمل مطمئن هستید؟',
    'irreversible_action' => 'این عمل برگشت‌ناپذیر است.',

    // Info messages
    'info' => 'اطلاعات',
    'no_data' => 'داده‌ای موجود نیست.',
    'no_changes' => 'تغییری اعمال نشده است.',

    // sms setting
    'invalid_sms_provider' => 'سرویس‌دهنده پیامک معتبر نیست.',
    //file
    'file_upload_failed' => 'آپلود فایل با خطا مواجه شد.',
    'file_delete_failed' => 'حذف فایل با خطا مواجه شد.',

    'invalid_sms_provider' => 'سرویس پیامک انتخاب‌شده معتبر نیست.',
    'invalid_email_provider' => 'سرویس ایمیل انتخاب‌شده معتبر نیست.',
];
