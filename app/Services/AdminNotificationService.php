<?php
namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Services\Notifications\Notifier;
use Nette\Utils\Json;

/**
 * سرویس پنل ادمین برای:
 * - ایجاد رکورد Notification
 * - ذخیره title/description در translations (پلی‌مورفیک)
 * - ارسال email/sms با Notifier (سرویس قبلی شما)
 */
class AdminNotificationService
{
    public function __construct(
        protected Notifier $notifier
    ) {}

    /**
     * ایجاد نوتیفیکیشن برای کاربر + ذخیره ترجمه‌ها + (در صورت نیاز) ارسال ایمیل/اس‌ام‌اس
     */
    public function createInternalForUser(User $user, int $adminId, array $payload): Notification
    {
        // ایجاد رکورد Notification
        $notification = Notification::create([
            'user_id'  => $user->id,
            'admin_id' => $adminId,
            'type'     => array_values(array_unique($payload['channels'] ?? [Notification::TYPE_INTERNAL])),
            'status'   => Notification::STATUS_ACTIVE,
            'read'     => false,
            'read_at'  => null,
            'section'  => Notification::SECTION_NORMAL,
        ]);

        // ذخیره ترجمه‌ها (فقط fa در فرم فعلی)
        $titleFa = trim((string) ($payload['title']['fa'] ?? ''));
        $descFa  = trim((string) ($payload['description']['fa'] ?? ''));

        if ($titleFa !== '') {
            $notification->setT('title', 'fa', $titleFa);
        }
        if ($descFa !== '') {
            $notification->setT('description', 'fa', $descFa);
        }

        return $notification->fresh(['translations']);
    }

    public function createInternalForAdmin(int $adminId , array $message){

        $notification = Notification::create([
            'user_id'  => null,
            'admin_id' => $adminId,
            'type'     => [Notification::TYPE_INTERNAL],
            'status'   => Notification::STATUS_ACTIVE,
            'read'     => false,
            'read_at'  => null,
            'section'  => Notification::SECTION_NORMAL,
        ]);
        $notification->setT('title', 'fa', $message['titleFa']);
        $notification->setT('description', 'fa', $message['descFa']);
    }


}
