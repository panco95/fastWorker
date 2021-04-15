<?php

namespace Services;

use Illuminate\Database\Capsule\Manager;
use Workerman\Lib\Timer;

/**
 * 定时器服务
 * Class TimerService
 * @package Services
 */
class TimerService
{

    //定时ping redis，防止连接断开
    public static function redis()
    {
        Timer::add(10, function () {
            try {
                RedisService::getInstance()->ping("1");
            } catch (\Exception $e) {
                LogServcice::write("redis重连", "Ping出错");
                RedisService::connect();
            }
        });
    }

    //定时ping mysql，防止连接断开
    public static function db()
    {
        Timer::add(10, function () {
            try {
                Manager::table('user')->find(1);
            } catch (\Exception $e) {
                LogServcice::write("数据库重连", "Ping出错");
                DbService::connect();
            }
        });
    }

}