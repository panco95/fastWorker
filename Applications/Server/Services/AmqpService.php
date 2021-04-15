<?php

namespace Services;

use GatewayClient\Gateway as GatewayClient;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * amqp(rabbitmq)消息队列服务
 * Class AmqpService
 * @package Services
 */
class AmqpService
{

    //消费者进程，消费消息
    public static function conmuser($queue)
    {
        //连接消息队列（rabbitmq）
        $connection = new AMQPStreamConnection($_ENV['AMQP_HOST'], $_ENV['AMQP_PORT'], $_ENV['AMQP_USER'], $_ENV['AMQP_PASSWORD']);
        $channel = $connection->channel();
        // durable为true开启消息持久化，服务重启后不会丢失消息(生产者和消费者都需要为true)
        $channel->queue_declare($queue, false, true, false, false);

        $callback = function ($msg) {
            //在消费者进程需要调用GatewayClient库
            //GatewayClient::sendToUid(1,"msg");
            LogServcice::write("Rabbitmq", $msg->body);
            var_dump("Rabbitmq：" . $msg->body);
            $msg->ack(); //给rabbitmq发送确认处理完成ack
        };
        // 公平调度：prefetch_count预取消息1条，这样就不会把所有消息取过来导致其他消费者取不到消息进行消费
        $channel->basic_qos(null, 1, null);
        // 第四个参数no_ack，开启消息确认机制：false
        $channel->basic_consume($queue, '', false, false, false, false, $callback);
        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

    //发布者，发布消息
    public static function publish($queue, $msg)
    {
        $connection = new AMQPStreamConnection($_ENV['AMQP_HOST'], $_ENV['AMQP_PORT'], $_ENV['AMQP_USER'], $_ENV['AMQP_PASSWORD']);
        $channel = $connection->channel();
        // durable为true开启消息持久化，服务重启后不会消息(生产者和消费者都需要为true)，还有在消息体中定义
        $channel->queue_declare($queue, false, true, false, false);
        $msg = new AMQPMessage($msg, [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT  // 消息持久化消息定义
        ]);
        $channel->basic_publish($msg, '', $queue);
        $channel->close();
        $connection->close();
    }


}