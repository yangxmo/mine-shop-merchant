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
namespace App\Order\Controller;

use Api\Service\Order\OrderPayService;
use App\Order\Request\OrderPayRequest;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 订单控制器
 * Class ProductCategoryController.
 */
#[Controller(prefix: 'order/pay'), Auth]
class OrderPayController extends MineController
{
    /**
     * 业务处理服务
     * OrderConfirmService.
     */
    #[Inject]
    protected OrderPayService $service;

    /**
     * 获取支付类型.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('getPayType'), Permission('order:pay:getPayType')]
    public function getPayType(): ResponseInterface
    {
        $result = $this->service->getPayType();

        return $this->success($result);
    }

    /**
     * 获取支付二维码
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('getPayCode'), Permission('order:pay:getPayCode')]
    public function getPayCode(OrderPayRequest $request): ResponseInterface
    {
        $orderNo = $request->input('order_no', '');
        $result = $this->service->getPayCode($orderNo);

        return $this->success($result);
    }
}
