<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notifications\NotificationIndexRequest;
use App\Http\Requests\Admin\Notifications\NotificationStoreRequest;
use App\Models\Notification;
use App\Models\User;
use App\Services\AdminNotificationService;
use App\Services\Notifications\Notifier;

class NotificationController extends Controller
{
    public function __construct(
        protected AdminNotificationService $service
    ) {}

    /**
     * صفحه لیست نوتیفیکیشن‌ها (Notification Center)
     */
    public function index(NotificationIndexRequest $request)
    {
        $filters = $request->validated();
        $users   = User::all();
        $q       = Notification::query()
            ->with('translations', 'user')
            ->latest('id');

        // فیلترها (همون چیزهایی که در UI داری)
        if (! empty($filters['type'])) {
            $q->whereJsonContains('type', $filters['type']);
        }

        if (isset($filters['read']) && $filters['read'] !== null) {
            $q->where('read', (bool) $filters['read']);
        }

        if (! empty($filters['range'])) {
            // range: 7days | 1month
            if ($filters['range'] === '7days') {
                $q->where('created_at', '>=', now()->subDays(7));
            } elseif ($filters['range'] === '1month') {
                $q->where('created_at', '>=', now()->subMonth());
            }
        }

        $notifications = $q->paginate(10)->withQueryString();

        // شمارش unread برای دکمه "علامت‌خوانده‌ها"
        $unreadCount = Notification::query()->where('read', false)->count();

        return view('admin.pages.notifications.index', compact('notifications', 'unreadCount', ));
    }

    /**
     * صفحه ایجاد/ارسال نوتیفیکیشن (به کاربر)
     */
    public function create()
    {
        // کامنت: چون در view لیست کاربران داریم، باید به صفحه پاس بدیم
        // اگر تعداد user زیاد است، بهتره ajax/select2 remote کنیم (بعداً)
        $users = User::query()
            ->select(['id', 'first_name', 'last_name']) // مطابق ساختار شما؛ اگر FullName accessor داری همین کافیه
            ->latest('id')
            ->limit(2000) // احتیاط برای سنگین نشدن صفحه
            ->get();

        return view('admin.pages.notifications.create', compact('users'));
    }

    /**
     * ثبت نوتیفیکیشن + (در صورت انتخاب) ارسال ایمیل/اس‌ام‌اس
     */
    public function store(NotificationStoreRequest $request)
    {
        $data = $request->validated();

        $userIds = $data['user_ids'];
        $users   = User::query()
            ->whereIn('id', $userIds)
            ->get();

        if ($users->isEmpty()) {
            return back()->with('error', __('general.select_at_least_one_user'));
        }

        $createdNotifications = [];

        foreach ($users as $user) {
            $notification = $this->service->createInternalForUser(
                user: $user,
                adminId: auth('admin')->id(),
                payload: $data
            );

            $createdNotifications[] = $notification;

            // Email
            if (in_array('email', $data['channels'], true)) {
                app(Notifier::class)->email(
                    $user,
                    $data['title']['fa'],
                    $data['description']['fa']
                );
            }

            // SMS (اگر داری)
            if (in_array('sms', $data['channels'], true)) {
                // app(Notifier::class)->sms(...);  // بسته به پیاده‌سازی خودت
            }
        }

        // اگر فقط برای یک نفر ساخته شد: برو صفحه show همان نوتیف
        if (count($createdNotifications) === 1) {
            return redirect()
                ->route('admin.notifications.show', $createdNotifications[0])
                ->with('success', __('general.notification_created_success'));
        }

        // اگر چند نفر: برگرد به لیست
        return redirect()
            ->route('admin.notifications.index')
            ->with('success', __('general.notification_created_success_multi', ['count' => count($createdNotifications)]));
    }

    /**
     * صفحه نمایش جزئیات
     */
    public function show(Notification $notification)
    {
        $notification->load('translations', 'user', 'admin');

        return view('admin.pages.notifications.show', compact('notification'));
    }

    /**
     * علامت به عنوان خوانده شده
     */
    public function markRead(Notification $notification)
    {
        $notification->update(['read' => true, 'read_at' => now()]);

        return back()->with('success', __('general.notification_marked_read'));
    }

    /**
     * علامت به عنوان نخوانده
     */
    public function markUnread(Notification $notification)
    {
        $notification->update(['read' => false, 'read_at' => null]);

        return back()->with('success', __('general.notification_marked_unread'));
    }

    /**
     * علامت‌زدن همه‌ی مواردِ لیست فعلی به عنوان خوانده شده
     * (بر اساس فیلترهای موجود در query string)
     */
    public function markAllRead(NotificationIndexRequest $request)
    {
        $filters = $request->validated();

        $q = Notification::query()->where('read', false);

        if (! empty($filters['type'])) {
            $q->whereJsonContains('type', $filters['type']);
        }

        if (! empty($filters['range'])) {
            if ($filters['range'] === '7days') {
                $q->where('created_at', '>=', now()->subDays(7));
            } elseif ($filters['range'] === '1month') {
                $q->where('created_at', '>=', now()->subMonth());
            }
        }

        $q->update(['read' => true, 'read_at' => now()]);

        return back()->with('success', __('general.notifications_marked_all_read'));
    }
}
