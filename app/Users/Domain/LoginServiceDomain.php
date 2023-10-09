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

use App\Users\Service\Api\LoginService;
use Hyperf\Di\Annotation\Inject;

/**
 * @method string loginByMiniApp(array $params) 小程序登陆
 * @method string loginByWap(array $params) 网页h5登陆
 * @method bool outLogin 退出登陆
 * @method bool loginAfter(int $userId) 用户登陆后续
 * @method bool outLoginAfter(int $userId) 用户退出登陆后续
 */
class LoginServiceDomain
{
    #[Inject]
    protected LoginService $loginService;

    public function __call(string $name, array $arguments)
    {
        return $this->loginService->{$name}(...$arguments);
    }
}
