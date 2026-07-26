<?php

namespace App\Http\Controllers\Admin;

use App\Filters\TicketFilter;
use App\Filters\UserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketStoreRequest as TicketTicketStoreRequest;
use App\Http\Requests\Admin\TicketMessageStoreRequest;
use App\Http\Requests\Admin\TicketStoreRequest;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * لیست تیکت‌ها
     */
    public function index()
    {
        $departmentOptions = Department::query()
            ->with('translations') // لازم چون name از translations میاد
            ->orderBy('sort_order')
            ->latest('id')
            ->get()
            ->mapWithKeys(fn($d) => [$d->id => $d->name])
            ->toArray();
        $tickets = Ticket::filters(new TicketFilter())
            ->with(['user', 'admin', 'department', 'creator'])
            ->orderBy('updated_at', 'desc')
            ->paginate(20)
            ->withQueryString(); // وقتی فیلتر میکنی، pagination فیلتر رو نگه می‌داره

        $filters = [
            [
                'name' => 'status',
                'label' => trans('general.tickets_status'),
                'type' => 'select',
                'options' => [
                    Ticket::STATUS_NEW => __('general.ticket_status.new'),
                    Ticket::STATUS_PENDING => __('general.ticket_status.pending'),
                    Ticket::STATUS_ANSWERED_BY_ADMIN => __('general.ticket_status.answered_by_admin'),
                    Ticket::STATUS_ANSWERED_BY_USER => __('general.ticket_status.answered_by_user'),
                    Ticket::STATUS_CLOSED => __('general.ticket_status.closed'),
                ],
            ],
            [
                'name' => 'user',
                'label' => trans('general.user'),
                'type' => 'text',
                'placeholder' => trans('general.search_user'),
            ],
            [
                'name' => 'department_id',
                'label' => trans('general.department'),
                'type' => 'select',
                'options' => $departmentOptions,
            ],
            //id
            [
                'name' => 'id',
                'label' => trans('general.id'),
                'type' => 'number',
            ],
            [
                'name' => 'date_from',
                'label' => trans('general.from_date'),
                'type' => 'date',
            ],
            // تاریخ تا
            [
                'name' => 'date_to',
                'label' => trans('general.to_date'),
                'type' => 'date',
            ],
        ];

        return view('admin.pages.tickets.index', compact('tickets', 'filters'));
    }


    /**
     * فرم ساخت تیکت از پنل ادمین (حتماً باید user انتخاب شود)
     */
    public function create()
    {
        $departments = Department::query()
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        // شما هر ساختاری برای نام User دارید اینجا تنظیم کن
        $users = \App\Models\User::query()
            ->select('id', 'first_name')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.pages.tickets.create', compact('departments', 'users'));
    }

    /**
     * ساخت تیکت توسط Admin:
     * - user_id مخاطب است
     * - creator = admin
     * - پیام اول + فایل‌ها روی TicketMessage
     */
    public function store(TicketStoreRequest $request)
    {
        $admin = auth('admin')->user();

        DB::beginTransaction();
        try {
            $ticket = Ticket::create([
                'user_id' => $request->user_id,

                // creator
                'creator_type' => get_class($admin),
                'creator_id' => $admin->id,

                // assign admin as handler (فعلاً همین ادمین)
                'admin_id' => $admin->id,

                'department_id' => $request->department_id,
                'title' => strip_tags($request->title),
                'description' => $request->description ? strip_tags($request->description) : null,
                'priority' => (int) $request->priority,
                'status' => Ticket::STATUS_NEW,
            ]);

            // پیام اول
            $message = TicketMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => $admin->id,
                'user_type' => get_class($admin),
                'message' => $ticket->description ?? '',
                'status' => TicketMessage::STATUS_NOT_SEEN,
                'from' => TicketMessage::FROM_ADMIN,
            ]);

            // فایل‌ها روی پیام اول
            if ($request->hasFile('files')) {
                store_model_files(
                    model: $message,
                    uploadedFiles: $request->file('files'),
                    dir: 'uploads/tickets',
                    collection: 'attachment',
                    disk: 'public',
                    uploadedBy: $admin
                );
            }

            DB::commit();

            return redirect()
                ->route('admin.tickets.chat', $ticket)
                ->with('success', __('general.created_successfully'));
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', __('general.operation_failed'));
        }
    }

    /**
     * صفحه چت تیکت
     */
    public function chat(Ticket $ticket)
    {
        $ticket->load(['user', 'admin', 'department', 'creator']);

        $messages = $ticket->messages()
            ->with(['user', 'files'])
            ->orderBy('created_at')
            ->get();

        return view('admin.pages.tickets.chat', compact('ticket', 'messages'));
    }

    /**
     * ارسال پیام توسط Admin
     */
    public function sendMessage(TicketMessageStoreRequest $request, Ticket $ticket)
    {
        if ($ticket->status === Ticket::STATUS_CLOSED) {
            return back()->with('error', __('general.ticket_closed_chat'));
        }

        $admin = auth('admin')->user();

        DB::beginTransaction();
        try {
            $ticket->update(['status' => Ticket::STATUS_ANSWERED_BY_ADMIN]);

            $message = TicketMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => $admin->id,
                'user_type' => get_class($admin),
                'message' => strip_tags($request->message),
                'status' => TicketMessage::STATUS_NOT_SEEN,
                'from' => TicketMessage::FROM_ADMIN,
            ]);

            if ($request->hasFile('files')) {
                store_model_files(
                    model: $message,
                    uploadedFiles: $request->file('files'),
                    dir: 'uploads/tickets',
                    collection: 'attachment',
                    disk: 'public',
                    uploadedBy: $admin
                );
            }

            DB::commit();

            return back()->with('success', __('general.operation_done'));
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', __('general.operation_failed'));
        }
    }

    /**
     * بستن تیکت
     */
    public function close(Ticket $ticket)
    {
        $ticket->update(['status' => Ticket::STATUS_CLOSED]);

        return back()->with('success', __('general.ticket_closed'));
    }
}
