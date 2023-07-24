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

class OrderAddressAssemble
{
    public static function buildOrderAddressData(OrderServiceVo $vo): array
    {
        return [
            'order_no' => $vo->getOrderNo(),
            'receive_user_name' => $vo->orderFreightVo->userName,
            'receive_user_mobile' => $vo->orderFreightVo->userPhone,
            'receive_user_province' => $vo->orderFreightVo->provinceName,
            'receive_user_province_code' => $vo->orderFreightVo->provinceCode,
            'receive_user_city' => $vo->orderFreightVo->cityName,
            'receive_user_city_code' => $vo->orderFreightVo->cityCode,
            'receive_user_street' => $vo->orderFreightVo->streetName,
            'receive_user_street_code' => '',
            'receive_user_address' => $vo->orderFreightVo->description,
        ];
    }
}
