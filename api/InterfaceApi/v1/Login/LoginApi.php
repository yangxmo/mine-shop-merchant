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

namespace Api\InterfaceApi\v1\Login;

use Api\Request\v1\Login\LoginRequest;
use App\Users\Domain\LoginServiceDomain;
use Mine\Annotation\Api\MApi;
use Mine\MineResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ApiController.
 */
class LoginApi
{
    protected MineResponse $response;

    protected LoginServiceDomain $loginServiceDomain;

    /**
     * DemoApi constructor.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(LoginServiceDomain $loginServiceDomain)
    {
        $this->response = container()->get(MineResponse::class);
        $this->loginServiceDomain = $loginServiceDomain;
    }

    /**
     * 微信小程序登陆.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[MApi(accessName: 'loginByMiniApp', name: '微信小程序登陆', description: '微信小程序登陆', appId: 'c5fb05c7f7', groupId: 1)]
    public function loginByMiniApp(LoginRequest $request): ResponseInterface
    {
        return $this->response->success('操作成功', ['token' => $this->loginServiceDomain->loginByMiniApp($request->validated())]);
    }

    /**
     * 网页登陆.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[MApi(accessName: 'loginByWap', name: '网页登陆', description: '网页登陆', appId: 'c5fb05c7f7', groupId: 1)]
    public function loginByWap(LoginRequest $request): ResponseInterface
    {
        return $this->response->success('操作成功', ['token' => $this->loginServiceDomain->loginByWap($request->validated())]);
    }

    /**
     * 退出登陆.
     */
    #[MApi(accessName: 'outLogin', name: '退出登陆', description: '退出登陆', appId: 'c5fb05c7f7', groupId: 1)]
    public function outLogin(): ResponseInterface
    {
        $outLogin = $this->loginServiceDomain->outLogin();

        return $outLogin ? $this->response->success() : $this->response->error();
    }
}
