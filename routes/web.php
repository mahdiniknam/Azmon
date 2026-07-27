<?php

use App\Http\Controllers\Admin\AdminActivityLogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminSecurityController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\GatewaySettingController;
use App\Http\Controllers\Admin\MonitorController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PatternOptionController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\BaleBot\BaleConnectionController;
use App\Http\Controllers\BaleBot\BaleWebhookController;
use App\Http\Controllers\Student\StudentExamController;
use App\Http\Controllers\Student\Auth\StudentAuthController;
use App\Http\Controllers\Student\SettingBotController;
use App\Http\Middleware\SetLocal;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

//روت کمکی برای ارتباط مستقیم با لاگین ادمین
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::middleware(SetLocal::class)->group(function () {

    // 🔵 پنل ادمین
    Route::prefix('admin')->name('admin.')->group(function () {

        // 🔓 مسیرهای عمومی (قابل دسترسی بدون لاگین)
        Route::middleware('guest:admin')->group(function () {
            Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [LoginController::class, 'loginWithPassword'])->name('login.post');

            Route::post('/login/verify', [LoginController::class, 'verifyLoginChallenge'])->name('login.verify');
        });

        // 🔄 کپچا (عمومی)
        Route::get('/captcha/refresh', [LoginController::class, 'refreshCaptcha'])->name('captcha.refresh');

        // 🔒 مسیرهای محافظت‌شده (نیاز به لاگین)
        Route::middleware(['auth:admin', 'setLogInfo'])->group(function () {
            // خروج
            Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

            // داشبورد
            Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

            // روت ریشه به داشبورد ریدایرکت شود
            Route::get('/', function () {
                return redirect()->route('admin.dashboard');
            });

            // منابع
            Route::resource('users', UserController::class)->names('users');
            Route::resource('admins', AdminController::class)->names('admins');


            Route::prefix('subjects')->name('subjects.')->group(function () {
                Route::get('index', [SubjectController::class, 'index'])->name('index');
                Route::get('create', [SubjectController::class, 'create'])->name('create');
                Route::post('store', [SubjectController::class, 'store'])->name('store');
                Route::get('edit/{id}', [SubjectController::class, 'edit'])->name('edit');
                Route::post('update/{id}', [SubjectController::class, 'update'])->name('update');
                Route::delete('destroy/{id}', [SubjectController::class, 'destroy'])->name('destroy');
            });


            Route::prefix('questions')->name('questions.')->group(function () {
                Route::get('index', [QuestionController::class, 'index'])->name('index');
                Route::get('create', [QuestionController::class, 'create'])->name('create');
                Route::post('store', [QuestionController::class, 'store'])->name('store');
                Route::get('edit/{id}', [QuestionController::class, 'edit'])->name('edit');
                Route::post('update/{id}', [QuestionController::class, 'update'])->name('update');
                Route::delete('destroy/{id}', [QuestionController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('exams')->name('exams.')->group(function () {
                Route::get('index', [ExamController::class, 'index'])->name('index');
                Route::get('create', [ExamController::class, 'create'])->name('create');
                Route::post('store', [ExamController::class, 'store'])->name('store');
                Route::get('edit/{id}', [ExamController::class, 'edit'])->name('edit');
                Route::post('update/{id}', [ExamController::class, 'update'])->name('update');
                Route::delete('destroy/{id}', [ExamController::class, 'destroy'])->name('destroy');
            });






            Route::prefix('security')->name('security.')->group(function () {

                Route::get('{admin}', [AdminSecurityController::class, 'index'])
                    ->name('index');

                Route::post('{admin}/generate-2fa', [AdminSecurityController::class, 'generateGoogle2FA'])
                    ->name('generate-2fa'); // اضافه شد

                Route::post('{admin}/verify-2fa', [AdminSecurityController::class, 'verifyGoogle2FA'])
                    ->name('verify-2fa');

                Route::post('verify-2fa-action', [AdminSecurityController::class, 'verify2FAAction'])
                    ->name('verify-2fa-action');

                Route::put('{admin}/toggle-2fa', [AdminSecurityController::class, 'toggleGoogle2FA'])
                    ->name('toggle-2fa');

                Route::delete('{admin}/delete-2fa', [AdminSecurityController::class, 'deleteGoogle2FA'])
                    ->name('delete-2fa');

                Route::delete('{admin}/logout-device', [AdminSecurityController::class, 'logoutDevice'])
                    ->name('logout-device');

                Route::put('{admin}/toggle-sms', [AdminSecurityController::class, 'toggleSms'])
                    ->name('toggle-sms');
            });

            // تنطیمات
            Route::prefix('setting')->name('setting.')->group(function () {
                Route::get('/', [SettingController::class, 'index'])->name('index');
                //site_setting
                Route::get('/site', [SettingController::class, 'siteEdit'])->name('site.edit');
                Route::post('/site', [SettingController::class, 'siteUpdate'])->name('site.update');
                // SMS
                Route::prefix('sms')->name('sms.')->group(function () {
                    Route::get('/', [SettingController::class, 'smsIndex'])->name('index');

                    Route::get('/edit', [SettingController::class, 'smsSettingEdit'])->name('edit');
                    Route::put('/update', [SettingController::class, 'smsUpdate'])->name('update');

                    // patterns
                    Route::get('/patterns/user', [PatternOptionController::class, 'smspatternsUser'])->name('patterns.user');
                    Route::get('/patterns/admin', [PatternOptionController::class, 'smspatternsAdmin'])->name('patterns.admin');
                    Route::put('/patterns/update', [PatternOptionController::class, 'smspatternsUpdate'])->name('patterns.update');
                });

                // EMAIL
                Route::prefix('email')->name('email.')->group(function () {
                    Route::get('/', [SettingController::class, 'emailIndex'])->name('index');

                    Route::get('/edit', [SettingController::class, 'emailSettingEdit'])->name('edit');
                    Route::put('/update', [SettingController::class, 'emailUpdate'])->name('update');

                    // patterns
                    Route::get('/patterns/user', [PatternOptionController::class, 'emailpatternsUser'])->name('patterns.user');
                    Route::get('/patterns/admin', [PatternOptionController::class, 'emailpatternsAdmin'])->name('patterns.admin');
                    Route::put('/patterns/update', [PatternOptionController::class, 'emailpatternsUpdate'])->name('patterns.update');
                });

                //gateway
                Route::prefix('gateways')->name('gateways.')->group(function () {
                    Route::get('/', [GatewaySettingController::class, 'index'])->name('index');
                    Route::get('/{gateway}/edit', [GatewaySettingController::class, 'edit'])->name('edit');
                    Route::put('/{gateway}/update', [GatewaySettingController::class, 'update'])->name('update');
                    Route::put('/{gateway}/toggle', [GatewaySettingController::class, 'toggle'])->name('toggle');
                });
            });
            //تیکت
            Route::prefix('tickets')->name('tickets.')->group(function () {
                Route::get('/', [TicketController::class, 'index'])->name('index');
                Route::get('/create', [TicketController::class, 'create'])->name('create');
                Route::post('/', [TicketController::class, 'store'])->name('store');

                Route::get('/{ticket}/chat', [TicketController::class, 'chat'])->name('chat');
                Route::post('/{ticket}/chat', [TicketController::class, 'sendMessage'])->name('chat.send');

                Route::put('/{ticket}/close', [TicketController::class, 'close'])->name('close');
            });

            //دپارتمان
            Route::prefix('departments')->name('departments.')->group(function () {
                Route::get('/', [DepartmentController::class, 'index'])->name('index');
                Route::get('/create', [DepartmentController::class, 'create'])->name('create');
                Route::post('/', [DepartmentController::class, 'store'])->name('store');
                Route::get('/{department}/edit', [DepartmentController::class, 'edit'])->name('edit');
                Route::put('/{department}', [DepartmentController::class, 'update'])->name('update');
                Route::delete('/{department}', [DepartmentController::class, 'destroy'])->name('destroy');
            });

            //اعلانات
            Route::prefix('notifications')->name('notifications.')->group(function () {
                // لیست/جزئیات/ویرایش/حذف نوتیف‌ها
                Route::get('/', [NotificationController::class, 'index'])->name('index');
                Route::get('/create', [NotificationController::class, 'create'])->name('create');
                Route::post('/', [NotificationController::class, 'store'])->name('store');

                // Single notification
                Route::get('/{notification}', [NotificationController::class, 'show'])->name('show');

                // Mark read/unread
                Route::post('/{notification}/read', [NotificationController::class, 'markRead'])->name('read');
                Route::post('/{notification}/unread', [NotificationController::class, 'markUnread'])->name('unread');

                // Mark all as read (based on current filters)
                Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('mark_all_read');
            });
            //monitor
            Route::prefix('monitor')->name('monitor.')->controller(MonitorController::class)->group(function () {
                Route::get('system/logs', 'systemLogs')->name('system_logs.index');
                Route::delete('system/logs/delete', 'deleteSystemLogs')->name('system_logs.delete');
                Route::get('system-logs/export', 'exportSystemLogsCsv')->name('system_logs.export');
            });
            // logs
            Route::prefix('logs')->name('activity.log.')->controller(AdminActivityLogController::class)->group(function () {
                Route::get('index', [AdminActivityLogController::class, 'index'])->name('index');
                Route::get('export', [AdminActivityLogController::class, 'exportAdminLogs'])->name('export');
                Route::delete('destroy', [AdminActivityLogController::class, 'destroy'])->name('destroy');
            });

            Route::resource('roles', AdminRoleController::class)->names('roles');

            // روت‌های اضافی (اختیاری)
            Route::get('users/delete/{user}', [UserController::class, 'destroy'])->name('users.delete');
            Route::post('users/update/{user}', [UserController::class, 'update'])->name('users.update');

            // گزارشات ادمین
            Route::prefix('reports')->name('reports.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\AdminReportController::class, 'overview'])->name('overview');
                Route::get('financial', [\App\Http\Controllers\Admin\AdminReportController::class, 'financial'])->name('financial');
                Route::get('exams', [\App\Http\Controllers\Admin\AdminReportController::class, 'exams'])->name('exams');
            });

            // تنظیمات ربات بله
            Route::prefix('setting/bale')->name('setting.bale.')->group(function () {
                Route::get('/', [SettingController::class, 'baleEdit'])->name('edit');
                Route::post('/', [SettingController::class, 'baleUpdate'])->name('update');
            });
        });
    });
});

Route::prefix('student')->name('student.')->group(function (): void {
    Route::middleware('guest:web')->group(function (): void {
        Route::get('login', [StudentAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [StudentAuthController::class, 'login'])
            ->middleware('throttle:6,1')
            ->name('login.store');
        Route::get('register', [StudentAuthController::class, 'showRegister'])->name('register');
        Route::post('register', [StudentAuthController::class, 'register'])
            ->middleware('throttle:6,1')
            ->name('register.store');
    });

    Route::middleware(['auth:web'])->group(function (): void {
        Route::post('logout', [StudentAuthController::class, 'logout'])->name('logout');

        Route::get('exams', [StudentExamController::class, 'index'])->name('exams.index');
        Route::get('exams/{exam}', [StudentExamController::class, 'showExam'])->name('exams.show');
        Route::post('exams/{exam}/start', [StudentExamController::class, 'start'])->name('exams.start');
        Route::get('attempts/history', [StudentExamController::class, 'history'])->name('attempts.history');
        Route::get('attempts/{attempt}', [StudentExamController::class, 'showAttempt'])->name('attempts.show');
        Route::post('attempts/{attempt}/answers', [StudentExamController::class, 'answer'])->name('attempts.answers.store');
        Route::post('attempts/{attempt}/suspicious-events', [StudentExamController::class, 'suspicious'])->name('attempts.suspicious');
        Route::post('attempts/{attempt}/finish', [StudentExamController::class, 'finish'])->name('attempts.finish');
        Route::get('attempts/{attempt}/result', [StudentExamController::class, 'result'])->name('attempts.result');
        Route::get('/attempts/results', [StudentExamController::class, 'results'])->name('attempts.results');

        // پرداخت‌ها و کیف پول
        Route::get('payments', [\App\Http\Controllers\Student\StudentPaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/wallet', [\App\Http\Controllers\Student\StudentPaymentController::class, 'wallet'])->name('payments.wallet');
        Route::post('payments/wallet/charge', [\App\Http\Controllers\Student\StudentPaymentController::class, 'charge'])->name('payments.wallet.charge');

        Route::get('show-seeting-bot',[SettingBotController::class,'show'])->name('show.setting.bot');

        // ایجاد کد جدید
        Route::post('/profile/bale/connect', [BaleConnectionController::class, 'create'])->name('profile.bale.connect');

        // قطع اتصال
        Route::delete('/profile/bale/disconnect', [BaleConnectionController::class, 'disconnect'])->name('profile.bale.disconnect');

    });
});

// 🟢 پنل استاد
Route::prefix('teacher')->name('teacher.')->group(function (): void {
    Route::middleware('guest:web')->group(function (): void {
        Route::get('login', [\App\Http\Controllers\Teacher\Auth\TeacherAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [\App\Http\Controllers\Teacher\Auth\TeacherAuthController::class, 'login'])
            ->middleware('throttle:6,1')
            ->name('login.store');
        Route::get('register', [\App\Http\Controllers\Teacher\Auth\TeacherAuthController::class, 'showRegister'])->name('register');
        Route::post('register', [\App\Http\Controllers\Teacher\Auth\TeacherAuthController::class, 'register'])
            ->middleware('throttle:6,1')
            ->name('register.store');
    });

    Route::middleware(['auth:web', 'teacher'])->group(function (): void {
        Route::post('logout', [\App\Http\Controllers\Teacher\Auth\TeacherAuthController::class, 'logout'])->name('logout');

        Route::get('dashboard', [\App\Http\Controllers\Teacher\TeacherDashboardController::class, 'index'])->name('dashboard');

        Route::get('/', function () {
            return redirect()->route('teacher.dashboard');
        });

        // دروس
        Route::prefix('subjects')->name('subjects.')->group(function () {
            Route::get('index', [\App\Http\Controllers\Teacher\TeacherSubjectController::class, 'index'])->name('index');
            Route::get('create', [\App\Http\Controllers\Teacher\TeacherSubjectController::class, 'create'])->name('create');
            Route::post('store', [\App\Http\Controllers\Teacher\TeacherSubjectController::class, 'store'])->name('store');
            Route::get('edit/{id}', [\App\Http\Controllers\Teacher\TeacherSubjectController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [\App\Http\Controllers\Teacher\TeacherSubjectController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [\App\Http\Controllers\Teacher\TeacherSubjectController::class, 'destroy'])->name('destroy');
        });

        // سوالات
        Route::prefix('questions')->name('questions.')->group(function () {
            Route::get('index', [\App\Http\Controllers\Teacher\TeacherQuestionController::class, 'index'])->name('index');
            Route::get('create', [\App\Http\Controllers\Teacher\TeacherQuestionController::class, 'create'])->name('create');
            Route::post('store', [\App\Http\Controllers\Teacher\TeacherQuestionController::class, 'store'])->name('store');
            Route::get('edit/{id}', [\App\Http\Controllers\Teacher\TeacherQuestionController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [\App\Http\Controllers\Teacher\TeacherQuestionController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [\App\Http\Controllers\Teacher\TeacherQuestionController::class, 'destroy'])->name('destroy');
        });

        // آزمون‌ها
        Route::prefix('exams')->name('exams.')->group(function () {
            Route::get('index', [\App\Http\Controllers\Teacher\TeacherExamController::class, 'index'])->name('index');
            Route::get('create', [\App\Http\Controllers\Teacher\TeacherExamController::class, 'create'])->name('create');
            Route::post('store', [\App\Http\Controllers\Teacher\TeacherExamController::class, 'store'])->name('store');
            Route::get('edit/{id}', [\App\Http\Controllers\Teacher\TeacherExamController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [\App\Http\Controllers\Teacher\TeacherExamController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [\App\Http\Controllers\Teacher\TeacherExamController::class, 'destroy'])->name('destroy');
        });

        // گزارشات
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Teacher\TeacherReportController::class, 'index'])->name('index');
            Route::get('exam/{id}', [\App\Http\Controllers\Teacher\TeacherReportController::class, 'examDetail'])->name('exam-detail');
        });
    });
});

// 💳 پرداخت (مشترک)
Route::middleware('auth:web')->prefix('payment')->name('payment.')->group(function () {
    Route::get('checkout/{exam}', [\App\Http\Controllers\Payment\PaymentController::class, 'checkout'])->name('checkout');
    Route::post('pay/{exam}', [\App\Http\Controllers\Payment\PaymentController::class, 'pay'])->name('pay');
    Route::post('wallet-pay/{exam}', [\App\Http\Controllers\Payment\PaymentController::class, 'walletPay'])->name('wallet-pay');
    Route::get('fake-gateway/{transaction}', [\App\Http\Controllers\Payment\PaymentController::class, 'fakeGateway'])->name('fake-gateway');
    Route::post('callback/{transaction}', [\App\Http\Controllers\Payment\PaymentController::class, 'callback'])->name('callback');
    Route::get('zarinpal/callback', [\App\Http\Controllers\Payment\PaymentController::class, 'zarinpalCallback'])->name('zarinpal.callback');
    Route::get('result/{transaction}', [\App\Http\Controllers\Payment\PaymentController::class, 'result'])->name('result');
    Route::post('calculate-share', [\App\Http\Controllers\Payment\PaymentController::class, 'calculateShare'])->name('calculate-share');

    Route::post('/profile/bale/connect', [BaleConnectionController::class, 'create'])
        ->name('profile.bale.connect');

    Route::delete('/profile/bale/disconnect', [BaleConnectionController::class, 'disconnect'])
        ->name('profile.bale.disconnect');
});
Route::post('/webhooks/bale', BaleWebhookController::class);
// روت‌های مدیریتی وب‌هوک بله
Route::get('/bale/setup/{password}', [BaleConnectionController::class, 'setupWebhook']);
Route::get('/bale/status/{password}', [BaleConnectionController::class, 'getWebhookStatus']);
