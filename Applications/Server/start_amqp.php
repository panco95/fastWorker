<?php
/**
 * AMQP(rabbitmq)消息队列消费者进程
 * 注意：分布式的时候请保证只有一台启动这个进程（因为这个主要是用来保持数据一致性）
 */

use \Workerman\Worker;
use \GatewayWorker\BusinessWorker;

require_once __DIR__ . '/../../vendor/autoload.php';

// amqp(rabbitmq)消费者进程
$worker = new BusinessWorker();
$worker->name = 'amqp';
$worker->count = 1;

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

