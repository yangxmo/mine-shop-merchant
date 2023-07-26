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
namespace App\Order\Service\Confirm\Service;

use Api\Service\Order\Confirm\Service\Db;
use Api\Service\Order\Confirm\Service\Expression;
use App\Order\Assemble\OrderAddressAssemble;
use App\Order\Assemble\OrderAssemble;
use App\Order\Assemble\OrderPayRecordAssemble;
use App\Order\Assemble\OrderProductAssemble;
use App\Order\Mapper\OrderBaseMapper;
use App\Order\Model\OrderBase;
use App\Order\Vo\OrderServiceVo;
use Hyperf\Database\Model\Model;
use Hyperf\Di\Annotation\Inject;
use Mine\Annotation\Transaction;

class OrderService
{
    #[Inject]
    protected OrderBaseMapper $orderBaseMapper;

    # 创建订单
    #[Transaction]
    public function createOrder(OrderServiceVo $vo): Model|OrderBase
    {
        // 订单基础信息
        $orderData = OrderAssemble::buildOrderData($vo);
        // 订单商品信息
        $goodsData = OrderProductAssemble::buildOrderProductData($vo);
        // 订单地址信息
        $addressData = OrderAddressAssemble::buildOrderAddressData($vo);
        // 订单支付信息
        $payData = OrderPayRecordAssemble::buildOrderPayRecordData($vo);
        // 创建订单
        $order = $this->orderBaseMapper->create($orderData);
        // 创建商品
        $order->goods()->insert($goodsData);
        // 创建地址
        $order->address()->create($addressData);
        // 创建支付记录
        $order->payRecord()->create($payData);

        return $order;
    }

    # 删除订单
    public function deleteOrder(int $orderId)
    {
        Db::transaction(function () use ($orderId) {
            Db::table('tcc_order')
                ->where('id', $orderId)
                ->delete();
        });
    }

    # 创建订单消息
    public function createMessage(int $orderId, string $message): int
    {
        $id = null;
        Db::transaction(function () use (&$id, $orderId) {
            $id = (int) Db::table('tcc_order_message')
                ->insertGetId([
                    'order_id' => $orderId,
                    'message' => '订单创建成功, 通知管理员',
                ]);
        });
        return $id;
    }

    # 删除订单消息
    public function deleteMessage(int $msgId)
    {
        Db::transaction(function () use ($msgId) {
            Db::table('tcc_order_message')
                ->where('id', $msgId)
                ->delete();
        });
    }

    # 增加订单统计
    public function incOrderStatistics()
    {
        Db::transaction(function () {
            Db::table('tcc_order_statistics')
                ->where('id', 1)
                ->update(['order_num' => new Expression('order_num + 1')]);
        });
    }

    # 减少订单统计
    public function decOrderStatistics()
    {
        Db::transaction(function () {
            Db::table('tcc_order_statistics')
                ->where('id', 1)
                ->update(['order_num' => new Expression('order_num - 1')]);
        });
    }
}
