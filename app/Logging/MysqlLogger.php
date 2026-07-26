<?php

namespace App\Logging;

use App\Models\SystemLog;
use Illuminate\Support\Facades\Schema;
use MongoDB\Client;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;

class MysqlLogger extends AbstractProcessingHandler
{
    protected $collection;

    public function __construct($level = Logger::DEBUG, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

    }

    protected function write(LogRecord $record): void
    {
        if(Schema::hasTable("system_logs")) {
        SystemLog::create([
            'level'       => $record['level_name'],
            'message'     => $record['message'],
            'context'     => $record['context'],
            'extra'       => $record['extra'],
            'datetime'    => $record['datetime']->format('Y-m-d H:i:s'),
            'channel'     => $record['channel'],
            'environment' => app()->environment(),
        ]);
        }
    }
}
