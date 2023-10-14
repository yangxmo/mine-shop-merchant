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

namespace Api\InterfaceApi\v1\Home;

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
 * Class ProductApi.
 */
#[MApiAuth(scene: "api")]
class ProductApi
{
    #[Inject]
    protected MineResponse $response;

    #[Inject]
    protected GoodsDomainService $goodsDomainService;

    /**
     * 获取推荐商品.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[MApi(accessName: 'getRecommendProduct', name: '获取推荐商品', description: '获取推荐商品', appId: 'c5fb05c7f7', groupId: 2)]
    public function getRecommendProduct(Request $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        $params['goods_recommend'] = 2;
        return $this->response->success('操作成功', $this->goodsDomainService->getPageList($params, false));
    }

    /**
     * 获取预售商品.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[MApi(accessName: 'getPresellProduct', name: '获取预售商品', description: '获取预售商品', appId: 'c5fb05c7f7', groupId: 2)]
    public function getPresellProduct(Request $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        $params['goods_is_presell'] = 2;
        return $this->response->success('操作成功', $this->goodsDomainService->getPageList($params, false));
    }

    /**
     * 获取会员商品.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[MApi(accessName: 'getVipProduct', name: '获取会员商品', description: '获取会员商品', appId: 'c5fb05c7f7', groupId: 2)]
    public function getVipProduct(Request $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        $params['goods_is_vip'] = 2;
        return $this->response->success('操作成功', $this->goodsDomainService->getPageList($params, false));
    }

    /**
     * 根据分类获取商品.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[MApi(accessName: 'getProductByCid', name: '根据分类获取商品', description: '根据分类获取商品', appId: 'c5fb05c7f7', groupId: 2)]
    public function getProductByCid(Request $request): ResponseInterface
    {
        return $this->response->success('操作成功', $this->goodsDomainService->getPageList($request->getQueryParams(), false));
    }

}
