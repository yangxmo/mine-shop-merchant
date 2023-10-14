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

namespace Api\Request\v1\Cart;

use Hyperf\Validation\Rule;
use Mine\MineApiFormRequest;

class CartRequest extends MineApiFormRequest
{
    /**
     * 公共规则.
     */
    public function commonRules(): array
    {
        return [];
    }

    /**
     * 新增数据验证规则
     * return array.
     */
    public function saveRules(): array
    {
        return [
            // 商品ID 验证
            'goods_id' => ['required', 'integer', Rule::exists('goods', 'id')],
            // 商品skuID
            'goods_sku_id' => ['nullable', Rule::exists('goods_sku', 'goods_sku_id')],
            // 商品数量 验证
            'num' => 'required|integer|min:1',
        ];
    }

    /**
     * 减少购物车
     * return array.
     */
    public function reduceRules(): array
    {
        return [
            // 商品ID 验证
            'goods_id' => ['required', 'integer', Rule::exists('goods', 'id')],
            // 商品skuID
            'goods_sku_id' => ['nullable', Rule::exists('goods_sku', 'goods_sku_id')],
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
            'goods_id' => '产品ID',
            'goods_sku_id' => '产品skuID',
            'num' => '商品数量',
        ];
    }
}
