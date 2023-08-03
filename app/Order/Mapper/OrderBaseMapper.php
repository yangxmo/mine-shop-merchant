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
     * 订单列表.
     */
    public function getOrderList(array $params, bool $isExport = false): array|\Hyperf\Contract\LengthAwarePaginatorInterface
    {
        $query = $this->handleSearch($this->model::query(), $params);
        $query->orderByDesc('id')->with(['product', 'address']);
        if ($isExport) {
            return $query->get()->toArray() ?? [];
        }
        return $query->paginate((int) $params['pageSize'], ['*'], 'page', (int) $params['page']);
    }

    /**
     * 订单详情.
     */
    public function orderInfo(string $orderNo): array
    {
        $result = $this->model::query()->where(['order_no' => $orderNo])->with(['product', 'address', 'orderActionRecord'])->tenantWhere()->first();
        return $result ? $result->toArray() : [];
    }

    /**
     * 订单统计.
     * @param mixed $mark
     */
    public function orderStatistics(string $date = null, $mark = true): array
    {
        $query = $this->model::query();
        $createdAtStart = $date . ' 00:00:00';
        $createdAtEnd = $date . ' 23:59:59';
        if ($mark) {
            $query->where('created_at', '<=', $createdAtEnd);
        } else {
            $query->whereBetween('created_at', [$createdAtStart, $createdAtEnd]);
        }
        $result = $query->tenantWhere()->get();
        return $result ? $result->toArray() : [];
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
