介绍
=======
FastWorker：一款使用PHP开发的高性能socket长连接业务框架，适用于游戏、实时通讯、推送、物联网等。
本项目基于workerman/gatewayWorker开发，具有长连接/多进程/分布式等高性能基础支持。

功能
=======
1、长连接消息路由<br>
2、mysql客户端(自动重连)<br>
3、redis客户端(自动重连)<br>
4、rabbitmq生产者/消费者模型<br>
5、自定义日志<br>
6、项目结构规范

启动
=======
1、cp .env.example .env<br>
2、启动mysql、redis、rabbitmq服务<br>
3、vim .env修改配置文件<br>
4、php start.php start（Windows：./start_win.bat）

更多
=======
请查询Wokerman文档：https://www.workerman.net
