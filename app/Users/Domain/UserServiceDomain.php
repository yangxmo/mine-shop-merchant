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

namespace App\Users\Domain;

use App\Users\Service\Api\UserService;
use Hyperf\Di\Annotation\Inject;

/**
 * @method array getUserInfo 获取登陆的用户信息
 * @method bool upUserInfo(array $params) 修改用户信息
 */
class UserServiceDomain
{
    #[Inject]
    protected UserService $userService;

    public function __call(string $name, array $arguments)
    {
        return $this->userService->{$name}(...$arguments);
    }
}
