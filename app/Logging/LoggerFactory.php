<?php

namespace App\Logging;

use Monolog\Logger;
use MongoDB\Client;

class LoggerFactory
{
    public function __invoke(array $config): Logger
    {
        $logger = new Logger('mysql');

        $handler = new MysqlLogger(
            Logger::toMonologLevel($config['level'] ?? 'debug')
        );

        $logger->pushHandler($handler);

        return $logger;
    }
}
