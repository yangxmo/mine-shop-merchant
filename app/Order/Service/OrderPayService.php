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

use App\JsonRpc\Interface\OrderPayInterface;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;

class OrderPayService extends AbstractService
{
    #[Inject]
    protected OrderPayInterface $order;

    public function getPayType(): array
    {
        return ['balance', 'ali-scan'];
    }

    /**
     * 获取支付二维码
     */
    public function getPayCode(string $orderNo): array
    {
        return $this->order->getScanCode($orderNo);
    }
}
