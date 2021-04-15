<?php

namespace Services;

use GatewayClient\Gateway as GatewayClient;
use GatewayWorker\Lib\Gateway;
use Workerman\Lib\Timer;
use Symfony\Component\Dotenv\Dotenv;

/**
 * 业务进程监听类
 * Class WorkerService
 * @package Services
 */
class WorkerService
{

    public static function onWorkerStart($businessWorker)
    {
        $dotenv = new Dotenv();
        $dotenv->load(dirname(__DIR__) . '/.env');
        RedisService::connect();
        TimerService::redis();
        DbService::connect();
        TimerService::db();

        //GatewayClient支持GatewayWorker中的所有接口(Gateway::closeCurrentClient Gateway::sendToCurrentClient除外)
        //消息队列进程是没有注册register进程地址端口的，所以不能直接调用Gateway方法，这里选择引入GatewayClient使用
        GatewayClient::$registerAddress = '127.0.0.1:7010';
        $name = $businessWorker->name;
        //消息队列消费者监听
        if ($name == "amqp") {
            AmqpService::conmuser(KeywordService::LOG);
        }
    }

    public static function onConnect($client_id)
    {
        //日志写入
        LogServcice::write("onConnect", $client_id);
        //消息队列生产者
        AmqpService::publish("log", "onConnect：" . $client_id);
        //GatewayWorker发消息
        Gateway::sendToClient($client_id, MsgService::send("connected"));
        //新连接15秒之内没有登录直接断开
        Timer::add(15, function ($client_id) {
            $sessions = Gateway::getSession($client_id);
            if (!isset($sessions['uid'])) {
                Gateway::sendToClient($client_id, MsgService::send('fail', "授权超时"));
                Gateway::closeClient($client_id);
            }
        }, [$client_id], false);
    }

    public static function onMessage($client_id, $message)
    {
        if ($message != '{"cmd":"Ping.ping","data":{"token":null}}') {
            LogServcice::write("onMessage", "$client_id" . $message);
            AmqpService::publish("log", $client_id . "：" . $message);
        }
        //消息路由
        RouteService::run($client_id, $message);
    }

    public static function onClose($client_id)
    {
        LogServcice::write("oncClose", $client_id);
        AmqpService::publish("log", "onClose：" . $client_id);
        if (isset($_SESSION['uid'])) {
            //设置用户离线
            UserService::setOnlineStatus($_SESSION['uid'], 0);
        }
    }

}