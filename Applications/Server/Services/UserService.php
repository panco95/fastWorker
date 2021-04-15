<?php

namespace Services;

use Illuminate\Database\Capsule\Manager;

/**
 * 用户服务
 * Class UserService
 * @package Services
 */
class UserService
{

    //保存用户在线状态
    public static function setOnlineStatus($uid, $status)
    {
//        Manager::table('user')
//            ->where('id', $uid)
//            ->update([
//                'status' => $status
//            ]);
    }

}