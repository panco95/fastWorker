<?php
/**
 * 服务注册进程
 */

use \Workerman\Worker;
use \GatewayWorker\Register;

require_once __DIR__ . '/../../vendor/autoload.php';

$register = new Register('text://0.0.0.0:7010');

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

