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
namespace Api\InterfaceApi\v1;

use App\Order\Request\OrderPreviewRequest;
use App\Order\Service\OrderConfirmService;
use Hyperf\Di\Annotation\Inject;
use Mine\Annotation\Api\MApi;
use Mine\Annotation\Api\MApiResponseParam;
use Mine\MineResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 订单确认页面.
 */
class OrderPreviewApi
{
    #[Inject]
    protected OrderConfirmService $orderConfirmService;

    protected MineResponse $response;

    /**
     * DemoApi constructor.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        $this->response = container()->get(MineResponse::class);
    }

    /**
     * 获取订单预览数据.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[MApi(accessName: 'getOrderPreview', name: '获取订单预览接口', description: '获取订单预览接口', appId: 'a7ccdef6d7', groupId: 3)]
    #[MApiResponseParam(name: 'data.user_data', description: '用户信息', dataType: 'Array')]
    #[MApiResponseParam(name: 'data.order_price_data', description: '订单金额信息', dataType: 'Array')]
    #[MApiResponseParam(name: 'data.product_data', description: '订单产品信息', dataType: 'Array')]
    #[MApiResponseParam(name: 'data.order_no', description: '订单号', dataType: 'Integer')]
    #[MApiResponseParam(name: 'data.is_cart', description: '是否购物车购买', dataType: 'Boolean')]
    public function getOrderPreview(OrderPreviewRequest $request): ResponseInterface
    {
        return $this->response->success('请求成功', $this->orderConfirmService->getPreviewOrder($request->validated()));
    }
}
