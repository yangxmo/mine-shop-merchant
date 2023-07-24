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
namespace App\Order\Trait;


use App\Order\Vo\OrderServiceVo;

trait OrderConfirmTrait
{
    /**
     * @param OrderServiceVo $orderServiceVo
     * @return OrderConfirmTrait
     */
    public function setOrderVo(OrderServiceVo $orderServiceVo): self
    {
        $this->orderVo = $orderServiceVo;
        return $this;
    }
}
