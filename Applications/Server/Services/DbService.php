<?php

namespace Services;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

/**
 * 数据库服务
 * Class DbService
 * @package Services
 */
class DbService
{

    private static $capsule;

    public static function connect()
    {
        self::$capsule = new Manager();
        self::$capsule->addConnection([
            'driver'    => $_ENV['DB_DRIVE'],
            'host'      => $_ENV['DB_HOST'],
            'database'  => $_ENV['DB_DATABASE'],
            'username'  => $_ENV['DB_USER'],
            'password'  => $_ENV['DB_PWD'],
            'charset'   => $_ENV['DB_CHARSET']
        ]);
        self::$capsule->setEventDispatcher(new Dispatcher(new Container));
        self::$capsule->setAsGlobal();
        self::$capsule->bootEloquent();
    }

}