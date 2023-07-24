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
    public static function buildOrderProductData(OrderServiceVo $vo): array
    {
        $productData = [];
        foreach ($vo->getProductData() as $datum) {
            $productData[] = [
                'order_no' => $vo->getOrderNo(),
                'product_name' => $datum['product_name'],
                'product_sku_name' => $datum['product_sku_name'],
                'product_sku_value' => $datum['product_sku_value'],
                'product_image' => $datum['product_image'],
                'product_no' => $datum['product_no'],
                'product_sku_no' => $datum['product_sku_id'],
                'product_num' => $datum['product_num'],
                'product_price' => $datum['product_price'],
                'product_pay_price' => $datum['product_price'] + $datum['product_freight_price'],
                'product_freight_price' => $datum['product_freight_price'],
                'product_discount_price' => $datum['product_discount_price'],
                'product_plat' => $datum['product_plat'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];
        }

        return $productData;
    }

    public static function buildOrderLuaProductData(OrderServiceVo $vo): array
    {
        $productData = [];
        foreach ($vo->getProductData() as $datum) {
            $productData[] = [
                'product_no' => $datum['product_no'],
                'product_sku_no' => $datum['product_sku_id'],
                'product_num' => $datum['product_num'],
            ];
        }

        return $productData;
    }
}
