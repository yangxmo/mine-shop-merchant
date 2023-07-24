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
namespace App\Order\Service;

use App\JsonRpc\Interface\OrderInterface;
use App\Order\Dto\OrderDto;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Mine\MineCollection;

class OrderBaseService extends AbstractService
{
    #[Inject]
    protected OrderInterface $order;

    /**
     * 订单详情.
     */
    public function orderInfo(string $orderNo): array
    {
        return $this->order->orderInfo($orderNo);
    }

    /**
     * 订单统计
     */
    public function orderStatistics(string $date = null): array
    {
        return $this->order->orderStatistics($date);
    }

    /**
     * 订单导出.
     */
    public function orderExport(array $params): \Psr\Http\Message\ResponseInterface
    {
        $result = $this->getOrderList($params, true);
        return (new MineCollection())->export(OrderDto::class, date('YmdHis'), $this->handleOrderExportData($result));
    }

    /**
     * 处理订单导出数据.
     */
    private function handleOrderExportData(array $orderData): array
    {
        if (empty($orderData)) {
            return $orderData;
        }
        $orderList = [];
        foreach ($orderData as $key => $item) {
            if (! empty($item['product']) && is_array($item['product'])) {
                foreach ($item['product'] as $val) {
                    $orderList[$key]['order_no'] = $item['order_no'];
                    $orderList[$key]['order_price'] = $item['order_price'];
                    $orderList[$key]['order_status'] = $item['order_status'];
                    $orderList[$key]['order_pay_type'] = $item['order_pay_type'];
                    $orderList[$key]['created_at'] = $item['created_at'];
                    $orderList[$key]['product_name'] = $val['product_name'];
                    $orderList[$key]['product_num'] = $val['product_num'];
                    $orderList[$key]['receive_user_name'] = $item['address']['receive_user_name'];
                    $orderList[$key]['receive_user_mobile'] = $item['address']['receive_user_mobile'];
                    $orderList[$key]['receive_user_province'] = $item['address']['receive_user_province'];
                    $orderList[$key]['receive_user_city'] = $item['address']['receive_user_city'];
                    $orderList[$key]['receive_user_street'] = $item['address']['receive_user_street'];
                    $orderList[$key]['receive_user_address'] = $item['address']['receive_user_address'];
                }
            }
        }
        return $orderList;
    }
}
