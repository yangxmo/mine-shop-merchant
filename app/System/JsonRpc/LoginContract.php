<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\System\JsonRpc;

interface LoginContract
{
    // 后台账号登陆
    public function loginByAccount(string $userServiceVod);

    // 后台手机号登陆
    public function loginByMobile(string $mobile);

    // 用户退出.
    public function logout();
}
