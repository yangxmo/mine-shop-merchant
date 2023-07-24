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

use App\Order\Service\Confirm\BuildOrderTcc;
use App\Order\Service\Confirm\GoodsLockTcc;
use App\Order\Service\Confirm\GoodsSubTcc;
use App\Order\Service\Confirm\OrderMessageTcc;
use App\Order\Service\Confirm\OrderStatisticsTcc;
use App\Order\Service\Confirm\OrderTcc;
use App\Order\Service\Preview\Interface\OrderPreviewInterface;
use App\Order\Vo\OrderAddressVo;
use App\Order\Vo\OrderServiceVo;
use Mine\Abstracts\AbstractService;
use Tcc\TccTransaction\Tcc;

class OrderConfirmService extends AbstractService
{
    /**
     * 订单预览
     * @param array $data
     * @return array
     */
    public function getPreviewOrder(array $data): array
    {
        // 设置订单运费对象属性
        /** @var OrderAddressVo $orderFreightVo */
        $orderFreightVo = make(OrderAddressVo::class);
        $orderFreightVo->provinceName = $data['address']['province_name'];
        $orderFreightVo->provinceCode = $data['address']['province_code'];
        $orderFreightVo->cityName = $data['address']['city_name'];
        $orderFreightVo->cityCode = $data['address']['city_code'];
        $orderFreightVo->areaName = $data['address']['area_name'];
        $orderFreightVo->areaCode = $data['address']['area_code'];
        $orderFreightVo->streetName = $data['address']['street_name'];
        $orderFreightVo->streetCode = $data['address']['street_code'] ?? 0;
        $orderFreightVo->description = $data['address']['description'];
        $orderFreightVo->userName = $data['address']['username'];
        $orderFreightVo->userPhone = $data['address']['mobile'];

        // 设置订单对象属性
        /** @var OrderServiceVo $orderServiceVo */
        $orderServiceVo = make(OrderServiceVo::class);
        $orderServiceVo->setUserId($data['user_id']);
        $orderServiceVo->setProductData($data['goods']);
        $orderServiceVo->setOrderFreight($orderFreightVo);
        $orderServiceVo->setIsCart($data['is_cart'] ?? false);

        /** @var OrderPreviewInterface $preview */
        $preview = make(OrderPreviewInterface::class);
        // 获取订单数据
        return $preview->init($orderServiceVo)->getPreviewOrder();
    }

    /**
     * 创建订单
     * @param int $previewOrderId
     * @return array
     */
    public function confirm(int $previewOrderId): array
    {
        /** @var Tcc $tcc */
        $tcc = make(Tcc::class);

        $tcc->tcc(1, new BuildOrderTcc($previewOrderId))
        ->tcc(2, new GoodsLockTcc())
        ->tcc(3, new OrderTcc())
        ->tcc(4, new GoodsSubTcc())
        ->tcc(5, new OrderMessageTcc())
        ->tcc(6, new OrderStatisticsTcc())
        ->rely([[1,2],[3],[4,5,6]])->begin();

        return ['order_id' => $tcc->get(OrderTcc::class)->id];
    }
}
