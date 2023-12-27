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
namespace App\System\Service\Dependencies;

use App\System\JsonRpc\LoginContract;
use Hyperf\Di\Annotation\Inject;
use Mine\Annotation\DependProxy;
use Mine\Interfaces\UserServiceInterface;
use Mine\Vo\UserServiceVo;

/**
 * 用户登录.
 */
#[DependProxy(values: [UserServiceInterface::class])]
class UserAuthService implements UserServiceInterface
{

    #[Inject]
    protected LoginContract $loginContract;

    // 登录
    public function login(UserServiceVo $userServiceVo): string
    {
        return $this->loginContract->loginByAccount(serialize($userServiceVo));
    }

    // 用户退出.
    public function logout(): void
    {
        $this->loginContract->logout();
    }
}
