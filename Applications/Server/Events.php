<?php
/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

class Events
{

    //进程开启
    public static function onWorkerStart(\GatewayWorker\BusinessWorker $businessWorker)
    {
        \Services\WorkerService::onWorkerStart($businessWorker);
    }

    //有新连接
    public static function onConnect($client_id)
    {
        \Services\WorkerService::onConnect($client_id);
    }

    //有新消息
    public static function onMessage($client_id, $message)
    {
        \Services\WorkerService::onMessage($client_id, $message);
    }

    //有连接关闭
    public static function onClose($client_id)
    {
        \Services\WorkerService::onClose($client_id);
    }

}
