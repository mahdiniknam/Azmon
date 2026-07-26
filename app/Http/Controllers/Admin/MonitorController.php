<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    public function systemLogs(Request $request)
    {
        $level = $request->get('level'); // error|warning|info|debug|...
        $q = trim((string)$request->get('q'));
        $perPage = (int) $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100], true) ? $perPage : 10;

        $logsQuery = SystemLog::query()->orderByDesc('datetime');

        if (!empty($level) && $level !== 'all') {
            $logsQuery->where('level', $level);
        }

        if (!empty($q)) {
            $logsQuery->where(function ($qq) use ($q) {
                $qq->where('message', 'like', "%{$q}%")
                   ->orWhere('channel', 'like', "%{$q}%")
                   ->orWhere('environment', 'like', "%{$q}%");
            });
        }

        $logs = $logsQuery->paginate($perPage)->withQueryString();

        // --- statistics (نمونه ساده و کاربردی)
        $todayStart = Carbon::today();
        $todayEnd = Carbon::tomorrow();

        $stats = [
            'today_errors' => SystemLog::query()
                ->where('level', 'error')
                ->whereBetween('datetime', [$todayStart, $todayEnd])
                ->count(),

            'warnings' => SystemLog::query()->where('level', 'warning')->count(),
            'infos' => SystemLog::query()->where('level', 'info')->count(),
            'total' => SystemLog::query()->count(),
        ];

        $levels = [
            'all' => trans('general.all'),
            'error' => trans('general.log_level_error'),
            'warning' => trans('general.log_level_warning'),
            'info' => trans('general.log_level_info'),
            'debug' => trans('general.log_level_debug'),
        ];

        return view('admin.pages.monitor.logs.index', compact('logs', 'stats', 'levels', 'level', 'q', 'perPage'));
    }

    public function deleteSystemLogs()
    {
        // اگر دیتای زیاد داری، truncate سریع‌تره:
        // SystemLog::truncate();
        SystemLog::query()->delete();

        return back()->with('toast-success', trans('general.operation_done_successfully'));
    }

    public function exportSystemLogsCsv(Request $request)
    {
        $level = $request->get('level');
        $q = trim((string)$request->get('q'));

        $query = SystemLog::query()->orderByDesc('datetime');

        if (!empty($level) && $level !== 'all') {
            $query->where('level', $level);
        }

        if (!empty($q)) {
            $query->where(function ($qq) use ($q) {
                $qq->where('message', 'like', "%{$q}%")
                   ->orWhere('channel', 'like', "%{$q}%")
                   ->orWhere('environment', 'like', "%{$q}%");
            });
        }

        $fileName = 'system-logs-' . now()->format('Y-m-d_H-i-s') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM برای اکسل
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'datetime', 'level', 'message', 'channel', 'environment', 'context', 'extra'
            ]);

            $query->chunk(1000, function ($logs) use ($handle) {
                foreach ($logs as $log) {
                    fputcsv($handle, [
                        optional($log->datetime)->format('Y-m-d H:i:s'),
                        $log->level,
                        $log->message,
                        $log->channel,
                        $log->environment,
                        json_encode($log->context, JSON_UNESCAPED_UNICODE),
                        json_encode($log->extra, JSON_UNESCAPED_UNICODE),
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}