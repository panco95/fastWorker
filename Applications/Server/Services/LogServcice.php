<?php

namespace Services;

use Katzgrau\KLogger\Logger;
use Psr\Log\LogLevel;

/**
 * 日志服务
 * Class LogServcice
 * @package Services
 */
class LogServcice
{

    public static function write($event, $msg)
    {
        $logger = new Logger(dirname(__DIR__) . '/Runtime/logs', LogLevel::INFO);
        $logger->info("{$event} -> {$msg}");
    }

}