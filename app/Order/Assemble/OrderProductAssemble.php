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
use Carbon\Carbon;

class OrderProductAssemble
{
    /**
     * 构建订单产品数据
     * @param OrderServiceVo $vo 订单服务对象
     * @return array
     */
    public static function buildOrderProductData(OrderServiceVo $vo): array
    {
        $productData = [];
        foreach ($vo->getGoodsData() as $datum) {
            $productData[] = [
                'order_no' => $vo->getOrderNo(),
                'goods_name' => $datum['goods_name'],
                'goods_sku_name' => $datum['goods_sku_name'],
                'goods_sku_value' => $datum['goods_sku_value'],
                'goods_image' => $datum['goods_image'],
                'goods_id' => $datum['goods_id'],
                'goods_sku_id' => $datum['goods_sku_id'],
                'goods_num' => $datum['goods_num'],
                'goods_price' => $datum['goods_price'],
                'goods_pay_price' => $datum['goods_price'] + $datum['goods_freight_price'],
                'goods_freight_price' => $datum['goods_freight_price'],
                'goods_discount_price' => $datum['goods_discount_price'],
                'goods_plat' => $datum['goods_plat'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];
        }

        return $productData;
    }
}
