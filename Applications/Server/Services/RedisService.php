<?php

namespace Services;

/**
 * redis服务
 * Class RedisService
 * @package Services
 */
class RedisService
{

    /**
     * @var \Redis
     */
    private static $client;

    /**
     * @return \Redis
     */
    public static function getInstance()
    {
        if (!(self::$client instanceof \Redis)) {
            self::connect();
        }
        return self::$client;
    }

    public static function connect()
    {
        try {
            self::$client = new \Redis();
            self::$client->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']);
            if ($_ENV['REDIS_PASSWORD']) {
                self::$client->auth($_ENV['REDIS_PASSWORD']);
            }
        } catch (\Exception $e) {
            LogServcice::write("Redis连接", $e->getMessage());
        }
    }

}