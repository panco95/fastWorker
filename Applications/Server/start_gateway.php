<?php
/**
 * gateway服务器，管理连接
 */

use \Workerman\Worker;
use \GatewayWorker\Gateway;

require_once __DIR__ . '/../../vendor/autoload.php';

$gateway = new Gateway("websocket://0.0.0.0:7000");
$gateway->name = 'gateway';
$gateway->count = 4;
$gateway->lanIp = '127.0.0.1';
// 内部通讯起始端口，假如$gateway->count=4，起始端口为4000
// 则一般会使用4000 4001 4002 4003 4个端口作为内部通讯端口 
$gateway->startPort = 7020;
$gateway->registerAddress = '127.0.0.1:7010';

//// 心跳间隔
//$gateway->pingInterval = 10;
//// pingInterval*pingNotResponseLimit=55 秒内没有任何数据传输给服务端则服务端认为对应客户端已经掉线，服务端关闭连接并触发onClose回调。
//$gateway->pingNotResponseLimit = 2;
//// 心跳数据
//$gateway->pingData = '{"cmd":"ping","message":"","data":null}';

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

