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
namespace App\Order\Request;

use Mine\MineFormRequest;

/**
 * 商品购物车验证数据类.
 */
class OrderPreviewRequest extends MineFormRequest
{
    /**
     * 公共规则.
     */
    public function commonRules(): array
    {
        return [];
    }

    public function confirmRules(): array
    {
        return ['order_no' => 'required|string'];
    }

    /**
     * 获取订单确认页面数据验证规则
     * return array.
     */
    public function viewRules(): array
    {
        return [
            'product' => 'required|array',
            // 商品ID 验证
            'product.*.product_id' => 'required|integer',
            // 商品skuID
            'product.*.product_sku_id' => 'nullable|string',
            // 商品数量 验证
            'product.*.product_num' => 'required|integer|min:1',
            // 商品来源
            'product.*.product_source' => 'required|integer|in:1,2',
            // 地址
            'address' => 'required|array',
            'address.province_name' => 'required|string',
            'address.province_code' => 'required|integer',
            'address.city_code' => 'nullable|integer',
            'address.city_name' => 'required|string',
            'address.area_name' => 'required|string',
            'address.area_code' => 'nullable|integer',
            'address.street_name' => 'required|string',
            'address.street_code' => 'required|integer',
            'address.description' => 'required|string',
            'address.mobile' => 'required|numeric',
            'address.username' => 'required|string',
            'address.post_code' => 'required|integer',
            // 是否购物车
            'is_cart' => 'required|boolean',
        ];
    }

    /**
     * 减少购物车
     * return array.
     */
    public function reduceCartRules(): array
    {
        return [
            // 商品ID 验证
            'product_id' => 'required|integer',
            // 商品skuID
            'product_sku_id' => 'nullable',
            // 商品数量 验证
            'num' => 'required|integer|min:1',
        ];
    }

    /**
     * 字段映射名称
     * return array.
     */
    public function attributes(): array
    {
        return [
            'title' => '分组名称',
            'status' => '分组状态（0无用1有用）',
            'sort' => '分类排序',
        ];
    }
}
