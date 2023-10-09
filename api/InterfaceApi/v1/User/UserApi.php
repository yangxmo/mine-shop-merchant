<?php
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Api\InterfaceApi\v1\User;

use Api\Request\v1\User\UserInfoRequest;
use App\Users\Domain\UserServiceDomain;
use Hyperf\Di\Annotation\Inject;
use Mine\Annotation\Api\MApi;
use Mine\Annotation\Api\MApiAuth;
use Mine\MineResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class UserApi.
 */
#[MApiAuth(scene: "api")]
class UserApi
{
    #[Inject]
    protected MineResponse $response;

    #[Inject]
    protected UserServiceDomain $userServiceDomain;

    /**
     * 获取用户信息.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[MApi(accessName: 'getUserInfo', name: '获取用户信息', description: '获取用户信息', appId: 'c5fb05c7f7', groupId: 2)]
    public function getUserInfo(): ResponseInterface
    {
        return $this->response->success('操作成功', $this->userServiceDomain->getUserInfo());
    }

    /**
     * 修改用户信息.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[MApi(accessName: 'upUserInfo', name: '修改用户信息', description: '修改用户信息', appId: 'c5fb05c7f7', groupId: 2)]
    public function upUserInfo(UserInfoRequest $request): ResponseInterface
    {
        $status = $this->userServiceDomain->upUserInfo($request->validated());
        return $status ? $this->response->success() : $this->response->error();
    }
}
