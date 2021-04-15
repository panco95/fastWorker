<?php

namespace Services;

use GatewayWorker\Lib\Gateway;

/**
 * 消息路由服务
 * Class RouteService
 * @package Services
 */
class RouteService
{

    public static function run($client_id, $message)
    {
        $message = json_decode($message, true);
        if (is_array($message)) {
            //检测连接是否授权，无授权只能调用Sign.login
            if (strtolower($message['cmd']) != "sign.login" && !isset($_SESSION['uid'])) {
                Gateway::sendToClient($client_id, MsgService::send("fail", "未授权"));
                return;
            }
            $url = explode('.', $message['cmd']);
            $namespace = "\Controllers\\";
            if (class_exists($namespace . ucfirst($url[0])) && method_exists($namespace . $url[0], $url[1])) {
                $className = $namespace . $url[0];
                $class = new $className();
                $method = $url[1];
                $class->$method($client_id, $message['data']);
                unset($class);
            } else {
                Gateway::sendToClient($client_id, MsgService::send("fail", "无效指令"));
            }
        } else {
            Gateway::sendToClient($client_id, MsgService::send("fail", "无效数据"));
        }
    }

}