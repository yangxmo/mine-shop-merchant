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
namespace App\Order\Mapper;

use App\Order\Model\OrderBase;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

class OrderBaseMapper extends AbstractMapper
{
    /**
     * @var OrderBase
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = OrderBase::class;
    }
    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        // 订单状态
        if (! empty($params['status'])) {
            if (is_array($params['status'])) {
                $query->whereIn('order_status', $params['status']);
            } else {
                $query->where('order_status', '=', $params['status']);
            }
        }
        // 订单关键词(货品名称，订单号)
        if (! empty($params['keyword'])) {
            $query->where('order_no', '=', $params['keyword'])
                ->orWhere(function ($query) use ($params) {
                    $query->whereHas('product', function ($query) use ($params) {
                        $query->where('product_name', 'like', '%' . $params['keyword'] . '%');
                    });
                });
        }
        // 订单金额
        if (! empty($params['order_price'])) {
            $query->where('order_price', '=', $params['order_price']);
        }
        // 创建时间
        if (! empty($params['order_time_begin']) && ! empty($params['order_time_end'])) {
            $query->whereBetween(
                'created_at',
                [$params['order_time_begin'] . ' 00:00:00', $params['order_time_end'] . ' 23:59:59']
            );
        }
        // 收货人名称
        if (! empty($params['consignee_name'])) {
            $query->whereHas('address', function ($query) use ($params) {
                $query->where('receive_user_name', '=', $params['consignee_name']);
            });
        }
        // 收货人手机号
        if (! empty($params['consignee_phone'])) {
            $query->whereHas('address', function ($query) use ($params) {
                $query->where('receive_user_mobile', '=', $params['consignee_phone']);
            });
        }
        return $query;
    }
}
