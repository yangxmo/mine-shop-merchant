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
namespace App\Order\Service\Preview\Abstract;

use App\Order\Service\Preview\Interface\OrderPreviewInterface;
use App\Order\Trait\OrderPriceTrait;
use App\Order\Vo\OrderServiceVo;
use Mine\Exception\MineException;

abstract class OrderPreviewAbstract implements OrderPreviewInterface
{
    use OrderPriceTrait;

    public OrderServiceVo $orderVo;

    protected ?array $errorMessage;

    public function init(OrderServiceVo $orderServiceVo): self
    {
        $this->orderVo = $orderServiceVo;
        return $this;
    }

    // 检查商品
    abstract public function checkOrderProduct(): self;

    // 检查商品总价
    abstract public function checkOrderProductPayPrice(): self;

    abstract public function after(string $orderNo, array $confirmOrder);

    // 设置错误信息
    public function setOrderError(string $message): void
    {
        if (! empty($message)) {
            throw new MineException($message);
        }
    }

    # 获取订单确认页信息
    public function getPreviewOrder(): array
    {
        // 获取订单号
        $orderNo = snowflake_id($this->orderVo->getUserId());

        $confirmOrder = [
            // 用户数据
            'user_data' => [
                'order_create_user_id' => $this->orderVo->getUserId(),
                'order_tenant_no' => $this->orderVo->getTenantId(),
                'order_address' => [
                    'username' => $this->orderVo->orderFreightVo->userName,
                    'mobile' => $this->orderVo->orderFreightVo->userPhone,
                    'province_code' => $this->orderVo->orderFreightVo->provinceCode,
                    'province_name' => $this->orderVo->orderFreightVo->provinceName,
                    'city_code' => $this->orderVo->orderFreightVo->cityCode,
                    'city_name' => $this->orderVo->orderFreightVo->cityName,
                    'area_code' => $this->orderVo->orderFreightVo->areaCode,
                    'area_name' => $this->orderVo->orderFreightVo->areaName,
                    'street_name' => $this->orderVo->orderFreightVo->streetName,
                    'description' => $this->orderVo->orderFreightVo->description,
                ],
            ],
            // 订单价格数据
            'order_price_data' => [
                'order_price' => $this->orderVo->getOrderPrice(),
                'order_discount_price' => $this->orderVo->getOrderDiscountPrice(),
                'order_freight_price' => $this->orderVo->getOrderFreightPrice(),
                'order_pay_price' => $this->orderVo->getOrderPayPrice(),
            ],
            // 订单产品数据
            'product_data' => $this->orderVo->productData,
            'order_no' => $orderNo,
            'is_cart' => $this->orderVo->isCart,
        ];

        // 设置确认订单页面缓存
        $this->after((string) $orderNo, $confirmOrder);

        return $confirmOrder;
    }
}
