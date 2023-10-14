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

namespace Api\InterfaceApi\v1\Cart;

use Api\Request\v1\Cart\CartRequest;
use App\Goods\Service\Domain\CartDomainService;
use App\Goods\Service\Domain\GoodsDomainService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Request;
use Mine\Annotation\Api\MApi;
use Mine\Annotation\Api\MApiAuth;
use Mine\MineResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CartApi.
 */
#[MApiAuth(scene: "api")]
class CartApi
{
    #[Inject]
    protected MineResponse $response;

    #[Inject]
    protected CartDomainService $cartDomainService;

    /**
     * 获取购物车商品.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[MApi(accessName: 'getCart', name: '获取购物车商品', description: '获取购物车商品', appId: 'c5fb05c7f7', groupId: 2)]
    public function getCart(): ResponseInterface
    {
        return $this->response->success('操作成功', $this->cartDomainService->cartList());
    }

    /**
     * 新增购物车.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[MApi(accessName: 'saveCart', name: '新增购物车', description: '新增购物车', appId: 'c5fb05c7f7', groupId: 2)]
    public function saveCart(CartRequest $request): ResponseInterface
    {
        $params = $request->validated();
        $action = $this->cartDomainService->saveCart($params['goods_id'], $params['goods_sku_id'], $params['num']);
        return $action ? $this->response->success() : $this->response->error();
    }

    /**
     * 删除购物车产品.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[MApi(accessName: 'reduceCart', name: '删除购物车产品', description: '删除购物车产品', appId: 'c5fb05c7f7', groupId: 2)]
    public function reduceCart(CartRequest $request): ResponseInterface
    {
        $params = $request->validated();
        $action = $this->cartDomainService->reduceCart($params['goods_id'], $params['goods_sku_id']);
        return $action ? $this->response->success() : $this->response->error();
    }

    /**
     * 清空购物车.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[MApi(accessName: 'clearCart', name: '清空购物车', description: '清空购物车', appId: 'c5fb05c7f7', groupId: 2)]
    public function clearCart(): ResponseInterface
    {
        $action = $this->cartDomainService->clearCart();
        return $action ? $this->response->success() : $this->response->error();
    }

}
