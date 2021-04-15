<?php

namespace Services;

/**
 * 通信消息结构服务
 * Class MsgService
 * @package Services
 */
class MsgService
{

    public static function send($cmd, $message = '', $data = null)
    {
        if (is_null($data) || empty($data)) {
            $data = new \StdClass();
        }
        return json_encode([
            'cmd' => $cmd,
            'message' => $message,
            'data' => $data
        ], 256);
    }

}