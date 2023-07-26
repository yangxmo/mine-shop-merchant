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
    /**
     * 构建订单数据
     * @param OrderServiceVo $vo 订单服务对象
     * @return array
     */
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

    /**
     * 构建订单预览数据
     * @param OrderServiceVo $vo
     * @return array
     */
    public static function buildOrderPreviewData(OrderServiceVo $vo): array
    {
        return [
            // 用户数据
            'user_data' => [
                'order_create_user_id' => $vo->getUserId(),
                'order_address' => [
                    'username' => $vo->orderFreightVo->userName,
                    'mobile' => $vo->orderFreightVo->userPhone,
                    'province_code' => $vo->orderFreightVo->provinceCode,
                    'province_name' => $vo->orderFreightVo->provinceName,
                    'city_code' => $vo->orderFreightVo->cityCode,
                    'city_name' => $vo->orderFreightVo->cityName,
                    'area_code' => $vo->orderFreightVo->areaCode,
                    'area_name' => $vo->orderFreightVo->areaName,
                    'street_name' => $vo->orderFreightVo->streetName,
                    'description' => $vo->orderFreightVo->description,
                ],
            ],
            // 订单价格数据
            'order_price_data' => [
                'order_price' => $vo->getOrderPrice(),
                'order_discount_price' => $vo->getOrderDiscountPrice(),
                'order_freight_price' => $vo->getOrderFreightPrice(),
                'order_pay_price' => $vo->getOrderPayPrice(),
            ],
            // 订单产品数据
            'product_data' => $vo->goodsData,
            'order_no' => $vo->getOrderNo(),
            'is_cart' => $vo->isCart,
        ];
    }
}
