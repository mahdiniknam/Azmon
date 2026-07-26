<?php

namespace App\Http\Controllers\Admin;


use App\Filters\UserTransactionFilter;
use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FA\Google2FA;
use Symfony\Component\HttpFoundation\Response;
use App\Exports\AdminActivityLogsExport;
use App\Filters\AdminActivityLogFilter;
use Maatwebsite\Excel\Facades\Excel;
class AdminActivityLogController extends Controller
{
    public function index()
    {

        $filters = [
            ['name' => 'admin', 'label' => trans('general.admin'), 'type' => 'text', 'placeholder' => trans('general.user_placeholder')],
            ['name' => 'fromDate', 'label' => trans('general.from_date'), 'type' => 'date'],
            ['name' => 'toDate', 'label' => trans('general.to_date'), 'type' => 'date'],
        ];
        $logs = AdminActivityLog::query()
            ->filters(new AdminActivityLogFilter())
            ->with(['admin'])
        ->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.pages.activity_log.index', [
            'logs' => $logs,
            'filters' => $filters
        ]);
    }
    public function destroy()
    {
        AdminActivityLog::query()->delete();
        return redirect()->back()->with('toast-success', __('general.operation_done'));
    }

    // public function exportAdminLogs()
    // {
    //     return Excel::download(
    //         new AdminActivityLogsExport,
    //         'admin-activity-logs.xlsx'
    //     );
    // }

}
