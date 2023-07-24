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
namespace App\Order\Constant;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * 订单异常.
 */
#[Constants]
class OrderErrorCode extends AbstractConstants
{
    public static array $aliyunOrderError = [
        '500_005' => '商品的购买数量小于起批量',
        '500_006' => '商品的购买数量或者总金额均不满足混批条件',
        '500_004' => '商品的某个规格库存不足',
        '500_002' => '存在多个卖家的商品或者商品没有指定specId',
        '500_003' => '存在多个卖家的商品或者商品不存在specId的规格',
        '500_001' => '商品不支持在线交易，目前不能购买',
    ];
}
