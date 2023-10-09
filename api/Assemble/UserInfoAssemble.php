<?php

namespace Api\Assemble;

class UserInfoAssemble
{
    public static function assembleUserInfo(array $userInfo)
    {
        return [
            'id' => $userInfo['id'],
            'nickname' => $userInfo['nickname'],
            'email' => $userInfo['email'],
            'mobile' => $userInfo['mobile'],
            'avatar' => $userInfo['avatar'],
            'created_at' => $userInfo['created_at'],
            'updated_at' => $userInfo['updated_at'],
        ];
    }
}