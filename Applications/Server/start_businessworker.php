<?php
/**
 * 业务进程，Events.php监听连接
 */

use \Workerman\Worker;
use \GatewayWorker\BusinessWorker;

require_once __DIR__ . '/../../vendor/autoload.php';

$worker = new BusinessWorker();
$worker->name = 'worker';
$worker->count = 4;
$worker->registerAddress = '127.0.0.1:7010';

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

