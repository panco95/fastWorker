<?php

namespace Controllers;

use GatewayWorker\Lib\Gateway;
use Services\MsgService;
use Services\UserService;

/**
 * 用户认证控制器
 * Class Sign
 * @package Controllers
 */
class Sign
{

    //登录授权
    //这里仅作为绑定uid演示，请自行添加鉴权机制，例如jwt
    public function login($client_id, $data)
    {
        if (!isset($data['uid'])) {
            Gateway::sendToClient($client_id, MsgService::send('fail', "缺少uid参数"));
            return;
        }
        $uid = $data['uid'];
        Gateway::bindUid($client_id, $uid);
        $_SESSION['uid'] = $uid;
        UserService::setOnlineStatus($uid, 1); //更新用户在线状态
        Gateway::sendToClient($client_id, MsgService::send('sign.loginOk', '登录成功'));
    }


}