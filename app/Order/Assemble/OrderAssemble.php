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
namespace App\Order\Assemble;

use App\Order\Vo\OrderServiceVo;

class OrderAssemble
{
    public static function buildOrderData(OrderServiceVo $vo): array
    {
        return [
            'order_no' => $vo->getOrderNo(),
            'order_price' => $vo->getOrderPrice(),
            'order_discount_price' => $vo->getOrderDiscountPrice(),
            'order_freight_price' => $vo->getOrderFreightPrice(),
            'order_pay_price' => $vo->getOrderPayPrice(),
            'order_remark' => '',
            'order_create_user_id' => $vo->getUserId(),
        ];
    }
}
