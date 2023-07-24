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
 * 订单状态（1正常2用户取消3系统取消4待发货5待收货6订单完成）.
 */
#[Constants]
class OrderStatusCode extends AbstractConstants
{
    public const ORDER_STATUS_TRUE = 1;

    public const ORDER_STATUS_CANCEL = 2;

    public const ORDER_STATUS_SYSTEM_CANCEL = 3;

    public const ORDER_STATUS_PROCESSED = 4;

    public const ORDER_STATUS_SHIPPED = 5;

    public const ORDER_STATUS_SUCCESS = 6;
}
