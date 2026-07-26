<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-activity-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $maxLogs = 500;
        $tables  = [
            'system_logs',
            'admin_activity_logs',
        ];
        foreach ($tables as $table) {
            $count = DB::table($table)->count();

            if ($count <= $maxLogs) {
                $this->info("No cleanup needed. Total logs: $count");
                return;
            }

            $deleteCount = $count - $maxLogs;

            // قدیمی‌ترین‌ها حذف شوند
            DB::table($table)
                ->orderBy('id', 'asc')
                ->limit($deleteCount)
                ->delete();

            $this->info("Deleted $deleteCount old logs. Kept last $maxLogs records.");
        }
    }
}
