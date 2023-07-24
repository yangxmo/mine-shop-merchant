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

trait OrderPriceTrait
{
    public function calculateOrderPrice(float &$orderPrice, int $productNum, float $productPrice): void
    {
        $price = floatval(bcmul((string) $productNum, (string) $productPrice, 2));

        $orderPrice = floatval(bcadd((string) $orderPrice, (string) $price, 2));
    }

    public function calculateOrderFreightPrice(float &$orderFreightPrice, int $goodsNum, float $freightPrice): void
    {
        $price = floatval(bcmul((string) $goodsNum, (string) $freightPrice, 2));

        $orderFreightPrice = floatval(bcadd((string) $orderFreightPrice, (string) $price, 2));
    }
}
