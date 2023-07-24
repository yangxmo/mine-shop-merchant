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

use App\Order\Request\OrderPreviewRequest;
use App\Order\Service\OrderConfirmService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\OperationLog;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 订单提交控制器
 * Class OrderConfirmController.
 */
#[Controller(prefix: 'order/confirm'), Auth]
class OrderConfirmController extends MineController
{
    /**
     * 业务处理服务
     * OrderConfirmService.
     */
    #[Inject]
    protected OrderConfirmService $service;

    /**
     * 获取确认订单页面.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('preview'), Permission('order:confirm:preview')]
    public function view(OrderPreviewRequest $request): ResponseInterface
    {
        $result = $this->service->getPreviewData($request->validated());

        return $this->success($result);
    }

    /**
     * 提交订单.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping('confirm'), Permission('order:confirm:confirm'), OperationLog]
    public function confirm(OrderPreviewRequest $request): ResponseInterface
    {
        $result = $this->service->confirm($request->input('order_no', ''));

        return $this->success($result);
    }
}
